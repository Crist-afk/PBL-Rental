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

/**
 * Penyesuaian: Middleware 'auth' dimatikan sementara.
 * Alasan: LoginController saat ini hanya melakukan pengecekan teks biasa 
 * dan belum mendaftarkan session ke sistem Auth Laravel.
 */

// Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    // ->middleware('auth'); // Dimatikan agar bisa diakses

// Route untuk produk
Route::get('/produk', [DashboardController::class, 'produk'])
    ->name('produk');
    // ->middleware('auth'); // Dimatikan agar bisa diakses