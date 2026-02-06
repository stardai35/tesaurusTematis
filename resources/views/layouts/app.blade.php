<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tesaurus Tematis Bahasa Indonesia')</title>
    <meta name="description"
        content="@yield('description', 'Pusat padanan kata Bahasa Indonesia yang baku dan terstandar')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #1e56a0;
            --primary-cyan: #16425b;
            --accent-teal: #3a7ca5;
            --accent-light: #81c3d7;
            --gradient-start: #1e56a0;
            --gradient-mid: #2e7ea6;
            --gradient-end: #a8dadc;
            --text-dark: #2d3142;
            --text-light: #4F5D75;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --border-color: #e1e8ed;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--bg-light);
        }

        /* Header */
        .header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            height: 4rem;
        }

        /* Sidebar Toggle Button */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-blue);
            cursor: pointer;
            padding: 0.5rem;
            width: 2.5rem;
            height: 2.5rem;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .nav-toggle:hover {
            background: rgba(30, 86, 160, 0.1);
        }

        .nav-toggle:active {
            transform: scale(0.95);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-blue);
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .logo-img {
            height: 50px;
        }

        .nav {
            display: flex;
            gap: 2.5rem;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .nav a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
            position: relative;
        }

        .nav a:hover {
            color: var(--primary-blue);
        }

        .nav a.active {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .kemendikbud-logo {
            height: 45px;
            flex-shrink: 0;
            display: none;
        }

        @media (min-width: 768px) {
            .kemendikbud-logo {
                display: block;
            }
        }

        /* Sidebar */
        .sidebar-nav {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-cyan) 100%);
            color: white;
            padding: 2rem 0;
            overflow-y: auto;
            overflow-x: hidden;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.12);
        }

        .sidebar-nav.show {
            transform: translateX(0);
            box-shadow: 2px 0 16px rgba(0, 0, 0, 0.3);
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .sidebar-nav li a {
            display: block;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-weight: 500;
        }

        .sidebar-nav li a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.12);
            border-left-color: var(--accent-light);
        }

        .sidebar-nav li a.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            border-left-color: var(--accent-light);
        }

        /* Sidebar Overlay */
        .nav-overlay {
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

        .nav-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Page Wrapper */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Main Content */
        .main {
            min-height: calc(100vh - 200px);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 35%, #5ba89f 70%, #a8dadc 100%);
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .footer a {
            color: white;
            text-decoration: underline;
            transition: opacity 0.2s;
        }

        .footer a:hover {
            opacity: 0.8;
        }

        /* Utility Classes */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.625rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary-blue);
            color: white;
        }

        .btn-primary:hover {
            background: #163d6f;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 86, 160, 0.3);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-nomina {
            background: #e3f2fd;
            color: #1976d2;
        }

        .badge-verba {
            background: #fce4ec;
            color: #c2185b;
        }

        .badge-adjektiva {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-teknologi {
            background: #e8f5e9;
            color: #388e3c;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-toggle {
                display: flex;
            }

            .nav {
                display: none;
            }

            .header-container {
                height: auto;
                padding: 0.75rem 1rem;
                gap: 1rem;
            }

            .logo-img {
                height: 40px;
            }

            .kemendikbud-logo {
                height: 35px;
            }
        }

        @media (max-width: 576px) {
            .header-container {
                padding: 0.5rem 0.75rem;
                gap: 0.75rem;
            }

            .logo {
                font-size: 0.95rem;
            }

            .logo-img {
                height: 35px;
            }

            .nav-toggle {
                width: 2.25rem;
                height: 2.25rem;
                font-size: 1.25rem;
            }

            .kemendikbud-logo {
                display: none;
            }
        }

        .img-responsive {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 6px;

        }

        .info-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .info-bar .right {
            text-align: right;
            margin-bottom: 2rem;
        }
        .hero-redaksi img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    display: block;
}

    </style>

    @stack('styles')
</head>

<body>
    <!-- Navigation Sidebar -->
    <nav class="sidebar-nav" id="sidebarNav">
        <ul>
            <li><a href="{{ route('home') }}" @if(Route::current()->getName() === 'home') class="active" @endif>Beranda</a></li>
            <li><a href="{{ route('guide') }}" @if(Route::current()->getName() === 'guide') class="active" @endif>Petunjuk Penggunaan</a></li>
            <li><a href="{{ route('team') }}" @if(Route::current()->getName() === 'team') class="active" @endif>Tim Redaksi</a></li>
            <li><a href="{{ route('about') }}" @if(Route::current()->getName() === 'about') class="active" @endif>Tentang</a></li>
        </ul>
    </nav>

    <!-- Navigation Overlay -->
    <div class="nav-overlay" id="navOverlay"></div>

    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <button class="nav-toggle" id="navToggle" title="Toggle Menu">
                    <span>☰</span>
                </button>
                <a href="{{ route('home') }}" class="logo">
                    <img src="https://aesthetic-sapphire-3vlcod9zlm.edgeone.app/tesaurus.png" alt="Logo" class="logo-img">
                </a>
                <nav class="nav">
                    <a href="{{ route('home') }}" @if(Route::current()->getName() === 'home') class="active" @endif>Beranda</a>
                    <a href="{{ route('guide') }}" @if(Route::current()->getName() === 'guide') class="active" @endif>Petunjuk Penggunaan</a>
                    <a href="{{ route('team') }}" @if(Route::current()->getName() === 'team') class="active" @endif>Tim Redaksi</a>
                    <a href="{{ route('about') }}" @if(Route::current()->getName() === 'about') class="active" @endif>Tentang</a>
                </nav>
                <img src="https://annual-salmon-xlcimjpgpr.edgeone.app/kmedikbud%20logo%20ong.png" alt="Kemendikbud"
                    class="kemendikbud-logo">
            </div>
        </header>

        <!-- Main Content -->
        <main class="main">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <p>&copy; {{ date('Y') }} Tesaurus Bahasa Indonesia. Semua hak dilindungi.</p>
                <p>Data tesaurus diambil dari <a href="http://badanbahasa.kemdikbud.go.id/" target="_blank">Badan Pengembangan dan Pembinaan Bahasa</a></p>
            </div>
        </footer>
    </div>

    <script>
        // Navigation Toggle Functionality
        const sidebarNav = document.getElementById('sidebarNav');
        const navToggle = document.getElementById('navToggle');
        const navOverlay = document.getElementById('navOverlay');
        let isToggling = false;

        // Function to toggle navigation
        function toggleNav() {
            if (isToggling) return;
            
            isToggling = true;
            sidebarNav.classList.toggle('show');
            navOverlay.classList.toggle('show');
            
            if (sidebarNav.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
            
            setTimeout(() => {
                isToggling = false;
            }, 300);
        }

        // Function to close navigation
        function closeNav() {
            sidebarNav.classList.remove('show');
            navOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Toggle on button click
        if (navToggle) {
            navToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleNav();
            });
        }

        // Close when clicking overlay
        if (navOverlay) {
            navOverlay.addEventListener('click', function() {
                closeNav();
            });
        }

        // Close when clicking menu links on mobile
        const navLinks = document.querySelectorAll('.sidebar-nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768 && sidebarNav.classList.contains('show')) {
                    closeNav();
                }
            });
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebarNav.classList.contains('show')) {
                closeNav();
            }
        });

        // Close on window resize above 768px
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && sidebarNav.classList.contains('show')) {
                closeNav();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>