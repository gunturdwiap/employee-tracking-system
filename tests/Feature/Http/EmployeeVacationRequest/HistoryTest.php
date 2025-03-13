<?php

use App\Models\User;
use App\Enums\UserRole;

it('can render the page', function () {
    $user = User::factory()->create(['role' => UserRole::EMPLOYEE]);
    $response = $this->actingAs($user)->get(route('employee.vacation-request-history'));

    $response->assertOk()
        ->assertViewIs('employee.vacation-request-history')
        ->assertViewHas('vacationRequests');
});
