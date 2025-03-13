<?php

use App\Enums\UserRole;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use App\Models\VacationRequest;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'name',
            'role',
            'email',
            'email_verified_at',
            'photo',
            'created_at',
            'updated_at',
        ]);
});

test('role', function () {
    $user = User::factory()->create()->fresh();

    expect($user->role)->toBeInstanceOf(UserRole::class);
});

it('has many schedules', function () {
    $user = User::factory()
        ->has(Schedule::factory()->count(3))
        ->create()->fresh();

    Schedule::factory()->create(['user_id' => $user->id]);

    expect($user->schedules)->toHaveCount(4)
        ->and($user->schedules->first())->toBeInstanceOf(Schedule::class);
});

it('has many attendances', function () {
    $user = User::factory()
        ->has(Attendance::factory()->count(3))
        ->create()->fresh();

    Attendance::factory()->create(['user_id' => $user->id]);

    expect($user->attendances)->toHaveCount(4)
        ->and($user->attendances->first())->toBeInstanceOf(Attendance::class);
});

it('has many vacation requests', function () {
    $user = User::factory()
        ->has(VacationRequest::factory()->count(3))
        ->create()->fresh();

    VacationRequest::factory()->create(['user_id' => $user->id]);

    expect($user->vacationRequests)->toHaveCount(4)
        ->and($user->vacationRequests->first())->toBeInstanceOf(VacationRequest::class);
});
