<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [SessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::delete('/logout', [SessionController::class, 'destroy'])
        ->name('logout');
});
