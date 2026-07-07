<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('parts.chapters')->get();
        $activeChapter = null;
        $activeBook = null;
        $searchResults = null;
        $recentUpdates = null;

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $searchResults = Chapter::where('title', 'like', "%{$keyword}%")
                                    ->orWhere('content', 'like', "%{$keyword}%")->get();
        }
        elseif ($request->has('read')) {
            $activeChapter = Chapter::with('part.book')->find($request->read);
            if($activeChapter) {
                $activeBook = $activeChapter->part->book;
            }
        }
        // 👇 INI ADALAH KODE YANG HILANG SEBELUMNYA. INI YANG MEMBUAT PDF BISA DIBUKA!
        elseif ($request->has('read_book')) {
            $activeBook = Book::with('parts.chapters')->find($request->read_book);
        }
        else {
            $recentUpdates = Chapter::with('part.book')->latest()->take(5)->get();
        }

        return view('ebook.index', compact('books', 'activeChapter', 'activeBook', 'searchResults', 'recentUpdates'));
    }
}
