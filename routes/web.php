<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardPelangganController;   // ← Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// [1] ROUTE PUBLIK
Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// ==================== ROUTE PRODUK ====================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ==================== ROUTE FORUM (PUBLIK) ====================
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/{forumPost}', [ForumController::class, 'show'])->name('forum.show');

// ==================== DASHBOARD PELANGGAN ====================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardPelangganController::class, 'index'])
         ->name('dashboard.pelanggan');

    // Route lain yang butuh login
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::patch('/forum/{forumPost}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{forumPost}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{forumPost}/comments', [ForumController::class, 'storeComment'])->name('forum.comments.store');
    Route::patch('/forum/{forumPost}/comments/{forumComment}', [ForumController::class, 'updateComment'])->name('forum.comments.update');
    Route::delete('/forum/{forumPost}/comments/{forumComment}', [ForumController::class, 'destroyComment'])->name('forum.comments.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// [2] ROUTE GUEST
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');
});