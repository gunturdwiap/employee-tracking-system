<?php

use App\Enums\UserRole;
use App\Enums\VacationRequestStatus;
use App\Models\User;
use App\Models\VacationRequest;

beforeEach(function () {
    $this->employee = User::factory()->create(['role' => UserRole::EMPLOYEE]);
});

it('can render the page', function () {
    $response = $this->actingAs($this->employee)
        ->get(route('employee.vacation'));

    $response->assertOk();
});

test('employee can submit vacation request', function () {
    $response = $this->actingAs($this->employee)
        ->post(route('employee.vacation'), [
            'start' => now()->addDays(1)->format('Y-m-d'),
            'end' => now()->addDays(10)->format('Y-m-d'),
            'reason' => 'Malas kerja',
        ]);

    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');
});

test('employee cant submit vacation request with invalid time', function () {
    $response = $this->actingAs($this->employee)
        ->post(route('employee.vacation'), [
            'start' => now()->subDays(1)->format('Y-m-d'),
            'end' => now()->subDays(10)->format('Y-m-d'),
            'reason' => 'Malas kerja',
        ]);

    $response->assertRedirect()
        ->assertSessionHasErrors();
});

test('employee cant submit another vacation request with overlapping time', function () {
    VacationRequest::factory()->create([
        'user_id' => $this->employee->id,
        'start' => now()->addDays(2)->format('Y-m-d'),
        'end' => now()->addDays(5)->format('Y-m-d'),
        'status' => VacationRequestStatus::APPROVED,
    ]);

    $response = $this->actingAs($this->employee)
        ->post(route('employee.vacation'), [
            'start' => now()->addDays(1)->format('Y-m-d'),
            'end' => now()->addDays(10)->format('Y-m-d'),
            'reason' => 'Malas kerja',
        ]);

    $response->assertRedirect()
        ->assertSessionHas('danger');
});

test('employee can submit another vacation request with overlapping time when the previous one is rejected', function () {
    VacationRequest::factory()->create([
        'user_id' => $this->employee->id,
        'start' => now()->addDays(2)->format('Y-m-d'),
        'end' => now()->addDays(5)->format('Y-m-d'),
        'status' => VacationRequestStatus::REJECTED,
    ]);

    $response = $this->actingAs($this->employee)
        ->post(route('employee.vacation'), [
            'start' => now()->addDays(1)->format('Y-m-d'),
            'end' => now()->addDays(10)->format('Y-m-d'),
            'reason' => 'Malas kerja',
        ]);

    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');
});
