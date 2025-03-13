<?php

use App\Enums\UserRole;
use App\Models\Attendance;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRole::ADMIN])->fresh();
    $this->dimas = User::factory()
        ->has(Attendance::factory())
        ->create(['name' => 'Dimas'])->fresh();
});

it('can render the page', function () {
    $response = $this->actingAs($this->user)
        ->get(route('attendances.show', ['attendance' => $this->dimas->attendances()->first()->id]));

    $response->assertOk()
        ->assertSee('Dimas');
});
