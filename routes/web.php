<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// [1] ROUTE PUBLIK (Bisa diakses siapa saja)
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');

// ==================== ROUTE PRODUK ====================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route detail produk (siap digunakan untuk tombol "Detail")
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// ======================================================

Route::view('/contact', 'contact')->name('contact');
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/forum/{forumPost}', [ForumController::class, 'show'])->name('forum.show');


// [2] ROUTE GUEST (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    // Menampilkan form login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Memproses data login
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');

    // Menampilkan form register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Memproses data register
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');
});


// [3] ROUTE AUTH (Hanya bisa diakses jika SUDAH login)
Route::middleware('auth')->group(function () {
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::patch('/forum/{forumPost}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{forumPost}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{forumPost}/comments', [ForumController::class, 'storeComment'])->name('forum.comments.store');
    Route::patch('/forum/{forumPost}/comments/{forumComment}', [ForumController::class, 'updateComment'])->name('forum.comments.update');
    Route::delete('/forum/{forumPost}/comments/{forumComment}', [ForumController::class, 'destroyComment'])->name('forum.comments.destroy');

    // Halaman Profil & Update
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});