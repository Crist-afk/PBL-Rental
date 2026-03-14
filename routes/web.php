<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

// Route untuk halaman utama / home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk halaman contact
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Route untuk login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'autentikasi'])->name('login.autentikasi');

// Route untuk dashboard (perlu middleware auth agar hanya bisa diakses setelah login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Route untuk produk (perlu middleware auth)
Route::get('/produk', [DashboardController::class, 'produk'])
    ->name('produk')
    ->middleware('auth');