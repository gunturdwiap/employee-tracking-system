<?php

use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\User;

it('cant be accessed by guest', function () {
    $response = $this->get(route('schedules.index'));

    $response->assertRedirect(route('login'));
});

it('cant be accessed by employee', function () {
    $user = User::factory()->create(['role' => UserRole::EMPLOYEE]);

    $response = $this
        ->actingAs($user)
        ->get(route('schedules.index'));

    $response->assertStatus(403);
});

it('can be accessed by admin', function () {
    $user = User::factory()->create(['role' => UserRole::ADMIN]);

    $response = $this
        ->actingAs($user)
        ->get(route('schedules.index'));

    $response->assertOk();
});

test('search', function () {
    $user = User::factory()->create(['role' => UserRole::ADMIN]);
    User::factory()
        ->has(Schedule::factory())
        ->create(['name' => 'Dimas']);
    User::factory()
        ->has(Schedule::factory())
        ->create(['name' => 'Khrisna']);

    $response = $this
        ->actingAs($user)
        ->get(route('schedules.index', ['s' => 'Dimas']));

    $response->assertOk()
        ->assertDontSee('Khrisna')
        ->assertSee('Dimas');
});
