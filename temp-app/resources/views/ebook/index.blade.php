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
        .dark .glass-panel { background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(14, 165, 233, 0.15); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5); }
        .glass-sidebar { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(24px); border-right: 1px solid rgba(255, 255, 255, 0.5); }
        .dark .glass-sidebar { background: rgba(8, 47, 73, 0.4); border-right: 1px solid rgba(14, 165, 233, 0.1); }
        #sepia-overlay { position: fixed; inset: 0; background-color: rgba(255, 190, 90, var(--sepia-level, 0)); pointer-events: none; z-index: 9999; mix-blend-mode: multiply; }
        html { scroll-behavior: smooth; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.3); border-radius: 10px; }
        .virtual-hidden { display: none !important; }

        #reader-content { font-family: "Inter", "Segoe UI", Roboto, sans-serif; font-size: 1.15rem; line-height: 1.9; color: #334155; }
        .dark #reader-content { color: #cbd5e1; }
        #reader-content p { margin-bottom: 1.75rem; text-align: justify; }
        #reader-content strong, #reader-content b { font-weight: 700 !important; color: #0f172a; }
        .dark #reader-content strong, .dark #reader-content b { color: #f8fafc; }
        #reader-content h1, #reader-content h2, #reader-content h3, #reader-content h4 { font-weight: 800 !important; color: #0369a1; margin-top: 3rem; margin-bottom: 1.5rem; line-height: 1.3; }
        .dark #reader-content h1, .dark #reader-content h2, .dark #reader-content h3, .dark #reader-content h4 { color: #38bdf8; }
        #reader-content h1 { font-size: 2.25rem; border-bottom: 2px solid rgba(14, 165, 233, 0.2); padding-bottom: 0.5rem; }
        #reader-content h2 { font-size: 1.85rem; border-bottom: 1px solid rgba(14, 165, 233, 0.1); padding-bottom: 0.5rem; }
        #reader-content ul { list-style-type: disc !important; padding-left: 2rem !important; margin-bottom: 2rem; }
        #reader-content table { width: 100% !important; table-layout: fixed; border-collapse: collapse !important; margin-top: 1.5rem; margin-bottom: 2.5rem; }
        #reader-content td { padding: 0.75rem 1rem 0.75rem 0 !important; vertical-align: top; border: none !important; }
        #reader-content th { background: rgba(14, 165, 233, 0.05); font-weight: 700 !important; text-align: left; padding: 1rem !important; border-bottom: 2px solid rgba(14, 165, 233, 0.2) !important; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .page-active { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="text-gray-800 dark:text-gray-200 transition-colors duration-300 antialiased overflow-x-hidden">

    <div id="sepia-overlay"></div>

    <nav class="fixed top-0 z-50 w-full glass-panel border-b border-transparent shadow-sm transition-all">
        <div class="px-4 py-3 lg:px-6 flex items-center justify-between">
            <div class="flex items-center justify-start shrink-0">
                <button id="sidebarToggleBtn" type="button" class="inline-flex items-center p-2 rounded-xl lg:hidden hover:bg-white/40 focus:ring-2 focus:ring-blue-200 transition-colors"><i class="fa-solid fa-bars text-xl text-amarin"></i></button>
                <a href="/" class="flex ms-2 items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg"><i class="fa-solid fa-anchor text-white text-lg"></i></div>
                    <span class="hidden sm:block text-xl md:text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-cyan-600">Amarin E-Book System</span>
                </a>
            </div>

            <div class="flex items-center space-x-3 ms-auto shrink-0">
                <div class="hidden lg:flex items-center gap-2 px-4 py-2 bg-blue-50/50 dark:bg-slate-800/50 border border-blue-200/50 rounded-2xl shadow-inner text-sm font-bold text-amarin">
                    <i class="fa-regular fa-clock fa-spin-pulse"></i><span id="realtime-clock">00:00:00 WIB</span>
                </div>
                <form action="/" method="GET" class="hidden md:flex">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-48 lg:w-64 p-2.5 pl-4 text-sm text-gray-900 border border-white/40 rounded-2xl bg-white/50 backdrop-blur-sm focus:ring-amarin focus:border-amarin transition-all" placeholder="Deep Search regulasi...">
                        <button type="submit" class="absolute top-0 end-0 p-2.5 h-full text-white bg-gradient-to-r from-cyan-500 to-blue-600 rounded-e-2xl hover:opacity-90"><i class="fa-solid fa-magnifying-glass px-2"></i></button>
                    </div>
                </form>
                <a href="/admin" class="p-2.5 bg-gradient-to-tr from-cyan-500 to-blue-600 text-white rounded-2xl hover:shadow-lg transition-all"><i class="fa-solid fa-shield-halved px-1"></i></a>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-[20rem] md:w-[24rem] h-screen pt-[5rem] transition-transform -translate-x-full lg:translate-x-0 glass-sidebar shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <div class="h-full px-4 md:px-5 pb-8 overflow-y-auto custom-scrollbar">

            <!-- BAGIAN BUKU / IMS -->
            <h5 class="text-[0.7rem] font-extrabold text-slate-500 uppercase tracking-widest mb-3 mt-2 px-1"><i class="fa-solid fa-book-open me-2"></i>Pustaka Manual</h5>
            <div id="accordion-container" class="space-y-3">
                @foreach($books as $book)
                <div class="bg-white/40 dark:bg-slate-800/40 rounded-2xl border border-white/50 overflow-hidden transition-all hover:bg-white/60">
                    <button type="button" class="accordion-btn flex items-center justify-between w-full p-3.5 text-left" data-target="accordion-body-{{ $book->id }}">
                        <div class="flex items-center gap-4">
                            @if($book->cover_image)
                                <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-12 h-16 object-cover rounded-xl shadow-sm shrink-0">
                            @else
                                <div class="w-12 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-50 flex items-center justify-center shrink-0 border border-white/50"><i class="fa-solid fa-book text-amarin text-lg"></i></div>
                            @endif
                            <div class="font-extrabold text-base text-gray-800 dark:text-gray-100 leading-tight">{{ $book->title }}</div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/50 flex items-center justify-center shrink-0 ms-2">
                            <i class="fa-solid fa-chevron-down text-amarin text-xs transition-transform duration-300 {{ (isset($activeBook) && $activeBook->id == $book->id) ? 'rotate-180' : '' }}"></i>
                        </div>
                    </button>

                    <div id="accordion-body-{{ $book->id }}" class="{{ (isset($activeBook) && $activeBook->id == $book->id) ? 'block' : 'hidden' }} px-3 pb-4">
                        @if($book->pdf_file)
                            <a href="?read_book={{ $book->id }}" class="flex items-center justify-center gap-2 p-2.5 mt-1 mx-1 text-xs text-red-500 rounded-xl bg-red-50/50 border border-red-100 font-bold shadow-sm hover:bg-red-100/50"><i class="fa-solid fa-file-pdf"></i> Lihat Dokumen Original (PDF)</a>
                        @endif

                        <div class="space-y-2 mt-4 px-1">
                            @foreach($book->parts as $part)
                                @php $isPartActive = isset($activeChapter) && $activeChapter->part_id == $part->id; @endphp
                                <div class="part-container mb-2">
                                    <!-- TOMBOL BUKA TUTUP LEVEL 2 (PART) -->
                                    <button type="button" class="part-accordion-btn flex items-center justify-between w-full px-3 py-2 bg-white/50 hover:bg-white/80 rounded-lg transition-colors border border-white/40 shadow-sm" data-target="part-body-{{ $part->id }}">
                                        <h6 class="text-[0.7rem] font-extrabold text-amarin/90 uppercase tracking-widest flex items-center gap-2 truncate"><i class="fa-solid fa-folder-open text-[0.6rem]"></i> {{ $part->title }}</h6>
                                        <i class="fa-solid fa-chevron-down text-[0.6rem] text-amarin/80 transition-transform duration-300 {{ $isPartActive ? 'rotate-180' : '' }}"></i>
                                    </button>

                                    <ul id="part-body-{{ $part->id }}" class="space-y-1 mt-1 {{ $isPartActive ? 'block' : 'hidden' }} pl-1 border-l-2 border-amarin/20 ml-4 py-1">
                                        @foreach($part->chapters as $chapter)
                                            <li>
                                                <!-- MENU LEVEL 3 (CHAPTER) DENGAN TOMBOL BUKA TUTUP LEVEL 4 (DYNAMIC TOC) -->
                                                <div class="flex items-center justify-between px-3 py-2 text-[0.85rem] rounded-xl transition-all {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'bg-white/80 shadow-sm border border-white/50' : 'hover:bg-white/40 font-medium' }}">
                                                    <a href="?read={{ $chapter->id }}" class="flex items-center flex-grow {{ (isset($activeChapter) && $activeChapter->id == $chapter->id) ? 'text-amarin font-bold' : 'text-gray-600 hover:text-amarin' }}">
                                                        <i class="fa-solid fa-file-lines text-[0.6rem] me-2 opacity-50"></i><span class="truncate">{{ $chapter->title }}</span>
                                                    </a>
                                                    @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                        <!-- TOMBOL BUKA TUTUP LEVEL 4 -->
                                                        <button type="button" class="ms-2 p-1 focus:outline-none" onclick="toggleToc()">
                                                            <i id="icon-toc-toggle" class="fa-solid fa-chevron-up text-[0.7rem] text-amarin bg-blue-50 w-5 h-5 rounded-full flex items-center justify-center transition-transform duration-300 shadow-inner"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                                <!-- LEVEL 4: DYNAMIC TOC -->
                                                @if(isset($activeChapter) && $activeChapter->id == $chapter->id)
                                                    <div id="dynamic-toc" class="mt-2 mb-3 space-y-1 border-l-2 border-amarin/20 ml-5 relative block transition-all duration-300 overflow-hidden"></div>
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

            <!-- BAGIAN KUMPULAN FORMULIR (TERPISAH DARI BUKU IMS) -->
            <div class="mt-8 border-t border-slate-200/50 pt-6">
                <h5 class="text-[0.7rem] font-extrabold text-rose-500 uppercase tracking-widest mb-3 px-1"><i class="fa-solid fa-file-signature me-2"></i>Formulir & Checklist</h5>
                <div class="space-y-2">
                    @foreach($allForms as $form)
                        <a href="?read_form={{ $form->id }}" class="flex items-center justify-between px-4 py-3 bg-white/50 hover:bg-white/90 rounded-xl transition-all border border-white/50 shadow-sm group {{ (isset($activeForm) && $activeForm->id == $form->id) ? 'border-rose-300 bg-rose-50' : '' }}">
                            <div class="flex items-center gap-3 truncate">
                                <div class="w-8 h-8 rounded-lg {{ $form->file_type == 'pdf' ? 'bg-red-100 text-red-500' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center shrink-0">
                                    <i class="fa-solid {{ $form->file_type == 'pdf' ? 'fa-file-pdf' : 'fa-file-word' }}"></i>
                                </div>
                                <div class="flex flex-col truncate">
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-rose-600 truncate">{{ $form->title }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $form->book->title ?? 'Umum' }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </aside>

    <div class="p-0 lg:ml-[24rem] mt-[5rem] min-h-screen relative z-10 transition-all duration-300">
        <div class="px-4 py-8 sm:px-8 sm:py-10 md:px-14 md:py-14 w-full max-w-none mx-auto">

            @if(isset($searchResults))
                <!-- HASIL PENCARIAN DEEP SEARCH (LEVEL 4) -->
                <div class="glass-panel rounded-3xl p-6 sm:p-8 md:p-12 border-t border-white/60">
                    <h4 class="text-2xl sm:text-3xl font-bold mb-8 text-gray-900 border-b border-gray-200 pb-5 flex items-center"><i class="fa-solid fa-magnifying-glass me-3 text-amarin"></i> Hasil Deep Search: "{{ request('search') }}"</h4>
                    @if($searchResults->isEmpty())
                        <div class="p-8 text-lg font-medium text-gray-500 bg-white/50 rounded-2xl text-center"><i class="fa-solid fa-triangle-exclamation text-3xl mb-3 block"></i>Tidak ada kecocokan dokumen.</div>
                    @else
                        <ul class="space-y-5">
                            @foreach($searchResults as $result)
                                <li>
                                    <a href="?read={{ $result->id }}&search={{ request('search') }}" class="block p-5 sm:p-6 bg-white/60 border border-white/50 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all group">
                                        <h5 class="mb-2 text-xl font-bold text-amarin group-hover:text-blue-600 transition-colors">{{ $result->title }}</h5>
                                        <p class="text-xs sm:text-sm text-gray-500 font-bold mb-3 uppercase tracking-wider flex items-center gap-2"><i class="fa-solid fa-folder-open"></i> {{ $result->part->title ?? 'Bab Umum' }}</p>
                                        <div class="text-sm text-gray-600 font-medium bg-white/50 p-4 rounded-xl border border-slate-200/50 shadow-inner">
                                            <i class="fa-solid fa-quote-left text-amarin/30 text-lg float-left me-2"></i> {!! Str::limit(strip_tags($result->content), 180, '...') !!}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            @elseif(isset($activeChapter))
                <div class="glass-panel rounded-3xl p-6 sm:p-10 md:p-14 border-t border-white/60 shadow-[0_10px_40px_-10px_rgba(14,165,233,0.1)]">
                    <button id="btn-show-all" class="hidden mb-8 text-sm font-bold text-white bg-gradient-to-r from-slate-800 to-slate-700 px-6 py-3 rounded-2xl transition-all shadow-lg w-full sm:w-auto text-center"><i class="fa-solid fa-book-open me-2 text-amarin"></i> Tampilkan Seluruh Modul</button>
                    <div id="main-chapter-title" class="mb-12">
                        <div class="inline-flex flex-wrap items-center gap-2 px-4 py-2 bg-blue-50/50 rounded-xl border border-blue-100/50 mb-6 text-xs sm:text-sm font-bold text-amarin"><span class="truncate">{{ $activeBook->title }}</span><i class="fa-solid fa-chevron-right text-[0.6rem] opacity-50"></i><span class="truncate">{{ $activeChapter->part->title }}</span></div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $activeChapter->title }}</h1>
                    </div>
                    <div id="reader-content">{!! $activeChapter->content !!}</div>
                </div>

            @elseif(isset($activeForm))
                <!-- TAMPILAN MENTAHAN WORD / PDF (SEBELAH KANAN) -->
                <div class="glass-panel rounded-3xl p-6 md:p-10 shadow-xl border border-white/60">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-200 pb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-inner {{ $activeForm->file_type == 'pdf' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                <i class="fa-solid {{ $activeForm->file_type == 'pdf' ? 'fa-file-pdf' : 'fa-file-word' }} text-3xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-extrabold text-slate-900">{{ $activeForm->title }}</h1>
                                <p class="text-sm text-slate-500 font-medium uppercase tracking-widest mt-1">Dokumen Lampiran (Formulir)</p>
                            </div>
                        </div>
                        <a href="{{ asset('uploads/forms/' . $activeForm->file_path) }}" download class="w-full md:w-auto text-white bg-gradient-to-r from-cyan-500 to-blue-600 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-lg hover:-translate-y-1 text-center flex items-center justify-center gap-2">
                            <i class="fa-solid fa-download"></i> Unduh File Mentahan
                        </a>
                    </div>

                    @if($activeForm->file_type == 'pdf')
                        <iframe src="{{ asset('uploads/forms/' . $activeForm->file_path) }}" class="w-full h-[70vh] rounded-2xl border border-slate-200 shadow-inner bg-slate-50"></iframe>
                    @else
                        <!-- TAMPILAN KHUSUS JIKA FILE MS. WORD -->
                        <div class="text-center py-16 bg-white/50 rounded-2xl border-2 border-dashed border-blue-200">
                            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <i class="fa-solid fa-file-word text-5xl text-blue-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-3">Dokumen Microsoft Word</h3>
                            <p class="text-slate-500 mb-8 max-w-lg mx-auto">File formulir berformat Word (.doc / .docx) harus diunduh ke komputer Anda untuk dapat diisi dan dicetak.</p>
                            <a href="{{ asset('uploads/forms/' . $activeForm->file_path) }}" download class="btn bg-white border border-slate-300 shadow-sm px-8 py-3 rounded-xl font-bold text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                <i class="fa-solid fa-download me-2"></i> Unduh Dokumen Sekarang
                            </a>
                        </div>
                    @endif
                </div>

            @elseif(isset($activeBook) && $activeBook->pdf_file)
                <div class="glass-panel rounded-3xl p-4 md:p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center text-lg text-slate-800 font-bold w-full md:w-auto"><div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center me-4 shadow-sm border border-red-100"><i class="fa-solid fa-file-pdf text-2xl"></i></div><span class="truncate">{{ $activeBook->title }}</span></div>
                    <a href="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" target="_blank" class="w-full md:w-auto text-white bg-gradient-to-r from-red-500 to-rose-600 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-lg text-center whitespace-nowrap">Buka Layar Penuh <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></a>
                </div>
                <iframe src="{{ asset('uploads/books/' . $activeBook->pdf_file) }}" class="w-full h-[80vh] rounded-3xl border border-white/50 shadow-xl glass-panel"></iframe>

            @else
                <!-- DASHBOARD HOMEPAGE: FULL WIDGETS -->
                <div class="w-full max-w-7xl mx-auto">
                    <div class="glass-panel rounded-[2rem] p-6 sm:p-10 mb-10 flex flex-col md:flex-row items-center gap-6 md:gap-10 border-t border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full sm:rounded-[2.5rem] flex items-center justify-center shadow-xl shadow-blue-500/30 shrink-0 relative overflow-hidden"><div class="absolute inset-0 bg-white/20 blur-md"></div><i class="fa-solid fa-ship text-white text-5xl sm:text-6xl relative z-10 drop-shadow-md"></i></div>
                        <div class="text-center md:text-left"><h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight drop-shadow-sm">Amarin Fleet <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">IMS</span></h1><p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed font-medium">Platform digitalisasi prosedur operasional dan keselamatan. Pilih Pustaka Induk di bawah ini untuk memonitor rincian bagian dan mengakses panduan.</p></div>
                    </div>
                    <div class="flex items-center gap-3 mb-6 px-2"><div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-amarin shadow-inner shrink-0"><i class="fa-solid fa-book-bookmark text-xl"></i></div><h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Pustaka & Monitoring Dokumen</h2></div>

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 md:gap-8 pb-12">
                        @foreach($books as $book)
                            <div class="glass-panel rounded-[2rem] p-5 sm:p-8 border border-white/50 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 flex flex-col h-full group">
                                <div class="flex flex-col sm:flex-row gap-6 mb-6">
                                    @if($book->cover_image)
                                        <img src="{{ asset('uploads/books/' . $book->cover_image) }}" class="w-32 h-44 sm:w-36 sm:h-48 object-cover rounded-2xl shadow-lg border border-white/50 shrink-0 mx-auto sm:mx-0 group-hover:-translate-y-1 transition-transform duration-300">
                                    @else
                                        <div class="w-32 h-44 sm:w-36 sm:h-48 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex flex-col items-center justify-center shrink-0 border border-white/50 shadow-lg mx-auto sm:mx-0 group-hover:-translate-y-1 transition-transform duration-300"><i class="fa-solid fa-book text-slate-300 text-5xl mb-2"></i><span class="text-[10px] font-bold text-slate-400">NO COVER</span></div>
                                    @endif
                                    <div class="flex flex-col flex-grow text-center sm:text-left">
                                        <h3 class="text-xl sm:text-2xl font-bold text-slate-800 mb-3 leading-tight">{{ $book->title }}</h3>
                                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-4">
                                            <span class="bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-lg"><i class="fa-solid fa-folder-tree me-1"></i> {{ $book->parts->count() }} Bagian</span>
                                            <span class="bg-cyan-50 border border-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1.5 rounded-lg"><i class="fa-solid fa-file-lines me-1"></i> {{ $book->parts->flatMap->chapters->count() }} Sub-bab</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // FUNGSI TOGGLE ACCORDION LEVEL 4 (DYNAMIC TOC)
        function toggleToc() {
            const toc = document.getElementById('dynamic-toc');
            const icon = document.getElementById('icon-toc-toggle');
            if (toc.style.maxHeight && toc.style.maxHeight !== '0px') {
                toc.style.maxHeight = '0px';
                icon.classList.remove('rotate-180');
            } else {
                toc.style.maxHeight = toc.scrollHeight + "px";
                icon.classList.add('rotate-180');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {

            function updateClock() {
                const now = new Date();
                const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
                const timeString = now.toLocaleTimeString('id-ID', options) + ' WIB';
                const clockEl = document.getElementById('realtime-clock');
                if(clockEl) clockEl.innerText = timeString;
            }
            setInterval(updateClock, 1000); updateClock();

            const partAccordionBtns = document.querySelectorAll('.part-accordion-btn');
            partAccordionBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    const targetBody = document.getElementById(targetId);
                    const icon = btn.querySelector('i.fa-chevron-down');
                    if (targetBody.classList.contains('hidden')) {
                        targetBody.classList.remove('hidden'); targetBody.classList.add('block');
                        if(icon) icon.classList.add('rotate-180');
                    } else {
                        targetBody.classList.add('hidden'); targetBody.classList.remove('block');
                        if(icon) icon.classList.remove('rotate-180');
                    }
                });
            });

            const accordionBtns = document.querySelectorAll('.accordion-btn');
            accordionBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    const targetBody = document.getElementById(targetId);
                    const icon = btn.querySelector('i.fa-chevron-down');
                    if (targetBody.classList.contains('hidden')) {
                        targetBody.classList.remove('hidden'); targetBody.classList.add('block'); if(icon) icon.classList.add('rotate-180');
                    } else {
                        targetBody.classList.add('hidden'); targetBody.classList.remove('block'); if(icon) icon.classList.remove('rotate-180');
                    }
                });
            });

            const dropdownBtn = document.getElementById('dropdownDefaultButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownMenu.classList.toggle('hidden'); });
                document.addEventListener('click', () => { dropdownMenu.classList.add('hidden'); });
            }

            const sidebarBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('logo-sidebar');
            if (sidebarBtn && sidebar) {
                sidebarBtn.addEventListener('click', (e) => { e.stopPropagation(); sidebar.classList.toggle('-translate-x-full'); });
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

            // ENGINE VIRTUAL PAGE LEVEL 4
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
                                    level = 3 + (match[1].split('.').length - 1);
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
                                let textClass = 'text-slate-600 hover:text-amarin';
                                let dotIndicator = '';

                                if (level === 1) { paddingClass = 'pl-2 mt-4'; textClass = 'text-slate-900 font-extrabold uppercase text-[0.75rem] tracking-widest'; }
                                else if (level === 2) { paddingClass = 'pl-3 mt-2'; textClass = 'text-slate-800 font-bold text-[0.85rem]'; }
                                else if (level === 3) { paddingClass = 'pl-5 mt-1'; textClass = 'text-slate-700 font-semibold text-[0.85rem]'; }
                                else { paddingClass = 'pl-8 relative'; textClass = 'text-slate-500 font-medium text-[0.85rem]'; dotIndicator = '<div class="absolute left-4 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-amarin transition-colors"></div>'; }

                                tocHTML += `<a href="#${currentSectionId}" class="toc-link block py-2 transition-all w-full truncate rounded-xl hover:bg-white/50 group ${paddingClass} ${textClass}" title="${text}">${dotIndicator} ${text}</a>`;
                            }
                        });
                    }
                    child.setAttribute('data-virtual-page', currentSectionId);
                });

                tocHTML += '</div>';
                if (validId > 0) {
                    tocContainer.innerHTML = tocHTML;
                    tocContainer.style.maxHeight = tocContainer.scrollHeight + "px"; // Auto open initially
                }

                const btnShowAll = document.getElementById('btn-show-all');
                const mainChapterTitle = document.getElementById('main-chapter-title');

                document.querySelectorAll('.toc-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetPageId = this.getAttribute('href').substring(1);

                        children.forEach(c => { c.classList.add('virtual-hidden'); c.classList.remove('page-active'); });
                        contentBox.querySelectorAll(`[data-virtual-page="${targetPageId}"]`).forEach(c => { c.classList.remove('virtual-hidden'); c.classList.add('page-active'); });

                        btnShowAll.classList.remove('hidden');
                        if(mainChapterTitle) mainChapterTitle.classList.add('hidden');

                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'bg-white/60', 'shadow-sm'));
                        this.classList.add('text-amarin', 'bg-white/60', 'shadow-sm');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                });

                if (btnShowAll) {
                    btnShowAll.addEventListener('click', () => {
                        children.forEach(c => { c.classList.remove('virtual-hidden', 'page-active'); });
                        btnShowAll.classList.add('hidden');
                        if(mainChapterTitle) mainChapterTitle.classList.remove('hidden');
                        document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('text-amarin', 'bg-white/60', 'shadow-sm'));
                    });
                }
            }
        });
    </script>
</body>
</html>
