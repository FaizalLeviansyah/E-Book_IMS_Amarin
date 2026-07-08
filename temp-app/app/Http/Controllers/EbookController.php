<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Form;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua buku dan ambil semua form secara global
        $books = Book::with(['parts.chapters'])->get();
        $allForms = Form::with('book')->get();

        $activeChapter = null;
        $activeBook = null;
        $activeForm = null;
        $searchResults = null;

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $searchResults = Chapter::with('part')
                ->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->get();
        } elseif ($request->has('read')) {
            $activeChapter = Chapter::with('part.book')->findOrFail($request->read);
            $activeBook = $activeChapter->part->book;
        } elseif ($request->has('read_book')) {
            $activeBook = Book::findOrFail($request->read_book);
        } elseif ($request->has('read_form')) {
            // INI LOGIKA UNTUK MENAMPILKAN FORM DI KANAN
            $activeForm = Form::with('book')->findOrFail($request->read_form);
        }

        return view('ebook.index', compact('books', 'allForms', 'activeChapter', 'activeBook', 'activeForm', 'searchResults'));
    }
}
