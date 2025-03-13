<?php

use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\User;

test('delete schedule', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    $schedule = Schedule::factory()->create();

    $response = $this->actingAs($admin)
        ->from(route('schedules.index'))
        ->delete(route('schedules.destroy', ['user' => $schedule->user, 'schedule' => $schedule->id]));

    $response->assertRedirect(route('schedules.index'))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');

    expect(Schedule::find($schedule->id))->toBeNull();
});
