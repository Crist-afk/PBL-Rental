<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardPelangganController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\PasswordResetController;

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
Route::get('/product', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
// Legacy redirect aliases (kept for backwards-compatible URLs)
Route::redirect('/products', '/product', 301);
Route::redirect('/products/{id}', '/product/{id}', 301);

// ==================== ROUTE FORUM (PUBLIK) ====================
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/{forumPost}', [ForumController::class, 'show'])->name('forum.show');

// ==================== DASHBOARD PELANGGAN ====================
Route::middleware(['auth'])->group(function () {
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
    Route::get('/riwayat/{id}/faktur', [DashboardPelangganController::class, 'faktur'])->name('riwayat.faktur');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/cover', [ProfileController::class, 'updateCover'])->name('profile.updateCover');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile/account', [ProfileController::class, 'destroyAccount'])->name('profile.account.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ==================== ADMIN ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ── Kostum CRUD ──
    Route::get('/kostum', [AdminController::class, 'kostum'])->name('kostum');
    Route::post('/kostum', [AdminController::class, 'kostumStore'])->name('kostum.store');
    Route::put('/kostum/{id}', [AdminController::class, 'kostumUpdate'])->name('kostum.update');
    Route::delete('/kostum/{id}', [AdminController::class, 'kostumDestroy'])->name('kostum.destroy');

    // ── Kategori CRUD ──
    Route::post('/kategori', [AdminController::class, 'kategoriStore'])->name('kategori.store');
    Route::delete('/kategori/{id}', [AdminController::class, 'kategoriDestroy'])->name('kategori.destroy');

    // ── Pembayaran ──
    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/{id}/setujui', [AdminController::class, 'pembayaranSetujui'])->name('pembayaran.setujui');
    Route::post('/pembayaran/{id}/tolak', [AdminController::class, 'pembayaranTolak'])->name('pembayaran.tolak');

    // ── Pengembalian ──
    Route::get('/pengembalian', [AdminController::class, 'pengembalian'])->name('pengembalian');
    Route::post('/pengembalian/{id}/kembali', [AdminController::class, 'pengembalianKembali'])->name('pengembalian.kembali');

    // ── Riwayat ──
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat/user/{id}', [AdminController::class, 'riwayatUser'])->name('riwayat.user');

    // ── Pengguna ──
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
    Route::delete('/pengguna/{id}', [AdminController::class, 'penggunaDestroy'])->name('pengguna.destroy');

    // ── Profil Admin ──
    Route::get('/profil', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('/profil', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profil/avatar', [AdminProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profil/cover', [AdminProfileController::class, 'updateCover'])->name('profile.cover');
});

// [2] ROUTE GUEST
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});
