<?php

use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Services\AttendanceService;

beforeEach(function () {
    $this->service = new AttendanceService();
});

test('user has schedule today', function () {
    $user = User::factory()->create();
    Schedule::factory()->create([
        'user_id' => $user->id,
        'day' => now()->isoWeekday(),
    ]);

    expect($this->service->hasScheduleToday($user))
        ->toBeInstanceOf(Schedule::class);
});

test('user has no schedule today', function () {
    $user = User::factory()->create();

    expect($this->service->hasScheduleToday($user))
        ->toBeNull();
});

test('user has checked in today', function () {
    $user = User::factory()->create();
    Attendance::factory()->create([
        'user_id' => $user->id,
        'date' => now()->format('Y-m-d'),
    ]);

    expect($this->service->hasCheckedInToday($user))
        ->toBeInstanceOf(Attendance::class);
});

test('user has not checked in today', function () {
    $user = User::factory()->create();

    expect($this->service->hasCheckedInToday($user))
        ->toBeNull();
});

test('is within check in time', function () {
    $early = now()->subMinutes(29);
    $late = now()->addMinutes(29);
    $checkInTime = now();

    expect($this->service->isWithinCheckInTime($early, $checkInTime))
        ->toBeTrue()
        ->and($this->service->isWithinCheckInTime(now(), $checkInTime))
        ->toBeTrue()
        ->and($this->service->isWithinCheckInTime($late, $checkInTime))
        ->toBeTrue();
});

test('is not within check in time', function () {
    $early = now()->subMinutes(31);
    $late = now()->addMinutes(31);
    $checkInTime = now();

    expect($this->service->isWithinCheckInTime($early, $checkInTime))
        ->toBeFalse()
        ->and($this->service->isWithinCheckInTime($late, $checkInTime))
        ->toBeFalse();
});

test('user has checked out today', function () {
    $user = User::factory()->create();
    Attendance::factory()->create([
        'user_id' => $user->id,
        'date' => now()->format('Y-m-d'),
        'check_out_time' => now(),
    ]);

    expect($this->service->hasCheckedOutToday($user))
        ->toBeInstanceOf(Attendance::class);
});

test('user has not checked out today', function () {
    $user = User::factory()->create();
    Attendance::factory()->create([
        'user_id' => $user->id,
        'date' => now()->format('Y-m-d'),
        'check_out_time' => null,
    ]);

    expect($this->service->hasCheckedOutToday($user))
        ->toBeNull();
});

test('is within radius', function () {
    $latitude = 14.5995;
    $longitude = 120.9842;
    $radius = 100;
    $location = [
        'latitude' => 14.5995,
        'longitude' => 120.9842,
    ];

    expect($this->service->isWithinRadius($latitude, $longitude, $location['latitude'], $location['longitude'], $radius))
        ->toBeTrue();
});

test('is not within radius', function () {
    $latitude = 14.5995;
    $longitude = 120.9842;
    $radius = 100;

    //more than 100 meters away
    $location = [
        'latitude' => 14.5995,
        'longitude' => 120.9832,
    ];

    expect($this->service->isWithinRadius($latitude, $longitude, $location['latitude'], $location['longitude'], $radius))
        ->toBeFalse();
});
