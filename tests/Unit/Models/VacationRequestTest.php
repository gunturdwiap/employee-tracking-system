<?php

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\VacationRequest;
use App\Enums\VacationRequestStatus;

test('to array', function () {
    $vacationRequest = VacationRequest::factory()->create()->fresh();

    expect(array_keys($vacationRequest->toArray()))
        ->toBe([
            'id',
            'start',
            'end',
            'status',
            'reason',
            'created_at',
            'updated_at',
            'user_id',
        ]);
});

test('start', function () {
    $vacationRequest = VacationRequest::factory()->create()->fresh();

    expect($vacationRequest->start)->toBeInstanceOf(Carbon::class);
});

test('end', function () {
    $vacationRequest = VacationRequest::factory()->create()->fresh();

    expect($vacationRequest->end)->toBeInstanceOf(Carbon::class);
});

test('status', function () {
    $vacationRequest = VacationRequest::factory()->create()->fresh();

    expect($vacationRequest->status)->toBeInstanceOf(VacationRequestStatus::class);
});

it('belongs to a user', function () {
    $vacationRequest = VacationRequest::factory()->create();

    expect($vacationRequest->user)->toBeInstanceOf(User::class);
});


