<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $books = Book::all();
        return view('admin.books', compact('books'));
    }

    // Menyimpan buku baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme_color' => 'required|string'
        ]);

        Book::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'theme_color' => $request->input('theme_color')
        ]);

        return back()->with('success', 'Buku baru berhasil ditambahkan!');
    }
}
