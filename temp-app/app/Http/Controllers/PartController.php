<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use Illuminate\Support\Str; // Untuk membuat slug otomatis

class PartController extends Controller
{
    // Menampilkan halaman daftar Part
    public function index()
    {
        $parts = Part::all();
        return view('admin.parts', compact('parts'));
    }

    // Menyimpan data Part baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        Part::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) // otomatis mengubah "Part A" jadi "part-a"
        ]);

        return back()->with('success', 'Bagian (Part) baru berhasil ditambahkan!');
    }
}
