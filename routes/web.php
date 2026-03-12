<?php

use App\Http\Controllers\ManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [ManagementController::class, 'showLogin'])->name('login');
    Route::post('/login', [ManagementController::class, 'login']);
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/', [ManagementController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [ManagementController::class, 'dashboard']);
    Route::get('/events', [ManagementController::class, 'events'])->name('events');
    Route::get('/donations', [ManagementController::class, 'donations'])->name('donations');
    Route::post('/donations', [ManagementController::class, 'storeDonation']);
    Route::get('/purohits', [ManagementController::class, 'purohits'])->name('purohits');
    Route::post('/purohits', [ManagementController::class, 'storePurohit']);
    Route::get('/volunteers', [ManagementController::class, 'volunteers'])->name('volunteers');
    Route::get('/assign-volunteers', [ManagementController::class, 'assignVolunteers'])->name('assign-volunteers');
    Route::get('/notification-logs', [ManagementController::class, 'notificationLogs'])->name('notification-logs');
    Route::get('/notification-settings', [ManagementController::class, 'notificationSettings'])->name('notification-settings');
    Route::get('/profile', [ManagementController::class, 'profile'])->name('profile');
    Route::post('/logout', [ManagementController::class, 'logout'])->name('logout');
});
