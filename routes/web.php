<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/', function () {
    session()->flash('success', 'You are logged in');
    return view('dashboard');
})->name('dashboard');

