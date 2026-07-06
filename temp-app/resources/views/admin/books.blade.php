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
                        <th width="5%">Tema</th>
                        <th width="30%">Judul Buku</th>
                        <th>Deskripsi</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="width: 30px; height: 30px; background-color: {{ $book->theme_color }}; border-radius: 5px; border: 1px solid #ccc;"></div>
                        </td>
                        <td class="fw-bold text-dark">
                            {{ $book->title }}
                            <!-- Indikator file PDF -->
                            @if($book->pdf_file)
                                <span class="badge bg-danger ms-2"><i class="fa-solid fa-file-pdf"></i> PDF</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $book->description ?? '-' }}</td>
                        <td>
                            <a href="/admin/books/{{ $book->id }}/parts" class="btn btn-sm btn-info text-white me-1" title="Kelola Materi">
                                <i class="fa-solid fa-folder-open"></i> Kelola Part
                            </a>
                            <button class="btn btn-sm btn-warning text-dark me-1" data-bs-toggle="modal" data-bs-target="#editBookModal-{{ $book->id }}" title="Edit Info & File">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookModal-{{ $book->id }}" title="Hapus Buku">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Buku -->
                    <div class="modal fade" id="editBookModal-{{ $book->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/admin/books/{{ $book->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Method Spoofing untuk UPDATE -->
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-dark">Edit E-Book</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Judul Buku</label>
                                            <input type="text" class="form-control" name="title" value="{{ $book->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                                            <textarea class="form-control" name="description" rows="2">{{ $book->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ganti Cover Buku (Opsional)</label>
                                            @if($book->cover_image)
                                                <div class="mb-2 small text-success"><i class="fa-solid fa-check"></i> Cover saat ini sudah tersimpan.</div>
                                            @endif
                                            <input type="file" class="form-control" name="cover_image" accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ganti File PDF Asli (Opsional)</label>
                                            @if($book->pdf_file)
                                                <div class="mb-2 small text-success"><i class="fa-solid fa-check"></i> PDF Mentahan sudah tersimpan.</div>
                                            @endif
                                            <input type="file" class="form-control" name="pdf_file" accept="application/pdf">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tema Warna</label>
                                            <input type="color" class="form-control form-control-color" name="theme_color" value="{{ $book->theme_color }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning text-dark"><i class="fa-solid fa-save me-1"></i> Perbarui Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="deleteBookModal-{{ $book->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/admin/books/{{ $book->id }}" method="POST">
                                    @csrf
                                    @method('DELETE') <!-- Method Spoofing untuk DELETE -->
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Konfirmasi Penghapusan</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus buku <strong>{{ $book->title }}</strong>?</p>
                                        <p class="text-danger small mb-0"><i class="fa-solid fa-triangle-exclamation"></i> Seluruh file Cover, PDF, serta data Part dan Chapter di dalamnya akan ikut terhapus permanen.</p>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash me-1"></i> Ya, Hapus Buku</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
            <form action="/admin/books" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Buat E-Book Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Buku</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cover Buku (JPG/PNG)</label>
                        <input type="file" class="form-control" name="cover_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mentahan Dokumen Asli (PDF)</label>
                        <input type="file" class="form-control" name="pdf_file" accept="application/pdf">
                        <small class="text-muted">Akan ditampilkan di tab 'Mentahan PDF' pada sisi pembaca.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Tema Warna Navbar</label>
                        <input type="color" class="form-control form-control-color" name="theme_color" value="#0d47a1">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
