@extends('layouts.tematis')

@section('content')
    <section class="bg-gradient-to-r from-sky-900 via-sky-800 to-emerald-700 text-white">
        <div class="mx-auto max-w-6xl px-4 py-14">
            <h1 class="text-4xl md:text-5xl font-semibold tracking-tight text-center">
                Tesaurus Tematis Bahasa Indonesia
            </h1>
            <p class="mt-3 text-center text-white/85">
                Pusat padanan kata Bahasa Indonesia yang baku dan terstandar
            </p>

            <div class="mt-10 mx-auto max-w-2xl">
                <form action="{{ route('tematis.search') }}" method="get" class="flex items-stretch bg-white rounded-xl overflow-hidden shadow-sm">
                    <div class="flex items-center px-4 text-slate-400">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <input name="q" class="flex-1 px-2 py-3 text-slate-900 outline-none" placeholder="Masukan Kata" />
                    <button class="px-6 bg-sky-600 hover:bg-sky-700 text-white font-semibold">Cari</button>
                </form>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-6 text-center">
                <div class="text-4xl font-semibold">{{ number_format($stats['jumlah_kata']) }}</div>
                <div class="mt-1 text-sm text-slate-500">Jumlah Kata</div>
            </div>
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-6 text-center">
                <div class="text-4xl font-semibold">{{ number_format($stats['jumlah_entri']) }}</div>
                <div class="mt-1 text-sm text-slate-500">Jumlah Entri</div>
            </div>
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-6 text-center">
                <div class="text-4xl font-semibold">{{ number_format($stats['relasi_sinonim']) }}</div>
                <div class="mt-1 text-sm text-slate-500">Relasi Sinonim</div>
            </div>
        </div>

        <h2 class="mt-12 text-center text-2xl font-semibold">Cari berdasarkan Kelas Kata</h2>
        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($wordClasses as $wc)
                <a href="{{ route('tematis.category', ['kelas' => $wc->id]) }}"
                   class="rounded-2xl border border-slate-100 bg-white p-5 hover:shadow-sm transition">
                    <div class="text-sm font-semibold">{{ ucfirst($wc->name) }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ number_format($wc->lemma_count) }} kata</div>
                </a>
            @endforeach
        </div>

        <h2 class="mt-12 text-center text-2xl font-semibold">Bidang Ilmu Kata</h2>
        <div class="mt-6">
            <div class="rounded-2xl border border-slate-100 bg-white p-4">
                <details open>
                    <summary class="cursor-pointer select-none text-sm font-semibold text-slate-700">
                        I. Ukuran dan Bentuk
                    </summary>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($categories as $cat)
                            <a class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 text-sm hover:bg-slate-100"
                               href="{{ route('tematis.category', ['bidang' => $cat->id]) }}">
                                {{ $cat->num }}. {{ $cat->title }}
                            </a>
                        @endforeach
                    </div>
                </details>
            </div>
        </div>
    </section>
@endsection

