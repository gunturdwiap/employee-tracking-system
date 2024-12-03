<?php

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VacationRequestController;
use App\Http\Controllers\VerifyAttendanceController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\UpdateVacationRequestController;
use App\Http\Controllers\EmployeeVacationRequestController;


// Auth
require __DIR__ . '/auth.php';

// Admin
Route::middleware(['auth', 'can:access-admin-panel'])
    ->prefix('/admin')
    ->group(function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('users', UserController::class);

        // Display all schedules
        Route::get('/schedules', [ScheduleController::class, 'index'])
            ->name('schedules.index');

        // Manage schedule for each user
        Route::resource('/users/{user}/schedules', ScheduleController::class)
            ->except(['index', 'show']);

        Route::resource('/attendances', AttendanceController::class);

        Route::resource('/vacation-requests', VacationRequestController::class);

        // TODO: edit nanti
        Route::put('/vacation-requests/{vacation_request}/update-status', UpdateVacationRequestController::class)
            ->name('vacation-requests.update-status');

        // Verificator
        Route::put('/attendances/{attendance}/verification', VerifyAttendanceController::class)
            ->name('attendances.verify');

    });

// Employee
Route::middleware(['auth', 'can:access-employee-menu', 'verified'])
    ->group(function () {
        Route::redirect('/', '/attendance');
        Route::get('/attendance', [EmployeeAttendanceController::class, 'create'])
            ->name('employee.attendance');

        Route::post('/check-in', [EmployeeAttendanceController::class, 'store'])
            ->name('checkin');

        Route::put('/check-out', [EmployeeAttendanceController::class, 'update'])
            ->name('checkout');

        Route::get('/schedule', function (Request $request) {
            $schedules = Schedule::query()
                ->where('user_id', $request->user()->id)
                ->get();
            return view('employee.schedule', [
                'schedules' => $schedules
            ]);
        })->name('employee.schedule');

        Route::get('/vacation-request', [EmployeeVacationRequestController::class, 'create'])
            ->name('employee.vacation');

        Route::post('/vacation-request', [EmployeeVacationRequestController::class, 'store']);
    });
