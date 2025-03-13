<?php

use App\Enums\UserRole;
use App\Models\Attendance;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRole::ADMIN])->fresh();
});

it('can render the page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('attendances.index'));

    $response->assertOk();
});

test('search', function () {
    $dimas = User::factory()
        ->has(Attendance::factory())
        ->create(['name' => 'Dimas']);
    $khrisna = User::factory()
        ->has(Attendance::factory())
        ->create(['name' => 'Khrisna']);

    $response = $this
        ->actingAs($this->user)
        ->get(route('schedules.index', ['s' => 'Dimas']));

    $response->assertOk()
        ->assertDontSee('Khrisna')
        ->assertSee('Dimas');
});
