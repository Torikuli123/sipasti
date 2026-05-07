<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AiController;

// ---- Auth Routes ----
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---- Public Routes ----
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

// ---- Protected Routes ----
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/profile', 'profile')->name('profile');
    Route::view('/change-password', 'password.change')->name('password.change');
    Route::view('/settings/theme', 'settings.theme')->name('settings.theme');
    Route::view('/settings/notifications', 'settings.notifications')->name('settings.notifications');

    // Arsip CRUD
    Route::resource('arsip', ArsipController::class);

    // Export
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/download', [ExportController::class, 'download'])->name('export.download');

    // AI
    Route::get('/ai', [AiController::class, 'index'])->name('ai.index');
});
