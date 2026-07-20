<!-- Cek apakah user yang login adalah Super Admin -->
@role('super-admin')
<div class="mb-2">
    <small class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">
        Control Panel
    </small>
    <a href="{{ route('admin.users.index') }}"
       class="nav-link d-flex align-items-center gap-2 px-3 py-2.5 rounded-3 font-medium transition-all {{ Request::is('admin/users*') ? 'bg-primary text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
        <i class="fa-solid fa-users-gear {{ Request::is('admin/users*') ? 'text-white' : 'text-primary' }}" style="width: 20px;"></i>
        <span>Manajemen Pengguna</span>
    </a>
</div>
@endrole
