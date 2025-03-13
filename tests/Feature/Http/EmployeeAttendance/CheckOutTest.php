<?php

use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// can check out
it('can check out', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $time->setTime(8, 0); // Set the time to 8 AM
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create([
            'user_id' => $user->id,
            'work_start_time' => $time->format('H:i'),
            'work_end_time' => '17:00',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'radius' => 100,
            'day' => $time->isoWeekday(),
        ]);
        $attendance = Attendance::factory()->create([
            'user_id' => $user->id,
            'check_in_time' => $time->subMinutes(15),
            'check_out_time' => null,
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $this->travelTo($time->setTime(17, 0));
        $response = $this->actingAs($user)
            ->from(route('employee.attendance'))
            ->put(route('checkout'), [
                'latitude' => 14.5995,
                'longitude' => 120.9842,
                'photo' => $file,
            ]);

        $response
            ->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('success');
        Storage::disk('public')->assertExists('photos/' . $file->hashName());
        $attendance->refresh();
        expect($attendance->check_out_time->format('H:i'))->toBe($time->format('H:i'));
    });
});

// cant check out if no check in
it('cant check out if no check in', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $time->setTime(8, 0); // Set the time to 8 AM
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create([
            'user_id' => $user->id,
            'work_start_time' => $time->format('H:i'),
            'work_end_time' => '17:00',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'radius' => 100,
            'day' => $time->isoWeekday(),
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $this->travelTo($time->setTime(17, 0));
        $response = $this->actingAs($user)
            ->from(route('employee.attendance'))
            ->put(route('checkout'), [
                'latitude' => 14.5995,
                'longitude' => 120.9842,
                'photo' => $file,
            ]);



        $response
            ->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();
        expect($attendance)->toBeNull();
    });
});
// cant check out if no schedule
it('cant check out if no schedule', function () {
    $this->freezeTime(function (Carbon $time) {
        $time->setTime(8, 0); // Set the time to 8 AM
        $user = User::factory()->create();
        $attendance = Attendance::factory()->create([
            'user_id' => $user->id,
            'check_in_time' => $time->subMinutes(15),
            'check_out_time' => null,
        ]);

        $this->travelTo($time->setTime(17, 0));
        $response = $this->actingAs($user)
            ->from(route('employee.attendance'))
            ->put(route('checkout'), [
                'latitude' => 14.5995,
                'longitude' => 120.9842,
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);


        $response
            ->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger');
        $attendance->refresh();
        expect($attendance->check_out_time)->toBeNull();
    });
});
// cant check out if not within check out time
it('cant check out if not within check out time', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $time->setTime(8, 0); // Set the time to 8 AM
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create([
            'user_id' => $user->id,
            'work_start_time' => $time->format('H:i'),
            'work_end_time' => '17:00',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'radius' => 100,
            'day' => $time->isoWeekday(),
        ]);
        $attendance = Attendance::factory()->create([
            'user_id' => $user->id,
            'check_in_time' => $time->subMinutes(15),
            'check_out_time' => null,
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $time->setTime(20, 30);
        $response = $this->actingAs($user)
            ->from(route('employee.attendance'))
            ->put(route('checkout'), [
                'latitude' => 14.5995,
                'longitude' => 120.9842,
                'photo' => $file,
            ]);

        $response
            ->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance->refresh();
        expect($attendance->check_out_time)->toBeNull();
    });
});

// cant check out if not within radius
it('cant check out if not within radius', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $time->setTime(8, 0); // Set the time to 8 AM
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create([
            'user_id' => $user->id,
            'work_start_time' => $time->format('H:i'),
            'work_end_time' => '17:00',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'radius' => 100,
            'day' => $time->isoWeekday(),
        ]);
        $attendance = Attendance::factory()->create([
            'user_id' => $user->id,
            'check_in_time' => $time->subMinutes(15),
            'check_out_time' => null,
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $this->travelTo($time->setTime(17, 0));
        $response = $this->actingAs($user)
            ->from(route('employee.attendance'))
            ->put(route('checkout'), [
                'latitude' => 14,
                'longitude' => 120,
                'photo' => $file,
            ]);


        $response
            ->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance->refresh();
        expect($attendance->check_out_time)->toBeNull();
    });
});

// cant check out if already checked out
it('cant check out if already checked out', function () {
    $this->freezeTime(function (Carbon $time) {
        Storage::fake('public');
        $time->setTime(8, 0); // Set the time to 8 AM
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create([
            'user_id' => $user->id,
            'work_start_time' => $time->format('H:i'),
            'work_end_time' => '17:00',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'radius' => 100,
            'day' => $time->isoWeekday(),
        ]);
        $attendance = Attendance::factory()->create([
            'user_id' => $user->id,
            'check_in_time' => $time->subMinutes(15),
            'check_out_time' => $time->setTime(17, 0),
        ]);
        $file = UploadedFile::fake()->image('photo.jpg');

        $this->travelTo($time->setTime(17, 0));
        $response = $this->actingAs($user)
            ->from(route('employee.attendance'))
            ->put(route('checkout'), [
                'latitude' => 14.5995,
                'longitude' => 120.9842,
                'photo' => $file,
            ]);


        $response
            ->assertRedirect(route('employee.attendance'))
            ->assertSessionHas('danger');
        Storage::disk('public')->assertMissing('photos/' . $file->hashName());
        $attendance->refresh();
        expect($attendance->check_out_time->format('H:i'))->toBe($time->format('H:i'));
    });
});

