<?php

use App\Enums\UserRole;
use App\Models\User;

it('can render the page', function () {
    $user = User::factory()->create(['role' => UserRole::EMPLOYEE]);
    $response = $this->actingAs($user)->get(route('employee.attendance-history'));

    $response->assertOk()
        ->assertViewIs('employee.attendance-history')
        ->assertViewHas('attendances');
});
