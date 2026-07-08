<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amarin Admin Workspace</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { amarin: '#0ea5e9', amarinDark: '#0369a1' } } } }
    </script>
    <style>
        body { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); background-attachment: fixed; font-family: "Inter", "Segoe UI", Roboto, sans-serif; color: #334155; }
        .glass-panel { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.6); box-shadow: 0 8px 32px 0 rgba(3, 105, 161, 0.05); border-radius: 1.5rem; }
        .glass-sidebar { background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(24px); border-right: 1px solid rgba(255, 255, 255, 0.5); }
        .navbar-glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); }
        .table { --bs-table-bg: transparent; margin-bottom: 0; }
        .table-light th { background-color: rgba(14, 165, 233, 0.05) !important; color: #0369a1; border-bottom: 2px solid rgba(14, 165, 233, 0.2); }
        .table td { border-bottom: 1px solid rgba(14, 165, 233, 0.1); padding: 1.25rem 0.75rem; vertical-align: middle; }
        .btn-amarin { background: linear-gradient(to right, #0ea5e9, #2563eb); color: white; border: none; border-radius: 0.75rem; transition: all 0.3s ease; }
        .btn-amarin:hover { box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); transform: translateY(-2px); color: white; }
        .nav-link-admin { color: #475569; border-radius: 0.75rem; padding: 0.85rem 1.25rem; transition: all 0.2s; font-weight: 600; display: flex; align-items: center; text-decoration: none; }
        .nav-link-admin:hover, .nav-link-admin.active { background: rgba(14, 165, 233, 0.15); color: #0ea5e9; }
        .form-control, .form-select { border-radius: 0.75rem; border: 1px solid #cbd5e1; padding: 0.7rem 1rem; background: rgba(255,255,255,0.8); }
        .form-control:focus, .form-select:focus { border-color: #0ea5e9; box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.25); background: #fff;}
        a { text-decoration: none; }
    </style>
</head>
<body>
    <nav class="navbar-glass fixed top-0 w-full z-50 h-[4.5rem] flex items-center justify-between px-4 sm:px-6 shadow-sm">
        <div class="flex items-center">
            <button id="sidebarToggle" class="mr-4 sm:hidden text-slate-600 hover:text-amarin focus:outline-none bg-white/50 p-2 rounded-lg"><i class="fa-solid fa-bars text-xl"></i></button>
            <div class="hidden sm:block font-bold text-slate-500 text-sm tracking-widest uppercase">PT Amarin Ship Management</div>
        </div>
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-2 text-sm font-bold text-amarin hover:text-blue-700 bg-blue-50/50 hover:bg-blue-100 px-4 py-2.5 rounded-xl border border-blue-100 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> <span class="hidden sm:inline">Lihat Portal Publik</span>
            </a>
        </div>
    </nav>

    <aside id="adminSidebar" class="glass-sidebar fixed top-0 left-0 z-40 w-72 h-screen pt-[4.5rem] transition-transform -translate-x-full sm:translate-x-0 shadow-[4px_0_24px_rgba(0,0,0,0.03)]">
        <div class="h-full px-4 py-8 overflow-y-auto">
            <a href="/admin" class="flex items-center gap-4 mb-10 px-2 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform"><i class="fa-solid fa-shield-halved text-white text-xl"></i></div>
                <div><div class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-cyan-600 tracking-tight">Workspace</div><div class="text-xs font-bold text-slate-400">ADMINISTRATOR</div></div>
            </a>
            <ul class="space-y-2">
                <li><a href="/admin" class="nav-link-admin {{ request()->is('admin') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie w-8 text-lg"></i> Dashboard Utama</a></li>
                <li><a href="/admin/books" class="nav-link-admin {{ request()->is('admin/books*') || request()->is('admin/parts*') || request()->is('admin/chapters*') ? 'active' : '' }}"><i class="fa-solid fa-book-journal-whills w-8 text-lg"></i> Kelola Pustaka</a></li>
                <li><a href="/admin/forms" class="nav-link-admin {{ request()->is('admin/forms*') ? 'active' : '' }}"><i class="fa-solid fa-file-signature w-8 text-lg"></i> Kelola Formulir</a></li>
            </ul>
        </div>
    </aside>

    <main class="p-4 sm:ml-72 mt-[4.5rem] min-h-screen">
        <div class="p-2 md:p-6 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>document.getElementById('sidebarToggle')?.addEventListener('click', function() { document.getElementById('adminSidebar').classList.toggle('-translate-x-full'); });</script>
</body>
</html>
