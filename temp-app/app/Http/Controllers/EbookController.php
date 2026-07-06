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
        $recentUpdates = null; // Penampung aktivitas terbaru

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
        else {
            // Jika sedang di halaman utama, ambil 5 bab terbaru
            $recentUpdates = Chapter::with('part.book')->latest()->take(5)->get();
        }

        return view('ebook.index', compact('books', 'activeChapter', 'activeBook', 'searchResults', 'recentUpdates'));
    }
}
