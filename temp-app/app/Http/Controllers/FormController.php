<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index($book_id)
    {
        $book = Book::with('forms')->findOrFail($book_id);
        return view('admin.forms', compact('book'));
    }

    public function store(Request $request, $book_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'form_file' => 'required|file|mimes:pdf,doc,docx|max:10240' // Max 10MB
        ]);

        $file = $request->file('form_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/forms'), $fileName);

        $type = $file->getClientOriginalExtension() == 'pdf' ? 'pdf' : 'word';

        Form::create([
            'book_id' => $book_id,
            'title' => $request->title,
            'file_path' => $fileName,
            'file_type' => $type
        ]);

        return back()->with('success', 'Formulir berhasil diunggah!');
    }

    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'form_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $form->title = $request->title;

        // Jika user mengunggah file pengganti
        if ($request->hasFile('form_file')) {
            // Hapus file lama
            if(file_exists(public_path('uploads/forms/'.$form->file_path))) {
                unlink(public_path('uploads/forms/'.$form->file_path));
            }

            // Simpan file baru
            $file = $request->file('form_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/forms'), $fileName);

            $form->file_path = $fileName;
            $form->file_type = $file->getClientOriginalExtension() == 'pdf' ? 'pdf' : 'word';
        }

        $form->save();

        return back()->with('success', 'Formulir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        if(file_exists(public_path('uploads/forms/'.$form->file_path))) {
            unlink(public_path('uploads/forms/'.$form->file_path));
        }
        $form->delete();
        return back()->with('success', 'Formulir berhasil dihapus!');
    }
}
