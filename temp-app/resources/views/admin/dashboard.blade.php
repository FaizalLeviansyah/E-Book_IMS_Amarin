<!-- Menggunakan cetakan layouts/admin.blade.php -->
@extends('layouts.admin')

<!-- Memasukkan konten ke dalam @yield('content') -->
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark">Dashboard Eksekutif</h3>
            <p class="text-muted">Kelola struktur materi dokumen IMS di sini.</p>
        </div>
    </div>

    <!-- Kotak Info (Cards) -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white p-3 rounded me-3">
                        <i class="fa-solid fa-folder fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Total Bagian (Part)</h6>
                        <h3 class="mb-0 fw-bold">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info text-white p-3 rounded me-3">
                        <i class="fa-solid fa-file-lines fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Total Bab (Chapter)</h6>
                        <h3 class="mb-0 fw-bold">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white p-3 rounded me-3">
                        <i class="fa-solid fa-list-check fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted">Total Sub-Bab</h6>
                        <h3 class="mb-0 fw-bold">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
