<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - EBook IMS Amarin</title>
    <!-- Bootstrap 5 & FontAwesome (Untuk Icon) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; }
        .sidebar {
            height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            position: fixed;
            width: 250px;
        }
        .sidebar-brand {
            font-weight: bold;
            color: #0d47a1; /* Biru Navy Maritim */
            padding: 20px;
            font-size: 1.2rem;
            border-bottom: 1px solid #e0e0e0;
        }
        .sidebar-nav .nav-link {
            color: #4f5d75;
            padding: 12px 20px;
            font-weight: 500;
        }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
            color: #0d47a1;
            background-color: #e8eaf6;
            border-right: 4px solid #0d47a1;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-top { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; }
    </style>
</head>
<body>

    <!-- Sidebar Samping -->
    <div class="sidebar d-flex flex-column">
        <div class="sidebar-brand text-center">
            <i class="fa-solid fa-ship me-2"></i> IMS AMARIN
        </div>
        <ul class="nav flex-column sidebar-nav mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="/admin"><i class="fa-solid fa-chart-pie me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/parts"><i class="fa-solid fa-book-open me-2"></i> Kelola IMS</a>
            </li>
            <li class="nav-item mt-5">
                <a class="nav-link text-danger" href="/"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Keluar (Ke Publik)</a>
            </li>
        </ul>
    </div>

    <!-- Konten Sebelah Kanan -->
    <div class="main-content">
        <!-- Navbar Atas -->
        <nav class="navbar navbar-expand-lg navbar-top rounded shadow-sm mb-4 p-3">
            <div class="container-fluid">
                <span class="navbar-text fw-bold">Manajemen E-Book System</span>
                <div class="d-flex align-items-center">
                    <span class="me-3 text-muted">Halo, Admin!</span>
                    <i class="fa-solid fa-circle-user fa-2x text-primary"></i>
                </div>
            </div>
        </nav>

        <!-- Tempat konten dinamis disisipkan -->
        @yield('content')

    </div>

</body>
</html>
