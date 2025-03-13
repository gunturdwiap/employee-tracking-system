<?php

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use App\Enums\AttendanceStatus;
use App\Enums\AttendanceVerificationStatus;

test('to array', function () {
    $attendance = Attendance::factory()->create()->fresh();

    expect(array_keys($attendance->toArray()))
        ->toBe([
            'id',
            'date',
            'check_in_time',
            'check_out_time',
            'check_in_photo',
            'check_out_photo',
            'verification_status',
            'status',
            'created_at',
            'updated_at',
            'user_id',
        ]);
});
// 'date' => 'datetime:Y-m-d',
//             'check_in_time' => 'datetime:H:i:s',
//             'check_out_time' => 'datetime:H:i:s',
//             'status' => AttendanceStatus::class,
//             'verification_status' => AttendanceVerificationStatus::class

test('date', function () {
    $attendance = Attendance::factory()->create()->fresh();

    expect($attendance->date)->toBeInstanceOf(Carbon::class);
});

test('check_in_time', function () {
    $attendance = Attendance::factory()->create()->fresh();

    expect($attendance->check_in_time)->toBeInstanceOf(Carbon::class);
});

test('check_out_time', function () {
    $attendance = Attendance::factory()->create()->fresh();

    expect($attendance->check_out_time)->toBeInstanceOf(Carbon::class);
});

test('status', function () {
    $attendance = Attendance::factory()->create()->fresh();

    expect($attendance->status)->toBeInstanceOf(AttendanceStatus::class);
});

test('verification_status', function () {
    $attendance = Attendance::factory()->create()->fresh();

    expect($attendance->verification_status)->toBeInstanceOf(AttendanceVerificationStatus::class);
});

it('belongs to user', function () {
    $attendance = Attendance::factory()->create();

    expect($attendance->user)->toBeInstanceOf(User::class);
});
