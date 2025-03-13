<?php

use App\Enums\VacationRequestStatus;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\VacationRequest;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRole::ADMIN])->fresh();
    $this->dimas = User::factory()
        ->create(['name' => 'Dimas'])->fresh();
    $this->vacationRequest = VacationRequest::factory()
        ->create(['user_id' => $this->dimas->id])->fresh();
});

it('can reject the vacation request', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'vacation-requests.update-status',
            ['vacation_request' => $this->dimas->vacationRequests()->first()->id]
        ), [
            'status' => VacationRequestStatus::REJECTED->value
        ]);

    $this->vacationRequest->refresh();

    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');
    expect($this->vacationRequest->status)->toBe(VacationRequestStatus::REJECTED);
});

it('can approve the vacation request', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'vacation-requests.update-status',
            ['vacation_request' => $this->dimas->vacationRequests()->first()->id]
        ), [
            'status' => VacationRequestStatus::APPROVED->value
        ]);

    $this->vacationRequest->refresh();

    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');
    expect($this->vacationRequest->status)->toBe(VacationRequestStatus::APPROVED);
});

it('cant update status as pending', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'vacation-requests.update-status',
            ['vacation_request' => $this->dimas->vacationRequests()->first()->id]
        ), [
            'status' => VacationRequestStatus::PENDING->value
        ]);

    $this->vacationRequest->refresh();

    $response->assertRedirect()
        ->assertSessionHasErrors();
    expect($this->vacationRequest->status)->toBe(VacationRequestStatus::PENDING);
});

it('cant update the status with invalid status', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'vacation-requests.update-status',
            ['vacation_request' => $this->dimas->vacationRequests()->first()->id]
        ), [
            'status' => 'Hengker'
        ]);

    $this->vacationRequest->refresh();

    $response->assertRedirect()
        ->assertSessionHasErrors();
    expect($this->vacationRequest->status)->not()->toBe('Hengker');
});
