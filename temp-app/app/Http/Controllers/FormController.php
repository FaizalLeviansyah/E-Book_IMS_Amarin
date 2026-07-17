<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::with('book')->orderBy('category')->get();
        $books = Book::all();
        return view('admin.forms', compact('forms', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100', // Validasi Kategori
            'form_file' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $file = $request->file('form_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/forms'), $fileName);

        Form::create([
            'book_id' => $request->book_id,
            'title' => $request->title,
            'category' => strtoupper($request->category), // Dibuat kapital agar rapi (Contoh: FORM C)
            'file_path' => $fileName,
            'file_type' => $file->getClientOriginalExtension() == 'pdf' ? 'pdf' : 'word'
        ]);

        return back()->with('success', 'Formulir berhasil diunggah!');
    }

    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'form_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $form->book_id = $request->book_id;
        $form->title = $request->title;
        $form->category = strtoupper($request->category);

        if ($request->hasFile('form_file')) {
            if(file_exists(public_path('uploads/forms/'.$form->file_path))) {
                unlink(public_path('uploads/forms/'.$form->file_path));
            }
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
