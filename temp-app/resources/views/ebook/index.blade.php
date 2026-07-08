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
                extend: {
                    colors: {
                        amarin: '#0ea5e9', // Cyan/Ocean Blue modern
                        amarinDark: '#0369a1',
                        marineDark: '#0f172a'
                    }
                }
            }
        }
    </script>
    <style>
        /* TEMA GLASSMORPHISM MARITIM */
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            background-attachment: fixed;
        }
        .dark body {
            background: linear-gradient(135deg, #0f172a 0%, #082f49 100%);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(3, 105, 161, 0.07);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(14, 165, 233, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
        }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(24px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
        }
        .dark .glass-sidebar {
            background: rgba(8, 47, 73, 0.4);
            border-right: 1px solid rgba(14, 165, 233, 0.1);
        }

        #sepia-overlay { position: fixed; inset: 0; background-color: rgba(255, 190, 90, var(--sepia-level, 0)); pointer-events: none; z-index: 9999; mix-blend-mode: multiply; }
        html { scroll-behavior: smooth; }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.3); border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.2); }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.6); }

        .virtual-hidden { display: none !important; }

        /* TIPOGRAFI READABLE */
        #reader-content {
            font-family: "Inter", "Segoe UI", Roboto, sans-serif;
            font-size: 1.15rem;
            line-height: 1.9;
            color: #334155;
        }
        .dark #reader-content { color: #cbd5e1; }

        #reader-content p { margin-bottom: 1.75rem; text-align: justify; }
        #reader-content strong, #reader-content b { font-weight: 700 !important; color: #0f172a; }
        .dark #reader-content strong, .dark #reader-content b { color: #f8fafc; }

        #reader-content h1, #reader-content h2, #reader-content h3, #reader-content h4 {
            font-weight: 800 !important; color: #0369a1; margin-top: 3rem; margin-bottom: 1.5rem; line-height: 1.3;
        }
        .dark #reader-content h1, .dark #reader-content h2, .dark #reader-content h3, .dark #reader-content h4 { color: #38bdf8; }

        #reader-content h1 { font-size: 2.25rem; border-bottom: 2px solid rgba(14, 165, 233, 0.2); padding-bottom: 0.5rem; }
        #reader-content h2 { font-size: 1.85rem; border-bottom: 1px solid rgba(14, 165, 233, 0.1); padding-bottom: 0.5rem; }

        #reader-content ul { list-style-type: disc !important; padding-left: 2rem !important; margin-bottom: 2rem; }
        #reader-content ol { list-style-type: decimal !important; padding-left: 2rem !important; margin-bottom: 2rem; }

        /* Tabel Dwibahasa Rapi */
        #reader-content table { width: 100% !important; table-layout: fixed; border-collapse: collapse !important; margin-top: 1.5rem; margin-bottom: 2.5rem; }
        #reader-content td { padding: 0.75rem 1rem 0.75rem 0 !important; vertical-align: top; border: none !important; }
        #reader-content th { background: rgba(14, 165, 233, 0.05); font-weight: 700 !important; text-align: left; padding: 1rem !important; border-bottom: 2px solid rgba(14, 165, 233, 0.2) !important; }
        .dark #reader-content th { background: rgba(15, 23, 42, 0.5); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .page-active { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="text-gray-800 dark:text-gray-200 transition-colors duration-300 antialiased overflow-x-hidden">

    <div id="sepia-overlay"></div>

    <nav class="fixed top-0 z-50 w-full glass-panel border-b border-transparent shadow-sm transition-all">
        <div class="px-4 py-3 lg:px-6 flex items-center justify-between">
            <div class="flex items-center justify-start shrink-0">
                <button id="sidebarToggleBtn" type="button" class="inline-flex items-center p-2 rounded-xl sm:hidden hover:bg-white/40 focus:ring-2 focus:ring-blue-200 dark:hover:bg-slate-800/50 transition-colors">
                    <i class="fa-solid fa-bars text-xl text-amarin"></i>
                </button>
                <a href="/" class="flex ms-2 items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-anchor text-white text-lg"></i>
                    </div>
                    <span class="text-xl md:text-2xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-cyan-600 dark:from-blue-400 dark:to-cyan-300">
                        Amarin E-Book System
                    </span>
                </a>
            </div>

            <div class="flex items-center space-x-3 ms-auto shrink-0">
                <form action="/" method="GET" class="hidden md:flex">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-64 p-2.5 pl-4 text-sm text-gray-900 border border-white/40 rounded-2xl bg-white/50 backdrop-blur-sm focus:ring-amarin focus:border-amarin dark:bg-slate-800/50 dark:border-slate-700 dark:text-white transition-all group-hover:shadow-md" placeholder="Cari regulasi...">
                        <button type="submit" class="absolute top-0 end-0 p-2.5 h-full text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-e-2xl hover:opacity-90 transition-opacity">
                            <i class="fa-solid fa-magnifying-glass px-2"></i>
                        </button>
                    </div>
                </form>

                <div class="relative">
                    <button id="dropdownDefaultButton" class="p-2.5 bg-white/50 dark:bg-slate-800/50 border border-white/40 dark:border-slate-700 hover:bg-white/80 dark:hover:bg-slate-700 rounded-2xl transition-all shadow-sm focus:ring-2 focus:ring-blue-200" type="button">
                        <i class="fa-solid fa-sliders text-amarin dark:text-blue-400"></i>
                    </button>

                    <div id="dropdownMenu" class="absolute right-0 top-full mt-3 z-50 hidden glass-panel rounded-2xl w-64 p-2">
                        <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-200">
                            <li class="flex justify-between items-center p-3 hover:bg-blue-50/50 dark:hover:bg-slate-800/50 rounded-xl transition-colors">
                                <span class="font-semibold"><i class="fa-solid fa-moon text-amarin me-2"></i> Night Mode</span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" id="theme-toggle" class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amarin shadow-inner"></div>
                                </label>
                            </li>
                            <li class="p-3 border-t border-gray-200/50 dark:border-slate-700/50">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="font-semibold"><i class="fa-solid fa-eye text-amarin me-2"></i> Eye Care</span>
                                    <span id="sliderValue" class="text-xs font-bold text-amarin">0%</span>
                                </div>
                                <input id="readSlider" type="range" min="0" max="0.4" step="0.05" value="0" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer dark:bg-slate-700">
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="/admin" class="p-2.5 bg-gradient-to-tr from-cyan-500 to-blue-600 text-white rounded-2xl hover:shadow-lg hover:shadow-blue-500/30 transition-all focus:ring-2 focus:ring-offset-1 focus:ring-blue-400">
                    <i class="fa-solid fa-shield-halved px-1"></i>
                </a>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-[24rem] h-screen pt-[5rem] transition-transform -translate-x-full sm:translate-x-0 glass-sidebar shadow-[4px_0_24px_rgba(0,0,0,0.02)] dark:shadow-[4px_0_24px_rgba(0,0,0,0.4)]">
        <div class="h-full px-5 pb-8 overflow-y-auto custom-scrollbar">

            @if($books->isEmpty())
                <div class="p-4 rounded-2xl glass-panel text-amarin text-center text-sm font-semibold">Pustaka masih kosong.</div>
            @else
                <div id="accordion-container" class="mt-2 space-y-3">
                    @foreach($books as $book)
                    <div class="bg-white/40 dark:bg-slate-800/40 rounded-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden transition-all hover:bg-white/60 dark:hover:bg-slate-800/60">
                        <button type="button" class="accordion-btn flex items-center justify-between w-full p-3.5 text-left" data-target="accordion-body-{{ $book->id }}">
                            <div class="flex items-center gap-4">
                                @if($book->cover_image)
                                    <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-12 h-16 object-cover rounded-xl shadow-sm shrink-0">
                                @else
                                    <div class="w-12 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-50 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center shrink-0 border border-white/50 dark:border-slate-600"><i class="fa-solid fa-book text-amarin text-lg"></i></div>
                                @endif
                                <div class="font-extrabold text-base text-gray-800 dark:text-gray-100 leading-tight">{{ $book->title }}</div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-700/50 flex items-center justify-center shrink-0 ms-2">
                                <svg class="w-4 h-4 text-amarin transition-transform duration-300 {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 10 6" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5 5 1 1 5"/></svg>
                            </div>
                        </button>

                        <div id="accordion-body-{{ $book->id }}" class="{{ (isset($activeBook) && $activeBook->id == $book->id) ? 'block' : 'hidden' }} px-3 pb-4">
                            @if($book->pdf_file)
                                <a href="?read_book={{ $book->id }}" class="flex items-center justify-center gap-2 p-2.5 mt-1 mx-1 text-xs text-red-500 rounded-xl bg-red-50/50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30 hover:bg-red-100/50 transition-colors font-bold">
                                    <i class="fa-solid fa-file-pdf"></i> Lihat Dokumen Original (PDF)
                                </a>
                            @endif

                            <div class="space-y-4 mt-4 px-1">
                                @foreach($book->parts as $part)
                                    <div>
                                        <h6 class="text-[0.7rem] font-extrabold text-amarin/70 dark:text-blue-400/70 uppercase tracking-widest mb-2 px-2 flex items-center gap-2">
                                            <i class="fa-solid fa-folder-open text-[0.6rem]"></i> {{ $part->title }}
                                        </h6>
                                        <ul class="space-y-1">
                                            @foreach($part->chapters as $chapter)
                                                <li>
                                                    <a href="?read={{ $chapter->id }}" class="flex items-center px-3 py-2 text-[0.9rem] rounded-xl transition-all {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'text-amarin font-bold bg-white/60 dark:bg-slate-700/50 shadow-sm border border-white/50 dark:border-slate-600' : 'text-gray-600 dark:text-gray-400 hover:bg-white/40 dark:hover:bg-slate-700/30 font-medium' }}">
                                                        <span class="truncate">{{ $chapter->title }}</span>
                                                    </a>

                                                    @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                        <div id="dynamic-toc" class="mt-2 mb-4 space-y-1 border-l-2 border-amarin/20 dark:border-blue-400/20 ml-5 relative"></div>
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

    <div class="p-0 sm:ml-[24rem] mt-[5rem] min-h-screen relative z-10">
        <div class="px-6 py-10 md:px-16 md:py-16 w-full max-w-none mx-auto">

            @if(isset($searchResults))
                <div class="glass-panel rounded-3xl p-8 md:p-12 border-t border-white/60">
                    <h4 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-5"><i class="fa-solid fa-magnifying-glass me-3 text-amarin"></i> Hasil Pencarian: "{{ request('search') }}"</h4>
                    @if($searchResults->isEmpty())
                        <div class="p-8 text-lg font-medium text-gray-500 bg-white/50 rounded-2xl dark:bg-slate-800/50 dark:text-gray-400 text-center">Tidak ada dokumen yang cocok.</div>
                    @else
                        <ul class="space-y-5">
                            @foreach($searchResults as $result)
                                <li>
                                    <a href="?read={{ $result->id }}" class="block p-6 bg-white/60 border border-white/50 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 dark:bg-slate-800/60 dark:border-slate-700 transition-all">
                                        <h5 class="mb-2 text-xl font-bold text-amarin">{{ $result->title }}</h5>
                                        <p class="text-base text-gray-600 dark:text-gray-300 font-medium">Klik untuk membuka modul prosedur ini.</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            @elseif(isset($activeChapter))

                <div class="glass-panel rounded-3xl p-8 md:p-14 border-t border-white/60 shadow-[0_10px_40px_-10px_rgba(14,165,233,0.1)]">
                    <button id="btn-show-all" class="hidden mb-10 text-sm font-bold text-white bg-gradient-to-r from-slate-800 to-slate-700 hover:from-slate-700 hover:to-slate-600 px-6 py-3 rounded-2xl transition-all shadow-lg shadow-slate-900/20 w-full sm:w-auto text-center">
                        <i class="fa-solid fa-book-open me-2 text-amarin"></i> Tampilkan Seluruh Modul (Reset Filter)
                    </button>

                    <div id="main-chapter-title" class="mb-12">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-50/50 dark:bg-slate-800/50 rounded-xl border border-blue-100/50 dark:border-slate-700/50 mb-6 text-sm font-bold text-amarin dark:text-blue-400">
                            <span>{{ $activeBook->title }}</span>
                            <i class="fa-solid fa-chevron-right text-[0.6rem] opacity-50"></i>
                            <span>{{ $activeChapter->part->title }}</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">{{ $activeChapter->title }}</h1>
                    </div>

                    <div id="reader-content">
                        {!! $activeChapter->content !!}
                    </div>
                </div>

            @elseif(isset($activeBook) && $activeBook->pdf_file)
                <div class="glass-panel rounded-3xl p-4 md:p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center text-lg text-slate-800 dark:text-gray-200 font-bold">
                        <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 text-red-500 rounded-xl flex items-center justify-center me-4 shadow-sm border border-red-100 dark:border-red-900/30">
                            <i class="fa-solid fa-file-pdf text-2xl"></i>
                        </div>
                        {{ $activeBook->title }}
                    </div>
                    <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="w-full md:w-auto text-white bg-gradient-to-r from-red-500 to-rose-600 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-lg shadow-red-500/30 hover:-translate-y-0.5 text-center">
                        Buka Layar Penuh <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                    </a>
                </div>
                <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" class="w-full h-[80vh] rounded-3xl border border-white/50 dark:border-slate-700 shadow-xl glass-panel"></iframe>

            @else
                <div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-4">
                    <div class="relative w-32 h-32 mb-8">
                        <div class="absolute inset-0 bg-cyan-400 blur-[40px] opacity-30 rounded-full dark:opacity-20"></div>
                        <div class="relative w-full h-full glass-panel rounded-3xl flex items-center justify-center border border-white/60 dark:border-slate-700 shadow-xl">
                            <i class="fa-solid fa-ship text-5xl bg-clip-text text-transparent bg-gradient-to-br from-blue-600 to-cyan-400"></i>
                        </div>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 dark:text-white mb-6 tracking-tight drop-shadow-sm">Amarin Fleet <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">IMS</span></h1>
                    <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed font-medium">Platform digitalisasi prosedur operasional dan keselamatan. Rentangkan menu di samping untuk mulai mengakses panduan armada.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

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
                        targetBody.classList.remove('hidden'); targetBody.classList.add('block'); icon.classList.add('rotate-180');
                    } else {
                        targetBody.classList.add('hidden'); targetBody.classList.remove('block'); icon.classList.remove('rotate-180');
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
                        if (firstHighlight) setTimeout(() => { firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 500);
                    }
                });
            }

            // ========================================================
            // ENGINE VIRTUAL PAGE
            // ========================================================
            const tocContainer = document.getElementById('dynamic-toc');
            if (contentBox && tocContainer) {
                const children = Array.from(contentBox.children);
                let tocHTML = '<div class="flex flex-col w-full py-2 relative">';
                let currentSectionId = 'virtual-intro';
                let validId = 0;
                let seenTexts = new Set();

                children.forEach((child) => {
                    const isDirectHeading = child.tagName.match(/^H[1-6]$/i);
                    const headingsInChild = isDirectHeading ? [child] : child.querySelectorAll('h1, h2, h3, h4, h5, h6, strong, b');
                    let foundNewSection = false;

                    if (headingsInChild.length > 0) {
                        headingsInChild.forEach((heading) => {
                            const originalText = heading.innerText;
                            if (originalText.match(/\.{3,}/)) return;

                            let text = originalText.replace(/\s+/g, ' ').trim();
                            if (text.length < 3 || text.length > 150) return;

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

                            if (level > 0 && !seenTexts.has(text)) {
                                if (!foundNewSection) {
                                    validId++;
                                    currentSectionId = 'v-page-' + validId;
                                    foundNewSection = true;
                                }
                                seenTexts.add(text);

                                let paddingClass = '';
                                let textClass = 'text-slate-600 dark:text-slate-400 hover:text-amarin dark:hover:text-blue-300';
                                let dotIndicator = '';

                                if (level === 1) {
                                    paddingClass = 'pl-2 mt-4'; textClass = 'text-slate-900 dark:text-white font-extrabold uppercase text-[0.75rem] tracking-widest';
                                } else if (level === 2) {
                                    paddingClass = 'pl-3 mt-2'; textClass = 'text-slate-800 dark:text-slate-300 font-bold text-[0.85rem]';
                                } else if (level === 3) {
                                    paddingClass = 'pl-5 mt-1'; textClass = 'text-slate-700 dark:text-slate-400 font-semibold text-[0.85rem]';
                                } else {
                                    paddingClass = 'pl-8 relative'; textClass = 'text-slate-500 dark:text-slate-500 font-medium text-[0.85rem]';
                                    dotIndicator = '<div class="absolute left-4 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600 group-hover:bg-amarin transition-colors"></div>';
                                }

                                tocHTML += `<a href="#${currentSectionId}" class="toc-link block py-2 transition-all w-full truncate rounded-xl hover:bg-white/50 dark:hover:bg-slate-800/50 group ${paddingClass} ${textClass}" title="${text}">
                                    ${dotIndicator} ${text}
                                </a>`;
                            }
                        });
                    }
                    child.setAttribute('data-virtual-page', currentSectionId);
                });

                tocHTML += '</div>';
                if (validId > 0) tocContainer.innerHTML = tocHTML;

                const btnShowAll = document.getElementById('btn-show-all');
                const mainChapterTitle = document.getElementById('main-chapter-title');

                document.querySelectorAll('.toc-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetPageId = this.getAttribute('href').substring(1);

                        children.forEach(c => {
                            c.classList.add('virtual-hidden');
                            c.classList.remove('page-active');
                        });

                        contentBox.querySelectorAll(`[data-virtual-page="${targetPageId}"]`).forEach(c => {
                            c.classList.remove('virtual-hidden');
                            c.classList.add('page-active');
                        });

                        btnShowAll.classList.remove('hidden');
                        if(mainChapterTitle) mainChapterTitle.classList.add('hidden');

                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'dark:text-blue-400', 'bg-white/60', 'shadow-sm'));
                        this.classList.add('text-amarin', 'dark:text-blue-400', 'bg-white/60', 'dark:bg-slate-700/50', 'shadow-sm');

                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                });

                if (btnShowAll) {
                    btnShowAll.addEventListener('click', () => {
                        children.forEach(c => {
                            c.classList.remove('virtual-hidden', 'page-active');
                        });
                        btnShowAll.classList.add('hidden');
                        if(mainChapterTitle) mainChapterTitle.classList.remove('hidden');
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'dark:text-blue-400', 'bg-white/60', 'shadow-sm'));
                    });
                }
            }
        });
    </script>
</body>
</html>
