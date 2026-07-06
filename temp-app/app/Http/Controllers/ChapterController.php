<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Chapter;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    // Menampilkan daftar bab di dalam part tertentu
    public function index($part_id)
    {
        $part = Part::findOrFail($part_id);
        $chapters = Chapter::where('part_id', $part_id)->get();

        return view('admin.chapters', compact('part', 'chapters'));
    }

    // Menyimpan bab baru ke dalam part tertentu
    public function store(Request $request, $part_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable' // Teks Word Editor
        ]);

        Chapter::create([
            'part_id' => $part_id,
            'title' => $request->input('title'),
            'slug' => \Illuminate\Support\Str::slug($request->input('title')),
            'content' => $request->input('content')
        ]);

        return back()->with('success', 'Bab dan materi berhasil disimpan!');
    }
}
