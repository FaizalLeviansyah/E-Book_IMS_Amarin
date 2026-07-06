<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil semua Buku beserta Part dan Chapter-nya
        $books = Book::with('parts.chapters')->get();

        $activeChapter = null;
        $activeBook = null;
        $searchResults = null;

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $searchResults = Chapter::where('title', 'like', "%{$keyword}%")
                                    ->orWhere('content', 'like', "%{$keyword}%")->get();
        }
        elseif ($request->has('read')) {
            // Mengambil chapter beserta data buku induknya
            $activeChapter = Chapter::with('part.book')->find($request->read);
            if($activeChapter) {
                $activeBook = $activeChapter->part->book;
            }
        }

        return view('ebook.index', compact('books', 'activeChapter', 'activeBook', 'searchResults'));
    }
}
