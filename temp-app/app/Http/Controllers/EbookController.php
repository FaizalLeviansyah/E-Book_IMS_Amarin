<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Chapter;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $parts = Part::with('chapters')->get();

        $activeChapter = null;
        if ($request->has('read')) {
            $activeChapter = Chapter::find($request->read);
        }
        return view('ebook.index', compact('parts', 'activeChapter'));
    }
}
