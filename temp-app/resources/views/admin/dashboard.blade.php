@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <!-- Welcome Banner (Modern Glassmorphism) -->
    <div class="p-5 mb-5 rounded-[2rem] shadow-sm border border-white/80 relative overflow-hidden transition-all hover:shadow-md" style="background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(224,242,254,0.5) 100%); backdrop-filter: blur(20px);">
        <!-- Decorative Background Glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-gradient-to-bl from-cyan-300/40 to-blue-500/20 rounded-full blur-[60px] pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-gradient-to-tr from-blue-300/30 to-transparent rounded-full blur-[50px] pointer-events-none"></div>

        <div class="d-flex align-items-center gap-4 relative z-10">
            <div class="w-20 h-20 rounded-[1.25rem] bg-gradient-to-tr from-cyan-500 to-blue-600 d-flex align-items-center justify-content-center shadow-[0_10px_20px_-5px_rgba(14,165,233,0.4)] shrink-0 transition-transform hover:scale-105">
                <i class="fa-solid fa-laptop-code text-white text-3xl"></i>
            </div>
            <div>
                <h2 class="fw-black text-slate-800 mb-1 tracking-tight" style="font-size: 1.8rem;">Selamat Datang di Workspace!</h2>
                <p class="text-slate-600 mb-0 font-medium" style="font-size: 0.95rem;">Pusat kendali digitalisasi dokumen, panduan keselamatan, dan prosedur operasional armada <span class="fw-bold text-amarin">PT Amarin Ship Management</span>.</p>
            </div>
        </div>
    </div>

    <h5 class="fw-bold text-slate-700 mb-4 d-flex align-items-center gap-2"><i class="fa-solid fa-layer-group text-amarin"></i> Menu Navigasi Cepat</h5>

    <div class="row g-4">
        <!-- Card 1: Kelola Pustaka (Blue Theme) -->
        <div class="col-md-4">
            <div class="card h-100 border border-white/60 rounded-[1.5rem] shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white/60 backdrop-blur-md overflow-hidden group">
                <!-- Top Color Accent -->
                <div class="h-1.5 w-full bg-gradient-to-r from-cyan-400 to-blue-500"></div>

                <div class="card-body p-4 d-flex flex-column">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 d-flex align-items-center justify-content-center mb-4 shadow-inner transition-transform duration-300 group-hover:scale-110">
                        <i class="fa-solid fa-book-open-reader text-2xl"></i>
                    </div>
                    <h5 class="fw-bolder text-slate-800 mb-2">Kelola Pustaka</h5>
                    <p class="text-slate-500 text-sm mb-4 font-medium leading-relaxed">Pustaka utama untuk menambah, mengedit teks, mengimpor Word, dan mengatur susunan bab.</p>

                    <a href="/admin/books" class="btn bg-gradient-to-r from-cyan-500 to-blue-600 text-white border-0 w-100 rounded-xl fw-bold mt-auto py-2.5 shadow-md hover:shadow-lg transition-all">
                        Mulai Mengelola <i class="fa-solid fa-arrow-right ms-2 text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Manajemen Admin (Indigo Theme) -->
        <div class="col-md-4">
            <div class="card h-100 border border-white/60 rounded-[1.5rem] shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white/60 backdrop-blur-md overflow-hidden group">
                <!-- Top Color Accent -->
                <div class="h-1.5 w-full bg-gradient-to-r from-indigo-400 to-violet-500"></div>

                <div class="card-body p-4 d-flex flex-column">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 d-flex align-items-center justify-content-center mb-4 shadow-inner transition-transform duration-300 group-hover:scale-110">
                        <i class="fa-solid fa-users-gear text-2xl"></i>
                    </div>
                    <h5 class="fw-bolder text-slate-800 mb-2">Manajemen Admin</h5>
                    <p class="text-slate-500 text-sm mb-4 font-medium leading-relaxed">Pengaturan pembuatan akun dan kredensial akses untuk rekan administrator sistem.</p>

                    <a href="/admin/users" class="btn bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 w-100 rounded-xl fw-bold mt-auto py-2.5 transition-colors">
                        Kelola Admin <i class="fa-solid fa-arrow-right ms-2 text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Statistik Akses (Emerald Theme) -->
        <div class="col-md-4">
            <div class="card h-100 border border-white/60 rounded-[1.5rem] shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white/60 backdrop-blur-md overflow-hidden group">
                <!-- Top Color Accent -->
                <div class="h-1.5 w-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>

                <div class="card-body p-4 d-flex flex-column">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 d-flex align-items-center justify-content-center mb-4 shadow-inner transition-transform duration-300 group-hover:scale-110">
                        <i class="fa-solid fa-satellite-dish text-2xl"></i>
                    </div>
                    <h5 class="fw-bolder text-slate-800 mb-2">Statistik Akses</h5>
                    <p class="text-slate-500 text-sm mb-4 font-medium leading-relaxed">Pantau IP perangkat kru yang membaca portal dan berikan label nama identitas armada.</p>

                    <a href="/admin/readers" class="btn bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 w-100 rounded-xl fw-bold mt-auto py-2.5 transition-colors">
                        Lihat Statistik <i class="fa-solid fa-arrow-right ms-2 text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
