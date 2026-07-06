<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Str;

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
            'pdf_file' => 'nullable|mimes:pdf|max:20000' // Maks 20MB
        ]);

        $coverName = null;
        $pdfName = null;

        // Upload Cover
        if ($request->hasFile('cover_image')) {
            $coverName = time() . '_cover.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('uploads/books'), $coverName);
        }

        // Upload PDF Mentahan
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
}
