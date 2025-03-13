<?php

use App\Enums\AttendanceStatus;
use App\Enums\VacationRequestStatus;
use App\Models\Schedule;
use App\Models\User;
use App\Models\VacationRequest;

it('marks attendance as on vacation', function () {
    $user = User::factory()->create();
    Schedule::factory()->create([
        'user_id' => $user->id,
        'day' => now()->isoWeekday(),
    ]);
    VacationRequest::factory()->create([
        'user_id' => $user->id,
        'start' => now()->subDays(1),
        'end' => now()->addDays(1),
        'status' => VacationRequestStatus::APPROVED,
    ]);

    $this->artisan('app:update-vacation-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseHas('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::VACATION,
    ]);
});

it('does not mark attendance as on vacation if vacation request is not approved', function () {
    $user = User::factory()->create();
    VacationRequest::factory()->create([
        'user_id' => $user->id,
        'start' => now()->subDays(1),
        'end' => now()->addDays(1),
        'status' => VacationRequestStatus::PENDING,
    ]);

    $this->artisan('app:update-vacation-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseMissing('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::VACATION,
    ]);
});

it('does not mark attendance as on vacation if vacation request is not for today', function () {
    $user = User::factory()->create();
    VacationRequest::factory()->create([
        'user_id' => $user->id,
        'start' => now()->subDays(2),
        'end' => now()->subDays(1),
        'status' => VacationRequestStatus::APPROVED,
    ]);

    $this->artisan('app:update-vacation-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseMissing('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::VACATION,
    ]);
});

it('does not mark attendance as on vacation if vacation request is for today but not approved', function () {
    $user = User::factory()->create();
    VacationRequest::factory()->create([
        'user_id' => $user->id,
        'start' => now(),
        'end' => now(),
        'status' => VacationRequestStatus::PENDING,
    ]);

    $this->artisan('app:update-vacation-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseMissing('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::VACATION,
    ]);
});

it('does not mark attendance as on vacation if user has no schedule today', function () {
    $user = User::factory()->create();
    VacationRequest::factory()->create([
        'user_id' => $user->id,
        'start' => now()->subDays(1),
        'end' => now()->addDays(1),
        'status' => VacationRequestStatus::APPROVED,
    ]);

    $this->artisan('app:update-vacation-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseMissing('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::VACATION,
    ]);
});

test('marks attendance that starts and ends on the same day', function () {
    $user = User::factory()->create();
    Schedule::factory()->create([
        'user_id' => $user->id,
        'day' => now()->isoWeekday(),
    ]);
    VacationRequest::factory()->create([
        'user_id' => $user->id,
        'start' => now(),
        'end' => now(),
        'status' => VacationRequestStatus::APPROVED,
    ]);

    $this->artisan('app:update-vacation-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseHas('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::VACATION,
    ]);
});
