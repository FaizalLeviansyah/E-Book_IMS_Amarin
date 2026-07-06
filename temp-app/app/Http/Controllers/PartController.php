<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Book;
use Illuminate\Support\Str;

class PartController extends Controller
{
    // Menampilkan daftar Part di dalam Buku tertentu
    public function index($book_id)
    {
        $book = Book::findOrFail($book_id);
        $parts = Part::where('book_id', $book_id)->get();

        return view('admin.parts', compact('book', 'parts'));
    }

    // Menyimpan Part baru ke Buku tertentu
    public function store(Request $request, $book_id)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        Part::create([
            'book_id' => $book_id,
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'))
        ]);

        return back()->with('success', 'Bagian (Part) baru berhasil ditambahkan!');
    }
}
