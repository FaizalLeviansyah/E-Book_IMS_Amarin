<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Part;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser; // Library baru untuk baca PDF

class ChapterController extends Controller
{
    public function index($part_id)
    {
        $part = Part::findOrFail($part_id);
        $chapters = Chapter::where('part_id', $part_id)->get();
        return view('admin.chapters', compact('part', 'chapters'));
    }

    public function store(Request $request, $part_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'import_pdf' => 'nullable|mimes:pdf|max:51200' // Maks 50MB untuk di-ekstrak
        ]);

        $finalContent = $request->input('content');

        // JIKA ADA FILE PDF YANG DIUNGGAH, EKSTRAK TEKSNYA
        if ($request->hasFile('import_pdf')) {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($request->file('import_pdf')->path());
                $rawText = $pdf->getText();

                // Ubah enter/baris baru dari PDF menjadi format HTML agar rapi di CKEditor
                $finalContent = nl2br(htmlspecialchars($rawText));
            } catch (\Exception $e) {
                return back()->withErrors(['import_pdf' => 'Gagal membaca PDF: ' . $e->getMessage()]);
            }
        }

        Chapter::create([
            'part_id' => $part_id,
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $finalContent
        ]);

        return back()->with('success', 'Bab berhasil disimpan! (Jika menggunakan PDF, teks telah otomatis diekstrak)');
    }

    public function edit($chapter_id)
    {
        $chapter = Chapter::findOrFail($chapter_id);
        return view('admin.edit_chapter', compact('chapter'));
    }
    public function update(Request $request, $chapter_id)
    {
        $chapter = Chapter::findOrFail($chapter_id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'import_pdf' => 'nullable|mimes:pdf|max:51200' // Maks 50MB untuk di-ekstrak
        ]);

        $finalContent = $request->input('content');

        // JIKA ADA FILE PDF YANG DIUNGGAH, EKSTRAK TEKSNYA
        if ($request->hasFile('import_pdf')) {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($request->file('import_pdf')->path());
                $rawText = $pdf->getText();

                // Ubah enter/baris baru dari PDF menjadi format HTML agar rapi di CKEditor
                $finalContent = nl2br(htmlspecialchars($rawText));
            } catch (\Exception $e) {
                return back()->withErrors(['import_pdf' => 'Gagal membaca PDF: ' . $e->getMessage()]);
            }
        }

        $chapter->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $finalContent
        ]);

        return back()->with('success', 'Bab berhasil diperbarui! (Jika menggunakan PDF, teks telah otomatis diekstrak)');
    }
}
