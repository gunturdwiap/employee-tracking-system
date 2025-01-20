<?php

use App\Http\Controllers\GetAttendanceTrendsController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UpdateProfileController;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\VacationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VacationRequestController;
use App\Http\Controllers\VerifyAttendanceController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\GetAttendanceOverviewController;
use App\Http\Controllers\UpdateVacationRequestController;
use App\Http\Controllers\EmployeeVacationRequestController;


// Auth
require __DIR__ . '/auth.php';

// Admin & Verificator
Route::middleware(['auth', 'can:access-admin-panel'])->prefix('/admin')->group(function () {
    // Dashboard
    Route::get('/', DashboardController::class)->name('dashboard');

    // Users Management
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->can('viewAny', User::class)
            ->name('index');
        Route::get('/create', [UserController::class, 'create'])
            ->can('create', User::class)
            ->name('create');
        Route::post('', [UserController::class, 'store'])
            ->can('create', User::class)
            ->name('store');
        Route::get('/{user}', [UserController::class, 'show'])
            ->can('view', 'user')
            ->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])
            ->can('update', 'user')
            ->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])
            ->can('update', 'user')
            ->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->can('delete', 'user')
            ->name('destroy');
    });

    // Schedules Management
    Route::name('schedules.')->group(function () {
        Route::get('/schedules', [ScheduleController::class, 'index'])
            ->can('viewAny', Schedule::class)
            ->name('index');
        Route::get('/users/{user}/schedules/create', [ScheduleController::class, 'create'])
            ->can('create', Schedule::class)
            ->name('create');
        Route::post('/users/{user}/schedules', [ScheduleController::class, 'store'])
            ->can('create', Schedule::class)
            ->name('store');
        Route::get('/users/{user}/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])
            ->can('update', 'schedule')
            ->name('edit');
        Route::put('/users/{user}/schedules/{schedule}', [ScheduleController::class, 'update'])
            ->can('update', 'schedule')
            ->name('update');
        Route::delete('/users/{user}/schedules/{schedule}', [ScheduleController::class, 'destroy'])
            ->can('delete', 'schedule')
            ->name('destroy');
    });

    // Attendances Management
    Route::name('attendances.')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'index'])
            ->can('viewAny', Attendance::class)
            ->name('index');
        // Route::post('/attendances', [AttendanceController::class, 'store'])
        //     ->can('create', Attendance::class)
        //     ->name('store');
        Route::get('/attendances/{attendance}', [AttendanceController::class, 'show'])
            ->can('view', 'attendance')
            ->name('show');
        // Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])
        //     ->can('update', 'attendance')
        //     ->name('update');
        // Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroy'])
        //     ->can('delete', 'attendance')
        //     ->name('destroy');

        Route::put('/attendances/{attendance}/verification', VerifyAttendanceController::class)
            ->can('verify', 'attendance')
            ->name('verify');
    });

    // Vacation Requests Management
    Route::name('vacation-requests.')->group(function () {
        Route::get('/vacation-requests', [VacationRequestController::class, 'index'])
            ->can('viewAny', VacationRequest::class)
            ->name('index');
        Route::post('/vacation-requests', [VacationRequestController::class, 'store'])
            ->can('create', VacationRequest::class)
            ->name('store');
        Route::get('/vacation-requests/{vacation_request}', [VacationRequestController::class, 'show'])
            ->can('view', 'vacation_request')
            ->name('show');
        Route::put('/vacation-requests/{vacation_request}', [VacationRequestController::class, 'update'])
            ->can('update', 'vacation_request')
            ->name('update');
        Route::delete('/vacation-requests/{vacation_request}', [VacationRequestController::class, 'destroy'])
            ->can('delete', 'vacation_request')
            ->name('destroy');

        Route::put('/vacation-requests/{vacation_request}/update-status', UpdateVacationRequestController::class)
            ->can('updateStatus', 'vacation_request')
            ->name('update-status');
    });

    // Chart
    Route::get('/attendance-status-overview', GetAttendanceOverviewController::class)
        ->name('attendances.overview');
    Route::get('/attendance-trends', GetAttendanceTrendsController::class)
        ->name('attendances.trends');

    Route::get('/profile', function (Request $request) {
        return view('admin-profile', ['user' => $request->user()]);
    })->name('profile');
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

        Route::get('/profile', function (Request $request) {
            return view('employee.profile', [
                'user' => $request->user()
            ]);
        })->name('employee.profile');
    });

Route::middleware(['auth'])->group(function () {
    Route::put('upddate-profile', UpdateProfileController::class)
        ->name('update-profile');
    Route::put('update-password', UpdatePasswordController::class)
        ->name('update-password');
});
