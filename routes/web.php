<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeAttendanceController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


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

        Route::resource('attendances', AttendanceController::class);
    });

Route::middleware(['auth', 'can:access-employee-menu'])
    ->group(function () {
        Route::get('/attendance', [EmployeeAttendanceController::class, 'create'])
            ->name('employee.attendance');

        Route::post('/check-in', [EmployeeAttendanceController::class, 'store'])
            ->name('checkin');

        Route::put('/check-out', [EmployeeAttendanceController::class, 'update'])
            ->name('checkout');
    });
