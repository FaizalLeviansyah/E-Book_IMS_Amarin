@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bolder text-slate-800 mb-1 d-flex align-items-center gap-2">
                <i class="fa-solid fa-book-open text-amarin"></i> Pustaka Induk
            </h2>
            <p class="text-muted mb-0">Kelola koleksi manual dan e-book utama PT Amarin Ship Management.</p>
        </div>
        <button class="btn btn-amarin px-4 py-2.5 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addBookModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Buku
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-panel border-0 text-success fw-bold rounded-3 shadow-sm mb-4">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($books as $book)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- CARD DESIGN ELEGANT -->
            <div class="card h-100 border-0 rounded-4 shadow-sm bg-white/60 backdrop-blur-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group overflow-hidden">
                <div class="card-body p-4 d-flex flex-column align-items-center text-center relative z-10">

                    <!-- Cover Area dengan Efek Zoom -->
                    <div class="position-relative mb-4 w-100 d-flex justify-content-center">
                        @if($book->cover_image)
                            <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="rounded-3 shadow object-fit-cover transition-transform duration-500 group-hover:scale-105" style="width: 140px; height: 190px;" alt="Cover">
                        @else
                            <div class="rounded-3 shadow bg-gradient-to-br from-slate-100 to-slate-200 d-flex flex-column align-items-center justify-content-center border border-white transition-transform duration-500 group-hover:scale-105" style="width: 140px; height: 190px;">
                                <i class="fa-solid fa-book text-slate-300 text-4xl mb-2"></i>
                                <span class="text-[10px] fw-bold text-slate-400 text-uppercase tracking-widest">No Cover</span>
                            </div>
                        @endif
                    </div>

                    <!-- Title & Badge -->
                    <h5 class="fw-bolder text-slate-800 mb-2 lh-sm">{{ $book->title }}</h5>
                    <span class="badge bg-blue-50 text-blue-600 border border-blue-100 rounded-pill px-3 py-1.5 fw-bold mb-auto">
                        {{ $book->parts->count() }} Bagian Tersedia
                    </span>

                    <!-- Action Buttons -->
                    <div class="w-100 mt-4 pt-4 border-top border-slate-200/60 d-flex flex-column gap-2">
                        <a href="/admin/books/{{ $book->id }}/parts" class="btn btn-amarin fw-bold w-100 rounded-3 py-2 shadow-sm hover:shadow-md transition-all">
                            <i class="fa-solid fa-list-check me-2"></i> Kelola Isi Bab
                        </a>

                        <form action="/admin/books/{{ $book->id }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin ingin menghapus seluruh buku ini beserta babnya secara permanen?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold w-100 text-sm hover:bg-red-50 rounded-3 transition-colors">
                                <i class="fa-solid fa-trash-can me-1"></i> Hapus Buku
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="glass-panel p-5 text-center rounded-4 border border-dashed border-slate-300">
                <i class="fa-solid fa-folder-open text-slate-300 text-5xl mb-3"></i>
                <h5 class="fw-bold text-slate-600">Pustaka Masih Kosong</h5>
                <p class="text-muted">Klik tombol "Tambah Buku" di atas untuk membuat dokumen IMS baru.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-panel border-0 rounded-4 overflow-hidden">
            <form action="/admin/books" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom border-light bg-white/50 px-4 py-3">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-book-medical me-2"></i> Tambah Buku Pustaka</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-white/30">
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Judul Buku</label>
                        <input type="text" class="form-control bg-white/70" name="title" required placeholder="Masukkan judul buku...">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Upload Cover (Opsional, JPG/PNG)</label>
                        <input type="file" class="form-control bg-white/70" name="cover_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Upload File PDF (Opsional)</label>
                        <input type="file" class="form-control bg-white/70" name="pdf_file" accept=".pdf">
                        <small class="text-muted text-[10px]">Unggah versi PDF asli sebagai referensi cadangan pembaca.</small>
                    </div>
                </div>
                <div class="modal-footer border-top border-light bg-white/50 px-4 py-3">
                    <button type="button" class="btn btn-light border shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-amarin px-4 shadow-sm"><i class="fa-solid fa-save me-2"></i> Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
