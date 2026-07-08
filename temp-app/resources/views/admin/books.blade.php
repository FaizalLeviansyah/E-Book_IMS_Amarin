@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bolder text-slate-800"><i class="fa-solid fa-book-open text-amarin me-2"></i> Pustaka Induk</h2>
        <p class="text-muted">Kelola koleksi manual dan e-book utama.</p>
    </div>
    <button type="button" class="btn btn-amarin px-4 py-2" data-bs-toggle="modal" data-bs-target="#addBookModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Buku
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success glass-panel border-0 text-success fw-bold"><i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="row g-4">
    @forelse($books as $book)
    <div class="col-md-4 col-lg-3">
        <div class="glass-panel h-100 d-flex flex-column overflow-hidden transition-all hover:shadow-md hover:-translate-y-1">
            <div class="p-4 text-center border-bottom border-light flex-grow-1">
                @if($book->cover_image)
                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="img-fluid rounded-xl shadow-sm mb-3" style="max-height: 200px; object-fit: cover;">
                @else
                    <div class="bg-gradient-to-br from-slate-200 to-slate-100 rounded-xl d-flex align-items-center justify-content-center mb-3 mx-auto shadow-sm" style="width: 140px; height: 200px;">
                        <i class="fa-solid fa-book fs-1 text-slate-400"></i>
                    </div>
                @endif
                <h5 class="fw-bold text-dark mb-1">{{ $book->title }}</h5>
                <small class="text-muted">{{ $book->parts->count() }} Bagian Tersedia</small>
            </div>
            <div class="p-3 bg-white/40 d-flex justify-content-between">
                <a href="/admin/books/{{ $book->id }}/parts" class="btn btn-sm btn-amarin w-100 me-2"><i class="fa-solid fa-folder-tree"></i> Kelola Isi</a>
                <form action="/admin/books/{{ $book->id }}" method="POST" onsubmit="return confirm('Hapus buku ini?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 glass-panel">
        <i class="fa-solid fa-folder-open fs-1 text-muted mb-3"></i>
        <p class="text-muted fw-bold">Belum ada buku yang ditambahkan.</p>
    </div>
    @endforelse
</div>

<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0">
            <form action="/admin/books" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom border-light">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-plus-circle me-2"></i> Tambah E-Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3"><label class="fw-bold text-slate-700 mb-1">Judul Buku</label><input type="text" class="form-control bg-white/50" name="title" required></div>
                    <div class="mb-3"><label class="fw-bold text-slate-700 mb-1">Deskripsi Singkat</label><textarea class="form-control bg-white/50" name="description" rows="2"></textarea></div>
                    <div class="mb-3"><label class="fw-bold text-slate-700 mb-1">Cover Image (Opsional)</label><input type="file" class="form-control bg-white/50" name="cover_image" accept="image/*"></div>
                    <div class="mb-3"><label class="fw-bold text-slate-700 mb-1">File PDF Asli (Opsional)</label><input type="file" class="form-control bg-white/50" name="pdf_file" accept="application/pdf"></div>
                </div>
                <div class="modal-footer border-top border-light"><button type="submit" class="btn btn-amarin w-100">Simpan Buku Baru</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
