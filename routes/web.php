<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman utama (Menampilkan menu_utama.blade.php) - Semua user diarahkan ke sini
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk menu utama
Route::get('/menu-utama', [HomeController::class, 'menuUtama'])->name('menu_utama');

// Route untuk halaman Tentang
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Dashboard hanya untuk user login (tidak auto-redirect dari home)
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Grup route untuk profile (hanya user login yang bisa akses)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes for User management (admin only)
Route::middleware(['auth'])->group(function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Menampilkan berita yang statusnya 'approved' di halaman utama dengan nama yang lebih deskriptif
Route::get('/berita', [PostController::class, 'index'])->name('posts.daftar');
Route::get('/berita/{post}', [PostController::class, 'show'])->name('posts.baca');

// Rute untuk kategori dengan nama yang lebih deskriptif
Route::get('/kategori', [CategoryController::class, 'index'])->name('categories.daftar');

// Rute untuk CRUD Post (butuh autentikasi)
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // Menambahkan dukungan PATCH
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/posts/{post}/update-status', [PostController::class, 'updateStatus'])->name('posts.update-status');
    
    // Rute CRUD untuk kategori
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Rute untuk komentar
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// International News Routes
Route::get('/api/international-news', [App\Http\Controllers\NewsApiController::class, 'getInternationalNews']);
Route::get('/berita-internasional', [App\Http\Controllers\NewsApiController::class, 'index'])->name('international.index');
Route::get('/berita-internasional/{id}', [App\Http\Controllers\NewsApiController::class, 'showInternationalNews'])->name('international.show')->where('id', '.*');

// Import semua rute autentikasi dari Laravel Breeze
require __DIR__.'/auth.php';
