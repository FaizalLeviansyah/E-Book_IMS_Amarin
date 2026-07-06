@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Kelola E-Book</h3>
            <p class="text-muted">Tambahkan dan kelola berbagai E-Book pedoman perusahaan.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addBookModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Buku Baru
        </button>
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
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Tema</th>
                        <th>Judul Buku</th>
                        <th>Deskripsi</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <!-- Menampilkan kotak kecil berisi warna tema yang dipilih -->
                            <div style="width: 30px; height: 30px; background-color: {{ $book->theme_color }}; border-radius: 5px; border: 1px solid #ccc;"></div>
                        </td>
                        <td class="fw-bold text-dark">{{ $book->title }}</td>
                        <td class="text-muted">{{ $book->description ?? '-' }}</td>
                        <td>
                            <!-- Nanti tombol ini akan mengarah ke kelola Bagian (Part) -->
                            <a href="/admin/books/{{ $book->id }}/parts" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-folder-open me-1"></i> Kelola Part</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada buku. Silakan tambah E-Book baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/books" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah E-Book Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Buku</label>
                        <input type="text" class="form-control" name="title" placeholder="Contoh: Integrated Management System (IMS)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control" name="description" rows="2" placeholder="Contoh: Manual Keselamatan PT Amarin Ship Management"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Warna Tema (Navbar & Sidebar)</label>
                        <!-- Input color picker bawaan HTML5 -->
                        <input type="color" class="form-control form-control-color w-100" name="theme_color" value="#0d47a1" title="Pilih Warna Tema Buku">
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
