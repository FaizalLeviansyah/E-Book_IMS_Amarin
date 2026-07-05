@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Tombol Kembali ke Daftar Bab -->
    <a href="/admin/parts/{{ $chapter->part_id }}/chapters" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Bab
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Kelola Sub-Bab & Materi</h3>
            <p class="text-muted">Bab: <span class="fw-bold text-primary">{{ $chapter->title }}</span></p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addSubChapterModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Sub-Bab
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="10%">No</th>
                        <th>Judul Sub-Bab</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subChapters as $index => $sub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold text-primary">{{ $sub->title }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen"></i> Edit Teks</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data Sub-Bab. Silakan tambah baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Sub-Chapter (Dibuat lebih lebar modal-lg) -->
<div class="modal fade" id="addSubChapterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/admin/chapters/{{ $chapter->id }}/sub-chapters" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Sub-Bab & Isi Materi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Sub-Bab</label>
                        <input type="text" class="form-control" name="title" placeholder="Contoh: 1.1. Purpose / Tujuan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Materi (Copy dari PDF)</label>
                        <textarea class="form-control" name="content" rows="10" placeholder="Paste teks materi IMS di sini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
