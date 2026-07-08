<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\SubChapterController;
use App\Http\Controllers\FormController;

// ==========================================
// RUTE PUBLIK (Untuk Kru Kapal membaca)
// ==========================================
Route::get('/', [EbookController::class, 'index']);

// ==========================================
// RUTE ADMIN (Manajemen E-Book & IMS)
// ==========================================

// 1. Dashboard Admin
Route::get('/admin', function () {
    return view('admin.dashboard');
});

// 2. Kelola E-Book Induk (Ini yang memicu 404 sebelumnya)
Route::get('/admin/books', [BookController::class, 'index']);
Route::post('/admin/books', [BookController::class, 'store']);

Route::put('/admin/books/{book_id}', [BookController::class, 'update']);
Route::delete('/admin/books/{book_id}', [BookController::class, 'destroy']);

// 3. Kelola Bagian (Part)
Route::get('/admin/books/{book_id}/parts', [PartController::class, 'index']);
Route::post('/admin/books/{book_id}/parts', [PartController::class, 'store']);

// 4. Kelola Bab (Chapter)
Route::get('/admin/parts/{part_id}/chapters', [ChapterController::class, 'index']);
Route::post('/admin/parts/{part_id}/chapters', [ChapterController::class, 'store']);

// 5. Kelola Isi Materi (Sub-Chapter)
Route::get('/admin/chapters/{chapter_id}/sub-chapters', [SubChapterController::class, 'index']);
Route::post('/admin/chapters/{chapter_id}/sub-chapters', [SubChapterController::class, 'store']);

// Tambahkan baris ini di routes/web.php
Route::get('/admin/chapters/{chapter_id}/edit', [ChapterController::class, 'edit']);
Route::put('/admin/chapters/{chapter_id}', [ChapterController::class, 'update']);

Route::put('/admin/parts/{part_id}', [PartController::class, 'update']);

Route::post('/admin/books/{book_id}/forms', [FormController::class, 'store']);
Route::delete('/admin/forms/{id}', [FormController::class, 'destroy']);

Route::get('/admin/books/{book_id}/forms', [App\Http\Controllers\FormController::class, 'index']);
Route::post('/admin/books/{book_id}/forms', [App\Http\Controllers\FormController::class, 'store']);
Route::put('/admin/forms/{id}', [App\Http\Controllers\FormController::class, 'update']);
Route::delete('/admin/forms/{id}', [App\Http\Controllers\FormController::class, 'destroy']);

