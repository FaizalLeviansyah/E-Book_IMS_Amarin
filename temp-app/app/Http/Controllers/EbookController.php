<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\SubChapter; // Pastikan memanggil model SubChapter

class EbookController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil semua data dokumen
        $parts = Part::with('chapters.subChapters')->get();

        // Mengecek apakah ada instruksi untuk membaca sub-bab tertentu
        $activeSubChapter = null;
        if ($request->has('read')) {
            $activeSubChapter = SubChapter::find($request->read);
        }

        return view('ebook.index', compact('parts', 'activeSubChapter'));
    }
}
