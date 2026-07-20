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
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // 1. User Management (Manajemen Kru & Hak Akses)
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // 2. Kelola E-Book Induk
    Route::get('/admin/books', [BookController::class, 'index']);
    Route::post('/admin/books', [BookController::class, 'store']);
    Route::put('/admin/books/{book_id}', [BookController::class, 'update']);
    Route::delete('/admin/books/{book_id}', [BookController::class, 'destroy']);

    // 3. Kelola Bagian (Part)
    Route::get('/admin/books/{book_id}/parts', [PartController::class, 'index']);
    Route::post('/admin/books/{book_id}/parts', [PartController::class, 'store']);
    Route::put('/admin/parts/{part_id}', [PartController::class, 'update']);

    // 4. Kelola Bab (Chapter) & Auto-Import Word
    Route::get('/admin/parts/{part_id}/chapters', [ChapterController::class, 'index']);
    Route::post('/admin/parts/{part_id}/chapters', [ChapterController::class, 'store']);
    Route::get('/admin/chapters/{chapter_id}/edit', [ChapterController::class, 'edit']);
    Route::put('/admin/chapters/{chapter_id}', [ChapterController::class, 'update']);
    Route::post('/admin/import-word-to-html', [ChapterController::class, 'importWordToHtml'])->name('admin.import_word');

    // 5. Kelola Formulir & Checklist
    Route::get('/admin/forms', [FormController::class, 'index']);
    Route::post('/admin/forms', [FormController::class, 'store']);
    Route::put('/admin/forms/{id}', [FormController::class, 'update']);
    Route::delete('/admin/forms/{id}', [FormController::class, 'destroy']);

    // Manajemen Statistik & Pembaca
    Route::get('/admin/readers', [App\Http\Controllers\ReaderController::class, 'index'])->name('admin.readers.index');
    Route::put('/admin/readers/{id}', [App\Http\Controllers\ReaderController::class, 'updateName'])->name('admin.readers.update');

});

// Memuat rute bawaan Laravel Breeze (Login, Register, Logout, Reset Password)
require __DIR__.'/auth.php';
