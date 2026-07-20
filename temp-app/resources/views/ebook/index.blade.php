<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amarin E-Book System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/mark.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.21/mammoth.browser.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { amarin: '#0ea5e9', amarinDark: '#0369a1', marineDark: '#0f172a' } } }
        }
    </script>
    <style>
        body { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); background-attachment: fixed; }
        .dark body { background: linear-gradient(135deg, #0f172a 0%, #082f49 100%); }
        .glass-panel { background: rgba(255, 255, 255, 0.65); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 8px 32px 0 rgba(3, 105, 161, 0.07); }
        .dark .glass-panel { background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(14, 165, 233, 0.2); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5); }
        .glass-sidebar { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(24px); border-right: 1px solid rgba(255, 255, 255, 0.5); }
        .dark .glass-sidebar { background: rgba(8, 47, 73, 0.5); border-right: 1px solid rgba(14, 165, 233, 0.15); }
        #sepia-overlay { position: fixed; inset: 0; background-color: rgba(255, 190, 90, var(--sepia-level, 0)); pointer-events: none; z-index: 9999; mix-blend-mode: multiply; }
        html { scroll-behavior: smooth; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.3); border-radius: 10px; }
        .virtual-hidden { display: none !important; }

        :root { --read-font-size: 1.15rem; --read-line-height: 1.9; }

        #reader-content { font-family: "Inter", "Segoe UI", Roboto, sans-serif; font-size: var(--read-font-size); line-height: var(--read-line-height); color: #334155; transition: all 0.3s ease; }
        .dark #reader-content { color: #cbd5e1; }
        #reader-content p { margin-bottom: 1.75rem; text-align: justify; }
        #reader-content strong, #reader-content b { font-weight: 700 !important; color: #0f172a; }
        .dark #reader-content strong, .dark #reader-content b { color: #f8fafc; }
        #reader-content h1, #reader-content h2, #reader-content h3, #reader-content h4 { font-weight: 800 !important; color: #0369a1; margin-top: 3rem; margin-bottom: 1.5rem; line-height: 1.3; }
        .dark #reader-content h1, .dark #reader-content h2, .dark #reader-content h3, .dark #reader-content h4 { color: #38bdf8; }
        #reader-content h1 { font-size: calc(var(--read-font-size) * 1.8); border-bottom: 2px solid rgba(14, 165, 233, 0.2); padding-bottom: 0.5rem; }
        #reader-content h2 { font-size: calc(var(--read-font-size) * 1.5); border-bottom: 1px solid rgba(14, 165, 233, 0.1); padding-bottom: 0.5rem; }
        #reader-content ul { list-style-type: disc !important; padding-left: 2rem !important; margin-bottom: 2rem; }
        #reader-content table { width: 100% !important; table-layout: fixed; border-collapse: collapse !important; margin-top: 1.5rem; margin-bottom: 2.5rem; }
        #reader-content td { padding: 0.75rem 1rem 0.75rem 0 !important; vertical-align: top; border: none !important; }
        #reader-content th { background: rgba(14, 165, 233, 0.05); font-weight: 700 !important; text-align: left; padding: 1rem !important; border-bottom: 2px solid rgba(14, 165, 233, 0.2) !important; }

        #word-content { font-family: 'Times New Roman', Times, serif, sans-serif; color: #1e293b; }
        #word-content table { width: 100% !important; border-collapse: collapse !important; margin-bottom: 2rem; }
        #word-content table, #word-content th, #word-content td { border: 1px solid #cbd5e1 !important; }
        #word-content th, #word-content td { padding: 0.75rem 1rem !important; vertical-align: middle; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .page-active { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .ai-panel-active { animation: slideInRight 0.3s ease forwards; display: flex !important; }

        .stat-card { @apply flex flex-col justify-center p-4 sm:p-5 glass-panel rounded-2xl border border-white/60 dark:border-slate-700 shadow-sm hover:-translate-y-1 transition-transform; }
        .stat-icon-wrapper { @apply w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center text-lg sm:text-xl shrink-0 shadow-inner; }
    </style>
