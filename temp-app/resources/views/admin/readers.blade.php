@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="glass-panel p-4 mb-4 rounded-4 shadow-sm border border-white/50 bg-gradient-to-r from-emerald-50 to-teal-50 d-flex align-items-center gap-3">
        <div class="w-12 h-12 rounded-3 bg-emerald-500 text-white d-flex align-items-center justify-content-center shadow-md shrink-0">
            <i class="fa-solid fa-satellite-dish text-xl"></i>
        </div>
        <div>
            <h3 class="fw-black text-slate-800 mb-1 tracking-tight text-xl">Statistik Akses Pembaca</h3>
            <p class="text-slate-600 mb-0 text-sm font-medium">Pantau lalu lintas kunjungan, jenis perangkat, dan identifikasi IP kru kapal.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-panel border-0 text-success fw-bold rounded-3 shadow-sm">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="glass-panel p-0 overflow-hidden rounded-4 border border-white/50 shadow-sm bg-white/60 backdrop-blur-md">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-100/50 text-slate-500 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
                    <tr>
                        <th class="ps-4 py-3" width="15%">IP Address</th>
                        <th width="35%">Informasi Perangkat (OS & Browser)</th>
                        <th width="15%">Akses Terakhir</th>
                        <th width="35%">Label Identitas (Custom)</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($readers as $reader)
                    <tr class="transition-all hover:bg-white/80">
                        <td class="ps-4">
                            <span class="fw-bold text-slate-700 font-monospace">{{ $reader->ip_address }}</span>
                        </td>
                        <td>
                            @php
                                // Memecah string data "Tipe|OS|Browser"
                                $deviceData = explode('|', $reader->device_name);
                                $type = $deviceData[0] ?? 'Unknown';
                                $os = $deviceData[1] ?? 'Unknown OS';
                                $browser = $deviceData[2] ?? 'Unknown Browser';

                                // Set Icon berdasarkan tipe
                                $icon = 'fa-laptop';
                                if($type == 'Smartphone') $icon = 'fa-mobile-screen-button';
                                if($type == 'Tablet') $icon = 'fa-tablet-screen-button';
                            @endphp

                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-100 px-2 py-1 rounded shadow-sm d-flex align-items-center gap-1">
                                    <i class="fa-solid {{ $icon }}"></i> {{ $type }}
                                </span>
                                <span class="badge bg-slate-100 text-slate-700 border border-slate-200 px-2 py-1 rounded shadow-sm d-flex align-items-center gap-1">
                                    <i class="fa-brands fa-windows"></i> {{ $os }} <!-- Icon statis sbg dekorasi -->
                                </span>
                                <span class="badge bg-blue-50 text-blue-700 border border-blue-100 px-2 py-1 rounded shadow-sm d-flex align-items-center gap-1">
                                    <i class="fa-brands fa-chrome"></i> {{ $browser }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-slate-700 text-sm">{{ \Carbon\Carbon::parse($reader->last_accessed_at)->diffForHumans() }}</span>
                                <small class="text-slate-400 text-[10px]">{{ \Carbon\Carbon::parse($reader->last_accessed_at)->format('d M Y, H:i') }}</small>
                            </div>
                        </td>
                        <td class="pe-4">
                            <form action="{{ route('admin.readers.update', $reader->id) }}" method="POST" class="d-flex gap-2">
                                @csrf @method('PUT')
                                <input type="text" name="custom_name" class="form-control form-control-sm bg-white/70 border-slate-200 shadow-inner" value="{{ $reader->custom_name }}" placeholder="Contoh: Kru MT Soviana (Budi)">
                                <button type="submit" class="btn btn-sm btn-amarin px-3 shadow-sm hover:-translate-y-0.5 transition-transform" title="Simpan Identitas">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted fw-bold"><i class="fa-solid fa-ghost text-4xl mb-3 block text-slate-300"></i>Belum ada data kunjungan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
