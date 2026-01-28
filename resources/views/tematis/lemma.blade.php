@extends('layouts.tematis')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10">
        <a href="{{ url()->previous() ?: route('tematis.home') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            <span aria-hidden="true">←</span> Kembali
        </a>

        <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-8">
            <div class="flex items-start justify-between gap-6">
                <div>
                    <h1 class="text-5xl font-semibold tracking-tight text-sky-900">{{ $lemma->name }}</h1>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @if($wordClass)
                            <span class="rounded-full bg-sky-100 text-sky-700 px-4 py-2 text-sm">{{ $wordClass->name }}</span>
                        @endif
                        @if($bidang)
                            <span class="rounded-full bg-slate-100 text-slate-700 px-4 py-2 text-sm">{{ $bidang->title }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" class="h-11 w-11 rounded-xl bg-slate-50 border border-slate-100"></button>
                    <button type="button" class="h-11 w-11 rounded-xl bg-slate-50 border border-slate-100"></button>
                    <button type="button" class="h-11 w-11 rounded-xl bg-slate-50 border border-slate-100"></button>
                    <button type="button" class="h-11 w-11 rounded-xl bg-slate-50 border border-slate-100"></button>
                </div>
            </div>

            <div class="mt-10 space-y-8">
                <div>
                    <h2 class="text-2xl font-semibold">Sinonim</h2>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @forelse($synonyms as $s)
                            <a href="{{ route('tematis.lemma', $s->slug) }}"
                               class="rounded-full bg-sky-50 text-sky-800 border border-sky-100 px-5 py-2 text-sm hover:bg-sky-100">
                                {{ $s->name }}
                            </a>
                        @empty
                            <div class="text-sm text-slate-500">Belum ada sinonim pada data contoh.</div>
                        @endforelse
                    </div>
                </div>

                @if($antonyms->count())
                    <div>
                        <h2 class="text-2xl font-semibold">Antonim</h2>
                        <div class="mt-4 flex flex-wrap gap-3">
                            @foreach($antonyms as $a)
                                <a href="{{ route('tematis.lemma', $a->slug) }}"
                                   class="rounded-full bg-rose-50 text-rose-800 border border-rose-100 px-5 py-2 text-sm hover:bg-rose-100">
                                    {{ $a->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div>
                    <h2 class="text-2xl font-semibold">Kata Terkait</h2>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @forelse($related as $r)
                            <a href="{{ route('tematis.lemma', \Illuminate\Support\Str::slug($r->name) ?: $r->id) }}"
                               class="rounded-full bg-slate-50 text-slate-800 border border-slate-100 px-5 py-2 text-sm hover:bg-slate-100">
                                {{ $r->name }}
                            </a>
                        @empty
                            <div class="text-sm text-slate-500">Belum ada kata terkait pada data contoh.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

