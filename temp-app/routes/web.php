<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\SubChapterController;
use App\Http\Controllers\FormController;

// RUTE PUBLIK (Kru Kapal)
Route::get('/', [EbookController::class, 'index']);

// RUTE ADMIN
Route::get('/admin', function () { return view('admin.dashboard'); });

// Kelola E-Book Induk
Route::get('/admin/books', [BookController::class, 'index']);
Route::post('/admin/books', [BookController::class, 'store']);
Route::put('/admin/books/{book_id}', [BookController::class, 'update']);
Route::delete('/admin/books/{book_id}', [BookController::class, 'destroy']);

// Kelola Bagian (Part)
Route::get('/admin/books/{book_id}/parts', [PartController::class, 'index']);
Route::post('/admin/books/{book_id}/parts', [PartController::class, 'store']);
Route::put('/admin/parts/{part_id}', [PartController::class, 'update']);

// Kelola Bab (Chapter)
Route::get('/admin/parts/{part_id}/chapters', [ChapterController::class, 'index']);
Route::post('/admin/parts/{part_id}/chapters', [ChapterController::class, 'store']);
Route::get('/admin/chapters/{chapter_id}/edit', [ChapterController::class, 'edit']);
Route::put('/admin/chapters/{chapter_id}', [ChapterController::class, 'update']);

// KELOLA FORMULIR & CHECKLIST (SEKARANG TERPISAH / GLOBAL)
Route::get('/admin/forms', [FormController::class, 'index']);
Route::post('/admin/forms', [FormController::class, 'store']);
Route::put('/admin/forms/{id}', [FormController::class, 'update']);
Route::delete('/admin/forms/{id}', [FormController::class, 'destroy']);

Route::post('/admin/import-word-to-html', [App\Http\Controllers\ChapterController::class, 'importWordToHtml'])->name('admin.import_word');
