@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="glass-panel p-5 mb-6 d-flex justify-content-between align-items-center rounded-4 shadow-sm border border-white/50">
        <div>
            <h3 class="fw-bolder text-slate-800 mb-1"><i class="fa-solid fa-users-gear text-amarin me-2"></i> Manajemen Pengguna</h3>
            <p class="text-muted mb-0 text-sm">Kelola akun kru dan atur otorisasi akses dokumen per armada.</p>
        </div>
        <button type="button" class="btn btn-amarin px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success glass-panel border-0 text-success fw-bold rounded-3 shadow-sm">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="glass-panel p-0 overflow-hidden rounded-4 border border-white/50 shadow-sm bg-white/40">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50/80 text-slate-500 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <tr>
                        <th class="ps-5 py-4" width="25%">Nama & Email</th>
                        <th width="15%">Role</th>
                        <th width="40%">Akses Armada (Permissions)</th>
                        <th class="text-end pe-5" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($users as $user)
                    <tr class="transition-all hover:bg-white/60">
                        <td class="ps-5 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-10 h-10 rounded-circle bg-gradient-to-tr from-cyan-400 to-blue-500 text-white d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-muted text-xs">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge {{ $role->name == 'super-admin' ? 'bg-rose-100 text-rose-600 border-rose-200' : 'bg-blue-100 text-blue-600 border-blue-200' }} border px-2 py-1 rounded-2">
                                    <i class="fa-solid {{ $role->name == 'super-admin' ? 'fa-shield-halved' : 'fa-user-tie' }} me-1"></i>
                                    {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @if($user->hasRole('super-admin'))
                                    <span class="badge bg-slate-100 text-slate-600 border border-slate-200 px-2 py-1"><i class="fa-solid fa-globe me-1"></i> Full Access</span>
                                @else
                                    @forelse($user->permissions as $permission)
                                        <span class="badge bg-cyan-50 text-cyan-700 border border-cyan-100 px-2 py-1"><i class="fa-solid fa-ship me-1"></i> {{ str_replace('access-', '', $permission->name) }}</span>
                                    @empty
                                        <span class="text-muted text-xs fst-italic">Belum ada otorisasi kapal</span>
                                    @endforelse
                                @endif
                            </div>
                        </td>
                        <td class="text-end pe-5">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border text-danger shadow-sm hover:bg-red-50 transition-colors" title="Hapus Pengguna">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted fw-bold">Belum ada pengguna terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content glass-panel border-0 rounded-4 overflow-hidden">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom border-light bg-white/50 px-4 py-3">
                    <h5 class="modal-title fw-bold text-amarin"><i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4 bg-white/30">
                    <div class="row g-4">
                        <!-- Informasi Dasar -->
                        <div class="col-md-6">
                            <h6 class="text-xs fw-bolder text-slate-400 text-uppercase tracking-widest mb-3">Informasi Akun</h6>

                            <div class="mb-3">
                                <label class="fw-bold text-slate-700 mb-1 text-sm">Nama Lengkap</label>
                                <input type="text" class="form-control bg-white/70 border-slate-200" name="name" required placeholder="Masukkan nama kru">
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-slate-700 mb-1 text-sm">Email</label>
                                <input type="email" class="form-control bg-white/70 border-slate-200" name="email" required placeholder="email@amarin.co.id">
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-slate-700 mb-1 text-sm">Password</label>
                                <input type="password" class="form-control bg-white/70 border-slate-200" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold text-slate-700 mb-1 text-sm">Role Pengguna</label>
                                <select name="role" class="form-select bg-white/70 border-slate-200" required>
                                    <option value="" disabled selected>Pilih Role...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucwords(str_replace('-', ' ', $role->name)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Otorisasi Akses Kapal -->
                        <div class="col-md-6">
                            <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-3 h-100">
                                <h6 class="text-xs fw-bolder text-amarin text-uppercase tracking-widest mb-3"><i class="fa-solid fa-shield-check me-1"></i> Otorisasi Akses Armada</h6>
                                <p class="text-xs text-slate-500 mb-3">Centang armada kapal yang diizinkan untuk diakses oleh kru ini (Abaikan jika role adalah Super Admin).</p>

                                <div class="space-y-2 mt-2">
                                    @foreach($permissions as $permission)
                                        @if(str_contains($permission->name, 'access-mt-'))
                                            <div class="form-check custom-checkbox mb-2">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                                <label class="form-check-label fw-medium text-slate-700 text-sm ms-1 cursor-pointer" for="perm_{{ $permission->id }}">
                                                    {{ ucwords(str_replace(['access-', '-'], ['', ' '], $permission->name)) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top border-light bg-white/50 px-4 py-3">
                    <button type="button" class="btn btn-light border shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-amarin px-4 shadow-sm"><i class="fa-solid fa-save me-2"></i> Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
