<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\SubChapterController;

// ==========================================
// RUTE PUBLIK (Untuk Kru Kapal)
// ==========================================
Route::get('/', [EbookController::class, 'index']);


// ==========================================
// RUTE ADMIN (Manajemen IMS)
// ==========================================

// 1. Dashboard Admin
Route::get('/admin', function () {
    return view('admin.dashboard');
});

// 2. Kelola Bagian (Part)
Route::get('/admin/parts', [PartController::class, 'index']);
Route::post('/admin/parts', [PartController::class, 'store']);

// 3. Kelola Bab (Chapter)
Route::get('/admin/parts/{part_id}/chapters', [ChapterController::class, 'index']);
Route::post('/admin/parts/{part_id}/chapters', [ChapterController::class, 'store']);

Route::get('/admin/chapters/{chapter_id}/sub-chapters', [SubChapterController::class, 'index']);
Route::post('/admin/chapters/{chapter_id}/sub-chapters', [SubChapterController::class, 'store']);
