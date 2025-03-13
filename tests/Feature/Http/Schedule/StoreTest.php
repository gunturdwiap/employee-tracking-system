<?php

use App\Enums\Day;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Schedule;

test('create schedule', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);

    $response = $this->actingAs($admin)
        ->from(route('schedules.create', ['user' => $employee->id]))
        ->post(route('schedules.store', ['user' => $employee->id]), [
            'work_start_time' => '08:00',
            'work_end_time' => '17:00',
            'day' => Day::MONDAY->value,
            'latitude' => -6.21462,
            'longitude' => 106.84513,
            'radius' => 100,
        ]);

    $response->assertRedirect(route('schedules.create', ['user' => $employee->id]))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');

    $schedule = Schedule::where('user_id', $employee->id)->first();
    expect($schedule)
        ->not()->toBeNull()
        ->and($schedule->day)->toBe(Day::MONDAY)
        ->and($schedule->work_start_time->format('H:i'))->toBe('08:00')
        ->and($schedule->work_end_time->format('H:i'))->toBe('17:00')
        ->and($schedule->latitude)->toBe(-6.21462)
        ->and($schedule->longitude)->toBe(106.84513)
        ->and($schedule->radius)->toBe(100);

});

test('cant create schedule with duplicate day', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
    Schedule::factory()->create([
        'user_id' => $employee->id,
        'day' => Day::MONDAY,
    ]);

    $response = $this->actingAs($admin)
        ->from(route('schedules.create', ['user' => $employee->id]))
        ->post(route('schedules.store', ['user' => $employee->id]), [
            'work_start_time' => now()->format('H:i'),
            'work_end_time' => now()->addHour()->format('H:i'),
            'day' => Day::MONDAY->value,
            'latitude' => -6.21462,
            'longitude' => 106.84513,
            'radius' => 100,
        ]);

    $response->assertRedirect(route('schedules.create', ['user' => $employee->id]))
        ->assertSessionHasErrors('day');
    $schedule = Schedule::where('day', Day::MONDAY);
    expect($schedule->count())->toBe(1);
});

test('cant create schedule with invalid start and end range', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);

    $response = $this->actingAs($admin)
        ->from(route('schedules.create', ['user' => $employee->id]))
        ->post(route('schedules.store', ['user' => $employee->id]), [
            'work_start_time' => '24:00',
            'work_end_time' => '17:00',
            'day' => Day::MONDAY->value,
            'latitude' => -6.21462,
            'longitude' => 106.84513,
            'radius' => 100,
        ]);

    $response->assertRedirect(route('schedules.create', ['user' => $employee->id]))
        ->assertSessionHasErrors('work_start_time')
        ->assertSessionHasErrors('work_end_time');
    $schedule = Schedule::where('user_id', $employee->id);
    expect($schedule->count())->toBe(0);
});
