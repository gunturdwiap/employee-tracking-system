<?php

use App\Enums\Day;
use App\Enums\UserRole;
use App\Models\User;

test('update schedule', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    $employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
    $schedule = $employee->schedules()->create([
        'work_start_time' => '08:00',
        'work_end_time' => '17:00',
        'day' => Day::MONDAY->value,
        'latitude' => -6.21462,
        'longitude' => 106.84513,
        'radius' => 100,
    ]);

    $response = $this->actingAs($admin)
        ->from(route('schedules.edit', ['user' => $employee->id, 'schedule' => $schedule->id]))
        ->put(route('schedules.update', ['user' => $employee->id, 'schedule' => $schedule->id]), [
            'work_start_time' => '09:00',
            'work_end_time' => '18:00',
            'day' => Day::TUESDAY->value,
            'latitude' => -6.21462,
            'longitude' => 106.84513,
            'radius' => 100,
        ]);

    $response->assertRedirect(route('schedules.edit', ['user' => $employee->id, 'schedule' => $schedule->id]))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');

    $schedule->refresh();
    expect($schedule)
        ->not()->toBeNull()
        ->and($schedule->day)->toBe(Day::TUESDAY)
        ->and($schedule->work_start_time->format('H:i'))->toBe('09:00')
        ->and($schedule->work_end_time->format('H:i'))->toBe('18:00')
        ->and($schedule->latitude)->toBe(-6.21462)
        ->and($schedule->longitude)->toBe(106.84513)
        ->and($schedule->radius)->toBe(100);
});
