<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book IMS - PT Amarin Ship Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* === VARIABEL WARNA (MODE TERANG / DEFAULT) === */
        :root {
            --bg-body: #f4f7f9;
            --text-main: #2c3e50;
            --text-muted: #6c757d;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(13, 71, 161, 0.1);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
            --brand-color: #0d47a1;
            --brand-glow: 0 4px 15px rgba(13, 71, 161, 0.15);
            --acc-btn-bg: rgba(255, 255, 255, 0.5);
            --acc-active-bg: rgba(13, 71, 161, 0.05);
            --icon-filter: invert(0);
        }

        /* === VARIABEL WARNA (MODE GELAP / NIGHT MODE) === */
        [data-theme="dark"] {
            --bg-body: #051124;
            --text-main: #e0e6ed;
            --text-muted: #8da4c0;
            --glass-bg: rgba(10, 25, 50, 0.6);
            --glass-border: rgba(0, 225, 255, 0.15);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --brand-color: #00e1ff;
            --brand-glow: 0 0 15px rgba(0, 225, 255, 0.3);
            --acc-btn-bg: rgba(255, 255, 255, 0.02);
            --acc-active-bg: rgba(0, 225, 255, 0.05);
            --icon-filter: invert(1) opacity(0.8);
        }

        body {
            background: var(--bg-body);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
        }

        /* Filter Eye-Care / Mode Baca (Dikendalikan oleh Slider) */
        #eye-care-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(255, 190, 90, var(--sepia-level, 0));
            pointer-events: none;
            z-index: 9999;
            transition: background-color 0.2s;
            mix-blend-mode: multiply;
        }

        /* Panel Glassmorphism */
        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: var(--glass-shadow);
            transition: all 0.4s ease;
        }

        /* Navbar */
        .navbar-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
        }
        .navbar-brand {
            color: var(--brand-color) !important;
            font-weight: 700;
            text-shadow: var(--brand-glow);
            transition: all 0.4s ease;
        }

        /* Sidebar & Menu */
        .sidebar-glass, .content-glass {
            height: calc(100vh - 90px);
            overflow-y: auto;
            padding: 25px;
        }
        .sidebar-title {
            color: var(--brand-color);
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        /* Link Sub-bab / Navigasi */
        .subchapter-link {
            color: var(--text-muted);
            text-decoration: none;
            display: block;
            padding: 8px 15px;
            border-radius: 6px;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        .subchapter-link:hover, .subchapter-link.active {
            color: var(--brand-color);
            background: var(--acc-active-bg);
            border-left: 3px solid var(--brand-color);
        }

        /* Scrollbar Elegan */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(13, 71, 161, 0.2); border-radius: 10px; }
        [data-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(0, 225, 255, 0.3); }

        /* Widget Tampilan */
        .widget-dropdown { min-width: 280px; }
    </style>
</head>
<body>

    <div id="eye-care-overlay"></div>

    <nav class="navbar navbar-expand-lg navbar-glass sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="fa-solid fa-ship me-3 fs-4"></i>
                <span>E-Book System<br><small class="text-muted fw-normal" style="font-size: 0.75rem;">PT Amarin Ship Management</small></span>
            </a>

            <div class="d-flex align-items-center">
                <form action="/" method="GET" class="d-flex me-4">
                    <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari prosedur atau aturan..." value="{{ request('search') }}">
                        <button class="btn text-white" style="background-color: var(--brand-color);" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

                <div class="dropdown me-3">
                    <button class="btn btn-sm glass-panel text-main fw-bold" style="color: var(--brand-color); border-color: var(--brand-color);" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="display-widget-btn">
                        <i class="fa-solid fa-sliders me-1"></i> Tampilan
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-3 glass-panel widget-dropdown border-0 shadow-lg">
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
                                <span><i class="fa-solid fa-glasses me-2"></i>Mode Baca (Filter)</span>
                                <span id="sliderValue" class="text-muted small">0%</span>
                            </label>
                            <input type="range" class="form-range" id="readSlider" min="0" max="0.4" step="0.05" value="0">
                            <div class="form-text" style="color: var(--text-muted); font-size: 0.75rem;">Geser untuk mengurangi cahaya biru.</div>
                        </div>
                    </div>
                </div>

                <a href="/admin" class="btn btn-sm fw-bold text-white shadow-sm" style="background-color: var(--brand-color); border-radius: 20px; padding: 6px 20px;">
                    <i class="fa-solid fa-shield-halved me-1"></i> Admin
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3 px-4 mb-4">
        <div class="row g-4">

            <div class="col-md-3">
                <div class="glass-panel sidebar-glass">
                    <h5 class="fw-bold sidebar-title">
                        <i class="fa-solid fa-list me-2"></i> Navigasi Bab
                    </h5>

                    @if(isset($parts) && $parts->isEmpty())
                        <div class="alert alert-info bg-transparent border-info text-info small">
                            Database dokumen masih kosong.
                        </div>
                    @else
                        <div class="document-nav">
                        @if(isset($parts))
                            @foreach($parts as $part)
                                <div class="mb-4">
                                    <div class="fw-bold text-uppercase mb-2" style="color: var(--text-muted); font-size: 0.8rem; letter-spacing: 1px; border-bottom: 1px solid var(--glass-border); padding-bottom: 5px;">
                                        {{ $part->title }}
                                    </div>
                                    <div class="d-flex flex-column ms-2">
                                        @foreach($part->chapters as $chapter)
                                            <a href="?read={{ $chapter->id }}" class="subchapter-link {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'active' : '' }}">
                                                <i class="fa-regular fa-file-lines me-2" style="opacity: 0.6;"></i> {{ $chapter->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-9">
                <div class="glass-panel content-glass">

                    @if(isset($searchResults))
                        <div class="px-md-4 py-2">
                            <h4 class="fw-bold mb-4" style="color: var(--brand-color); border-bottom: 2px solid var(--glass-border); padding-bottom: 15px;">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> Hasil Pencarian: "{{ request('search') }}"
                            </h4>

                            @if($searchResults->isEmpty())
                                <div class="alert alert-warning border-0 shadow-sm text-center py-4">
                                    <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 text-warning"></i><br>
                                    Tidak ada dokumen yang cocok dengan kata kunci tersebut.
                                </div>
                            @else
                                <div class="list-group">
                                    @foreach($searchResults as $result)
                                        <a href="?read={{ $result->id }}" class="list-group-item list-group-item-action mb-2 border-0 shadow-sm rounded glass-panel" style="background: var(--acc-btn-bg); color: var(--text-main);">
                                            <h6 class="fw-bold mb-1" style="color: var(--brand-color);">{{ $result->title }}</h6>
                                            <small class="text-muted">Terdapat kecocokan pada bab ini. Klik untuk membaca selengkapnya.</small>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    @elseif(isset($activeChapter))
                        <div class="px-md-4 py-2">
                            <h3 class="fw-bold mb-4" style="color: var(--brand-color); border-bottom: 2px solid var(--glass-border); padding-bottom: 15px;">
                                {{ $activeChapter->title }}
                            </h3>
                            <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-main); text-align: justify; overflow-wrap: break-word;">
                                {!! $activeChapter->content !!}
                            </div>
                        </div>

                    @else
                        <div class="d-flex h-100 flex-column align-items-center justify-content-center text-center">
                            <div class="mb-4">
                                <i class="fa-brands fa-space-awesome fa-4x" style="color: var(--brand-color); filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));"></i>
                            </div>
                            <h3 class="fw-bold mb-3" style="color: var(--text-main);">Pusat Integrasi Data</h3>
                            <p style="color: var(--text-muted); max-width: 500px;">
                                Gunakan kolom pencarian di atas atau pilih navigasi di sebelah kiri untuk memuat panduan operasional.
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeSwitch = document.getElementById('themeSwitch');
            const readSlider = document.getElementById('readSlider');
            const sliderValueText = document.getElementById('sliderValue');
            const htmlElement = document.documentElement;

            // Logika Mode Malam
            const savedTheme = localStorage.getItem('amarin-theme') || 'light';
            if (savedTheme === 'dark') {
                htmlElement.setAttribute('data-theme', 'dark');
                themeSwitch.checked = true;
            }
            themeSwitch.addEventListener('change', (e) => {
                if (e.target.checked) {
                    htmlElement.setAttribute('data-theme', 'dark');
                    localStorage.setItem('amarin-theme', 'dark');
                } else {
                    htmlElement.setAttribute('data-theme', 'light');
                    localStorage.setItem('amarin-theme', 'light');
                }
            });

            // Logika Mode Baca
            const savedSepia = localStorage.getItem('amarin-sepia') || '0';
            readSlider.value = savedSepia;
            applySepia(savedSepia);

            readSlider.addEventListener('input', (e) => {
                applySepia(e.target.value);
            });

            function applySepia(value) {
                htmlElement.style.setProperty('--sepia-level', value);
                localStorage.setItem('amarin-sepia', value);
                const percentage = Math.round((value / 0.4) * 100);
                sliderValueText.textContent = percentage + '%';
            }

            // Cegah dropdown tertutup saat geser slider
            document.querySelector('.widget-dropdown').addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>
