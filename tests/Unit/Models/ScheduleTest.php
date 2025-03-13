<?php

use App\Enums\Day;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

test('to array', function () {
    $schedule = Schedule::factory()->create()->fresh();

    expect(array_keys($schedule->toArray()))
        ->toBe([
            'id',
            'work_start_time',
            'work_end_time',
            'day',
            'latitude',
            'longitude',
            'radius',
            'created_at',
            'updated_at',
            'user_id',
        ]);
});

test('work_start_time', function () {
    $schedule = Schedule::factory()->create()->fresh();

    expect($schedule->work_start_time)->toBeInstanceOf(Carbon::class);
});

test('work_end_time', function () {
    $schedule = Schedule::factory()->create()->fresh();

    expect($schedule->work_end_time)->toBeInstanceOf(Carbon::class);
});

test('day', function () {
    $schedule = Schedule::factory()->create()->fresh();

    expect($schedule->day)->toBeInstanceOf(Day::class);
});

it('belongs to a user', function () {
    $schedule = Schedule::factory()->create();

    expect($schedule->user)->toBeInstanceOf(User::class);
});
