@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="glass-panel p-5 mb-6 d-flex justify-content-between align-items-center rounded-4 shadow-sm border border-white/50">
        <div>
            <h3 class="fw-bolder text-slate-800 mb-1"><i class="fa-solid fa-users-gear text-amarin me-2"></i> Manajemen Admin</h3>
            <p class="text-muted mb-0 text-sm">Kelola akun administrator dan tentukan tingkat hak akses sistem e-book.</p>
        </div>
        <button type="button" class="btn btn-amarin px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fa-solid fa-user-plus me-2"></i> Tambah Admin
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-panel border-0 text-success fw-bold rounded-3 shadow-sm mb-4">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="glass-panel p-0 overflow-hidden rounded-4 border border-white/50 shadow-sm bg-white/40">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50/80 text-slate-500 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <tr>
                        <th class="ps-5 py-4" width="30%">Nama & Email</th>
                        <th width="50%">Role / Hak Akses</th>
                        <th class="text-end pe-5" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($users as $user)
                    <tr class="transition-all hover:bg-white/60">
                        <td class="ps-5 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($user->profile_photo && file_exists(public_path('uploads/profiles/' . $user->profile_photo)))
                                    <img src="{{ asset('uploads/profiles/' . $user->profile_photo) }}" class="w-10 h-10 rounded-circle object-fit-cover shadow-sm border border-white">
                                @else
                                    <div class="w-10 h-10 rounded-circle bg-gradient-to-tr from-cyan-400 to-blue-500 text-white d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-muted text-xs">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->hasRole('super-admin'))
                                <span class="badge bg-purple-100 text-purple-700 border border-purple-200 px-3 py-1.5 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-shield-halved me-1"></i> Super Administrator
                                </span>
                            @else
                                <span class="badge bg-blue-100 text-blue-600 border border-blue-200 px-3 py-1.5 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-user-shield me-1"></i> Administrator
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-5">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-light border text-primary shadow-sm hover:bg-blue-50 transition-colors" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Edit Admin">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini dari sistem?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger shadow-sm hover:bg-red-50 transition-colors" title="Hapus Admin">
                                        <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted fw-bold">Belum ada administrator terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================================================= -->
<!-- SEMUA MODAL DILETAKKAN DI LUAR KONTAINER TABEL    -->
<!-- ================================================= -->

<!-- Modal Perulangan Edit Admin -->
@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-panel border-0 rounded-4 overflow-hidden shadow-2xl bg-white">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header border-bottom bg-slate-50 px-4 py-3">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-user-pen me-2"></i> Edit Data Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Nama Lengkap</label>
                        <input type="text" class="form-control bg-white border-slate-200" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Alamat Email</label>
                        <input type="email" class="form-control bg-white border-slate-200" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Level Hak Akses (Role)</label>
                        <select name="role" class="form-select bg-white border-slate-200" required>
                            <option value="super-admin" {{ $user->hasRole('super-admin') ? 'selected' : '' }}>Super Administrator (Akses Penuh)</option>
                            <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Administrator (Tanpa Pengaturan Sistem)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Password Baru (Opsional)</label>
                        <input type="password" class="form-control bg-white border-slate-200" name="password" minlength="8" placeholder="Kosongkan jika tidak ingin diubah">
                    </div>
                </div>
                <div class="modal-footer border-top bg-slate-50 px-4 py-3">
                    <button type="button" class="btn btn-light border shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-amarin px-4 shadow-sm"><i class="fa-solid fa-save me-2"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Admin -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-panel border-0 rounded-4 overflow-hidden shadow-2xl bg-white">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom bg-slate-50 px-4 py-3">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-user-plus me-2"></i> Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Nama Lengkap</label>
                        <input type="text" class="form-control bg-white border-slate-200" name="name" required placeholder="Masukkan nama admin...">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Alamat Email</label>
                        <input type="email" class="form-control bg-white border-slate-200" name="email" required placeholder="email@amarin.co.id">
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Level Hak Akses (Role)</label>
                        <select name="role" class="form-select bg-white border-slate-200" required>
                            <option value="admin" selected>Administrator (Tanpa Pengaturan Sistem)</option>
                            <option value="super-admin">Super Administrator (Akses Penuh)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-slate-700 mb-1 text-sm">Password Akun</label>
                        <input type="password" class="form-control bg-white border-slate-200" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                    </div>
                </div>
                <div class="modal-footer border-top bg-slate-50 px-4 py-3">
                    <button type="button" class="btn btn-light border shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-amarin px-4 shadow-sm"><i class="fa-solid fa-save me-2"></i> Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
