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
        <div class="card-header bg-warning text-dark fw-bold py-3">
            <i class="fa-solid fa-pen-to-square me-2"></i> Form Edit: {{ $chapter->title }}
        </div>
        <div class="card-body p-4">
            <form action="/admin/chapters/{{ $chapter->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="mb-4">
                    <label class="form-label fw-bold">Judul Bab</label>
                    <input type="text" class="form-control" name="title" value="{{ $chapter->title }}" required>
                </div>

                <div class="mb-4 p-3 bg-light border rounded" style="border-left: 4px solid #198754 !important;">
                    <label class="form-label fw-bold text-success"><i class="fa-solid fa-magic me-1"></i> Auto-Import / Timpa Text dari PDF (Opsional)</label>
                    <input type="file" class="form-control" name="import_pdf" accept="application/pdf">
                    <small class="text-muted">Upload file PDF baru <b>HANYA JIKA</b> kamu ingin <b>MENIMPA/MENGHAPUS</b> seluruh teks lama di bawah secara otomatis.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Dokumen (Editor Teks)</label>
                    <textarea name="content" id="editor">{{ $chapter->content }}</textarea>
                </div>

                <div class="d-flex justify-content-end bg-light p-3 rounded">
                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                        <i class="fa-solid fa-save me-2"></i> Perbarui Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: 600 // Dibuat lebih tinggi (600px) agar lebih leluasa saat mengedit teks panjang
    });
</script>
@endsection
