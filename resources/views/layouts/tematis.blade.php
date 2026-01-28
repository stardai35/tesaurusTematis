<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Tesaurus Tematis Bahasa Indonesia' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-slate-900">
<header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-100">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex h-16 items-center justify-between gap-4">
            <a href="{{ route('tematis.home') }}" class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-lg bg-sky-50 border border-sky-100 flex items-center justify-center">
                    <span class="text-sky-700 font-bold">T</span>
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-semibold">TESAURUS</div>
                    <div class="text-[11px] text-slate-500 -mt-0.5">Bahasa Indonesia</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm text-slate-600">
                <a class="hover:text-slate-900 {{ request()->routeIs('tematis.home') ? 'text-slate-900 font-semibold' : '' }}" href="{{ route('tematis.home') }}">Beranda</a>
                <a class="hover:text-slate-900 {{ request()->routeIs('tematis.petunjuk') ? 'text-slate-900 font-semibold' : '' }}" href="{{ route('tematis.petunjuk') }}">Petunjuk Penggunaan</a>
                <a class="hover:text-slate-900 {{ request()->routeIs('tematis.tim_redaksi') ? 'text-slate-900 font-semibold' : '' }}" href="{{ route('tematis.tim_redaksi') }}">Tim Redaksi</a>
                <a class="hover:text-slate-900 {{ request()->routeIs('tematis.tentang') ? 'text-slate-900 font-semibold' : '' }}" href="{{ route('tematis.tentang') }}">Tentang</a>
            </nav>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2">
                    <div class="h-9 w-9 rounded-full bg-slate-50 border border-slate-100"></div>
                    <div class="text-[10px] leading-tight text-slate-500">
                        BADAN PENGEMBANGAN<br/>DAN PEMBINAAN BAHASA
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="mt-14 border-t border-slate-100">
    <div class="mx-auto max-w-6xl px-4 py-8 text-center text-xs text-slate-500">
        © {{ date('Y') }} Tesaurus Bahasa Indonesia. Semua hak dilindungi.
    </div>
</footer>
</body>
</html>

