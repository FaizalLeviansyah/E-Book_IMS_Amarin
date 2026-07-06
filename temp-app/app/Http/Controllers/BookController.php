<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Wajib ditambahkan untuk memanipulasi file

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('admin.books', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:102400'
        ]);

        $coverName = null;
        $pdfName = null;

        if ($request->hasFile('cover_image')) {
            $coverName = time() . '_cover.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('uploads/books'), $coverName);
        }

        if ($request->hasFile('pdf_file')) {
            $pdfName = time() . '_pdf.' . $request->pdf_file->extension();
            $request->pdf_file->move(public_path('uploads/books'), $pdfName);
        }

        Book::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'theme_color' => $request->input('theme_color') ?? '#0d47a1',
            'cover_image' => $coverName,
            'pdf_file' => $pdfName
        ]);

        return back()->with('success', 'E-Book & File berhasil diunggah!');
    }

    // FUNGSI BARU: UPDATE DATA BUKU
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:102400'
        ]);

        // Cek dan timpa Cover lama jika ada file baru
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && File::exists(public_path('uploads/books/' . $book->cover_image))) {
                File::delete(public_path('uploads/books/' . $book->cover_image));
            }
            $coverName = time() . '_cover.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('uploads/books'), $coverName);
            $book->cover_image = $coverName;
        }

        // Cek dan timpa PDF lama jika ada file baru
        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file && File::exists(public_path('uploads/books/' . $book->pdf_file))) {
                File::delete(public_path('uploads/books/' . $book->pdf_file));
            }
            $pdfName = time() . '_pdf.' . $request->pdf_file->extension();
            $request->pdf_file->move(public_path('uploads/books'), $pdfName);
            $book->pdf_file = $pdfName;
        }

        // Update data teks
        $book->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'theme_color' => $request->input('theme_color') ?? '#0d47a1',
        ]);

        return back()->with('success', 'Data E-Book berhasil diperbarui!');
    }

    // FUNGSI BARU: HAPUS BUKU & FILE FISIK
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Hapus file fisik secara permanen dari server
        if ($book->cover_image && File::exists(public_path('uploads/books/' . $book->cover_image))) {
            File::delete(public_path('uploads/books/' . $book->cover_image));
        }
        if ($book->pdf_file && File::exists(public_path('uploads/books/' . $book->pdf_file))) {
            File::delete(public_path('uploads/books/' . $book->pdf_file));
        }

        $book->delete();
        return back()->with('success', 'E-Book dan seluruh filenya berhasil dihapus!');
    }
}
