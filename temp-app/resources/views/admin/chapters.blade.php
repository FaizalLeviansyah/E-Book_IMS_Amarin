@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Tombol Kembali -->
    <a href="/admin/parts" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Part
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Kelola Bab (Chapter)</h3>
            <p class="text-muted">Bagian: <span class="fw-bold text-primary">{{ $part->title }}</span></p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addChapterModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Bab
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
                        <th>Judul Bab (Chapter)</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chapters as $index => $chapter)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold text-primary">{{ $chapter->title }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data Bab. Silakan tambah baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Chapter -->
<div class="modal fade" id="addChapterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/parts/{{ $part->id }}/chapters" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Bab Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Bab</label>
                        <input type="text" class="form-control" name="title" placeholder="Contoh: CHAPTER 1 - GENERAL ISSUES" required>
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
