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
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul Bab (Chapter)</th>
                        <th width="15%">Aksi</th>
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
                    <h5 class="modal-title"><i class="fa-solid fa-file-signature me-2"></i> Tulis / Import Materi Bab</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Bab (Sesuai Daftar Isi)</label>
                        <input type="text" class="form-control" name="title" placeholder="Contoh: Chapter 1 - General Issues" required>
                    </div>

                    <div class="mb-4 p-3 bg-light border rounded" style="border-left: 4px solid #198754 !important;">
                        <label class="form-label fw-bold text-success"><i class="fa-solid fa-magic me-1"></i> Auto-Import Text dari PDF (Opsional)</label>
                        <input type="file" class="form-control" name="import_pdf" accept="application/pdf">
                        <small class="text-muted">Upload file PDF di sini. Sistem akan otomatis menyedot seluruh teks di dalam PDF tersebut menjadi materi interaktif.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Atau Tulis / Paste Manual (Isi Dokumen)</label>
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
<script>
    CKEDITOR.replace('editor', {
        height: 400
    });
</script>
@endsection
