<?php

use App\Models\User;
use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can render the page', function () {
    $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);

    $response = $this->actingAs($employee)
        ->get(route('employee.attendance'));

    $response->assertOk();
});

it('can check in', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
        $schedule = Schedule::factory()->create([
            'user_id' => $employee->id,
            'day' => $time->isoWeekday(),
            'work_start_time' => $time->subMinutes(15)->format('H:i'),
            'work_end_time' => '24:00',
            'latitude' => 1,
            'longitude' => 1,
            'radius' => 100,
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($employee)
            ->from(route('employee.attendance'))
            ->post(route('checkin'), [
                'latitude' => 1,
                'longitude' => 1,
                'photo' => $file,
            ]);

        $response->assertRedirect(route('employee.attendance'))
            ->assertSessionHasNoErrors()
            ->assertSessionMissing('danger')
            ->assertSessionHas('success');
        Storage::disk('public')->assertExists('photos/' . $file->hashName());
        $attendance = Attendance::where('user_id', $employee->id)
            ->where('date', $time->format('Y-m-d'))
            ->first();
        expect($attendance->check_in_time->format('H:i'))->toBe(now()->format('H:i'))
            ->and($attendance->check_out_time)->toBeNull()
            ->and($attendance->check_in_photo)->toBe('photos/' . $file->hashName());
    });
});

// cant check in if no schedule
it('cant check in if no schedule', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($employee)
            ->from(route('employee.attendance'))
            ->post(route('checkin'), [
                'latitude' => 1,
                'longitude' => 1,
                'photo' => $file,
            ]);

        $response->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger')
            ->assertSessionMissing('success');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
    });
});

// cant check in if already checked in
it('cant check in if already checked in', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
        Schedule::factory()->create([
            'user_id' => $employee->id,
            'day' => $time->isoWeekday(),
            'work_start_time' => $time->subMinutes(15)->format('H:i'),
            'work_end_time' => '24:00',
            'latitude' => 1,
            'longitude' => 1,
            'radius' => 100,
        ]);
        $attendance = Attendance::factory()->create([
            'user_id' => $employee->id,
            'date' => $time->format('Y-m-d'),
            'check_in_time' => $time->format('H:i'),
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $this->travel(15)->minutes();
        $response = $this->actingAs($employee)
            ->from(route('employee.attendance'))
            ->post(route('checkin'), [
                'latitude' => 1,
                'longitude' => 1,
                'photo' => $file,
            ]);

        $response->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger')
            ->assertSessionMissing('success');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance->refresh();
        expect($attendance->check_in_time->format('H:i'))->toBe($time->format('H:i'));
    });
});

it('cant check in if not within check in time', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $time->setTime(8, 0);
        $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
        $schedule = Schedule::factory()->create([
            'user_id' => $employee->id,
            'day' => $time->isoWeekday(),
            'work_start_time' => $time->format('H:i'),
            'work_end_time' => '17:00',
            'latitude' => 1,
            'longitude' => 1,
            'radius' => 100,
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $this->travel(1)->hours();
        $response = $this->actingAs($employee)
            ->from(route('employee.attendance'))
            ->post(route('checkin'), [
                'latitude' => 1,
                'longitude' => 1,
                'photo' => $file,
            ]);

        $response->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger')
            ->assertSessionMissing('success');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance = Attendance::where('user_id', $employee->id)
            ->where('date', $time->format('Y-m-d'))
            ->first();
        expect($attendance)->toBeNull();
    });
});

it('cant check in if not within radius', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
        $schedule = Schedule::factory()->create([
            'user_id' => $employee->id,
            'day' => $time->isoWeekday(),
            'work_start_time' => $time->subMinutes(15)->format('H:i'),
            'work_end_time' => '24:00',
            'latitude' => 1,
            'longitude' => 1,
            'radius' => 100,
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($employee)
            ->from(route('employee.attendance'))
            ->post(route('checkin'), [
                'latitude' => 100000,
                'longitude' => 100000,
                'photo' => $file,
            ]);

        $response->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger')
            ->assertSessionMissing('success');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance = Attendance::where('user_id', $employee->id)
            ->where('date', $time->format('Y-m-d'))
            ->first();
        expect($attendance)->toBeNull();
    });
});
