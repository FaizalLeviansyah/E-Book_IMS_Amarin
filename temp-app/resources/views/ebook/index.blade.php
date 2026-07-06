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

        body { background: var(--bg-body); color: var(--text-main); font-family: 'Segoe UI', Tahoma, sans-serif; transition: 0.4s; overflow-x: hidden; }

        .glass-panel { background: var(--glass-bg); backdrop-filter: blur(16px); border: 1px solid var(--glass-border); border-radius: 16px; box-shadow: var(--glass-shadow); }

        /* Tinggi dinamis agar responsif di layar HP maupun PC */
        .sidebar-glass, .content-glass { height: calc(100vh - 90px); overflow-y: auto; padding: 25px; transition: all 0.3s ease-in-out; }
        @media (max-width: 768px) {
            .sidebar-glass, .content-glass { height: auto; min-height: calc(100vh - 90px); }
            .pdf-frame { height: 70vh !important; }
        }

        .sidebar-hidden { display: none !important; }

        .subchapter-link { color: var(--text-muted); text-decoration: none; display: block; padding: 10px 15px; border-radius: 6px; border-left: 3px solid transparent; transition: 0.2s; font-size: 0.9rem; }
        .subchapter-link:hover, .subchapter-link.active { color: var(--brand-color); background: var(--acc-active-bg); border-left: 3px solid var(--brand-color); }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: rgba(13, 71, 161, 0.2); border-radius: 10px; }
        .nav-tabs .nav-link { color: var(--text-muted); border-radius: 10px 10px 0 0; font-weight: bold; border: none; }
        .nav-tabs .nav-link.active { color: var(--brand-color); background-color: var(--glass-bg); border-color: var(--glass-border) var(--glass-border) transparent; border-bottom: 2px solid var(--glass-bg); }

        .widget-dropdown { min-width: 280px; }
        #eye-care-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255, 190, 90, var(--sepia-level, 0)); pointer-events: none; z-index: 9999; mix-blend-mode: multiply; }

        .book-card { transition: all 0.3s ease; }
        .book-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; cursor: pointer; }
        .book-item-sidebar:hover { background: var(--acc-active-bg); cursor: pointer; }
    </style>
