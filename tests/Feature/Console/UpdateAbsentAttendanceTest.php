<?php

use App\Models\Attendance;
use App\Models\User;
use App\Models\Schedule;
use App\Enums\AttendanceStatus;

it('marks attendance as absent', function () {
    $user = User::factory()->create();
    Schedule::factory()->create([
        'user_id' => $user->id,
        'day' => now()->isoWeekday(),
    ]);

    $this->artisan('app:update-absent-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseHas('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::ABSENT,
    ]);
});

it('does not mark attendance as absent if user has checked in', function () {
    $user = User::factory()->create();
    Schedule::factory()->create([
        'user_id' => $user->id,
        'day' => now()->isoWeekday(),
    ]);
    Attendance::factory()->create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
    ]);

    $this->artisan('app:update-absent-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseMissing('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::ABSENT,
    ]);
});

it('does not mark attendance as absent if user has no schedule today', function () {
    $user = User::factory()->create();

    $this->artisan('app:update-absent-attendance')
        ->assertExitCode(0);

    $this->assertDatabaseMissing('attendances', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'status' => AttendanceStatus::ABSENT,
    ]);
});