</head>
<body class="text-gray-800 dark:text-slate-100 transition-colors duration-300 antialiased overflow-x-hidden">

    <div id="sepia-overlay"></div>

    <!-- NAVBAR UTAMA -->
    <nav class="fixed top-0 z-50 w-full glass-panel border-b border-transparent shadow-sm transition-all">
        <div class="px-4 py-3 lg:px-6 flex items-center justify-between">
            <div class="flex items-center justify-start shrink-0">
                <button id="sidebarToggleBtn" type="button" class="inline-flex items-center p-2 rounded-xl lg:hidden hover:bg-white/40 dark:hover:bg-slate-800 focus:ring-2 focus:ring-blue-200 transition-colors"><i class="fa-solid fa-bars text-xl text-amarin"></i></button>
                <a href="/" class="flex ms-2 items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg"><i class="fa-solid fa-anchor text-white text-lg"></i></div>
                    <span class="hidden sm:block text-xl md:text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-cyan-400 dark:from-cyan-400 dark:to-blue-400">Amarin E-Book System</span>
                </a>
            </div>

            <div class="flex items-center space-x-3 ms-auto shrink-0">
                <div class="hidden 2xl:flex items-center gap-2 px-3.5 py-2 bg-cyan-50/50 dark:bg-cyan-950/40 border border-cyan-200/50 dark:border-cyan-800/50 rounded-2xl shadow-inner text-xs font-bold text-cyan-700 dark:text-cyan-300">
                    <i class="fa-solid fa-compass text-cyan-500 fa-spin-pulse"></i><span>Navigasi: Aman (Open Sea)</span>
                </div>

                <div class="hidden xl:flex items-center gap-2 px-3 py-2 bg-green-50/50 dark:bg-green-950/40 border border-green-200/50 dark:border-green-800/50 rounded-2xl shadow-inner text-sm font-bold text-green-600 dark:text-green-400"><div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div> Online</div>
                <div class="hidden lg:flex items-center gap-3 px-4 py-2 bg-blue-50/50 dark:bg-slate-800/60 border border-blue-200/50 dark:border-slate-700 rounded-2xl shadow-inner text-sm font-bold text-amarin">
                    <i class="fa-regular fa-calendar text-blue-400"></i><span id="realtime-date">--/--/----</span>
                    <div class="w-px h-4 bg-blue-200 dark:bg-slate-700 mx-1"></div>
                    <i class="fa-regular fa-clock fa-spin-pulse text-blue-400"></i><span id="realtime-clock">00:00</span>
                </div>
                <form action="/" method="GET" class="hidden md:flex">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-48 lg:w-64 p-2.5 pl-4 text-sm text-gray-900 dark:text-white border border-white/40 dark:border-slate-700 rounded-2xl bg-white/50 dark:bg-slate-900/60 backdrop-blur-sm focus:ring-amarin focus:border-amarin transition-all placeholder-slate-400" placeholder="Deep Search regulasi...">
                        <button type="submit" class="absolute top-0 end-0 p-2.5 h-full text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-e-2xl hover:opacity-90"><i class="fa-solid fa-magnifying-glass px-2"></i></button>
                    </div>
                </form>

                <!-- MEGA MENU SETTINGS -->
                <div class="relative">
                    <button id="dropdownDefaultButton" class="p-2.5 bg-white/50 dark:bg-slate-800/60 border border-white/40 dark:border-slate-700 hover:bg-white/80 dark:hover:bg-slate-800 rounded-2xl transition-all shadow-sm focus:ring-2 focus:ring-blue-200" type="button"><i class="fa-solid fa-sliders text-amarin"></i></button>

                    <div id="dropdownMenu" class="absolute right-0 top-full mt-3 z-50 hidden glass-panel rounded-[2rem] w-80 sm:w-96 p-6 shadow-2xl border border-white/80 dark:border-slate-700 origin-top-right transition-all">
                        <div class="flex items-center gap-3 mb-5 border-b border-slate-200/50 dark:border-slate-700 pb-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-slate-800 dark:to-cyan-950 text-amarin flex items-center justify-center shrink-0 shadow-inner"><i class="fa-solid fa-palette text-lg"></i></div>
                            <div>
                                <h6 class="font-extrabold text-slate-800 dark:text-slate-100 tracking-tight text-base">Tampilan Global</h6>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium uppercase tracking-widest mt-0.5">App Appearance</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-3 block"><i class="fa-solid fa-circle-half-stroke me-1"></i> Tema Dasar</span>
                                <div class="grid grid-cols-3 gap-3">
                                    <button class="theme-btn flex flex-col items-center justify-center gap-2 p-3 rounded-xl border-2 transition-all shadow-sm" data-theme="light">
                                        <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center shadow-inner"><i class="fa-solid fa-sun"></i></div>
                                        <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Terang</span>
                                    </button>
                                    <button class="theme-btn flex flex-col items-center justify-center gap-2 p-3 rounded-xl border-2 transition-all shadow-sm" data-theme="dark">
                                        <div class="w-8 h-8 rounded-full bg-slate-800 text-blue-400 border border-slate-600 flex items-center justify-center shadow-inner"><i class="fa-solid fa-moon"></i></div>
                                        <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Gelap</span>
                                    </button>
                                    <button class="theme-btn flex flex-col items-center justify-center gap-2 p-3 rounded-xl border-2 transition-all shadow-sm" data-theme="auto">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 flex items-center justify-center shadow-inner"><i class="fa-solid fa-desktop"></i></div>
                                        <span class="text-[10px] font-bold text-slate-600 dark:text-slate-300">Sistem</span>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-amber-50/80 to-orange-50/50 dark:from-slate-800 dark:to-slate-900 p-4 rounded-2xl border border-amber-100/50 dark:border-slate-700 shadow-sm">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xs font-bold text-amber-700 dark:text-amber-400 flex items-center gap-2"><i class="fa-solid fa-eye text-amber-500"></i> Proteksi Mata (Sepia)</span>
                                    <span id="sliderValue" class="text-[10px] font-bold text-amber-600 dark:text-amber-300 bg-amber-100 dark:bg-slate-800 px-2 py-1 rounded-md shadow-inner">0%</span>
                                </div>
                                <input id="readSlider" type="range" min="0" max="0.4" step="0.05" value="0" class="w-full h-1.5 bg-amber-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-amber-500">
                                <p class="text-[9px] text-amber-600/70 dark:text-slate-400 mt-3 font-medium leading-snug">Aktifkan filter cahaya biru untuk kenyamanan membaca dalam durasi lama di ruangan redup.</p>
                            </div>
                        </div>
                    </div>
                </div>

               @role('super-admin')
                    <a href="/admin" class="p-2.5 bg-gradient-to-tr from-cyan-500 to-blue-600 text-white rounded-2xl hover:shadow-lg transition-all" title="Panel Administrator">
                        <i class="fa-solid fa-shield-halved px-1"></i>
                    </a>
                @endrole
            </div>
        </div>
    </nav>

    <!-- SIDEBAR KIRI -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-[20rem] md:w-[24rem] h-screen pt-[5rem] transition-transform -translate-x-full lg:translate-x-0 glass-sidebar shadow-[4px_0_24px_rgba(0,0,0,0.02)] flex flex-col">
        <div class="px-4 md:px-5 mt-4 mb-2 shrink-0">
            <div class="relative">
                <input type="text" id="sidebarFilter" class="w-full bg-white/60 dark:bg-slate-900/60 border border-white/50 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-slate-100 focus:ring-amarin focus:border-amarin shadow-inner font-medium placeholder-slate-400" placeholder="Filter cepat judul bab atau formulir...">
                <i class="fa-solid fa-filter absolute right-4 top-3.5 text-slate-400 text-sm"></i>
            </div>
        </div>

        <div class="px-4 md:px-5 pb-8 overflow-y-auto custom-scrollbar flex-grow">
            <h5 class="text-[0.7rem] font-extrabold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3 mt-4 px-1"><i class="fa-solid fa-book-open me-2"></i>Pustaka Manual</h5>

            <!-- LIST BUKU SIDEBAR -->
            <div class="space-y-3">
                @foreach($books as $book)
                <div class="book-group bg-white/40 dark:bg-slate-900/50 rounded-2xl border border-white/50 dark:border-slate-800 overflow-hidden transition-all hover:bg-white/60 dark:hover:bg-slate-900/80">
                    <button type="button" class="accordion-btn flex items-center justify-between w-full p-3.5 text-left" data-target="sidebar-book-{{ $book->id }}">
                        <div class="flex items-center gap-4">
                            @if($book->cover_image)
                                <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-12 h-16 object-cover rounded-xl shadow-sm shrink-0">
                            @else
                                <div class="w-12 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-50 dark:from-slate-800 dark:to-cyan-950 flex items-center justify-center shrink-0 border border-white/50 dark:border-slate-700"><i class="fa-solid fa-book text-amarin text-lg"></i></div>
                            @endif
                            <div class="font-extrabold text-base text-gray-800 dark:text-slate-100 leading-tight book-title">{{ $book->title }}</div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/50 dark:bg-slate-800 flex items-center justify-center shrink-0 ms-2"><i class="fa-solid fa-chevron-down text-amarin text-xs transition-transform duration-300 {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'rotate-180' : '' }}"></i></div>
                    </button>

                    <div id="sidebar-book-{{ $book->id }}" class="book-body {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'block' : 'hidden' }} px-3 pb-4">
                        @if($book->pdf_file)
                            <a href="?read_book={{ $book->id }}" class="sidebar-searchable flex items-center justify-center gap-2 p-2.5 mt-1 mx-1 text-xs text-red-500 dark:text-red-400 rounded-xl bg-red-50/50 dark:bg-red-950/40 border border-red-100 dark:border-red-900/50 font-bold shadow-sm hover:bg-red-100/50"><i class="fa-solid fa-file-pdf"></i> Lihat Dokumen Original (PDF)</a>
                        @endif

                        <!-- FOLDER TREE SIDEBAR -->
                        <div class="mt-4 px-1">
                            <ul class="border-l-2 border-slate-200 dark:border-slate-700 ml-2 pl-4 mt-3 space-y-2">
                                @foreach($book->parts as $part)
                                    @php $isPartActive = isset($activeChapter) && $activeChapter->part_id == $part->id; @endphp
                                    <li class="relative group part-container">
                                        <div class="absolute -left-4 top-3 w-3 h-0.5 bg-slate-200 dark:bg-slate-700"></div>

                                        <button type="button" class="part-accordion-btn flex items-center justify-between w-full px-2 py-1.5 rounded-lg transition-colors {{ $isPartActive ? 'bg-blue-50 dark:bg-slate-800' : 'hover:bg-slate-50 dark:hover:bg-slate-800/50' }}" data-target="sidebar-part-{{ $part->id }}">
                                            <div class="flex items-center gap-2 text-sm font-bold truncate {{ $isPartActive ? 'text-amarin' : 'text-slate-500 dark:text-slate-400' }}">
                                                <i class="fa-solid fa-caret-{{ $isPartActive ? 'down' : 'right' }} text-[12px] w-3 text-center transition-transform"></i>
                                                <span class="truncate part-title">{{ $part->title }}</span>
                                            </div>
                                        </button>

                                        <div id="sidebar-part-{{ $part->id }}" class="part-body mt-1 {{ $isPartActive ? 'block active-part' : 'hidden' }}">
                                            <ul class="pl-5 space-y-1.5 py-1">
                                                @foreach($part->chapters as $chapter)
                                                    <li class="chapter-item flex items-center justify-between px-2 py-1.5 text-[0.85rem] rounded-lg transition-all hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                                        <a href="?read={{ $chapter->id }}" onclick="recordProgress('{{ $book->id }}', '{{ $chapter->id }}')" class="flex items-center gap-2 flex-grow truncate {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'text-amarin font-bold' : 'text-slate-500 dark:text-slate-400 hover:text-amarin font-medium' }}">
                                                            <i class="fa-solid fa-file-lines text-[10px] opacity-40"></i>
                                                            <span class="truncate chapter-title">{{ $chapter->title }}</span>
                                                        </a>
                                                        <i class="fa-solid fa-check-circle text-green-500 text-[10px] hidden read-indicator" data-chapter-id="{{ $chapter->id }}"></i>

                                                        @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                            <button type="button" class="ms-2 p-1 focus:outline-none" onclick="toggleToc()"><i id="icon-toc-toggle" class="fa-solid fa-chevron-up text-[0.7rem] text-amarin bg-blue-50 dark:bg-slate-800 w-5 h-5 rounded-full flex items-center justify-center transition-transform duration-300 shadow-inner"></i></button>
                                                        @endif
                                                    </li>
                                                    @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                        <li class="pl-2"><div id="dynamic-toc" class="mt-1 mb-2 space-y-1 border-l-2 border-amarin/20 ml-2 relative block transition-all duration-300 overflow-hidden"></div></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- KATEGORI FORMULIR -->
            <div class="mt-8 border-t border-slate-200/50 dark:border-slate-800 pt-6">
                <h5 class="text-[0.7rem] font-extrabold text-rose-500 uppercase tracking-widest mb-4 px-1"><i class="fa-solid fa-file-signature me-2"></i>Formulir & Checklist</h5>
                @php $groupedForms = isset($allForms) ? $allForms->groupBy('category') : collect(); @endphp
                @foreach($groupedForms as $category => $forms)
                    <div class="form-category-group mb-5">
                        <h6 class="text-[0.75rem] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 px-2 flex items-center gap-2 form-category-title"><i class="fa-solid fa-tags text-slate-400"></i> {{ $category ?: 'Lainnya' }}</h6>
                        <div class="space-y-2">
                            @foreach($forms as $form)
                                <a href="?read_form={{ $form->id }}" class="form-item flex items-center justify-between px-4 py-3 bg-white/50 dark:bg-slate-900/50 hover:bg-white/90 dark:hover:bg-slate-900 rounded-xl transition-all border border-white/50 dark:border-slate-800 shadow-sm group {{ (isset($activeForm) && $activeForm->id == $form->id) ? 'border-rose-300 bg-rose-50 dark:bg-rose-950/40 shadow-md' : '' }}">
                                    <div class="flex items-center gap-3 truncate">
                                        <div class="w-8 h-8 rounded-lg {{ $form->file_type == 'pdf' ? 'bg-red-100 text-red-500 dark:bg-red-950 dark:text-red-400' : 'bg-blue-100 text-blue-600 dark:bg-blue-950 dark:text-blue-400' }} flex items-center justify-center shrink-0"><i class="fa-solid {{ $form->file_type == 'pdf' ? 'fa-file-pdf' : 'fa-file-word' }}"></i></div>
                                        <div class="flex flex-col truncate"><span class="text-sm font-bold text-slate-700 dark:text-slate-200 group-hover:text-rose-600 truncate form-title">{{ $form->title }}</span><span class="text-[10px] text-slate-400 font-medium">{{ $form->book->title ?? 'Umum' }}</span></div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <div class="p-0 lg:ml-[24rem] mt-[5rem] min-h-screen relative z-10 transition-all duration-300">
        <div class="px-4 py-8 sm:px-8 sm:py-10 md:px-14 md:py-14 w-full max-w-none mx-auto relative">

            @if(isset($searchResults))
                <!-- HASIL DEEP SEARCH -->
                <div class="glass-panel rounded-3xl p-6 sm:p-8 md:p-12 border-t border-white/60 dark:border-slate-700">
                    <h4 class="text-2xl sm:text-3xl font-bold mb-8 text-gray-900 dark:text-slate-100 border-b border-gray-200 dark:border-slate-700 pb-5 flex items-center"><i class="fa-solid fa-magnifying-glass me-3 text-amarin"></i> Hasil Deep Search: "{{ request('search') }}"</h4>
                    @if($searchResults->isEmpty())
                        <div class="p-8 text-lg font-medium text-gray-500 dark:text-slate-400 bg-white/50 dark:bg-slate-900/60 rounded-2xl text-center"><i class="fa-solid fa-triangle-exclamation text-3xl mb-3 block"></i>Tidak ada kecocokan dokumen.</div>
                    @else
                        <ul class="space-y-5">
                            @foreach($searchResults as $result)
                                <li>
                                    <a href="?read={{ $result->id }}&search={{ request('search') }}" class="block p-5 sm:p-6 bg-white/60 dark:bg-slate-900/60 border border-white/50 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group">
                                        <h5 class="mb-2 text-xl font-bold text-amarin group-hover:text-blue-400 transition-colors">{{ $result->title }}</h5>
                                        <p class="text-xs sm:text-sm text-gray-500 dark:text-slate-400 font-bold mb-3 uppercase tracking-wider flex items-center gap-2"><i class="fa-solid fa-folder-open"></i> {{ $result->part->title ?? 'Bab Umum' }}</p>
                                        <div class="text-sm text-gray-600 dark:text-slate-300 font-medium bg-white/50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200/50 dark:border-slate-700 shadow-inner"><i class="fa-solid fa-quote-left text-amarin/30 text-lg float-left me-2"></i> {!! Str::limit(strip_tags($result->content), 180, '...') !!}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            @elseif(isset($activeChapter))
                <!-- CHAPTER VIEW -->
                <div class="glass-panel rounded-3xl p-6 sm:p-10 md:p-14 border-t border-white/60 dark:border-slate-700 shadow-[0_10px_40px_-10px_rgba(14,165,233,0.1)] mb-10 relative">
                    <button id="btn-show-all" class="hidden mb-8 text-sm font-bold text-white bg-gradient-to-r from-slate-800 to-slate-700 dark:from-slate-700 dark:to-slate-600 px-6 py-3 rounded-2xl transition-all shadow-lg w-full sm:w-auto text-center"><i class="fa-solid fa-book-open me-2 text-amarin"></i> Tampilkan Seluruh Modul</button>
                    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-10">
                        <div class="inline-flex flex-wrap items-center gap-2 px-4 py-2 bg-blue-50/50 dark:bg-slate-800/60 rounded-xl border border-blue-100/50 dark:border-slate-700 text-xs sm:text-sm font-bold text-amarin">
                            <span class="truncate max-w-[120px] sm:max-w-xs">{{ $activeBook->title }}</span><i class="fa-solid fa-chevron-right text-[0.6rem] opacity-50"></i><span class="truncate max-w-[150px] sm:max-w-xs">{{ $activeChapter->part->title }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/60 dark:bg-slate-800/60 p-2 rounded-2xl border border-white/50 dark:border-slate-700 shadow-sm">
                            <div class="flex items-center gap-1 border-r border-slate-200 dark:border-slate-700 pr-2 mr-1">
                                <button id="btn-tts-play" class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center shadow-sm" title="Dengarkan Materi"><i class="fa-solid fa-play"></i></button>
                                <button id="btn-tts-stop" class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-slate-700 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-colors flex items-center justify-center shadow-sm hidden" title="Hentikan Suara"><i class="fa-solid fa-stop"></i></button>
                                <div id="tts-indicator" class="hidden items-center gap-1 mx-2"><span class="flex h-3 w-1 bg-blue-500 rounded-full animate-bounce"></span><span class="flex h-4 w-1 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></span><span class="flex h-3 w-1 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span></div>
                            </div>
                            <div class="relative">
                                <button id="btn-typo-settings" class="w-10 h-10 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 transition-colors flex items-center justify-center font-serif font-bold text-lg" title="Gaya Membaca">Aa</button>
                                <div id="panel-typo-settings" class="absolute right-0 top-full mt-2 w-64 p-4 glass-panel rounded-2xl hidden shadow-xl border border-white/80 dark:border-slate-700 z-50">
                                    <h6 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Pengaturan Teks</h6>
                                    <div class="mb-4"><div class="flex justify-between text-xs font-bold text-slate-600 dark:text-slate-300 mb-2"><span>Ukuran Font</span> <span id="val-font-size">1.15rem</span></div><input type="range" id="slider-font-size" min="0.8" max="1.8" step="0.05" value="1.15" class="w-full h-1.5 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer"></div>
                                    <div><div class="flex justify-between text-xs font-bold text-slate-600 dark:text-slate-300 mb-2"><span>Spasi Baris</span> <span id="val-line-height">1.9</span></div><input type="range" id="slider-line-height" min="1.4" max="2.5" step="0.1" value="1.9" class="w-full h-1.5 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="main-chapter-title" class="mb-10"><h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">{{ $activeChapter->title }}</h1></div>
                    <div id="reader-content">{!! $activeChapter->content !!}</div>
                </div>

            @elseif(isset($activeForm))
                <!-- FORM VIEW -->
                <div class="glass-panel rounded-3xl p-6 md:p-10 lg:p-14 shadow-2xl border border-white/60 dark:border-slate-700 w-full mb-10">
                    <div class="flex flex-col xl:flex-row justify-between items-center gap-6 mb-10 border-b border-slate-200 dark:border-slate-700 pb-8">
                        <div class="flex items-center gap-5 w-full">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-inner shrink-0 {{ $activeForm->file_type == 'pdf' ? 'bg-red-100 text-red-600 border border-red-200 dark:bg-red-950 dark:text-red-400 dark:border-red-900' : 'bg-blue-100 text-blue-600 border border-blue-200 dark:bg-blue-950 dark:text-blue-400 dark:border-blue-900' }}"><i class="fa-solid {{ $activeForm->file_type == 'pdf' ? 'fa-file-pdf' : 'fa-file-word' }} text-4xl"></i></div>
                            <div class="flex-grow"><h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">{{ $activeForm->title }}</h1>
                                <p class="text-sm text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest mt-2 flex items-center gap-2"><i class="fa-solid fa-tags"></i> Kategori: {{ $activeForm->category ?? 'Lainnya' }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('uploads/forms/' . $activeForm->file_path) }}" download class="w-full xl:w-auto text-white bg-gradient-to-r from-cyan-500 to-blue-600 font-bold rounded-2xl text-base px-8 py-4 transition-all shadow-[0_10px_25px_-5px_rgba(37,99,235,0.4)] hover:-translate-y-1 hover:shadow-[0_15px_35px_-5px_rgba(37,99,235,0.5)] text-center flex items-center justify-center gap-3 whitespace-nowrap shrink-0"><i class="fa-solid fa-cloud-arrow-down text-xl"></i> Unduh File Asli</a>
                    </div>

                    @if($activeForm->file_type == 'pdf')
                        <iframe src="{{ asset('uploads/forms/' . $activeForm->file_path) }}" class="w-full h-[85vh] rounded-2xl border-2 border-slate-200 dark:border-slate-700 shadow-inner bg-slate-50"></iframe>
                    @else
                        <div class="bg-slate-100 dark:bg-slate-900 p-2 sm:p-6 md:p-8 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-inner w-full overflow-x-auto">
                            <div id="word-preview-container" class="bg-white text-slate-900 p-8 sm:p-12 md:p-16 mx-auto rounded-xl shadow-[0_0_40px_rgba(0,0,0,0.1)] min-h-[800px] w-full relative">
                                <div id="word-loading" class="absolute inset-0 bg-white flex flex-col items-center justify-center rounded-xl z-10 text-blue-500"><i class="fa-solid fa-circle-notch fa-spin text-6xl mb-6"></i><h3 class="font-bold text-2xl mb-2">Memproses Dokumen</h3><p class="text-slate-500 font-medium">Sedang merender Pratinjau Interaktif...</p></div>
                                <div id="word-content" class="w-full text-base sm:text-lg"></div>
                            </div>
                        </div>
                        <script>
                            fetch("{{ asset('uploads/forms/' . $activeForm->file_path) }}")
                                .then(response => response.arrayBuffer())
                                .then(buffer => mammoth.convertToHtml({arrayBuffer: buffer}))
                                .then(result => { document.getElementById('word-content').innerHTML = result.value; setTimeout(() => { document.getElementById('word-loading').style.display = 'none'; }, 500); })
                                .catch(err => { document.getElementById('word-loading').innerHTML = '<i class="fa-solid fa-triangle-exclamation text-red-500 text-6xl mb-6"></i><h3 class="font-bold text-2xl mb-2 text-slate-800">Pratinjau Tidak Tersedia</h3><p class="text-slate-500 font-medium">Silakan unduh file secara langsung menggunakan tombol biru di atas.</p>'; });
                        </script>
                    @endif
                </div>

            @elseif(isset($activeBook) && $activeBook->pdf_file)
                <div class="glass-panel rounded-3xl p-4 md:p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center text-lg text-slate-800 dark:text-slate-100 font-bold w-full md:w-auto"><div class="w-12 h-12 bg-red-50 dark:bg-red-950 text-red-500 dark:text-red-400 rounded-xl flex items-center justify-center me-4 shadow-sm border border-red-100 dark:border-red-900"><i class="fa-solid fa-file-pdf text-2xl"></i></div><span class="truncate">{{ $activeBook->title }}</span></div>
                    <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="w-full md:w-auto text-white bg-gradient-to-r from-red-500 to-rose-600 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-lg text-center whitespace-nowrap">Buka Layar Penuh <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></a>
                </div>
                <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" class="w-full h-[80vh] rounded-3xl border border-white/50 dark:border-slate-700 shadow-xl glass-panel mb-10"></iframe>

            @else
                <!-- DASHBOARD HOMEPAGE -->
                <div class="w-full max-w-7xl mx-auto mb-10">

                    <div class="glass-panel rounded-[2rem] p-6 sm:p-10 mb-8 flex flex-col md:flex-row items-center gap-6 md:gap-10 border-t border-white/60 dark:border-slate-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-cyan-300/40 dark:from-cyan-900/30 to-transparent rounded-full blur-[50px] pointer-events-none"></div>
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full sm:rounded-[2.5rem] flex items-center justify-center shadow-xl shadow-blue-500/30 shrink-0 relative z-10"><div class="absolute inset-0 bg-white/20 blur-md"></div><i class="fa-solid fa-ship text-white text-5xl sm:text-6xl relative z-10 drop-shadow-md"></i></div>
                        <div class="text-center md:text-left relative z-10">
                            <!-- PERBAIKAN UTAMA WARNA TEKS BANNER DI DARK MODE -->
                            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4 tracking-tight drop-shadow-sm">Amarin Fleet <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-cyan-400 dark:to-blue-400">IMS</span></h1>
                            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-2xl leading-relaxed font-medium">Sistem digitalisasi prosedur operasional dan keselamatan kapal. Akses dokumen, panduan, dan formulir dengan efisien dan terpantau.</p>
                        </div>
                    </div>

                    <!-- STATISTICS WIDGET -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 px-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-950 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-inner shrink-0"><i class="fa-solid fa-chart-simple text-sm"></i></div>
                            <h2 class="text-xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">Statistik Membaca Kru</h2>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="stat-card">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="stat-icon-wrapper bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400"><i class="fa-regular fa-clock"></i></div>
                                    <div><h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Waktu Baca</h4><h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-slate-100" id="stat-time">14h 25m</h3></div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="stat-icon-wrapper bg-cyan-100 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400"><i class="fa-solid fa-file-lines"></i></div>
                                    <div><h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Selesai</h4><h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-slate-100"><span id="stat-completed">0</span> Modul</h3></div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="stat-icon-wrapper bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400"><i class="fa-regular fa-calendar-check"></i></div>
                                    <div><h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Hari Baca</h4><h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-slate-100" id="stat-days">42 Hari</h3></div>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="stat-icon-wrapper bg-orange-100 dark:bg-orange-950 text-orange-500 dark:text-orange-400"><i class="fa-solid fa-fire"></i></div>
                                    <div><h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Rekor Beruntun</h4><h3 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-slate-100" id="stat-streak">5 Hari</h3></div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <div class="lg:col-span-2 glass-panel p-5 rounded-2xl border border-white/60 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 mb-4"><i class="fa-solid fa-calendar-days text-amarin me-2"></i>Aktivitas Membaca Tahunan</h4>
                                <div id="heatmap-container" class="flex gap-1 overflow-x-auto custom-scrollbar pb-2"></div>
                                <div class="flex justify-end items-center gap-2 mt-2 text-[9px] font-bold text-slate-400">
                                    <span>Sedikit</span>
                                    <div class="flex gap-1">
                                        <div class="w-2.5 h-2.5 rounded-sm bg-slate-100 dark:bg-slate-800"></div><div class="w-2.5 h-2.5 rounded-sm bg-cyan-200"></div><div class="w-2.5 h-2.5 rounded-sm bg-cyan-400"></div><div class="w-2.5 h-2.5 rounded-sm bg-blue-500"></div><div class="w-2.5 h-2.5 rounded-sm bg-blue-700"></div>
                                    </div>
                                    <span>Banyak</span>
                                </div>
                            </div>

                            <div class="glass-panel p-5 rounded-2xl border border-white/60 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 mb-2"><i class="fa-solid fa-chart-column text-amarin me-2"></i>Tren Durasi 7 Hari</h4>
                                <div id="trend-chart-container" class="flex items-end justify-between h-32 w-full pt-4 border-b border-slate-200 dark:border-slate-700"></div>
                            </div>
                        </div>
                    </div>

                    <!-- GRID PUSTAKA & WIDGET -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-12 mt-8">
                        <!-- PUSTAKA & PROGRESS (KIRI) -->
                        <div class="lg:col-span-8 flex flex-col gap-6">
                            <div class="flex items-center gap-3 px-2">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-950 flex items-center justify-center text-amarin dark:text-blue-400 shadow-inner shrink-0"><i class="fa-solid fa-book-bookmark text-xl"></i></div>
                                <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">Pustaka & Modul Materi</h2>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @forelse($books as $book)
                                    @php $totalChapters = $book->parts->flatMap->chapters->count(); @endphp
                                    <div class="glass-panel rounded-2xl p-5 border border-white/50 dark:border-slate-700 hover:shadow-xl transition-all duration-300 flex flex-col h-full group bg-white/40 dark:bg-slate-900/50">
                                        <div class="flex gap-4 mb-4">
                                            @if($book->cover_image)
                                                <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-24 h-32 object-cover rounded-xl shadow-md border border-white/50 dark:border-slate-700 shrink-0 group-hover:-translate-y-1 transition-transform">
                                            @else
                                                <div class="w-24 h-32 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 flex flex-col items-center justify-center shrink-0 border border-white/50 dark:border-slate-700 shadow-md group-hover:-translate-y-1 transition-transform"><i class="fa-solid fa-book text-slate-300 dark:text-slate-600 text-3xl mb-1"></i></div>
                                            @endif

                                            <div class="flex flex-col w-full">
                                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2 leading-snug">{{ $book->title }}</h3>
                                                <div class="flex gap-1.5 mt-1">
                                                    <span class="bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 text-[9px] font-bold px-2 py-1 rounded w-fit"><i class="fa-solid fa-folder-tree me-1"></i> {{ $book->parts->count() }} Bagian</span>
                                                    <span class="bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-300 text-[9px] font-bold px-2 py-1 rounded w-fit"><i class="fa-solid fa-file-lines me-1"></i> {{ $totalChapters }} Bab</span>
                                                </div>

                                                <div class="mt-auto pt-3">
                                                    <div class="flex justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-1.5">
                                                        <span>Progres Kru</span>
                                                        <span class="text-amarin progress-percentage" data-book-id="{{ $book->id }}" data-total-chapters="{{ $totalChapters }}">0%</span>
                                                    </div>
                                                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5 overflow-hidden">
                                                        <div class="bg-gradient-to-r from-cyan-400 to-blue-500 h-1.5 rounded-full progress-bar shadow-sm transition-all duration-1000 ease-out" data-book-id="{{ $book->id }}" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-auto border-t border-slate-200/60 dark:border-slate-800 pt-4">
                                            <h4 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2 px-1 flex items-center justify-between"><span>Isi Pustaka</span><i class="fa-solid fa-list-ul"></i></h4>

                                            <!-- FOLDER TREE (GRID DASHBOARD) -->
                                            <div class="bg-white/60 dark:bg-slate-900/60 border border-blue-100/50 dark:border-slate-800 rounded-xl shadow-sm mb-2 mt-3">
                                                <button type="button" class="accordion-btn w-full flex items-center justify-between p-3 focus:outline-none group" data-target="grid-book-{{ $book->id }}">
                                                    <div class="flex items-center gap-2 text-amarin font-extrabold text-xs tracking-widest uppercase">
                                                        <i class="fa-solid fa-folder-open group-hover:scale-110 transition-transform"></i>
                                                        <span>{{ $book->title }}</span>
                                                    </div>
                                                    <i class="fa-solid fa-chevron-down text-amarin text-xs transition-transform duration-300"></i>
                                                </button>

                                                <div id="grid-book-{{ $book->id }}" class="folder-content hidden p-3 pt-0 border-t border-slate-200/50 dark:border-slate-800 transition-all duration-300">
                                                    <ul class="border-l-2 border-slate-200 dark:border-slate-700 ml-2 pl-4 mt-3 space-y-2">
                                                        @foreach($book->parts as $part)
                                                            <li class="relative group part-container">
                                                                <div class="absolute -left-4 top-3 w-3 h-0.5 bg-slate-200 dark:bg-slate-700"></div>

                                                                <button type="button" class="part-accordion-btn flex items-center justify-between w-full px-2 py-1.5 rounded-lg transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50" data-target="grid-part-{{ $part->id }}">
                                                                    <div class="flex items-center gap-2 text-sm font-bold truncate text-slate-500 dark:text-slate-400">
                                                                        <i class="fa-solid fa-caret-right text-[12px] w-3 text-center transition-transform"></i>
                                                                        <span class="truncate part-title">{{ $part->title }}</span>
                                                                    </div>
                                                                </button>

                                                                <div id="grid-part-{{ $part->id }}" class="part-body hidden mt-1">
                                                                    <ul class="pl-5 space-y-1.5 py-1">
                                                                        @foreach($part->chapters as $chapter)
                                                                            <li class="chapter-item flex items-center justify-between px-2 py-1.5 text-[0.85rem] rounded-lg transition-all hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                                                                <a href="?read={{ $chapter->id }}" onclick="recordProgress('{{ $book->id }}', '{{ $chapter->id }}')" class="flex items-center gap-2 flex-grow truncate text-slate-500 dark:text-slate-400 hover:text-amarin font-medium">
                                                                                    <i class="fa-solid fa-file-lines text-[10px] opacity-40"></i>
                                                                                    <span class="truncate chapter-title">{{ $chapter->title }}</span>
                                                                                </a>
                                                                                <i class="fa-solid fa-check-circle text-green-500 text-[10px] hidden read-indicator" data-chapter-id="{{ $chapter->id }}"></i>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full glass-panel p-8 text-center rounded-2xl border border-white/50 dark:border-slate-700"><p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada buku yang diunggah.</p></div>
                                @endforelse
                            </div>
                        </div>

                        <!-- FORMULIR CEPAT & STATUS (KANAN) -->
                        <div class="lg:col-span-4 flex flex-col gap-6">
                            <div class="flex items-center gap-3 px-2">
                                <div class="w-10 h-10 rounded-lg bg-rose-100 dark:bg-rose-950 flex items-center justify-center text-rose-500 dark:text-rose-400 shadow-inner shrink-0"><i class="fa-solid fa-bolt text-xl"></i></div>
                                <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">Formulir Cepat</h2>
                            </div>

                            <div class="glass-panel rounded-3xl p-5 border border-white/60 dark:border-slate-700 shadow-sm bg-white/40 dark:bg-slate-900/50 h-full">
                                @if(isset($allForms) && $allForms->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($allForms->take(5) as $form)
                                            <a href="?read_form={{ $form->id }}" class="bg-white/80 dark:bg-slate-800/80 p-3.5 rounded-xl flex items-center gap-3 hover:shadow-md hover:-translate-y-1 transition-all border border-white/60 dark:border-slate-700 group">
                                                <div class="w-10 h-10 rounded-lg {{ $form->file_type == 'pdf' ? 'bg-red-50 text-red-500 border border-red-100 dark:bg-red-950 dark:text-red-400 dark:border-red-900' : 'bg-blue-50 text-blue-600 border border-blue-100 dark:bg-blue-950 dark:text-blue-400 dark:border-blue-900' }} flex items-center justify-center shrink-0 shadow-inner group-hover:scale-105 transition-transform"><i class="fa-solid {{ $form->file_type == 'pdf' ? 'fa-file-pdf' : 'fa-file-word' }} text-lg"></i></div>
                                                <div class="truncate flex-grow">
                                                    <h4 class="font-bold text-slate-800 dark:text-slate-200 text-xs truncate group-hover:text-amarin transition-colors">{{ $form->title }}</h4>
                                                    <span class="text-[9px] font-bold text-slate-400 bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded uppercase mt-1 inline-block"><i class="fa-solid fa-tag"></i> {{ $form->category ?? 'Lainnya' }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    @if($allForms->count() > 5)
                                        <div class="text-center mt-4"><span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold bg-white/50 dark:bg-slate-800 px-3 py-1 rounded-full border border-white dark:border-slate-700">Gunakan Sidebar untuk form lainnya</span></div>
                                    @endif
                                @else
                                    <div class="text-center py-10"><p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada formulir.</p></div>
                                @endif
                            </div>

                            <div class="glass-panel rounded-2xl p-5 border border-white/60 dark:border-slate-700 shadow-sm relative overflow-hidden bg-white/40 dark:bg-slate-900/50">
                                <div class="absolute -right-4 -bottom-4 text-slate-200 dark:text-slate-800 opacity-50"><i class="fa-solid fa-server text-5xl"></i></div>
                                <h4 class="text-sm font-extrabold text-slate-800 dark:text-slate-100 mb-3 flex items-center gap-2 relative z-10"><i class="fa-solid fa-signal text-green-500"></i> Server Amarin</h4>
                                <div class="space-y-3 relative z-10">
                                    <div><div class="flex justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-1"><span class="uppercase">Database Sync</span><span class="text-green-500">Connected</span></div><div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5"><div class="bg-green-500 h-1.5 rounded-full shadow-[0_0_8px_#22c55e]" style="width: 100%"></div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(isset($activeChapter))
        <div id="ai-chat-panel" class="fixed bottom-24 right-6 w-80 sm:w-96 glass-panel border border-white dark:border-slate-700 shadow-2xl rounded-2xl hidden flex-col z-50 overflow-hidden transform transition-transform">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-500 p-4 text-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center"><i class="fa-solid fa-robot"></i></div>
                    <div><h4 class="font-bold text-sm leading-tight">Amarin AI Partner</h4><span class="text-[10px] opacity-80">Asisten Prosedur Kapal</span></div>
                </div>
                <button onclick="toggleAI()" class="text-white hover:text-red-200"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div id="ai-chat-messages" class="h-80 bg-slate-50 dark:bg-slate-900 p-4 overflow-y-auto flex flex-col gap-3 text-sm">
                <div class="flex gap-2 w-5/6">
                    <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 mt-1"><i class="fa-solid fa-robot text-[10px]"></i></div>
                    <div class="bg-white dark:bg-slate-800 p-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 leading-relaxed">
                        Halo! Saya asisten AI Amarin. Apakah ada prosedur dari Bab <b>{{ $activeChapter->title }}</b> ini yang ingin saya rangkum atau jelaskan?
                    </div>
                </div>
            </div>

            <div class="p-3 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <input type="text" id="ai-input" class="w-full bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white border-none rounded-xl text-sm focus:ring-amarin px-4 py-2 placeholder-slate-400" placeholder="Tanya sesuatu...">
                <button onclick="sendAIMessage()" class="w-10 h-10 bg-amarin text-white rounded-xl shrink-0 hover:bg-blue-600 transition-colors shadow-md"><i class="fa-solid fa-paper-plane"></i></button>
            </div>
        </div>

        <button onclick="toggleAI()" class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-full shadow-[0_10px_25px_rgba(14,165,233,0.5)] hover:scale-110 transition-transform flex items-center justify-center text-2xl z-50 border-2 border-white dark:border-slate-700">
            <i class="fa-solid fa-sparkles"></i>
        </button>
    @endif

    <script>
        // SCRIPT: THEME PICKER & SLIDERS
        const themeBtns = document.querySelectorAll('.theme-btn');
        function updateThemeUI(theme) {
            themeBtns.forEach(btn => {
                if (btn.getAttribute('data-theme') === theme) {
                    btn.classList.add('border-amarin', 'bg-blue-50', 'dark:bg-slate-800');
                    btn.classList.remove('border-transparent');
                } else {
                    btn.classList.remove('border-amarin', 'bg-blue-50', 'dark:bg-slate-800');
                    btn.classList.add('border-transparent');
                }
            });
        }

        function applyTheme(theme) {
            if (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            updateThemeUI(theme);
        }

        const currentTheme = localStorage.getItem('color-theme') || 'auto';
        applyTheme(currentTheme);

        themeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const theme = btn.getAttribute('data-theme');
                localStorage.setItem('color-theme', theme);
                applyTheme(theme);
            });
        });

        const fontSizeSlider = document.getElementById('slider-font-size');
        const lineHeightSlider = document.getElementById('slider-line-height');

        if(fontSizeSlider) {
            const savedSize = localStorage.getItem('read_font_size') || '1.15';
            const savedLine = localStorage.getItem('read_line_height') || '1.9';

            document.documentElement.style.setProperty('--read-font-size', savedSize + 'rem');
            document.documentElement.style.setProperty('--read-line-height', savedLine);

            fontSizeSlider.value = savedSize; document.getElementById('val-font-size').innerText = savedSize + 'rem';
            lineHeightSlider.value = savedLine; document.getElementById('val-line-height').innerText = savedLine;

            fontSizeSlider.addEventListener('input', (e) => { const val = e.target.value; document.documentElement.style.setProperty('--read-font-size', val + 'rem'); document.getElementById('val-font-size').innerText = val + 'rem'; localStorage.setItem('read_font_size', val); });
            lineHeightSlider.addEventListener('input', (e) => { const val = e.target.value; document.documentElement.style.setProperty('--read-line-height', val); document.getElementById('val-line-height').innerText = val; localStorage.setItem('read_line_height', val); });

            document.getElementById('btn-typo-settings').addEventListener('click', (e) => { e.stopPropagation(); document.getElementById('panel-typo-settings').classList.toggle('hidden'); });
            document.addEventListener('click', () => { document.getElementById('panel-typo-settings').classList.add('hidden'); });
            document.getElementById('panel-typo-settings').addEventListener('click', e => e.stopPropagation());
        }

        const btnTTSPlay = document.getElementById('btn-tts-play');
        const btnTTSStop = document.getElementById('btn-tts-stop');
        const ttsIndicator = document.getElementById('tts-indicator');

        if(btnTTSPlay && 'speechSynthesis' in window) {
            let synth = window.speechSynthesis; let utterance = null;
            btnTTSPlay.addEventListener('click', () => {
                const content = document.getElementById('reader-content').innerText;
                const cleanText = content.replace(/[^a-zA-Z0-9.,!? ]/g, ' ');
                utterance = new SpeechSynthesisUtterance(cleanText);
                utterance.lang = 'id-ID'; utterance.rate = 1.0;
                synth.speak(utterance);
                btnTTSPlay.classList.add('hidden'); btnTTSStop.classList.remove('hidden');
                ttsIndicator.classList.remove('hidden'); ttsIndicator.classList.add('flex');
                utterance.onend = () => { btnTTSPlay.classList.remove('hidden'); btnTTSStop.classList.add('hidden'); ttsIndicator.classList.add('hidden'); ttsIndicator.classList.remove('flex'); };
            });
            btnTTSStop.addEventListener('click', () => { synth.cancel(); btnTTSPlay.classList.remove('hidden'); btnTTSStop.classList.add('hidden'); ttsIndicator.classList.add('hidden'); ttsIndicator.classList.remove('flex'); });
        }

        function toggleAI() { const panel = document.getElementById('ai-chat-panel'); if(panel.classList.contains('hidden')) { panel.classList.remove('hidden'); panel.classList.add('ai-panel-active'); } else { panel.classList.add('hidden'); panel.classList.remove('ai-panel-active'); } }
        function sendAIMessage() {
            const input = document.getElementById('ai-input'); const msg = input.value.trim(); if(!msg) return;
            const chatBox = document.getElementById('ai-chat-messages');
            chatBox.innerHTML += `<div class="flex gap-2 w-5/6 self-end ml-auto justify-end"><div class="bg-blue-600 p-3 rounded-2xl rounded-tr-sm shadow-sm text-white leading-relaxed">${msg}</div></div>`;
            input.value = ''; chatBox.scrollTop = chatBox.scrollHeight;
            setTimeout(() => {
                chatBox.innerHTML += `<div class="flex gap-2 w-5/6"><div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 mt-1"><i class="fa-solid fa-robot text-[10px]"></i></div><div class="bg-white dark:bg-slate-800 p-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 leading-relaxed text-xs"><b>[Simulasi UI API]</b><br>Terkait pertanyaan Anda: "${msg}".<br><br>Ini adalah antarmuka AI Partner.</div></div>`;
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 1000);
        }
        document.getElementById('ai-input')?.addEventListener('keypress', function (e) { if (e.key === 'Enter') sendAIMessage(); });

        function recordProgress(bookId, chapterId) {
            let readData = JSON.parse(localStorage.getItem('amarin_read_progress')) || {};
            if(!readData[bookId]) readData[bookId] = [];
            if(!readData[bookId].includes(chapterId)) { readData[bookId].push(chapterId); localStorage.setItem('amarin_read_progress', JSON.stringify(readData)); }
        }

        function renderProgressAndStats() {
            let readData = JSON.parse(localStorage.getItem('amarin_read_progress')) || {};
            let totalChaptersRead = 0;

            document.querySelectorAll('.progress-percentage').forEach(el => {
                const bookId = el.getAttribute('data-book-id');
                const total = parseInt(el.getAttribute('data-total-chapters')) || 0;
                if(total > 0 && readData[bookId]) {
                    const readCount = readData[bookId].length;
                    totalChaptersRead += readCount;
                    const percentage = Math.min(Math.round((readCount / total) * 100), 100);
                    el.innerText = percentage + '%';
                    const bar = document.querySelector(`.progress-bar[data-book-id="${bookId}"]`);
                    if(bar) bar.style.width = percentage + '%';
                }
            });

            document.querySelectorAll('.read-indicator').forEach(icon => {
                const chapterId = icon.getAttribute('data-chapter-id');
                for(const bookId in readData) { if(readData[bookId].includes(chapterId)) { icon.classList.remove('hidden'); icon.parentElement.classList.add('opacity-60'); } }
            });

            const statCompleted = document.getElementById('stat-completed');
            if(statCompleted) statCompleted.innerText = totalChaptersRead;

            const heatmapContainer = document.getElementById('heatmap-container');
            if(heatmapContainer) {
                let html = ''; const weeks = 22; const days = 7;
                for(let w=0; w<weeks; w++) {
                    html += '<div class="flex flex-col gap-1">';
                    for(let d=0; d<days; d++) {
                        const intensity = Math.random() > 0.6 ? Math.floor(Math.random() * 4) + 1 : 0;
                        let bg = 'bg-slate-100 dark:bg-slate-800';
                        if(intensity===1) bg = 'bg-cyan-200 dark:bg-cyan-900';
                        else if(intensity===2) bg = 'bg-cyan-400 dark:bg-cyan-700';
                        else if(intensity===3) bg = 'bg-blue-500 dark:bg-blue-600';
                        else if(intensity===4) bg = 'bg-blue-700 dark:bg-blue-500';
                        html += `<div class="w-3 h-3 sm:w-3.5 sm:h-3.5 rounded-sm ${bg}"></div>`;
                    }
                    html += '</div>';
                }
                heatmapContainer.innerHTML = html;
            }

            const trendContainer = document.getElementById('trend-chart-container');
            if(trendContainer) {
                const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                let html = '';
                for(let i=0; i<7; i++) {
                    const height = Math.floor(Math.random() * 80) + 10;
                    html += `<div class="flex flex-col items-center gap-2 flex-1 group"><div class="w-full bg-blue-50 dark:bg-slate-800 rounded-t-xl h-24 relative overflow-visible flex items-end justify-center"><div class="w-full sm:w-4/5 bg-gradient-to-t from-blue-600 to-cyan-400 rounded-t-xl transition-all duration-700 hover:opacity-80 mx-auto" style="height: ${height}%"></div><div class="absolute bottom-[calc(100%+5px)] left-1/2 -translate-x-1/2 bg-slate-800 dark:bg-slate-700 text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity z-10 pointer-events-none">${height}m</div></div><span class="text-[9px] font-bold text-slate-500 dark:text-slate-400">${days[i]}</span></div>`;
                }
                trendContainer.innerHTML = html;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderProgressAndStats();

            const sidebarFilter = document.getElementById('sidebarFilter');
            if (sidebarFilter) {
                sidebarFilter.addEventListener('input', function() {
                    const term = this.value.toLowerCase();
                    document.querySelectorAll('.book-group').forEach(bookGroup => {
                        let bookMatches = false; const bookTitle = bookGroup.querySelector('.book-title')?.innerText.toLowerCase() || '';
                        bookGroup.querySelectorAll('.part-container').forEach(partContainer => {
                            let partMatches = false; const partTitle = partContainer.querySelector('.part-title')?.innerText.toLowerCase() || '';
                            const partBtn = partContainer.querySelector('.part-accordion-btn'); const partBody = partContainer.querySelector('.part-body');
                            partContainer.querySelectorAll('.chapter-item').forEach(chapterItem => {
                                const chapterTitle = chapterItem.querySelector('.chapter-title')?.innerText.toLowerCase() || '';
                                if (chapterTitle.includes(term) || partTitle.includes(term) || bookTitle.includes(term)) { chapterItem.style.display = ''; partMatches = true; bookMatches = true; } else { chapterItem.style.display = 'none'; }
                            });
                            if (partMatches) { partBtn.style.display = ''; if(term.length > 0) { partBody.classList.remove('hidden'); partBody.classList.add('block', 'active-part'); let icon = partBtn.querySelector('.fa-chevron-down'); if(icon) icon.classList.add('rotate-180'); } } else { partBtn.style.display = 'none'; partBody.classList.add('hidden'); partBody.classList.remove('block', 'active-part'); }
                        });
                        if (bookMatches || bookTitle.includes(term)) { bookGroup.style.display = ''; const bookBody = bookGroup.querySelector('.book-body'); if(term.length > 0 && bookBody) { bookBody.classList.remove('hidden'); bookBody.classList.add('block'); } } else { bookGroup.style.display = 'none'; }
                    });
                    document.querySelectorAll('.form-category-group').forEach(catGroup => {
                        let catMatches = false; const catTitle = catGroup.querySelector('.form-category-title')?.innerText.toLowerCase() || '';
                        catGroup.querySelectorAll('.form-item').forEach(formItem => {
                            const formTitle = formItem.querySelector('.form-title')?.innerText.toLowerCase() || '';
                            if (formTitle.includes(term) || catTitle.includes(term)) { formItem.style.display = ''; catMatches = true; } else { formItem.style.display = 'none'; }
                        });
                        if (catMatches) { catGroup.style.display = ''; } else { catGroup.style.display = 'none'; }
                    });
                });
            }

            function updateDateClock() {
                const now = new Date();
                const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                const dateStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                const clockEl = document.getElementById('realtime-clock'); const dateEl = document.getElementById('realtime-date');
                if(clockEl) clockEl.innerText = timeStr + ' WIB'; if(dateEl) dateEl.innerText = dateStr;
            }
            setInterval(updateDateClock, 1000); updateDateClock();

            // JS ACCORDION BUKU
            const accordionBtns = document.querySelectorAll('.accordion-btn');
            accordionBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target'); const targetBody = document.getElementById(targetId); const icon = btn.querySelector('.fa-chevron-down, .fa-chevron-up');
                    if (targetBody && targetBody.classList.contains('hidden')) {
                        targetBody.classList.remove('hidden'); targetBody.classList.add('block');
                        if(icon) { icon.classList.replace('fa-chevron-down', 'fa-chevron-up'); }
                    } else if(targetBody) {
                        targetBody.classList.add('hidden'); targetBody.classList.remove('block');
                        if(icon) { icon.classList.replace('fa-chevron-up', 'fa-chevron-down'); }
                    }
                });
            });

            // JS ACCORDION PART (Sub-Bab)
            const partAccordionBtns = document.querySelectorAll('.part-accordion-btn');
            partAccordionBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    if(e.target.tagName.toLowerCase() === 'a') return;

                    const targetId = btn.getAttribute('data-target');
                    if(!targetId) return;
                    const targetBody = document.getElementById(targetId);
                    const icon = btn.querySelector('.fa-caret-right, .fa-caret-down');

                    if (targetBody && targetBody.classList.contains('hidden')) {
                        targetBody.classList.remove('hidden'); targetBody.classList.add('block');
                        if(icon) { icon.classList.replace('fa-caret-right', 'fa-caret-down'); }
                    } else if(targetBody) {
                        targetBody.classList.add('hidden'); targetBody.classList.remove('block');
                        if(icon) { icon.classList.replace('fa-caret-down', 'fa-caret-right'); }
                    }
                });
            });

            const dropdownBtn = document.getElementById('dropdownDefaultButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownBtn && dropdownMenu) { dropdownBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownMenu.classList.toggle('hidden'); }); document.addEventListener('click', () => { dropdownMenu.classList.add('hidden'); }); }

            const sidebarBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('logo-sidebar');
            if (sidebarBtn && sidebar) { sidebarBtn.addEventListener('click', (e) => { e.stopPropagation(); sidebar.classList.toggle('-translate-x-full'); }); }

            const readSlider = document.getElementById('readSlider');
            const sliderValueText = document.getElementById('sliderValue');
            const htmlElement = document.documentElement;
            const savedSepia = localStorage.getItem('amarin-sepia') || '0';
            if(readSlider && sliderValueText) {
                readSlider.value = savedSepia; htmlElement.style.setProperty('--sepia-level', savedSepia); sliderValueText.textContent = Math.round((savedSepia / 0.4) * 100) + '%';
                readSlider.addEventListener('input', (e) => { const val = e.target.value; htmlElement.style.setProperty('--sepia-level', val); localStorage.setItem('amarin-sepia', val); sliderValueText.textContent = Math.round((val / 0.4) * 100) + '%'; });
            }

            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            const contentBox = document.getElementById('reader-content');
            if (searchQuery && contentBox) {
                const markInstance = new Mark(contentBox);
                markInstance.mark(searchQuery, {
                    element: "mark", className: "search-highlight", separateWordSearch: false,
                    done: function() {
                        const firstHighlight = document.querySelector('mark.search-highlight');
                        if (firstHighlight) setTimeout(() => { firstHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 500);
                    }
                });
            }

            const tocContainer = document.getElementById('dynamic-toc');
            if (contentBox && tocContainer) {
                const children = Array.from(contentBox.children);
                let tocHTML = '<div class="flex flex-col w-full py-2 relative">';
                let currentSectionId = 'virtual-intro'; let validId = 0; let seenTexts = new Set();

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
                            if (/^PART\s+[A-Z]\b/i.test(text)) { level = 1; } else if (/^CHAPTER\s+\d+/i.test(text)) { level = 2; } else if (/^(?:PART|BAGIAN)\s+\d+/i.test(text)) { level = 3; } else if (/^\d+\.\d+/.test(text) || /^\d+\.\s/.test(text)) { const match = text.match(/^(\d+(?:\.\d+)*)/); if (match) { level = 3 + (match[1].split('.').length - 1); } }

                            if (level > 0 && !seenTexts.has(text)) {
                                if (!foundNewSection) { validId++; currentSectionId = 'v-page-' + validId; foundNewSection = true; }
                                seenTexts.add(text);
                                let paddingClass = ''; let textClass = 'text-slate-600 hover:text-amarin'; let dotIndicator = '';
                                if (level === 1) { paddingClass = 'pl-2 mt-4'; textClass = 'text-slate-900 font-extrabold uppercase text-[0.75rem] tracking-widest'; } else if (level === 2) { paddingClass = 'pl-3 mt-2'; textClass = 'text-slate-800 font-bold text-[0.85rem]'; } else if (level === 3) { paddingClass = 'pl-5 mt-1'; textClass = 'text-slate-700 font-semibold text-[0.85rem]'; } else { paddingClass = 'pl-8 relative'; textClass = 'text-slate-500 font-medium text-[0.85rem]'; dotIndicator = '<div class="absolute left-4 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-amarin transition-colors"></div>'; }
                                tocHTML += `<a href="#${currentSectionId}" class="toc-link block py-2 transition-all w-full truncate rounded-xl hover:bg-white/50 group ${paddingClass} ${textClass}" title="${text}">${dotIndicator} ${text}</a>`;
                            }
                        });
                    }
                    child.setAttribute('data-virtual-page', currentSectionId);
                });

                tocHTML += '</div>';
                if (validId > 0) { tocContainer.innerHTML = tocHTML; tocContainer.style.maxHeight = tocContainer.scrollHeight + "px"; }

                const btnShowAll = document.getElementById('btn-show-all');
                const mainChapterTitle = document.getElementById('main-chapter-title');

                document.querySelectorAll('.toc-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault(); const targetPageId = this.getAttribute('href').substring(1);
                        children.forEach(c => { c.classList.add('virtual-hidden'); c.classList.remove('page-active'); });
                        contentBox.querySelectorAll(`[data-virtual-page="${targetPageId}"]`).forEach(c => { c.classList.remove('virtual-hidden'); c.classList.add('page-active'); });
                        if(btnShowAll) btnShowAll.classList.remove('hidden'); if(mainChapterTitle) mainChapterTitle.classList.add('hidden');
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'bg-white/60', 'shadow-sm'));
                        this.classList.add('text-amarin', 'bg-white/60', 'shadow-sm');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                });

                if (btnShowAll) {
                    btnShowAll.addEventListener('click', () => {
                        children.forEach(c => { c.classList.remove('virtual-hidden', 'page-active'); });
                        btnShowAll.classList.add('hidden'); if(mainChapterTitle) mainChapterTitle.classList.remove('hidden');
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'bg-white/60', 'shadow-sm'));
                    });
                }
            }
        });
    </script>
</body>
</html>
