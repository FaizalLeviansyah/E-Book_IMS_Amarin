@extends('layouts.admin')

@section('content')
<a href="/admin/books/{{ $part->book_id }}/parts" class="text-decoration-none text-muted fw-bold mb-4 d-inline-block hover:text-amarin transition-colors">
    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar Part
</a>

<div class="glass-panel p-4 mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h3 class="fw-bolder text-slate-800 mb-1">Daftar Materi (Sub-Bab)</h3>
        <p class="text-muted mb-0">Part: <span class="fw-bold text-amarin">{{ $part->title }}</span></p>
    </div>
    <button type="button" class="btn btn-amarin px-4 py-2" data-bs-toggle="modal" data-bs-target="#addChapterModal">
        <i class="fa-solid fa-pen-nib me-2"></i> Tulis Materi Baru
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success glass-panel border-0 text-success fw-bold"><i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="glass-panel p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" width="10%">No</th>
                    <th>Judul Bab Materi</th>
                    <th class="text-end pe-4" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($chapters as $index => $chapter)
                <tr>
                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                    <td class="fw-bold text-slate-800"><i class="fa-regular fa-file-lines text-amarin me-2"></i> {{ $chapter->title }}</td>
                    <td class="text-end pe-4">
                        <a href="/admin/chapters/{{ $chapter->id }}/edit" class="btn btn-sm btn-light border shadow-sm text-primary fw-bold px-3">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Teks
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-5 text-muted fw-bold">Belum ada materi di Part ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addChapterModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content glass-panel border-0">
            <form action="/admin/parts/{{ $part->id }}/chapters" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom border-light bg-white/40">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-file-signature me-2"></i> Tulis Materi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="fw-bold text-slate-700 mb-1">Judul Materi (Contoh: 1.1 Purpose)</label>
                        <input type="text" class="form-control bg-white/70" name="title" required>
                    </div>

                    <div class="mb-4 p-4 rounded-xl border border-blue-200 bg-blue-50/50">
                        <label class="fw-bold text-amarin mb-1 d-block"><i class="fa-solid fa-wand-magic-sparkles me-2"></i> Auto-Convert Word (.docx)</label>
                        <small class="text-muted d-block mb-3">Ekstrak teks dan tabel dari Word langsung ke editor (opsional).</small>
                        <input type="file" id="upload-docx-modal" class="form-control bg-white" accept=".docx">
                        <div id="docx-loading-modal" class="text-amarin fw-bold mt-2" style="display: none;"><i class="fa-solid fa-circle-notch fa-spin me-2"></i>Mengekstrak file...</div>
                    </div>

                    <div class="mb-2"><label class="fw-bold text-slate-700 mb-2">Editor Interaktif</label><textarea name="content" id="editor"></textarea></div>
                </div>
                <div class="modal-footer border-top border-light bg-white/40">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-amarin px-4"><i class="fa-solid fa-save me-2"></i> Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"></script>
<script>
    CKEDITOR.replace('editor', { height: 400 });
    document.getElementById('upload-docx-modal').addEventListener('change', function(e) {
        var r = new FileReader(), l = document.getElementById('docx-loading-modal');
        r.onload = function() {
            l.style.display = 'block';
            mammoth.convertToHtml({arrayBuffer: r.result}).then(function(res) {
                CKEDITOR.instances.editor.setData(res.value); l.style.display = 'none';
            }).catch(function() { l.style.display = 'none'; alert('Gagal membaca Word.'); });
        };
        if(this.files.length > 0) r.readAsArrayBuffer(this.files[0]);
    });
</script>
@endsection
