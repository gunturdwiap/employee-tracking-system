<?php

use App\Enums\AttendanceVerificationStatus;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Attendance;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRole::ADMIN])->fresh();
    $this->dimas = User::factory()
        ->create(['name' => 'Dimas'])->fresh();
    $this->attendance = Attendance::factory()
        ->create(['user_id' => $this->dimas->id])->fresh();
});

it('can reject the attendance', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'attendances.verify',
            ['attendance' => $this->dimas->attendances()->first()->id]
        ), [
            'verification_status' => AttendanceVerificationStatus::REJECTED->value
        ]);

    $this->attendance->refresh();

    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');
    expect($this->attendance->verification_status)->toBe(AttendanceVerificationStatus::REJECTED);
});

it('can approve the attendance', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'attendances.verify',
            ['attendance' => $this->dimas->attendances()->first()->id]
        ), [
            'verification_status' => AttendanceVerificationStatus::APPROVED->value
        ]);

    $this->attendance->refresh();

    $response->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionHas('success');
    expect($this->attendance->verification_status)->toBe(AttendanceVerificationStatus::APPROVED);
});

it('cant update status as pending', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'attendances.verify',
            ['attendance' => $this->dimas->attendances()->first()->id]
        ), [
            'verification_status' => AttendanceVerificationStatus::PENDING->value
        ]);

    $this->attendance->refresh();

    $response->assertRedirect()
        ->assertSessionHasErrors();
    expect($this->attendance->verification_status)->toBe(AttendanceVerificationStatus::PENDING);
});

it('cant update the status with invalid status', function () {
    $response = $this->actingAs($this->user)
        ->put(route(
            'attendances.verify',
            ['attendance' => $this->dimas->attendances()->first()->id]
        ), [
            'verification_status' => 'Hengker'
        ]);

    $this->attendance->refresh();

    $response->assertRedirect()
        ->assertSessionHasErrors();
    expect($this->attendance->verification_status)->not()->toBe('Hengker');
});
