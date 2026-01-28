<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tesaurus Tematis Bahasa Indonesia')</title>
    <meta name="description" content="@yield('description', 'Pusat padanan kata Bahasa Indonesia yang baku dan terstandar')">
    
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
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-blue);
            text-decoration: none;
        }

        .logo-img {
            height: 40px;
        }

        .nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav a {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .nav a:hover {
            color: var(--primary-blue);
        }

        .kemendikbud-logo {
            height: 35px;
        }

        /* Main Content */
        .main {
            min-height: calc(100vh - 200px);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 35%, #5ba89f 70%, #a8dadc 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer p {
            margin: 0.25rem 0;
            font-size: 0.9rem;
        }

        .footer a {
            color: white;
            text-decoration: underline;
        }

        /* Utility Classes */
        .container {
            max-width: 1200px;
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
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }

            .nav {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }

            .container {
                padding: 0 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/150px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png" alt="Logo" class="logo-img">
                <span>Tesaurus Tematis</span>
            </a>
            <nav class="nav">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('guide') }}">Petunjuk Penggunaan</a>
                <a href="{{ route('team') }}">Tim Redaksi</a>
                <a href="{{ route('about') }}">Tentang</a>
            </nav>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/150px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png" alt="Kemendikbud" class="kemendikbud-logo">
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <p>&copy; 2024 Tesaurus Bahasa Indonesia. Semua hak dilindungi.</p>
            <p>Data tesaurus diambil dari <a href="http://badanbahasa.kemdikbud.go.id/" target="_blank">Badan Pengembangan dan Pembinaan Bahasa</a></p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
