<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book IMS - PT Amarin Ship Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-maritime {
            background-color: #0d47a1; /* Biru Navy Maritim */
            border-bottom: 4px solid #fbc02d; /* Aksen Kuning Emas */
        }
        .sidebar-book {
            background-color: #ffffff;
            height: calc(100vh - 60px);
            overflow-y: auto;
            border-right: 1px solid #e0e0e0;
        }
        .content-reader {
            height: calc(100vh - 60px);
            overflow-y: auto;
            padding: 40px;
            background-color: #ffffff;
        }
        .part-title { font-weight: 800; color: #0d47a1; font-size: 1.1rem; }
        .chapter-title { font-weight: 600; color: #4f5d75; }
        .subchapter-link {
            color: #555;
            text-decoration: none;
            display: block;
            padding: 5px 0;
            transition: 0.2s;
        }
        .subchapter-link:hover { color: #0d47a1; font-weight: bold; padding-left: 5px; }
    </style>
</head>
<body>

    <!-- Navbar Publik -->
    <nav class="navbar navbar-dark navbar-maritime shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fa-solid fa-ship me-2"></i> E-Book IMS Amarin
            </a>
            <div class="d-flex">
                <a href="/admin" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="fa-solid fa-lock me-1"></i> Admin Login
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Daftar Isi (Index) -->
            <div class="col-md-3 sidebar-book p-3 shadow-sm">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fa-solid fa-list me-2"></i> Daftar Isi</h5>

                @if($parts->isEmpty())
                    <p class="text-muted small">Buku panduan belum diunggah.</p>
                @else
                    <div class="accordion accordion-flush" id="accordionBook">
                        @foreach($parts as $part)
                            <div class="mb-3">
                                <div class="part-title text-uppercase mb-2">{{ $part->title }}</div>

                                @foreach($part->chapters as $chapter)
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed py-2 px-1 chapter-title bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#chap-{{ $chapter->id }}">
                                            {{ $chapter->title }}
                                        </button>
                                    </h2>
                                    <div id="chap-{{ $chapter->id }}" class="accordion-collapse collapse">
                                        <div class="accordion-body py-1 px-3 border-start border-2 border-primary ms-2">
                                            @foreach($chapter->subChapters as $sub)
                                                <!-- Link ini nantinya akan memuat isi materi di sebelah kanan -->
                                                <a href="?read={{ $sub->id }}" class="subchapter-link small">
                                                    <i class="fa-regular fa-file-lines me-1"></i> {{ $sub->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Area Baca Utama -->
            <div class="col-md-9 content-reader shadow-sm">
                <div class="container mx-auto" style="max-width: 800px;">
                    <div class="text-center mb-5 mt-4">
                        <i class="fa-solid fa-book-atlas fa-4x text-muted mb-3"></i>
                        <h2 class="fw-bold text-dark">Sistem Manajemen Terintegrasi</h2>
                        <p class="text-muted">Silakan pilih sub-bab pada menu di sebelah kiri untuk mulai membaca dokumen operasional.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
