<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\SubChapter;
use Illuminate\Support\Str;

class SubChapterController extends Controller
{
    // Menampilkan daftar sub-bab beserta isinya
    public function index($chapter_id)
    {
        // Mengambil data chapter beserta data part-nya agar tombol "Kembali" bisa berfungsi
        $chapter = Chapter::with('part')->findOrFail($chapter_id);
        $subChapters = SubChapter::where('chapter_id', $chapter_id)->get();

        return view('admin.sub_chapters', compact('chapter', 'subChapters'));
    }

    // Menyimpan sub-bab dan teks materinya
    public function store(Request $request, $chapter_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required' // Wajib diisi dengan teks dari PDF
        ]);

        SubChapter::create([
            'chapter_id' => $chapter_id,
            'title' => $request->input('title'), // Ubah di sini
            'slug' => Str::slug($request->input('title')), // Ubah di sini
            'content' => $request->input('content') // Ubah di sini juga
        ]);

        return back()->with('success', 'Sub-Bab dan materi berhasil ditambahkan!');
    }
}
