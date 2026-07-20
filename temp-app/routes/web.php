<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\SubChapterController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\UserController;

// ==========================================
// RUTE PUBLIK (Bisa diakses tanpa login)
// ==========================================
Route::get('/', [EbookController::class, 'index'])->name('home');


// ==========================================
// RUTE PROTEKSI (Wajib Login)
// ==========================================
// ==========================================
// RUTE PROTEKSI ADMIN (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Akses Umum (Super Admin & Admin Bisa Buka)
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/profile', [UserController::class, 'editProfile'])->name('admin.profile');
    Route::put('/admin/profile', [UserController::class, 'updateProfile'])->name('admin.profile.update');

    // Kelola Pustaka, Bagian, Bab, & Formulir
    Route::get('/admin/books', [BookController::class, 'index']);
    Route::post('/admin/books', [BookController::class, 'store']);
    Route::put('/admin/books/{book_id}', [BookController::class, 'update']);
    Route::delete('/admin/books/{book_id}', [BookController::class, 'destroy']);

    Route::get('/admin/books/{book_id}/parts', [PartController::class, 'index']);
    Route::post('/admin/books/{book_id}/parts', [PartController::class, 'store']);
    Route::put('/admin/parts/{part_id}', [PartController::class, 'update']);

    Route::get('/admin/parts/{part_id}/chapters', [ChapterController::class, 'index']);
    Route::post('/admin/parts/{part_id}/chapters', [ChapterController::class, 'store']);
    Route::get('/admin/chapters/{chapter_id}/edit', [ChapterController::class, 'edit']);
    Route::put('/admin/chapters/{chapter_id}', [ChapterController::class, 'update']);
    Route::post('/admin/import-word-to-html', [ChapterController::class, 'importWordToHtml'])->name('admin.import_word');

    Route::get('/admin/forms', [FormController::class, 'index']);
    Route::post('/admin/forms', [FormController::class, 'store']);
    Route::put('/admin/forms/{id}', [FormController::class, 'update']);
    Route::delete('/admin/forms/{id}', [FormController::class, 'destroy']);


    // ==========================================
    // RUTE EKSKLUSIF SUPER ADMIN
    // ==========================================
    Route::middleware(['auth', \Spatie\Permission\Middleware\RoleMiddleware::class.':super-admin'])->group(function () {
        // Manajemen Admin (CRUD User)
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Statistik Akses Pembaca
        Route::get('/admin/readers', [App\Http\Controllers\ReaderController::class, 'index'])->name('admin.readers.index');
        Route::put('/admin/readers/{id}', [App\Http\Controllers\ReaderController::class, 'updateName'])->name('admin.readers.update');
    });

});

// Memuat rute bawaan Laravel Breeze (Login, Register, Logout, Reset Password)
require __DIR__.'/auth.php';
