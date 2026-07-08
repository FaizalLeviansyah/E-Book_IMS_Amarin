@extends('layouts.admin')

@section('content')

<!-- Header Welcome Card -->
<div class="glass-panel p-8 md:p-12 mb-8 relative overflow-hidden flex flex-col md:flex-row items-center gap-8 border-t-2 border-white">
    <!-- Ornamen Lingkaran Bercahaya di Belakang -->
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-cyan-300 to-blue-400 rounded-full blur-[60px] opacity-30 pointer-events-none"></div>

    <div class="w-32 h-32 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-[2rem] flex items-center justify-center shadow-xl shadow-blue-500/30 shrink-0 relative z-10">
        <i class="fa-solid fa-laptop-code text-white text-5xl"></i>
    </div>

    <div class="text-center md:text-left relative z-10">
        <h1 class="text-4xl font-extrabold text-slate-800 mb-3 tracking-tight">Selamat Datang di Workspace!</h1>
        <p class="text-slate-500 text-lg max-w-2xl leading-relaxed">
            Ini adalah pusat kendali digitalisasi dokumen, panduan keselamatan, dan prosedur operasional armada <b>PT Amarin Ship Management</b>.
        </p>
    </div>
</div>

<h3 class="text-xl font-bold text-slate-700 mb-4 px-2"><i class="fa-solid fa-bolt text-amber-500 me-2"></i> Akses Cepat</h3>

<div class="row g-5">
    <!-- WIDGET 1: Kelola Pustaka -->
    <div class="col-md-6 col-lg-4">
        <a href="/admin/books" class="text-decoration-none block h-100">
            <div class="glass-panel p-8 h-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl group relative overflow-hidden border-b-4 border-amarin">
                <!-- Ornamen Hover -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -z-10 transition-transform duration-500 group-hover:scale-125"></div>

                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-blue-100 mb-6 text-amarin text-3xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">Kelola Pustaka</h3>
                <p class="text-slate-500 text-base mb-6">Akses pustaka utama untuk menambah, mengedit, mengimpor Word, dan mengatur susunan bab dokumen.</p>
                <div class="mt-auto flex items-center text-amarin font-bold text-sm bg-blue-50 py-2 px-4 rounded-lg w-fit">
                    Mulai Mengelola <i class="fa-solid fa-arrow-right ms-2 transition-transform group-hover:translate-x-2"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- WIDGET 2: Panduan Admin (Visual Placeholder) -->
    <div class="col-md-6 col-lg-4">
        <div class="glass-panel p-8 h-100 opacity-80 cursor-default">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center border border-slate-200 mb-6 text-slate-400 text-3xl">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-700 mb-3">Manajemen User</h3>
            <p class="text-slate-500 text-base">Fitur untuk mengatur hak akses kru kapal dan kredensial administrator.</p>
            <div class="mt-6 flex items-center text-slate-400 font-bold text-sm bg-slate-100 py-2 px-4 rounded-lg w-fit">
                <i class="fa-solid fa-lock me-2"></i> Segera Hadir
            </div>
        </div>
    </div>

    <!-- WIDGET 3: Statistik (Visual Placeholder) -->
    <div class="col-md-6 col-lg-4">
        <div class="glass-panel p-8 h-100 opacity-80 cursor-default">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center border border-slate-200 mb-6 text-slate-400 text-3xl">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-700 mb-3">Statistik Baca</h3>
            <p class="text-slate-500 text-base">Pantau analitik modul prosedur operasional mana yang paling sering diakses oleh kru.</p>
            <div class="mt-6 flex items-center text-slate-400 font-bold text-sm bg-slate-100 py-2 px-4 rounded-lg w-fit">
                <i class="fa-solid fa-lock me-2"></i> Segera Hadir
            </div>
        </div>
    </div>
</div>

@endsection
