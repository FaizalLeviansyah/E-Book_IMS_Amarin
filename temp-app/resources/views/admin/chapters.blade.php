@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <a href="/admin/books/{{ $part->book_id }}/parts" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Part
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Kelola Bab & Materi</h3>
            <p class="text-muted">Bagian: <span class="fw-bold text-primary">{{ $part->title }}</span></p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addChapterModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Bab & Tulis Materi
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul Bab (Chapter)</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapters as $index => $chapter)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $chapter->title }}</td>
                        <td>
                            <a href="/admin/chapters/{{ $chapter->id }}/edit" class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-pen"></i> Edit Materi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada Bab.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addChapterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="/admin/parts/{{ $part->id }}/chapters" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fa-solid fa-file-signature me-2"></i> Tambah Bab Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Bab</label>
                        <input type="text" class="form-control" name="title" placeholder="Contoh: 1.1. Purpose" required>
                    </div>

                    <div class="mb-4 p-4 bg-light rounded-4 shadow-sm" style="border: 2px dashed #0d6efd;">
                        <label class="form-label fw-bold text-primary mb-1">
                            <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Auto-Convert Dokumen Word (.docx)
                        </label>
                        <p class="text-muted small mb-3">Pilih file Word, sistem akan mengekstrak formatnya ke editor di bawah.</p>
                        <input type="file" id="upload-docx-modal" class="form-control" accept=".docx">
                        <div id="docx-loading-modal" class="text-warning fw-bold mt-2" style="display: none;">
                            <i class="fa-solid fa-spinner fa-spin me-1"></i> Sedang mengekstrak dokumen...
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Materi</label>
                        <textarea name="content" id="editor"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"></script>
<script>
    // Inisialisasi Editor
    CKEDITOR.replace('editor', { height: 400 });

    // Algoritma Ekstraksi Word Otomatis di Modal
    document.getElementById('upload-docx-modal').addEventListener('change', function(event) {
        var reader = new FileReader();
        var loadingText = document.getElementById('docx-loading-modal');

        reader.onload = function(event) {
            loadingText.style.display = 'block';
            var arrayBuffer = reader.result;

            mammoth.convertToHtml({arrayBuffer: arrayBuffer})
                .then(function(result) {
                    var html = result.value;
                    CKEDITOR.instances.editor.setData(html); // Kirim ke editor modal
                    loadingText.style.display = 'none';
                    alert('Dokumen Word berhasil diekstrak!');
                })
                .catch(function(err) {
                    console.log(err);
                    loadingText.style.display = 'none';
                    alert('Gagal membaca file Word.');
                });
        };

        if (this.files.length > 0) {
            reader.readAsArrayBuffer(this.files[0]);
        }
    });
</script>
@endsection
