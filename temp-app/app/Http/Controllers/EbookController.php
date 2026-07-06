<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Chapter;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil semua data untuk sidebar
        $parts = Part::with('chapters')->get();

        $activeChapter = null;
        $searchResults = null; // Penampung hasil pencarian

        // Jika user melakukan pencarian
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            // Mencari kata kunci di judul bab atau isi materi
            $searchResults = Chapter::where('title', 'like', "%{$keyword}%")
                                    ->orWhere('content', 'like', "%{$keyword}%")
                                    ->get();
        }
        // Jika user mengklik bab tertentu dari sidebar
        elseif ($request->has('read')) {
            $activeChapter = Chapter::find($request->read);
        }

        return view('ebook.index', compact('parts', 'activeChapter', 'searchResults'));
    }
}
