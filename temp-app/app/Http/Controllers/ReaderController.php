<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reader;

class ReaderController extends Controller
{
    public function index()
    {
        // Mengambil data pembaca dan mengirimkannya ke view
        $readers = Reader::orderBy('last_accessed_at', 'desc')->get();
        return view('admin.readers', compact('readers'));
    }

    public function updateName(Request $request, $id)
    {
        $request->validate(['custom_name' => 'nullable|string|max:255']);
        Reader::findOrFail($id)->update(['custom_name' => $request->custom_name]);
        return back()->with('success', 'Identitas pembaca berhasil diperbarui.');
    }
}