</head>
<body>

    <div id="eye-care-overlay"></div>

    <nav class="navbar navbar-expand-lg glass-panel sticky-top" style="border-radius: 0; border-top: 0; border-left: 0; border-right: 0; z-index: 1040;">
        <div class="container-fluid px-3 px-md-4">

            <div class="d-flex align-items-center">
                <button class="btn btn-sm d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile" style="color: var(--brand-color);">
                    <i class="fa-solid fa-bars fs-5"></i>
                </button>

                <button class="btn btn-sm glass-panel me-3 d-none d-md-block shadow-sm" id="desktopSidebarToggle" style="color: var(--brand-color);" title="Buka/Tutup Sidebar">
                    <i class="fa-solid fa-bars-staggered" id="sidebarToggleIcon"></i>
                </button>

                <a class="navbar-brand fw-bold d-flex align-items-center m-0" href="/" style="color: var(--brand-color); text-shadow: var(--brand-glow);">
                    <i class="fa-solid fa-ship me-2 d-none d-sm-block"></i> E-Book System
                </a>
            </div>

            <div class="d-flex align-items-center ms-auto">
                <form action="/" method="GET" class="d-flex me-2 me-md-4">
                    <div class="input-group input-group-sm shadow-sm" style="max-width: 200px;">
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari..." value="{{ request('search') }}">
                        <button class="btn text-white" style="background-color: var(--brand-color);" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

                <div class="dropdown me-2 me-md-3">
                    <button class="btn btn-sm glass-panel fw-bold shadow-sm" style="color: var(--brand-color); border-color: var(--glass-border);" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <i class="fa-solid fa-sliders"></i> <span class="d-none d-md-inline ms-1">Tampilan</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-3 glass-panel widget-dropdown border-0 shadow-lg mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom" style="border-color: var(--glass-border) !important;">
                            <label class="form-check-label fw-bold" for="themeSwitch" style="color: var(--text-main);">
                                <i class="fa-solid fa-moon me-2"></i>Mode Malam
                            </label>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input fs-5" type="checkbox" role="switch" id="themeSwitch">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="readSlider" class="form-label fw-bold d-flex justify-content-between" style="color: var(--text-main);">
                                <span><i class="fa-solid fa-glasses me-2"></i>Proteksi Mata</span>
                                <span id="sliderValue" class="text-muted small">0%</span>
                            </label>
                            <input type="range" class="form-range" id="readSlider" min="0" max="0.4" step="0.05" value="0">
                        </div>
                    </div>
                </div>

                <a href="/admin" class="btn btn-sm fw-bold text-white shadow-sm" style="background-color: var(--brand-color); border-radius: 20px; padding: 6px 15px;">
                    <i class="fa-solid fa-shield-halved"></i> <span class="d-none d-md-inline ms-1">Admin</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3 px-3 px-md-4 mb-4">
        <div class="row g-3 g-md-4">

            <div class="col-md-3 d-none d-md-block transition-all" id="sidebar-column">
                <div class="offcanvas-md offcanvas-start glass-panel sidebar-glass" tabindex="-1" id="sidebarMobile" style="background: var(--glass-bg);">

                    <div class="offcanvas-header d-md-none border-bottom" style="border-color: var(--glass-border) !important;">
                        <h5 class="offcanvas-title fw-bold" style="color: var(--brand-color);"><i class="fa-solid fa-book-journal-whills me-2"></i> Pustaka Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="filter: var(--icon-filter);"></button>
                    </div>

                    <div class="offcanvas-body flex-column p-md-0">
                        <h5 class="fw-bold mb-4 d-none d-md-block" style="color: var(--brand-color); border-bottom: 1px solid var(--glass-border); padding-bottom: 15px;">
                            <i class="fa-solid fa-book-journal-whills me-2"></i> Pustaka Dokumen
                        </h5>

                        @if($books->isEmpty())
                            <div class="alert alert-info bg-transparent border-info text-info small">Pustaka masih kosong.</div>
                        @else
                            <div class="accordion accordion-flush" id="bookAccordion">
                                @foreach($books as $book)
                                    <div class="accordion-item bg-transparent border-0 mb-3">

                                        <div class="d-flex align-items-center shadow-sm rounded book-item-sidebar p-2" style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                                            <a href="?read_book={{ $book->id }}" class="d-flex align-items-center flex-grow-1 text-decoration-none" style="color: var(--text-main);">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" class="rounded me-3 shadow-sm" style="width: 45px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="rounded me-3 d-flex justify-content-center align-items-center shadow-sm" style="width: 45px; height: 60px; background: {{ $book->theme_color ?? 'var(--brand-color)' }}; color: white;"><i class="fa-solid fa-book"></i></div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold mb-1" style="font-size: 0.95rem; line-height: 1.2;">{{ $book->title }}</div>
                                                    @if($book->pdf_file)
                                                        <div style="font-size: 0.75rem; color: var(--brand-color);"><i class="fa-solid fa-file-pdf"></i> Lihat PDF Asli</div>
                                                    @else
                                                        <div style="font-size: 0.75rem; color: var(--text-muted);"><i class="fa-solid fa-file-circle-xmark"></i> PDF Belum Tersedia</div>
                                                    @endif
                                                </div>
                                            </a>
                                            <button class="btn btn-sm text-muted ms-2 p-2 border-start" type="button" data-bs-toggle="collapse" data-bs-target="#book-{{ $book->id }}" style="border-radius: 0; border-color: var(--glass-border) !important;">
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </button>
                                        </div>

                                        <div id="book-{{ $book->id }}" class="accordion-collapse collapse {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'show' : '' }}" data-bs-parent="#bookAccordion">
                                            <div class="accordion-body p-2 mt-2">
                                                @foreach($book->parts as $part)
                                                    <div class="fw-bold text-uppercase mb-1 mt-3" style="color: var(--text-muted); font-size: 0.75rem;"><i class="fa-solid fa-layer-group me-1"></i> {{ $part->title }}</div>
                                                    <div class="ms-1 mb-2 border-start border-2" style="border-color: var(--glass-border) !important;">
                                                        @foreach($part->chapters as $chapter)
                                                            <a href="?read={{ $chapter->id }}" class="subchapter-link {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'active fw-bold' : '' }}">
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
            </div>

            <div class="col-md-9 transition-all" id="content-column">
                <div class="glass-panel content-glass p-0">

                    @if(isset($searchResults))
                        <div class="p-3 p-md-4">
                            <h4 class="fw-bold mb-4" style="color: var(--brand-color);"><i class="fa-solid fa-magnifying-glass me-2"></i> Hasil: "{{ request('search') }}"</h4>
                            @if($searchResults->isEmpty())
                                <div class="alert alert-warning border-0 shadow-sm text-center py-4">
                                    <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 text-warning"></i><br>Tidak ada dokumen yang cocok.
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($searchResults as $result)
                                        <a href="?read={{ $result->id }}" class="list-group-item list-group-item-action mb-2 border-0 shadow-sm rounded glass-panel" style="background: var(--acc-active-bg); color: var(--text-main);">
                                            <h6 class="fw-bold mb-1" style="color: var(--brand-color);">{{ $result->title }}</h6>
                                            <small class="text-muted">Kecocokan ditemukan pada Bab ini.</small>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    @elseif(isset($activeBook))

                        @if($activeBook->pdf_file || isset($activeChapter))

                            <div class="px-3 px-md-4 pt-3" style="background: var(--acc-active-bg); border-radius: 16px 16px 0 0;">
                                <ul class="nav nav-tabs border-bottom-0" role="tablist">
                                    @if(isset($activeChapter))
                                    <li class="nav-item" role="presentation">
                                        <a href="?read={{ $activeChapter->id }}" class="nav-link active">
                                            <i class="fa-solid fa-file-code me-1"></i> Teks Interaktif
                                        </a>
                                    </li>
                                    @endif

                                    @if($activeBook->pdf_file)
                                    <li class="nav-item" role="presentation">
                                        <a href="?read_book={{ $activeBook->id }}" class="nav-link {{ !isset($activeChapter) ? 'active' : '' }}">
                                            <i class="fa-solid fa-file-pdf {{ !isset($activeChapter) ? 'text-danger' : '' }} me-1"></i> File PDF Asli
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="border-top" style="border-color: var(--glass-border) !important;">
                                @if(isset($activeChapter))
                                <div class="p-3 p-md-4">
                                    <h3 class="fw-bold mb-4" style="color: var(--brand-color);">{{ $activeChapter->title }}</h3>
                                    <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main); overflow-wrap: break-word;">
                                        {!! $activeChapter->content !!}
                                    </div>
                                </div>
                                @elseif($activeBook->pdf_file)
                                <div>
                                    <div class="bg-dark d-flex flex-wrap justify-content-between align-items-center px-3 py-2 text-white">
                                        <small class="mb-1 mb-md-0"><i class="fa-solid fa-magnifying-glass me-1"></i> Gunakan <b>Ctrl + F</b> (PC) / <b>Cari</b> (HP) untuk mencari kata.</small>
                                        <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-up-right-from-square me-1"></i> Layar Penuh</a>
                                    </div>
                                    <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" width="100%" class="pdf-frame" style="height: 75vh; border: none; border-radius: 0 0 16px 16px;"></iframe>
                                </div>
                                @endif
                            </div>

                        @else
                            <div class="d-flex h-100 flex-column align-items-center justify-content-center text-center p-4">
                                <i class="fa-solid fa-file-circle-xmark fa-4x mb-4 text-muted"></i>
                                <h3 class="fw-bold mb-2" style="color: var(--text-main);">PDF Belum Diunggah</h3>
                                <p style="color: var(--text-muted); max-width: 500px; font-size: 1.1rem;">
                                    Administrator belum melampirkan file mentahan PDF untuk buku <b>{{ $activeBook->title }}</b>.
                                </p>
                                <p style="color: var(--text-muted); font-size: 0.9rem;">
                                    Silakan gunakan ikon <i class="fa-solid fa-chevron-down"></i> di sidebar untuk membaca teks interaktif per bab.
                                </p>
                            </div>
                        @endif

                    @else
                        <div class="p-4 p-md-5">
                            <div class="d-flex flex-column flex-md-row align-items-center mb-5 border-bottom pb-4 text-center text-md-start" style="border-color: var(--glass-border) !important;">
                                <i class="fa-brands fa-space-awesome fa-4x mb-3 mb-md-0 me-md-4" style="color: var(--brand-color); filter: drop-shadow(var(--brand-glow));"></i>
                                <div>
                                    <h2 class="fw-bold mb-2" style="color: var(--text-main);">E-Book Terintegrasi</h2>
                                    <p style="color: var(--text-muted); margin: 0; font-size: 1.1rem;">Platform digitalisasi dokumen operasional dan keselamatan kapal PT Amarin Ship Management.</p>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3" style="color: var(--brand-color);">
                                <i class="fa-solid fa-book-bookmark me-2"></i> Daftar E-Book Tersedia
                            </h5>
                            <div class="row g-3 mb-5">
                                @forelse($books as $book)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <a href="?read_book={{ $book->id }}" class="text-decoration-none">
                                            <div class="glass-panel p-3 h-100 d-flex flex-column align-items-center text-center book-card" style="border-top: 4px solid {{ $book->theme_color ?? 'var(--brand-color)' }};">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover" class="rounded mb-3 shadow-sm" style="width: 70px; height: 95px; object-fit: cover;">
                                                @else
                                                    <div class="rounded mb-3 d-flex justify-content-center align-items-center shadow-sm" style="width: 70px; height: 95px; background: {{ $book->theme_color ?? 'var(--brand-color)' }}; color: white;"><i class="fa-solid fa-book fa-2x"></i></div>
                                                @endif
                                                <h6 class="fw-bold mb-1 w-100 text-truncate" style="color: var(--text-main); font-size: 0.9rem;" title="{{ $book->title }}">{{ $book->title }}</h6>
                                                <small style="color: var(--text-muted); font-size: 0.75rem;">{{ $book->parts->count() }} Bagian</small>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert glass-panel border-0 text-center text-muted">Belum ada E-Book yang ditambahkan.</div>
                                    </div>
                                @endforelse
                            </div>

                            <h5 class="fw-bold mb-4" style="color: var(--brand-color);">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i> Baru Saja Diperbarui
                            </h5>
                            @if(isset($recentUpdates) && $recentUpdates->isNotEmpty())
                                <div class="list-group shadow-sm">
                                    @foreach($recentUpdates as $update)
                                        <a href="?read={{ $update->id }}" class="list-group-item list-group-item-action border-0 mb-2 rounded glass-panel" style="background: var(--acc-active-bg); transition: 0.3s;">
                                            <div class="d-flex flex-column flex-md-row w-100 justify-content-between align-items-md-center mb-1">
                                                <h6 class="fw-bold mb-2 mb-md-0" style="color: var(--text-main); font-size: 1.1rem;">{{ $update->title }}</h6>
                                                <span class="badge rounded-pill align-self-start align-self-md-center" style="background-color: var(--brand-color);">{{ $update->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="small mt-2 mt-md-0" style="color: var(--text-muted);">
                                                <i class="fa-solid fa-book-open me-1"></i> <strong>{{ $update->part->book->title ?? 'Tidak diketahui' }}</strong> &nbsp;|&nbsp;
                                                <i class="fa-solid fa-folder me-1"></i> {{ $update->part->title }}
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert glass-panel border-0 text-center py-4 text-muted">
                                    <i class="fa-solid fa-box-open fa-2x mb-2"></i><br>Belum ada aktivitas penambahan bab.
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // === Logika Tema ===
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

            // === Logika Proteksi Mata ===
            const readSlider = document.getElementById('readSlider');
            const sliderValueText = document.getElementById('sliderValue');
            const savedSepia = localStorage.getItem('amarin-sepia') || '0';

            readSlider.value = savedSepia;
            htmlElement.style.setProperty('--sepia-level', savedSepia);
            sliderValueText.textContent = Math.round((savedSepia / 0.4) * 100) + '%';

            readSlider.addEventListener('input', (e) => {
                const val = e.target.value;
                htmlElement.style.setProperty('--sepia-level', val);
                localStorage.setItem('amarin-sepia', val);
                sliderValueText.textContent = Math.round((val / 0.4) * 100) + '%';
            });

            document.querySelector('.widget-dropdown').addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // === Logika Buka/Tutup Sidebar ===
            const desktopToggle = document.getElementById('desktopSidebarToggle');
            const sidebarCol = document.getElementById('sidebar-column');
            const contentCol = document.getElementById('content-column');
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            if(desktopToggle) {
                desktopToggle.addEventListener('click', () => {
                    sidebarCol.classList.toggle('sidebar-hidden');

                    if(sidebarCol.classList.contains('sidebar-hidden')) {
                        contentCol.classList.replace('col-md-9', 'col-md-12');
                        toggleIcon.classList.replace('fa-bars-staggered', 'fa-bars');
                    } else {
                        contentCol.classList.replace('col-md-12', 'col-md-9');
                        toggleIcon.classList.replace('fa-bars', 'fa-bars-staggered');
                    }
                });
            }
        });
    </script>
</body>
</html>
