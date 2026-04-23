<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function() { return redirect()->route('login'); });

// Registration
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Dashboard (protected)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// EXTRA FEATURE: Profile
Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware('auth')
    ->name('profile');

Route::post('/profile', [AuthController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('profile.update');