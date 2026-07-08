@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <a href="/admin/parts/{{ $chapter->part_id }}/chapters" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Bab
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Edit Materi Bab</h3>
            <p class="text-muted">Perbarui teks interaktif untuk bab ini.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white fw-bold py-3">
            <i class="fa-solid fa-pen-to-square me-2"></i> Form Edit: {{ $chapter->title }}
        </div>
        <div class="card-body p-4">
            <form action="/admin/chapters/{{ $chapter->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold">Judul Bab</label>
                    <input type="text" class="form-control" name="title" value="{{ $chapter->title }}" required>
                </div>

                <div class="mb-4 p-4 bg-light rounded-4 shadow-sm" style="border: 2px dashed #0d6efd;">
                    <label class="form-label fw-bold text-primary mb-1">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Auto-Convert Dokumen Word (.docx)
                    </label>
                    <p class="text-muted small mb-3">Pilih file Word, dan sistem akan langsung mengekstrak teks beserta format tabelnya ke dalam editor di bawah tanpa perlu Copy-Paste manual!</p>
                    <input type="file" id="upload-docx" class="form-control" accept=".docx">
                    <div id="docx-loading" class="text-warning fw-bold mt-2" style="display: none;">
                        <i class="fa-solid fa-spinner fa-spin me-1"></i> Sedang mengekstrak dokumen...
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Dokumen (Editor Teks)</label>
                    <textarea name="content" id="editor">{{ $chapter->content }}</textarea>
                </div>

                <div class="d-flex justify-content-end bg-light p-3 rounded">
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="fa-solid fa-save me-2"></i> Perbarui Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 600
    });

    // Algoritma Ekstraksi Word Otomatis
    document.getElementById('upload-docx').addEventListener('change', function(event) {
        var reader = new FileReader();
        var loadingText = document.getElementById('docx-loading');

        reader.onload = function(event) {
            loadingText.style.display = 'block';
            var arrayBuffer = reader.result;

            mammoth.convertToHtml({arrayBuffer: arrayBuffer})
                .then(function(result) {
                    var html = result.value; // Hasil ekstraksi HTML mentah dari Word
                    // Masukkan langsung ke dalam kotak CKEditor
                    CKEDITOR.instances.editor.setData(html);
                    loadingText.style.display = 'none';
                    alert('Dokumen Word berhasil diekstrak! Silakan periksa hasilnya di editor dan klik Simpan.');
                })
                .catch(function(err) {
                    console.log(err);
                    loadingText.style.display = 'none';
                    alert('Gagal membaca file Word. Pastikan formatnya .docx');
                });
        };

        if (this.files.length > 0) {
            reader.readAsArrayBuffer(this.files[0]);
        }
    });
</script>
@endsection
