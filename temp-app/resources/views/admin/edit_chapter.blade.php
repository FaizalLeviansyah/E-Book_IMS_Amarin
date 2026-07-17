@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <a href="/admin/parts/{{ $chapter->part_id }}/chapters" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Bab
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Edit Materi Bab</h3>
            <p class="text-muted">Perbarui teks interaktif untuk bab ini.</p>
        </div>
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
        <div class="card-header bg-primary text-white fw-bold py-3">
            <i class="fa-solid fa-pen-to-square me-2"></i> Form Edit: {{ $chapter->title }}
        </div>
        <div class="card-body p-4">
            <form action="/admin/chapters/{{ $chapter->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold">Judul Bab</label>
                    <input type="text" class="form-control form-control-lg" name="title" value="{{ $chapter->title }}" required>
                </div>

                <div class="mb-4 p-3 bg-light rounded border">
                    <label class="form-label fw-bold text-primary"><i class="fa-solid fa-file-word me-1"></i> Auto-Import dari MS Word (.docx)</label>
                    <input type="file" id="upload-docx" accept=".docx" class="form-control mb-2">
                    <small class="text-muted">Pilih file Word untuk mengekstrak teksnya langsung ke dalam editor di bawah.</small>
                    <div id="docx-loading" class="text-primary fw-bold mt-2" style="display: none;"><i class="fa-solid fa-spinner fa-spin me-1"></i> Sedang mengekstrak dokumen...</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Materi</label>
                    <textarea class="form-control" id="editor" name="content" rows="10" required>{{ $chapter->content }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="/admin/parts/{{ $chapter->part_id }}/chapters" class="btn btn-light border"><i class="fa-solid fa-times me-1"></i> Batal</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"></script>

<script>
    // Inisialisasi CKEditor yang 100% AMAN dari Crash
    CKEDITOR.replace('editor', {
        height: 600,
        versionCheck: false,  // KUNCI 1: Menghilangkan banner merah "Not Secure" yang menutupi layar
        allowedContent: true, // KUNCI 2: Mencegah format Word (Tabel, Rata Tengah) agar tidak terhapus
        extraAllowedContent: '*(*);*{*};*[*];'
        // Plugin tambahan dihapus agar tidak memicu error "plugin not found" dari CDN
    });

    // Algoritma Ekstraksi Word Otomatis via Mammoth
    document.getElementById('upload-docx').addEventListener('change', function(event) {
        var reader = new FileReader();
        var loadingText = document.getElementById('docx-loading');

        reader.onload = function(event) {
            loadingText.style.display = 'block';
            var arrayBuffer = reader.result;

            mammoth.convertToHtml({
                arrayBuffer: arrayBuffer,
                styleMap: [
                    "p[style-name='Section Title'] => h1:fresh",
                    "p[style-name='Subsection Title'] => h2:fresh",
                    "p[style-name='Heading 1'] => h1:fresh",
                    "p[style-name='Heading 2'] => h2:fresh",
                    "p[style-name='Heading 3'] => h3:fresh"
                ]
            })
            .then(function(result) {
                var html = result.value;
                CKEDITOR.instances.editor.setData(html);
                loadingText.style.display = 'none';
                alert('Dokumen Word berhasil diekstrak! Silakan periksa hasilnya di editor dan pastikan tabel/formatnya sudah rapi sebelum klik Simpan.');
            })
            .catch(function(err) {
                console.log(err);
                loadingText.style.display = 'none';
                alert('Gagal membaca file Word. Pastikan formatnya .docx');
            });
        };

        if (this.files.length > 0) {
            reader.readAsArrayBuffer(this.files[0]);
        }
    });
</script>
@endsection
