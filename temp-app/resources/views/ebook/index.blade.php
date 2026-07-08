<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book System - PT Amarin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/mark.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: { colors: { amarin: '#0d47a1', amarinDark: '#0a367a' } }
            }
        }
    </script>
    <style>
        #sepia-overlay { position: fixed; inset: 0; background-color: rgba(255, 190, 90, var(--sepia-level, 0)); pointer-events: none; z-index: 9999; mix-blend-mode: multiply; }
        html { scroll-behavior: smooth; }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #4b5563; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #9ca3af; }

        /* CLASS MAGIC UNTUK VIRTUAL PAGE GITBOOK */
        .virtual-hidden { display: none !important; }

        /* ========================================================
           GITBOOK TYPOGRAPHY STYLE (Tampilan Mewah & Readable)
           ======================================================== */
        #reader-content {
            font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 1.05rem;
            line-height: 1.8;
            color: #374151;
        }
        .dark #reader-content { color: #d1d5db; }

        #reader-content p { margin-bottom: 1.25rem; text-align: left; }
        #reader-content strong, #reader-content b { font-weight: 600 !important; color: #111827; }
        .dark #reader-content strong, .dark #reader-content b { color: #f3f4f6; }

        #reader-content h1, #reader-content h2, #reader-content h3, #reader-content h4, #reader-content h5 {
            font-weight: 700 !important;
            color: #111827;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        .dark #reader-content h1, .dark #reader-content h2, .dark #reader-content h3, .dark #reader-content h4, .dark #reader-content h5 { color: #f9fafb; }

        #reader-content h1 { font-size: 2.25rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.5rem; }
        .dark #reader-content h1 { border-color: #374151; }
        #reader-content h2 { font-size: 1.75rem; border-bottom: 1px solid #f3f4f6; padding-bottom: 0.5rem; }
        .dark #reader-content h2 { border-color: #374151; }
        #reader-content h3 { font-size: 1.35rem; }
        #reader-content h4 { font-size: 1.15rem; }

        #reader-content ul { list-style-type: disc !important; padding-left: 1.5rem !important; margin-bottom: 1.25rem; }
        #reader-content ol { list-style-type: decimal !important; padding-left: 1.5rem !important; margin-bottom: 1.25rem; }

        /* Format Tabel Dwibahasa Word (Invisible Table Layout) */
        #reader-content table {
            width: 100% !important;
            table-layout: fixed;
            border-collapse: collapse !important;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            border: none !important;
        }
        #reader-content td { padding: 0.5rem 1rem 0.5rem 0 !important; vertical-align: top; border: none !important; }
        #reader-content th { background-color: #f9fafb; font-weight: 600 !important; text-align: left; padding: 0.75rem !important; border-bottom: 2px solid #e5e7eb !important; border-top: none; border-left: none; border-right: none;}
        .dark #reader-content th { background-color: #1f2937; border-color: #374151 !important; color: #d1d5db; }

        /* Animasi Transisi Halaman Virtual */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .page-active { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300 antialiased overflow-x-hidden">

    <div id="sepia-overlay"></div>

    <!-- NAVBAR -->
    <nav class="fixed top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-200 dark:bg-gray-900/80 dark:border-gray-800 shadow-sm">
        <div class="px-2 py-3 lg:px-5 lg:pl-3 flex items-center justify-between">
            <div class="flex items-center justify-start shrink-0">
                <button id="sidebarToggleBtn" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <a href="/" class="flex ms-1 sm:ms-2 md:me-24 items-center">
                    <i class="fa-solid fa-ship text-amarin dark:text-blue-400 text-xl sm:text-2xl me-2"></i>
                    <span class="self-center text-lg sm:text-xl md:text-2xl font-bold whitespace-nowrap text-amarin dark:text-blue-400 truncate">E-Book System</span>
                </a>
            </div>

            <div class="flex items-center space-x-2 sm:space-x-3 ms-auto shrink-0">
                <form action="/" method="GET" class="hidden md:flex">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amarin focus:border-amarin dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari materi...">
                        <button type="submit" class="absolute top-0 end-0 p-2 text-sm font-medium h-full text-white bg-amarin rounded-e-lg hover:bg-amarinDark">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>

                <div class="relative">
                    <button id="dropdownDefaultButton" class="text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-2.5 py-2 sm:px-4 sm:py-2 text-center inline-flex items-center transition-colors" type="button">
                        <i class="fa-solid fa-sliders"></i> <span class="hidden sm:inline ms-2">Tampilan</span>
                    </button>

                    <div id="dropdownMenu" class="absolute right-0 top-full mt-2 z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg border border-gray-100 w-64 dark:bg-gray-800 dark:border-gray-700 dark:divide-gray-700">
                        <ul class="p-4 space-y-4 text-sm text-gray-700 dark:text-gray-200">
                            <li class="flex justify-between items-center">
                                <span class="font-medium"><i class="fa-solid fa-moon me-2 text-gray-400"></i> Mode Malam</span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" id="theme-toggle" class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amarin"></div>
                                </label>
                            </li>
                            <li class="pt-3 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium"><i class="fa-solid fa-glasses me-2 text-gray-400"></i> Proteksi Mata</span>
                                    <span id="sliderValue" class="text-xs text-gray-500 font-mono">0%</span>
                                </div>
                                <input id="readSlider" type="range" min="0" max="0.4" step="0.05" value="0" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="/admin" class="text-gray-600 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 sm:px-4 sm:py-2 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-shield-halved"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-[22rem] h-screen pt-[4.5rem] transition-transform -translate-x-full bg-gray-50 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-900/50 dark:border-gray-800">
        <div class="h-full px-4 pb-4 overflow-y-auto custom-scrollbar">

            @if($books->isEmpty())
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">Pustaka masih kosong.</div>
            @else
                <div id="accordion-container" class="mt-2">
                    @foreach($books as $book)
                    <div class="mb-2">
                        <button type="button" class="accordion-btn flex items-center justify-between w-full p-2.5 font-medium text-left text-gray-700 rounded-lg hover:bg-gray-200/50 dark:hover:bg-gray-800 dark:text-gray-300 transition-colors" data-target="accordion-body-{{ $book->id }}">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-8 h-8 rounded bg-amarin flex items-center justify-center text-white shadow-sm shrink-0"><i class="fa-solid fa-book text-xs"></i></div>
                                <div class="text-sm truncate">
                                    <div class="font-bold truncate text-gray-900 dark:text-gray-100">{{ $book->title }}</div>
                                </div>
                            </div>
                            <svg class="w-3 h-3 text-gray-400 transition-transform duration-200 {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'rotate-180' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/></svg>
                        </button>

                        <div id="accordion-body-{{ $book->id }}" class="{{ (isset($activeBook) && $activeBook->id == $book->id) ? 'block' : 'hidden' }} pt-1">
                            @if($book->pdf_file)
                                <a href="?read_book={{ $book->id }}" class="flex items-center p-2 mt-2 mx-2 text-xs text-red-600 rounded-lg border border-red-200 mb-3 bg-red-50 dark:bg-red-900/10 dark:border-red-900/30 dark:text-red-400 hover:bg-red-100 transition-colors">
                                    <i class="fa-solid fa-file-pdf w-4 h-4"></i>
                                    <span class="ms-2 font-semibold">Lihat PDF Original</span>
                                </a>
                            @endif

                            <div class="space-y-3 mt-3">
                                @foreach($book->parts as $part)
                                    <div>
                                        <h6 class="text-[0.7rem] font-bold text-gray-400 uppercase tracking-wider mb-1 px-3">{{ $part->title }}</h6>
                                        <ul class="space-y-0.5">
                                            @foreach($part->chapters as $chapter)
                                                <li>
                                                    <!-- Link Chapter Utama (Akan menampilkan keseluruhan / reset mode) -->
                                                    <a href="?read={{ $chapter->id }}" class="flex items-center px-3 py-1.5 text-sm rounded-md transition-colors {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'text-amarin font-semibold bg-blue-50/50 dark:bg-gray-800 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                                        <span class="truncate">{{ $chapter->title }}</span>
                                                    </a>

                                                    <!-- TEMPAT DYNAMIC TOC -->
                                                    @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                        <div id="dynamic-toc" class="mt-1 mb-3 space-y-0.5 border-l border-gray-200 dark:border-gray-800 ml-4"></div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </aside>

    <!-- KONTEN UTAMA -->
    <div class="p-0 sm:ml-[22rem] mt-[4.5rem] min-h-screen">
        <div class="px-6 py-8 md:px-16 md:py-12 max-w-5xl mx-auto">

            @if(isset($searchResults))
                <h4 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-800 pb-4"><i class="fa-solid fa-magnifying-glass me-2 text-gray-400"></i> Hasil Pencarian: "{{ request('search') }}"</h4>
                @if($searchResults->isEmpty())
                    <div class="p-6 text-sm text-gray-500 bg-gray-50 rounded-xl dark:bg-gray-800/50 dark:text-gray-400 text-center border border-gray-100 dark:border-gray-800">Tidak ada dokumen yang cocok.</div>
                @else
                    <ul class="space-y-4">
                        @foreach($searchResults as $result)
                            <li>
                                <a href="?read={{ $result->id }}&search={{ request('search') }}" class="block p-5 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md dark:bg-gray-800/50 dark:border-gray-700 transition-all">
                                    <h5 class="mb-2 text-lg font-bold text-amarin dark:text-blue-400">{{ $result->title }}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Ditemukan di dalam modul ini.</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            @elseif(isset($activeChapter))
                <!-- BREADCRUMB ALA GITBOOK -->
                <nav class="flex mb-4 text-sm text-gray-500 dark:text-gray-400">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center"><span class="hover:text-gray-900 dark:hover:text-white">{{ $activeBook->title }}</span></li>
                        <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[0.6rem] mx-2"></i><span class="hover:text-gray-900 dark:hover:text-white">{{ $activeChapter->part->title }}</span></div></li>
                    </ol>
                </nav>

                <!-- TOMBOL KEMBALI KE TAMPILAN PENUH (Disembunyikan default, muncul saat mode Virtual Page aktif) -->
                <button id="btn-show-all" class="hidden mb-6 text-xs font-semibold text-amarin bg-blue-50 hover:bg-blue-100 dark:text-blue-400 dark:bg-gray-800 dark:hover:bg-gray-700 px-3 py-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-left me-1"></i> Tampilkan Seluruh Dokumen
                </button>

                <!-- JUDUL UTAMA (Ditangani oleh JS kalau mode Virtual Page aktif) -->
                <div id="main-chapter-title" class="mb-10">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $activeChapter->title }}</h1>
                </div>

                <!-- ISI KONTEN -->
                <div id="reader-content">
                    {!! $activeChapter->content !!}
                </div>

            @elseif(isset($activeBook) && $activeBook->pdf_file)
                <div class="flex justify-between items-center mb-4 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="fa-solid fa-file-pdf text-red-500 text-xl me-3"></i>
                        <span class="font-medium">{{ $activeBook->title }}</span>
                    </div>
                    <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-xs px-4 py-2 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                        Buka Layar Penuh <i class="fa-solid fa-up-right-from-square ms-1"></i>
                    </a>
                </div>
                <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" class="w-full h-[80vh] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm"></iframe>

            @else
                <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4">
                    <div class="w-20 h-20 bg-blue-50 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-book-open text-3xl text-amarin dark:text-blue-400"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-3 tracking-tight">Dokumentasi Operasional</h1>
                    <p class="text-base text-gray-500 dark:text-gray-400 max-w-lg leading-relaxed">Pilih panduan atau prosedur melalui struktur navigasi di sebelah kiri untuk mulai membaca.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- SCRIPT UTAMA -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Pengaturan Navbar & Tampilan (Standard)
            const dropdownBtn = document.getElementById('dropdownDefaultButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownMenu.classList.toggle('hidden'); });
                document.addEventListener('click', () => { dropdownMenu.classList.add('hidden'); });
            }

            const accordionBtns = document.querySelectorAll('.accordion-btn');
            accordionBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    const targetBody = document.getElementById(targetId);
                    const icon = btn.querySelector('svg');
                    if (targetBody.classList.contains('hidden')) {
                        targetBody.classList.remove('hidden');
                        targetBody.classList.add('block');
                        icon.classList.add('rotate-180');
                    } else {
                        targetBody.classList.add('hidden');
                        targetBody.classList.remove('block');
                        icon.classList.remove('rotate-180');
                    }
                });
            });

            const sidebarBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('logo-sidebar');
            if (sidebarBtn && sidebar) {
                sidebarBtn.addEventListener('click', (e) => { e.stopPropagation(); sidebar.classList.toggle('-translate-x-full'); });
            }

            const themeToggleBtn = document.getElementById('theme-toggle');
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark'); themeToggleBtn.checked = true;
            } else { document.documentElement.classList.remove('dark'); }

            themeToggleBtn.addEventListener('change', function() {
                if (this.checked) { document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark'); }
                else { document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light'); }
            });

            const readSlider = document.getElementById('readSlider');
            const sliderValueText = document.getElementById('sliderValue');
            const htmlElement = document.documentElement;
            const savedSepia = localStorage.getItem('amarin-sepia') || '0';
            readSlider.value = savedSepia;
            htmlElement.style.setProperty('--sepia-level', savedSepia);
            sliderValueText.textContent = Math.round((savedSepia / 0.4) * 100) + '%';
            readSlider.addEventListener('input', (e) => {
                const val = e.target.value; htmlElement.style.setProperty('--sepia-level', val);
                localStorage.setItem('amarin-sepia', val); sliderValueText.textContent = Math.round((val / 0.4) * 100) + '%';
            });

            // ========================================================
            // ENGINE VIRTUAL PAGE: Memecah Konten Tunggal menjadi Halaman-halaman
            // ========================================================
            const contentBox = document.getElementById('reader-content');
            const tocContainer = document.getElementById('dynamic-toc');

            if (contentBox && tocContainer) {
                const headings = contentBox.querySelectorAll('h1, h2, h3, h4, h5, h6, strong, b');
                let tocHTML = '<div class="flex flex-col w-full py-1">';
                let validId = 0;
                let seenTexts = new Set();

                // 1. Ekstraksi Daftar Isi
                headings.forEach((heading) => {
                    const originalText = heading.innerText;
                    if (originalText.match(/\.{3,}/)) return; // Abaikan TOC bawaan Word

                    let text = originalText.replace(/\s+/g, ' ').trim();
                    if (text.length < 3 || text.length > 150 || seenTexts.has(text)) return;

                    let level = 0;
                    if (/^PART\s+[A-Z]\b/i.test(text)) { level = 1; }
                    else if (/^CHAPTER\s+\d+/i.test(text)) { level = 2; }
                    else if (/^(?:PART|BAGIAN)\s+\d+/i.test(text)) { level = 3; }
                    else if (/^\d+\.\d+/.test(text) || /^\d+\.\s/.test(text)) {
                        const match = text.match(/^(\d+(?:\.\d+)*)/);
                        if (match) {
                            const dotsCount = match[1].split('.').length - 1;
                            level = 3 + dotsCount;
                        }
                    }

                    if (level > 0) {
                        validId++;
                        seenTexts.add(text);
                        const id = 'section-' + validId;
                        heading.id = id;

                        let paddingClass = '';
                        let textClass = 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200';

                        if (level === 1) {
                            paddingClass = 'pl-2 mt-3'; textClass = 'text-gray-900 dark:text-gray-200 font-bold uppercase text-[0.75rem] tracking-wider';
                        } else if (level === 2) {
                            paddingClass = 'pl-2 mt-1'; textClass = 'text-gray-800 dark:text-gray-300 font-semibold text-[0.8rem]';
                        } else if (level === 3) {
                            paddingClass = 'pl-4'; textClass = 'text-gray-700 dark:text-gray-400 font-medium text-[0.8rem]';
                        } else {
                            paddingClass = 'pl-6'; textClass = 'text-gray-500 dark:text-gray-500 text-[0.8rem]';
                        }

                        // LINK INI KITA GANTI CLASS-NYA JADI toc-link UNTUK DI-INTERCEPT
                        tocHTML += `<a href="#${id}" class="toc-link block py-1.5 transition-colors w-full truncate ${paddingClass} ${textClass}" title="${text}">
                            ${text}
                        </a>`;
                    }
                });

                tocHTML += '</div>';
                if (validId > 0) { tocContainer.innerHTML = tocHTML; }

                // 2. TAGGING SEMUA ELEMEN: Memasukkan elemen paragraf & baris tabel ke dalam "Virtual Group"
                // Mengambil anak langsung (seperti p, div, atau baris tabel di dalam tabel raksasa)
                const elementsToGroup = contentBox.querySelectorAll(':scope > p, :scope > ul, :scope > ol, :scope > h1, :scope > h2, :scope > h3, :scope > h4, :scope > h5, :scope > table > tbody > tr, :scope > table > tr, :scope > div');
                let currentPageGroup = 'page-intro'; // Teks sebelum ada judul

                elementsToGroup.forEach(el => {
                    // Cari tau apakah elemen ini sendiri adalah judul, atau di dalam elemen ini ada judul
                    const headingInside = el.querySelector('[id^="section-"]');
                    const isHeading = el.id && el.id.startsWith('section-');
                    const actualHeading = isHeading ? el : headingInside;

                    // Kalau nemu judul baru, ubah ID grupnya
                    if (actualHeading) {
                        currentPageGroup = actualHeading.id;
                    }

                    // Tempel ID grup ke elemen tersebut
                    el.setAttribute('data-virtual-page', currentPageGroup);
                });

                // 3. MAGIC ISOLATOR: Waktu Link Sidebar Diklik
                const btnShowAll = document.getElementById('btn-show-all');
                const mainChapterTitle = document.getElementById('main-chapter-title');

                document.querySelectorAll('.toc-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetPageId = this.getAttribute('href').substring(1);

                        // Sembunyikan SEMUA elemen
                        elementsToGroup.forEach(el => el.classList.add('virtual-hidden'));

                        // Tampilkan HANYA elemen yang punya grup data-virtual-page yang sama dengan target
                        contentBox.querySelectorAll(`[data-virtual-page="${targetPageId}"]`).forEach(el => {
                            el.classList.remove('virtual-hidden');
                            el.classList.add('page-active'); // Kasih animasi muncul
                        });

                        // Munculkan tombol "Kembali", sembunyikan judul besar bawaan
                        btnShowAll.classList.remove('hidden');
                        if(mainChapterTitle) mainChapterTitle.classList.add('hidden');

                        // Beri styling tebal pada link sidebar yang aktif
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'dark:text-blue-400', 'font-bold'));
                        this.classList.add('text-amarin', 'dark:text-blue-400', 'font-bold');

                        // Scroll ke atas layar dengan mulus
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                });

                // 4. Tombol "Tampilkan Seluruh Dokumen"
                if (btnShowAll) {
                    btnShowAll.addEventListener('click', () => {
                        // Tampilkan ulang semua
                        elementsToGroup.forEach(el => {
                            el.classList.remove('virtual-hidden', 'page-active');
                        });
                        // Reset tombol dan judul
                        btnShowAll.classList.add('hidden');
                        if(mainChapterTitle) mainChapterTitle.classList.remove('hidden');

                        // Reset link aktif
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'dark:text-blue-400', 'font-bold'));
                    });
                }
            }
        });
    </script>
</body>
</html>
