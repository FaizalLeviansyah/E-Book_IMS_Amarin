@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bolder text-slate-800"><i class="fa-solid fa-file-signature text-amarin me-2"></i> Pustaka Formulir</h2>
        <p class="text-muted">Kelola seluruh form, checklist, dengan pengelompokan kategori (C, H, J, dll).</p>
    </div>
    <button type="button" class="btn btn-amarin px-4 py-2" data-bs-toggle="modal" data-bs-target="#addFormModal">
        <i class="fa-solid fa-upload me-2"></i> Unggah Form Baru
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success glass-panel border-0 text-success fw-bold"><i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="glass-panel p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" width="5%">No</th>
                    <th width="15%">Kategori</th>
                    <th>Judul Formulir</th>
                    <th>Tipe File</th>
                    <th class="text-end pe-4" width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($forms as $index => $form)
                <tr>
                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                    <td><span class="badge bg-slate-200 text-slate-700 px-2 py-1"><i class="fa-solid fa-tag me-1"></i> {{ $form->category }}</span></td>
                    <td class="fw-bold text-slate-800">{{ $form->title }}</td>
                    <td>
                        @if($form->file_type == 'pdf')
                            <span class="badge bg-danger text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-pdf me-1"></i> PDF</span>
                        @else
                            <span class="badge bg-primary text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-word me-1"></i> Word</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-light border me-2 shadow-sm text-primary fw-bold" onclick="editForm({{ $form->id }}, '{{ addslashes($form->title) }}', '{{ addslashes($form->category) }}', {{ $form->book_id }})" title="Edit & Ganti File">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form action="/admin/forms/{{ $form->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus form ini secara permanen?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm fw-bold"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted fw-bold">Belum ada formulir yang diunggah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addFormModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0">
            <form action="/admin/forms" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom border-light">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-cloud-arrow-up me-2"></i> Unggah Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1">Terkait Buku Apa?</label>
                        <select class="form-select bg-white/50" name="book_id" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1">Kategori Formulir</label>
                        <input type="text" class="form-control bg-white/50" name="category" required placeholder="Cth: FORM C, FORM H, FORM J">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1">Nama / Judul Form</label>
                        <input type="text" class="form-control bg-white/50" name="title" required placeholder="Cth: C1-040 VISITOR PRE-BOARDING">
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold text-slate-700 mb-1">File Dokumen (PDF / Word)</label>
                        <input type="file" class="form-control bg-white/50" name="form_file" accept=".pdf,.doc,.docx" required>
                    </div>
                </div>
                <div class="modal-footer border-top border-light"><button type="submit" class="btn btn-amarin w-100">Simpan & Unggah</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editFormModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header border-bottom border-light">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Formulir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1">Terkait Buku Apa?</label>
                        <select class="form-select bg-white/50" id="editBookId" name="book_id" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1">Kategori Formulir</label>
                        <input type="text" class="form-control bg-white/50" id="editCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1">Nama / Judul Form</label>
                        <input type="text" class="form-control bg-white/50" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold text-slate-700 mb-1">Ganti File (Opsional)</label>
                        <input type="file" class="form-control bg-white/50" name="form_file" accept=".pdf,.doc,.docx">
                    </div>
                </div>
                <div class="modal-footer border-top border-light"><button type="submit" class="btn btn-amarin w-100">Update Data</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    function editForm(id, title, category, book_id) {
        document.getElementById('editForm').action = '/admin/forms/' + id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editCategory').value = category;
        document.getElementById('editBookId').value = book_id;
        new bootstrap.Modal(document.getElementById('editFormModal')).show();
    }
</script>
@endsection
