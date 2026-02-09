<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Tesaurus Tematis</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8f9fa;
            color: #2d3142;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Mobile Toggle */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: #2d3142;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            width: 2.5rem;
            height: 2.5rem;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .sidebar-toggle:hover {
            background: rgba(30, 86, 160, 0.1);
            color: #1e56a0;
        }

        .sidebar-toggle:active {
            transform: scale(0.95);
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #1e56a0 0%, #16425b 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.12);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        .sidebar-logo {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .sidebar-menu li a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.12);
            border-left-color: #a8dadc;
        }

        .sidebar-menu li a.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            border-left-color: #a8dadc;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 260px;
        }

        /* Topbar/Header */
        .topbar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e1e8ed;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .topbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e56a0;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-left: auto;
        }

        .topbar-user span {
            font-weight: 500;
            color: #2d3142;
        }

        .user-menu {
            display: flex;
            gap: 0.75rem;
        }

        .user-menu a,
        .user-menu button {
            padding: 0.5rem 1rem;
            background: #f3f4f6;
            border: none;
            border-radius: 6px;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-menu a:hover,
        .user-menu button:hover {
            background: #e5e7eb;
        }

        .user-menu a.logout,
        .user-menu button.logout {
            background: #ef4444;
            color: white;
        }

        .user-menu a.logout:hover,
        .user-menu button.logout:hover {
            background: #dc2626;
        }

        /* Main Content Area */
        .content {
            flex: 1;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            flex: 1;
        }

        .page-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        /* Buttons */
        .btn {
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #1e56a0;
            color: white;
        }

        .btn-primary:hover {
            background: #163d6f;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-success {
            background: #d1e6d5;
            border-color: #10b981;
            color: #047857;
        }

        .alert-error {
            background: #fee2e2;
            border-color: #ef4444;
            color: #b91c1c;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e56a0;
            box-shadow: 0 0 0 3px rgba(30, 86, 160, 0.1);
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table thead {
            background: #f9fafb;
        }

        .table th {
            padding: 0.875rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .table td {
            padding: 0.875rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr:hover {
            background: #f9fafb;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e5e7eb;
            color: #374151;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-primary {
            background: #dbeafe;
            color: #0c4a6e;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.5rem;
            margin-top: 1.5rem;
            justify-content: center;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            text-decoration: none;
            color: #374151;
            font-size: 0.875rem;
        }

        .pagination a:hover {
            background: #f3f4f6;
        }

        .pagination .active {
            background: #1e56a0;
            color: white;
            border-color: #1e56a0;
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .error-list {
            margin-top: 0.5rem;
            padding-left: 1.5rem;
            color: #dc2626;
            font-size: 0.875rem;
        }

        .error-list li {
            margin-bottom: 0.25rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
            }
        }

        @media (max-width: 768px) {
            /* Show hamburger menu */
            .sidebar-toggle {
                display: flex;
            }

            /* Sidebar hidden by default on mobile */
            .sidebar {
                width: 260px;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 2px 0 16px rgba(0, 0, 0, 0.3);
            }

            /* Main content takes full width */
            .main-content {
                margin-left: 0;
            }

            /* Content padding */
            .content {
                padding: 1.5rem;
            }

            /* Topbar adjustments */
            .topbar {
                padding: 0.75rem 1rem;
                gap: 0.5rem;
            }

            .topbar-title {
                flex: 1;
                min-width: 0;
                font-size: 1.1rem;
            }

            .topbar-user {
                gap: 0.5rem;
                font-size: 0.875rem;
            }

            .topbar-user span {
                display: none;
            }

            /* User menu adjustments */
            .user-menu {
                display: flex;
                gap: 0.35rem;
            }

            .user-menu a {
                padding: 0.4rem 0.75rem;
                font-size: 0.75rem;
            }

            /* Page header */
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .page-actions {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            /* Full width sidebar */
            .sidebar {
                width: 100%;
            }

            .sidebar-logo {
                padding: 1rem;
                margin-bottom: 1.5rem;
                font-size: 0.95rem;
            }

            .sidebar-menu li a {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            /* Hamburger button */
            .sidebar-toggle {
                width: 2rem;
                height: 2rem;
                font-size: 1.25rem;
                margin-right: 0.25rem;
                padding: 0.25rem;
            }

            /* Topbar */
            .topbar {
                padding: 0.5rem 0.75rem;
                gap: 0.35rem;
            }

            .topbar-title {
                font-size: 0.95rem;
                min-width: 0;
            }

            .topbar-user {
                gap: 0.25rem;
                font-size: 0.75rem;
            }

            .user-menu a {
                padding: 0.35rem 0.5rem;
                font-size: 0.7rem;
                white-space: nowrap;
            }

            /* Content */
            .content {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            /* Buttons */
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            /* Table */
            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 0.5rem;
            }

            /* Page header */
            .page-header {
                gap: 0.75rem;
            }

            .page-actions {
                gap: 0.5rem;
            }
        }

        @yield('extra-css')
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">📚 Admin Panel</div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="@if(Route::current()->getName() === 'admin.dashboard') active @endif">Dashboard</a></li>
                <li><a href="{{ route('admin.articles.index') }}" class="@if(str_starts_with(Route::current()->getName(), 'admin.articles')) active @endif">📄 Artikel</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="@if(str_starts_with(Route::current()->getName(), 'admin.categories')) active @endif">🏷️ Kategori</a></li>
                <li><a href="{{ route('admin.subcategories.index') }}" class="@if(str_starts_with(Route::current()->getName(), 'admin.subcategories')) active @endif">🏷️ Sub Kategori</a></li>
                 <li><a href="{{ route('admin.lemmas.index') }}" class="@if(str_starts_with(Route::current()->getName(), 'admin.lemmas')) active @endif">📚 Kelola Lemma</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
                    <span>☰</span>
                </button>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-user">
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="user-menu">
                        <a href="{{ route('home') }}" target="_blank">Lihat Website</a>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                @if($errors->any())
                    <div class="alert alert-error">
                        <strong>Errors:</strong>
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        let isToggling = false;

        // Function to toggle sidebar
        function toggleSidebar() {
            if (isToggling) return;
            
            isToggling = true;
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            
            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
            
            setTimeout(() => {
                isToggling = false;
            }, 300);
        }

        // Function to close sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Toggle sidebar on button click
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });
        }

        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                closeSidebar();
            });
        }

        // Close sidebar when clicking on menu links (mobile only)
        const menuLinks = document.querySelectorAll('.sidebar-menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768 && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });
        });

        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });

        // Close sidebar on window resize above 768px
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });
    </script>
</body>
</html>
