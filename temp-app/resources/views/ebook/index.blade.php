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
        mark.search-highlight { background-color: #fde047; color: #000; padding: 0.1rem 0.2rem; border-radius: 0.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }

        /* Tembok Pelindung Teks Word agar tidak dihancurkan Tailwind */
        #reader-content { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1.05rem; line-height: 1.6; color: #374151; }
        .dark #reader-content { color: #d1d5db; }
        #reader-content p { margin-bottom: 1rem; text-align: justify; }
        #reader-content strong, #reader-content b { font-weight: 700 !important; color: #111827; }
        .dark #reader-content strong, .dark #reader-content b { color: #f9fafb; }
        #reader-content ul { list-style-type: disc !important; padding-left: 2rem !important; margin-bottom: 1rem; }
        #reader-content ol { list-style-type: decimal !important; padding-left: 2rem !important; margin-bottom: 1rem; }
        #reader-content table { width: 100% !important; border-collapse: collapse !important; margin-top: 1.5rem; margin-bottom: 1.5rem; }
        #reader-content th, #reader-content td { border: 1px solid #9ca3af !important; padding: 0.75rem !important; }
        #reader-content th { background-color: #e5e7eb; font-weight: bold !important; text-align: left; }
        .dark #reader-content th { background-color: #374151; border-color: #4b5563 !important; }
        .dark #reader-content td { border-color: #4b5563 !important; }
        #reader-content h1, #reader-content h2, #reader-content h3, #reader-content h4 { font-weight: bold !important; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1e3a8a; }
        .dark #reader-content h1, .dark #reader-content h2, .dark #reader-content h3, .dark #reader-content h4 { color: #60a5fa; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300 antialiased overflow-x-hidden">

    <div id="sepia-overlay"></div>

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
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
                    <button id="dropdownDefaultButton" class="text-amarin dark:text-blue-400 bg-blue-50 dark:bg-gray-700 hover:bg-blue-100 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-2 sm:px-4 sm:py-2 text-center inline-flex items-center" type="button">
                        <i class="fa-solid fa-sliders"></i> <span class="hidden sm:inline ms-2">Tampilan</span>
                    </button>

                    <div id="dropdownMenu" class="absolute right-0 top-full mt-2 z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-64 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="p-4 space-y-4 text-sm text-gray-700 dark:text-gray-200">
                            <li class="flex justify-between items-center">
                                <span class="font-bold"><i class="fa-solid fa-moon me-2"></i> Mode Malam</span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" id="theme-toggle" class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amarin"></div>
                                </label>
                            </li>
                            <li class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold"><i class="fa-solid fa-glasses me-2"></i> Proteksi Mata</span>
                                    <span id="sliderValue" class="text-xs text-gray-500">0%</span>
                                </div>
                                <input id="readSlider" type="range" min="0" max="0.4" step="0.05" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-600">
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="/admin" class="text-white bg-amarin hover:bg-amarinDark focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 sm:px-4 sm:py-2 dark:bg-blue-600 dark:hover:bg-blue-700">
                    <i class="fa-solid fa-shield-halved"></i> <span class="hidden sm:inline ms-1">Admin</span>
                </a>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-[22rem] h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="h-full px-4 pb-4 overflow-y-auto custom-scrollbar bg-white dark:bg-gray-800">
            <h5 class="text-lg font-bold text-amarin dark:text-blue-400 mb-4 pb-2 border-b dark:border-gray-700"><i class="fa-solid fa-book-journal-whills me-2"></i> Pustaka Dokumen</h5>

            @if($books->isEmpty())
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-700 dark:text-blue-400">Pustaka masih kosong.</div>
            @else
                <div id="accordion-container">
                    @foreach($books as $book)
                    <div class="mb-3">
                        <button type="button" class="accordion-btn flex items-center justify-between w-full p-3 font-medium text-left text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 dark:text-gray-300" data-target="accordion-body-{{ $book->id }}">
                            <div class="flex items-center gap-3 overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-10 h-14 object-cover rounded shadow-sm">
                                @else
                                    <div class="w-10 h-14 rounded bg-amarin flex items-center justify-center text-white shadow-sm"><i class="fa-solid fa-book"></i></div>
                                @endif
                                <div class="text-sm truncate">
                                    <div class="font-bold truncate text-wrap leading-tight">{{ $book->title }}</div>
                                    <div class="text-xs font-normal text-gray-500 dark:text-gray-400 mt-1">{{ $book->parts->count() }} Bagian</div>
                                </div>
                            </div>
                            <svg class="w-3 h-3 transition-transform duration-200 {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'rotate-180' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/></svg>
                        </button>

                        <div id="accordion-body-{{ $book->id }}" class="{{ (isset($activeBook) && $activeBook->id == $book->id) ? 'block' : 'hidden' }} pt-2">
                            @if($book->pdf_file)
                                <a href="?read_book={{ $book->id }}" class="flex items-center p-2 text-sm text-red-600 rounded-lg hover:bg-red-50 dark:hover:bg-gray-700 dark:text-red-400 border border-red-200 dark:border-gray-600 mb-3 bg-red-50 dark:bg-gray-800 transition-colors shadow-sm">
                                    <i class="fa-solid fa-file-pdf w-5 h-5 text-lg"></i>
                                    <span class="ms-2 font-bold">Buka PDF Mentahan</span>
                                </a>
                            @endif

                            <div class="ps-2 ms-2 border-s-2 border-gray-200 dark:border-gray-600 space-y-4">
                                @foreach($book->parts as $part)
                                    <div>
                                        <h6 class="text-xs font-bold text-gray-500 uppercase dark:text-gray-400 mb-2"><i class="fa-solid fa-layer-group me-1"></i> {{ $part->title }}</h6>
                                        <ul class="space-y-1 ms-2 border-s border-gray-200 dark:border-gray-700">
                                            @foreach($part->chapters as $chapter)
                                                <li>
                                                    <a href="?read={{ $chapter->id }}" class="flex items-center p-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group transition-colors {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'text-amarin font-bold bg-blue-50 dark:bg-gray-700 dark:text-blue-400 border-l-2 border-amarin' : 'text-gray-600 dark:text-gray-300' }}">
                                                        <i class="fa-regular fa-file-lines me-2"></i>
                                                        <span class="truncate">{{ $chapter->title }}</span>
                                                    </a>

                                                    @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                        <div id="dynamic-toc" class="ms-1 mt-2 mb-2 space-y-0.5 border-s-2 border-gray-200 dark:border-gray-700"></div>
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

    <div class="p-4 sm:ml-[22rem] mt-16 min-h-screen">
        <div class="p-4 md:p-8 border border-gray-200 rounded-xl dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm min-h-[85vh]">

            @if(isset($searchResults))
                <h4 class="text-2xl font-bold mb-6 text-amarin dark:text-blue-400 border-b pb-4 dark:border-gray-700"><i class="fa-solid fa-magnifying-glass me-2"></i> Hasil: "{{ request('search') }}"</h4>
                @if($searchResults->isEmpty())
                    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 text-center"><i class="fa-solid fa-triangle-exclamation fa-2x mb-2"></i><br>Tidak ada dokumen yang cocok.</div>
                @else
                    <ul class="space-y-3">
                        @foreach($searchResults as $result)
                            <li>
                                <a href="?read={{ $result->id }}&search={{ request('search') }}" class="block p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                    <h5 class="mb-1 text-lg font-bold tracking-tight text-amarin dark:text-blue-400">{{ $result->title }}</h5>
                                    <p class="text-sm text-gray-700 dark:text-gray-400">Kata <span class="font-bold bg-yellow-200 text-black px-1 rounded">"{{ request('search') }}"</span> ditemukan di bab ini.</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            @elseif(isset($activeChapter))
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-amarin dark:text-blue-400">{{ $activeChapter->title }}</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 border border-blue-400 hidden sm:inline">Dokumen Interaktif</span>
                </div>

                <div id="reader-content">
                    {!! $activeChapter->content !!}
                </div>

            @elseif(isset($activeBook) && $activeBook->pdf_file)
                <div class="flex flex-col lg:flex-row justify-between items-center mb-4 bg-gray-100 dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 gap-3">
                    <div class="flex items-center text-sm text-gray-700 dark:text-gray-300 text-center lg:text-left">
                        <i class="fa-solid fa-file-pdf text-red-600 text-xl me-2"></i>
                        <span>Dokumen Asli: <strong class="text-amarin dark:text-blue-400">{{ $activeBook->title }}</strong></span>
                    </div>
                    <div class="flex gap-2 w-full lg:w-auto justify-center">
                        <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="text-white bg-amarin hover:bg-amarinDark focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 whitespace-nowrap">
                            <i class="fa-solid fa-up-right-from-square me-1"></i> Buka Layar Penuh
                        </a>
                    </div>
                </div>
                <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" class="w-full h-[75vh] rounded-lg border border-gray-200 dark:border-gray-700"></iframe>

            @else
                <div class="flex flex-col md:flex-row items-center mb-10 pb-8 border-b border-gray-200 dark:border-gray-700 text-center md:text-left mt-4">
                    <i class="fa-brands fa-space-awesome text-6xl text-amarin dark:text-blue-400 mb-4 md:mb-0 md:me-6"></i>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-2">E-Book Terintegrasi</h1>
                        <p class="text-base md:text-lg text-gray-500 dark:text-gray-400">Platform digitalisasi dokumen operasional dan keselamatan kapal PT Amarin Ship Management.</p>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-amarin dark:text-blue-400 mb-4"><i class="fa-solid fa-book-bookmark me-2"></i> Pustaka Utama</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-10">
                    @forelse($books as $book)
                        <a href="?read_book={{ $book->id }}" class="flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition-transform hover:-translate-y-1">
                            @if($book->cover_image)
                                <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-20 h-28 object-cover rounded shadow mb-3">
                            @else
                                <div class="w-20 h-28 rounded bg-amarin flex items-center justify-center text-white shadow mb-3"><i class="fa-solid fa-book text-3xl"></i></div>
                            @endif
                            <h5 class="text-sm font-bold text-center text-gray-900 dark:text-white truncate w-full">{{ $book->title }}</h5>
                            <span class="text-xs text-red-600 dark:text-red-400 mt-1"><i class="fa-solid fa-file-pdf"></i> PDF Mentahan</span>
                        </a>
                    @empty
                        <div class="col-span-full p-4 text-center text-gray-500 bg-gray-50 rounded-lg dark:bg-gray-800 dark:text-gray-400">Belum ada buku diunggah.</div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Dropdown Tampilan
            const dropdownBtn = document.getElementById('dropdownDefaultButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });
                dropdownMenu.addEventListener('click', (e) => { e.stopPropagation(); });
                document.addEventListener('click', () => { dropdownMenu.classList.add('hidden'); });
            }

            // Accordion Buku
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

            // Mobile Sidebar Toggle
            const sidebarBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('logo-sidebar');
            if (sidebarBtn && sidebar) {
                sidebarBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                });
            }

            // Dark Mode & Sepia
            const themeToggleBtn = document.getElementById('theme-toggle');
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                themeToggleBtn.checked = true;
            } else { document.documentElement.classList.remove('dark'); }

            themeToggleBtn.addEventListener('change', function() {
                if (this.checked) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            });

            const readSlider = document.getElementById('readSlider');
            const sliderValueText = document.getElementById('sliderValue');
            const htmlElement = document.documentElement;
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

            // Auto Highlight
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            const contentBox = document.getElementById('reader-content');
            if (searchQuery && contentBox) {
                const markInstance = new Mark(contentBox);
                markInstance.mark(searchQuery, {
                    element: "mark",
                    className: "search-highlight",
                    separateWordSearch: false,
                    done: function() {
                        const firstHighlight = document.querySelector('mark.search-highlight');
                        if (firstHighlight) {
                            setTimeout(() => { firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 500);
                        }
                    }
                });
            }

            // ========================================================
            // MESIN EKSTRAKSI DAFTAR ISI (TOC) 6-LEVEL FINAL
            // ========================================================
            const tocContainer = document.getElementById('dynamic-toc');
            if (contentBox && tocContainer) {

                // MURNI HANYA mengambil teks yang di-Heading/Bold oleh user, bukan <p>
                const headings = contentBox.querySelectorAll('h1, h2, h3, h4, h5, h6, strong, b');
                let tocHTML = '<div class="flex flex-col w-full">';
                let validId = 0;
                let seenTexts = new Set(); // Mencegah judul terekam 2x jika ada Bold di dalam Heading

                headings.forEach((heading) => {
                    let text = heading.innerText.replace(/\s+/g, ' ').trim();

                    // PEMBERSIH AJAIB: Menghapus titik-titik dan nomor halaman bawaan Word
                    // Mengubah "1.1. Purpose ...................... 1" -> "1.1. Purpose"
                    text = text.replace(/\.{2,}\s*\d*$/, '').trim();

                    if (text.length < 3 || text.length > 150 || seenTexts.has(text)) return;

                    let level = 0;

                    // LEVEL 1: PART A (Huruf kapital setelah kata PART)
                    if (/^PART\s+[A-Z]\b/i.test(text)) { level = 1; }
                    // LEVEL 2: CHAPTER 1 (Angka setelah kata CHAPTER)
                    else if (/^CHAPTER\s+\d+/i.test(text)) { level = 2; }
                    // LEVEL 3: PART 1 / BAGIAN 1 (Angka)
                    else if (/^(?:PART|BAGIAN)\s+\d+/i.test(text)) { level = 3; }
                    // LEVEL 4, 5, 6: Sub-bab angka (1.1, 1.1.1, dll)
                    else if (/^\d+\.\d+/.test(text) || /^\d+\.\s/.test(text)) {
                        // Menghitung jumlah titik untuk menentukan kedalaman
                        const match = text.match(/^(\d+(?:\.\d+)*)/);
                        if (match) {
                            const dotsCount = match[1].split('.').length - 1;
                            // 1 titik (1.1) = Level 4. 2 titik (1.1.1) = Level 5.
                            level = 3 + dotsCount;
                        }
                    }

                    if (level > 0) {
                        validId++;
                        seenTexts.add(text);
                        const id = 'section-' + validId;
                        heading.id = id; // Tanamkan jangkar

                        let paddingClass = '';
                        let textClass = '';
                        let icon = '';

                        // STYLING SIDEBAR BERDASARKAN LEVEL HIERARKI
                        if (level === 1) {
                            paddingClass = 'pl-1 mt-4';
                            textClass = 'text-amarin dark:text-blue-400 font-extrabold uppercase border-b border-gray-200 dark:border-gray-700 pb-1 text-[0.85rem]';
                            icon = '<i class="fa-solid fa-book-open me-1 opacity-70"></i>';
                        } else if (level === 2) {
                            paddingClass = 'pl-3 border-l-2 border-amarin ml-2 mt-2';
                            textClass = 'text-gray-800 dark:text-gray-200 font-bold text-[0.8rem]';
                            icon = '<i class="fa-solid fa-folder me-1 text-amarin opacity-80"></i>';
                        } else if (level === 3) {
                            paddingClass = 'pl-5 border-l-2 border-gray-300 dark:border-gray-600 ml-2 mt-1';
                            textClass = 'text-gray-700 dark:text-gray-300 font-semibold text-[0.75rem]';
                            icon = '<i class="fa-solid fa-bookmark me-1 opacity-50"></i>';
                        } else if (level === 4) {
                            paddingClass = 'pl-7 border-l-2 border-gray-300 dark:border-gray-600 ml-2';
                            textClass = 'text-gray-600 dark:text-gray-400 text-[0.75rem]';
                            icon = '<i class="fa-solid fa-caret-right me-1 opacity-50"></i>';
                        } else {
                            // Level 5 ke atas
                            paddingClass = 'pl-9 border-l-2 border-gray-300 dark:border-gray-600 ml-2';
                            textClass = 'text-gray-500 dark:text-gray-400 text-[0.7rem]';
                            icon = '<i class="fa-solid fa-circle text-[4px] me-1 opacity-50 align-middle"></i>';
                        }

                        tocHTML += `<a href="#${id}" class="block py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors w-full truncate ${paddingClass} ${textClass}" title="${text}">
                            ${icon} ${text}
                        </a>`;
                    }
                });

                tocHTML += '</div>';

                if (validId > 0) {
                    tocContainer.innerHTML = tocHTML;
                } else {
                    tocContainer.innerHTML = '<span class="text-xs text-gray-400 italic px-2">Sub-bab tidak terdeteksi. Bold teks (contoh: 1.1) di Editor.</span>';
                }
            }
        });
    </script>
</body>
</html>
