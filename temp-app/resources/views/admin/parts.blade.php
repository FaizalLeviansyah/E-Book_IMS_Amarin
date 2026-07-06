@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <a href="/admin/books" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar E-Book
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Kelola Bagian (Part)</h3>
            <p class="text-muted">Buku: <span class="fw-bold" style="color: {{ $book->theme_color }};">{{ $book->title }}</span></p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPartModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Part
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
                        <th width="10%">No</th>
                        <th>Judul Bagian (Part)</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parts as $index => $part)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $part->title }}</td>
                        <td>
                            <a href="/admin/parts/{{ $part->id }}/chapters" class="btn btn-sm btn-info text-white">
                                <i class="fa-solid fa-list me-1"></i> Kelola Bab
                            </a>
                            <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data Part. Silakan tambah baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addPartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/books/{{ $book->id }}/parts" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: {{ $book->theme_color }};">
                    <h5 class="modal-title">Tambah Part Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Part</label>
                        <input type="text" class="form-control" name="title" placeholder="Contoh: PART A - GENERAL" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background-color: {{ $book->theme_color }};"><i class="fa-solid fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
