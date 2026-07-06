<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book System - PT Amarin Ship Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-body: #f4f7f9;
            --text-main: #2c3e50;
            --text-muted: #6c757d;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(13, 71, 161, 0.1);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
            --brand-color: #0d47a1;
            --brand-glow: 0 4px 15px rgba(13, 71, 161, 0.15);
            --acc-active-bg: rgba(13, 71, 161, 0.05);
        }
        [data-theme="dark"] {
            --bg-body: #051124;
            --text-main: #e0e6ed;
            --text-muted: #8da4c0;
            --glass-bg: rgba(10, 25, 50, 0.6);
            --glass-border: rgba(0, 225, 255, 0.15);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --brand-color: #00e1ff;
            --brand-glow: 0 0 15px rgba(0, 225, 255, 0.3);
            --acc-active-bg: rgba(0, 225, 255, 0.05);
        }
        body { background: var(--bg-body); color: var(--text-main); font-family: 'Segoe UI', Tahoma, sans-serif; transition: 0.4s; }
        .glass-panel { background: var(--glass-bg); backdrop-filter: blur(16px); border: 1px solid var(--glass-border); border-radius: 16px; box-shadow: var(--glass-shadow); }
        .sidebar-glass, .content-glass { height: calc(100vh - 90px); overflow-y: auto; padding: 25px; }
        .subchapter-link { color: var(--text-muted); text-decoration: none; display: block; padding: 8px 15px; border-radius: 6px; border-left: 3px solid transparent; transition: 0.2s; font-size: 0.9rem; }
        .subchapter-link:hover, .subchapter-link.active { color: var(--brand-color); background: var(--acc-active-bg); border-left: 3px solid var(--brand-color); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: rgba(13, 71, 161, 0.2); border-radius: 10px; }
        .nav-tabs .nav-link { color: var(--text-muted); border-radius: 10px 10px 0 0; font-weight: bold; }
        .nav-tabs .nav-link.active { color: var(--brand-color); background-color: var(--glass-bg); border-color: var(--glass-border) var(--glass-border) transparent; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg glass-panel sticky-top" style="border-radius: 0; border-top: 0; border-left: 0; border-right: 0;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/" style="color: var(--brand-color); text-shadow: var(--brand-glow);">
                <i class="fa-solid fa-ship me-3"></i> E-Book System
            </a>
            <div class="d-flex align-items-center">
                <form action="/" method="GET" class="d-flex me-4">
                    <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari isi materi..." value="{{ request('search') }}">
                        <button class="btn text-white" style="background-color: var(--brand-color);" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <div class="form-check form-switch me-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch">
                    <label class="form-check-label" for="themeSwitch"><i class="fa-solid fa-moon"></i></label>
                </div>
                <a href="/admin" class="btn btn-sm fw-bold text-white shadow-sm" style="background-color: var(--brand-color); border-radius: 20px; padding: 6px 20px;"><i class="fa-solid fa-shield-halved me-1"></i> Admin</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3 px-4 mb-4">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="glass-panel sidebar-glass">
                    <h5 class="fw-bold mb-4" style="color: var(--brand-color); border-bottom: 1px solid var(--glass-border); padding-bottom: 15px;">
                        <i class="fa-solid fa-book-journal-whills me-2"></i> Pustaka Dokumen
                    </h5>

                    @if($books->isEmpty())
                        <div class="alert alert-info bg-transparent border-info text-info small">Pustaka masih kosong.</div>
                    @else
                        <div class="accordion accordion-flush" id="bookAccordion">
                            @foreach($books as $book)
                                <div class="accordion-item bg-transparent border-0 mb-3">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed shadow-sm rounded glass-panel" type="button" data-bs-toggle="collapse" data-bs-target="#book-{{ $book->id }}" style="padding: 10px;">
                                            <div class="d-flex align-items-center">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" class="rounded me-3" style="width: 40px; height: 55px; object-fit: cover;">
                                                @else
                                                    <div class="rounded me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 55px; background: var(--brand-color); color: white;"><i class="fa-solid fa-book"></i></div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold" style="color: var(--text-main); font-size: 0.95rem;">{{ $book->title }}</div>
                                                    <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $book->parts->count() }} Bagian</div>
                                                </div>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="book-{{ $book->id }}" class="accordion-collapse collapse {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'show' : '' }}" data-bs-parent="#bookAccordion">
                                        <div class="accordion-body p-2 mt-2">
                                            @foreach($book->parts as $part)
                                                <div class="fw-bold text-uppercase mb-1 mt-2" style="color: var(--text-muted); font-size: 0.75rem;">{{ $part->title }}</div>
                                                <div class="ms-1 mb-2 border-start border-2" style="border-color: var(--glass-border) !important;">
                                                    @foreach($part->chapters as $chapter)
                                                        <a href="?read={{ $chapter->id }}" class="subchapter-link {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'active' : '' }}">
                                                            <i class="fa-regular fa-file-lines me-2"></i> {{ $chapter->title }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-9">
                <div class="glass-panel content-glass p-0">

                    @if(isset($searchResults))
                        <div class="p-4">
                            <h4 class="fw-bold mb-4" style="color: var(--brand-color);"><i class="fa-solid fa-magnifying-glass me-2"></i> Hasil: "{{ request('search') }}"</h4>
                            <div class="list-group">
                                @foreach($searchResults as $result)
                                    <a href="?read={{ $result->id }}" class="list-group-item list-group-item-action mb-2 border-0 shadow-sm rounded glass-panel" style="background: var(--acc-active-bg); color: var(--text-main);">
                                        <h6 class="fw-bold mb-1" style="color: var(--brand-color);">{{ $result->title }}</h6>
                                        <small class="text-muted">Kecocokan ditemukan pada Bab ini.</small>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    @elseif(isset($activeChapter) && isset($activeBook))

                        <ul class="nav nav-tabs px-4 pt-3 border-bottom-0" id="readTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#text-mode" type="button">
                                    <i class="fa-solid fa-file-code me-2"></i> Teks Interaktif
                                </button>
                            </li>
                            @if($activeBook->pdf_file)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pdf-mode" type="button">
                                    <i class="fa-solid fa-file-pdf me-2 text-danger"></i> Mentahan PDF
                                </button>
                            </li>
                            @endif
                        </ul>

                        <div class="tab-content border-top" style="border-color: var(--glass-border) !important;">
                            <div class="tab-pane fade show active p-4" id="text-mode">
                                <h3 class="fw-bold mb-4" style="color: var(--brand-color);">{{ $activeChapter->title }}</h3>
                                <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main);">
                                    {!! $activeChapter->content !!}
                                </div>
                            </div>

                            @if($activeBook->pdf_file)
                            <div class="tab-pane fade" id="pdf-mode">
                                <div class="bg-dark d-flex justify-content-between px-3 py-2 text-white">
                                    <small><i class="fa-solid fa-circle-info me-1"></i> Gunakan <b>Ctrl + F</b> untuk mencari kata di dalam PDF ini.</small>
                                    <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="text-white text-decoration-none small"><i class="fa-solid fa-up-right-from-square me-1"></i> Buka Penuh</a>
                                </div>
                                <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" width="100%" height="700px" style="border: none;"></iframe>
                            </div>
                            @endif
                        </div>

                    @else
                        <div class="d-flex h-100 flex-column align-items-center justify-content-center text-center p-4">
                            <i class="fa-brands fa-space-awesome fa-4x mb-4" style="color: var(--brand-color);"></i>
                            <h3 class="fw-bold mb-3" style="color: var(--text-main);">Pusat Integrasi Data</h3>
                            <p style="color: var(--text-muted); max-width: 500px;">Pilih buku pada pustaka di sebelah kiri untuk mulai membaca. Anda dapat melihat teks interaktif maupun dokumen PDF asli yang disahkan.</p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const themeSwitch = document.getElementById('themeSwitch');
        const htmlElement = document.documentElement;
        if (localStorage.getItem('amarin-theme') === 'dark') {
            htmlElement.setAttribute('data-theme', 'dark');
            themeSwitch.checked = true;
        }
        themeSwitch.addEventListener('change', (e) => {
            const theme = e.target.checked ? 'dark' : 'light';
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('amarin-theme', theme);
        });
    </script>
</body>
</html>
