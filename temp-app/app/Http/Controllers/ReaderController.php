<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reader;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::orderBy('last_accessed_at', 'desc')->get();
        return view('admin.readers.index', compact('readers'));
    }

    public function updateName(Request $request, $id)
    {
        $request->validate(['custom_name' => 'nullable|string|max:255']);
        $reader = Reader::findOrFail($id);
        $reader->update(['custom_name' => $request->custom_name]);

        return back()->with('success', 'Nama pembaca berhasil diperbarui.');
    }
}
