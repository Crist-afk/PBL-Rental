<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardPelangganController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== ADMIN DASHBOARD ====================
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/kostum', [AdminController::class, 'kostum'])->name('admin.kostum');
Route::get('/admin/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
Route::get('/admin/pengembalian', [AdminController::class, 'pengembalian'])->name('admin.pengembalian');
Route::get('/admin/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');

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

    Route::get('/booking', [DashboardPelangganController::class, 'booking'])->name('booking.index');
    Route::post('/booking', [DashboardPelangganController::class, 'storeBooking'])->name('booking.store');
    Route::get('/riwayat', [DashboardPelangganController::class, 'riwayat'])->name('riwayat.index');

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