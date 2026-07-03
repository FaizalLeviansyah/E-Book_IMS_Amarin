<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class EbookController extends Controller
{
    public function index()
    {
        // Mengambil semua data Part beserta Chapter dan SubChapter di dalamnya
        $parts = Part::with('chapters.subChapters')->get();

        // Mengirim data ke tampilan (view) bernama 'ebook.index'
        return view('ebook.index', compact('parts'));
    }
}
