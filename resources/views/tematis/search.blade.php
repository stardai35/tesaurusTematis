@extends('layouts.tematis')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10">
        <a href="{{ route('tematis.home') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            <span aria-hidden="true">←</span> Kembali
        </a>

        <h1 class="mt-4 text-3xl font-semibold">Hasil Pencarian</h1>
        <div class="mt-2 text-sm text-slate-500">
            “{{ $q }}” - {{ $lemmas->total() }} hasil ditemukan
        </div>

        <div class="mt-6 space-y-3">
            @forelse($lemmas as $lemma)
                <a href="{{ route('tematis.lemma', $lemma->slug) }}"
                   class="block rounded-2xl border border-slate-100 bg-white p-5 hover:shadow-sm transition">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-2xl font-semibold text-sky-800">{{ $lemma->name }}</div>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @if(!empty($lemma->word_class_name))
                                    <span class="rounded-full bg-sky-100 text-sky-700 px-3 py-1 text-xs">
                                        {{ $lemma->word_class_name }}
                                    </span>
                                @endif
                                @if(!empty($lemma->bidang_title))
                                    <span class="rounded-full bg-slate-100 text-slate-700 px-3 py-1 text-xs">
                                        {{ $lemma->bidang_title }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="pt-2 text-slate-400" aria-hidden="true">→</div>
                    </div>
                </a>
            @empty
                <div class="rounded-2xl border border-slate-100 bg-white p-10 text-center">
                    <div class="mx-auto h-16 w-16 rounded-full border-4 border-slate-200"></div>
                    <div class="mt-6 text-xl font-semibold">Tidak ada hasil ditemukan</div>
                    <div class="mt-1 text-sm text-slate-500">Coba Kata Kunci Berbeda</div>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $lemmas->links() }}
        </div>
    </section>
@endsection

