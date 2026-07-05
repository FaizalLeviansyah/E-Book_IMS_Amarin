@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Kelola Bagian (Part)</h3>
            <p class="text-muted">Tambahkan dan kelola Bagian Utama dari dokumen IMS.</p>
        </div>
        <!-- Tombol untuk memunculkan Pop-Up Form -->
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPartModal">
            <i class="fa-solid fa-plus me-2"></i> Tambah Part
        </button>
    </div>

    <!-- Alert jika sukses menyimpan -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Daftar Part -->
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
                        <td class="fw-bold text-primary">{{ $part->title }}</td>
                        <td>
                            <!-- Tombol menuju halaman pengelolaan Bab -->
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

<!-- Pop-Up (Modal) Form Tambah Part -->
<div class="modal fade" id="addPartModal" tabindex="-1" aria-labelledby="addPartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/parts" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addPartModalLabel">Tambah Part Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Part</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: PART A - COMPANY CIMS STRUCTURE" required>
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

<!-- Pastikan memanggil script JS Bootstrap agar Modal pop-up bisa berfungsi -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
