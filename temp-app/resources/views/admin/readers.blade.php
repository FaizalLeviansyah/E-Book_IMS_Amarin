@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="glass-panel p-4 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bolder text-slate-800 mb-1"><i class="fa-solid fa-chart-pie text-amarin me-2"></i> Statistik Akses Pembaca</h3>
            <p class="text-muted mb-0 text-sm">Pantau IP perangkat yang mengakses portal publik dan berikan label nama identitas kru.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-panel border-0 text-success fw-bold rounded-3 shadow-sm">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="glass-panel p-0 overflow-hidden bg-white/40">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50/80 text-slate-500 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <tr>
                        <th class="ps-4 py-3">IP Address</th>
                        <th>Device & Browser</th>
                        <th>Terakhir Akses</th>
                        <th width="30%">Identitas Pembaca (Admin Only)</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($readers as $reader)
                    <tr>
                        <td class="ps-4 fw-bold text-slate-700">{{ $reader->ip_address }}</td>
                        <td>
                            <span class="badge bg-blue-50 text-blue-600 border border-blue-200 me-2"><i class="fa-solid fa-laptop"></i> {{ $reader->device_name }}</span>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 150px;" title="{{ $reader->user_agent }}">{{ Str::limit($reader->user_agent, 30) }}</small>
                        </td>
                        <td><small class="fw-bold text-slate-600">{{ \Carbon\Carbon::parse($reader->last_accessed_at)->diffForHumans() }}</small></td>
                        <td class="pe-4">
                            <form action="{{ route('admin.readers.update', $reader->id) }}" method="POST" class="d-flex gap-2">
                                @csrf @method('PUT')
                                <input type="text" name="custom_name" class="form-control form-control-sm bg-white/70" value="{{ $reader->custom_name }}" placeholder="Contoh: Kru MT Soviana">
                                <button type="submit" class="btn btn-sm btn-amarin"><i class="fa-solid fa-save"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted fw-bold">Belum ada data kunjungan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
