@extends('layouts.admin')

@section('content')
<a href="/admin/books" class="text-decoration-none text-muted fw-bold mb-4 d-inline-block hover:text-amarin transition-colors">
    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Pustaka
</a>

<div class="glass-panel p-4 mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h3 class="fw-bolder text-slate-800 mb-1">Kelola Formulir & Checklist</h3>
        <p class="text-muted mb-0">Buku: <span class="fw-bold text-amarin">{{ $book->title }}</span></p>
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
                    <th>Judul Formulir</th>
                    <th>Tipe File</th>
                    <th class="text-end pe-4" width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($book->forms as $index => $form)
                <tr>
                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                    <td class="fw-bold text-slate-800">{{ $form->title }}</td>
                    <td>
                        @if($form->file_type == 'pdf')
                            <span class="badge bg-danger text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-pdf me-1"></i> PDF Document</span>
                        @else
                            <span class="badge bg-primary text-white px-3 py-2 rounded-lg"><i class="fa-solid fa-file-word me-1"></i> Word Document</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-light border me-2 shadow-sm text-primary fw-bold" onclick="editForm({{ $form->id }}, '{{ $form->title }}')" title="Edit & Ganti File">
                            <i class="fa-solid fa-pen"></i> Edit
                        </button>
                        <form action="/admin/forms/{{ $form->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus form ini secara permanen?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm fw-bold"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-5 text-muted fw-bold">Belum ada lampiran form. Silakan unggah dokumen PDF/Word.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addFormModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-panel border-0">
            <form action="/admin/books/{{ $book->id }}/forms" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom border-light">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-cloud-arrow-up me-2"></i> Unggah Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="fw-bold text-slate-700 mb-1">Nama Form / Checklist</label>
                        <input type="text" class="form-control bg-white/50" name="title" required placeholder="Cth: Navigational Checklist">
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold text-slate-700 mb-1">File Dokumen (PDF / Word)</label>
                        <input type="file" class="form-control bg-white/50" name="form_file" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted mt-1 d-block">Unggah file mentahan agar bisa diunduh oleh kru.</small>
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
                    <div class="mb-4">
                        <label class="fw-bold text-slate-700 mb-1">Nama Form / Checklist</label>
                        <input type="text" class="form-control bg-white/50" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold text-slate-700 mb-1">Ganti File (Opsional)</label>
                        <input type="file" class="form-control bg-white/50" name="form_file" accept=".pdf,.doc,.docx">
                        <small class="text-muted mt-1 d-block">Kosongkan jika tidak ingin mengganti file dokumen saat ini.</small>
                    </div>
                </div>
                <div class="modal-footer border-top border-light"><button type="submit" class="btn btn-amarin w-100">Update Data</button></div>
            </form>
        </div>
    </div>
</div>

<script>
    function editForm(id, title) {
        document.getElementById('editForm').action = '/admin/forms/' + id;
        document.getElementById('editTitle').value = title;
        new bootstrap.Modal(document.getElementById('editFormModal')).show();
    }
</script>
@endsection
