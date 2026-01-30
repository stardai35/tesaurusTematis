@extends('layouts.tematis')

@php
    $letters = range('A','Z');
@endphp

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10">
        <a href="{{ route('tematis.home') }}" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
            <span aria-hidden="true">←</span> Kembali
        </a>

        <h1 class="mt-4 text-3xl font-semibold">Jelajahi Kategori</h1>

        <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-6">
            <div class="flex items-center gap-2 text-slate-700 font-semibold">
                <span aria-hidden="true">⎇</span> Filter
            </div>

            <form class="mt-4 space-y-5" method="get" action="{{ route('tematis.category') }}">
                <div>
                    <div class="text-xs font-semibold text-slate-500">Kelas Kata</div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <a href="{{ route('tematis.category', array_filter(['bidang' => $filters['bidang'], 'abjad' => $filters['abjad'], 'q' => $filters['q']])) }}"
                           class="rounded-full px-4 py-2 text-sm border {{ empty($filters['kelas']) ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                            Semua
                        </a>
                        @foreach($wordClasses as $wc)
                            <a href="{{ route('tematis.category', array_filter(['kelas' => $wc->id, 'bidang' => $filters['bidang'], 'abjad' => $filters['abjad'], 'q' => $filters['q']])) }}"
                               class="rounded-full px-4 py-2 text-sm border {{ (int)$filters['kelas'] === (int)$wc->id ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                                {{ $wc->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold text-slate-500">Bidang</div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <a href="{{ route('tematis.category', array_filter(['kelas' => $filters['kelas'], 'abjad' => $filters['abjad'], 'q' => $filters['q']])) }}"
                           class="rounded-full px-4 py-2 text-sm border {{ empty($filters['bidang']) ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                            Semua
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('tematis.category', array_filter(['kelas' => $filters['kelas'], 'bidang' => $cat->id, 'abjad' => $filters['abjad'], 'q' => $filters['q']])) }}"
                               class="rounded-full px-4 py-2 text-sm border {{ (int)$filters['bidang'] === (int)$cat->id ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                                {{ $cat->num }}. {{ $cat->title }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($filters['bidang'])
                    @php
                        $selectedCategory = $categories->firstWhere('id', $filters['bidang']);
                    @endphp
                    @if($selectedCategory && $selectedCategory->subcategories->isNotEmpty())
                        <div>
                            <div class="text-xs font-semibold text-slate-500">Sub Bidang</div>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <a href="{{ route('tematis.category', array_filter(['kelas' => $filters['kelas'], 'bidang' => $filters['bidang'], 'abjad' => $filters['abjad'], 'q' => $filters['q']])) }}"
                                   class="rounded-full px-4 py-2 text-sm border {{ empty($filters['subbidang']) ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                                    Semua
                                </a>
                                @foreach($selectedCategory->subcategories as $subcat)
                                    <a href="{{ route('tematis.category', array_filter(['kelas' => $filters['kelas'], 'bidang' => $filters['bidang'], 'subbidang' => $subcat->id, 'abjad' => $filters['abjad'], 'q' => $filters['q']])) }}"
                                       class="rounded-full px-4 py-2 text-sm border {{ (int)$filters['subbidang'] === (int)$subcat->id ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                                        {{ $subcat->num }}. {{ $subcat->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                <div>
                    <div class="text-xs font-semibold text-slate-500">Abjad</div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($letters as $L)
                            <a href="{{ route('tematis.category', array_filter(['kelas' => $filters['kelas'], 'bidang' => $filters['bidang'], 'abjad' => $L, 'q' => $filters['q']])) }}"
                               class="h-10 w-10 grid place-items-center rounded-xl border {{ $filters['abjad'] === $L ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-50 border-slate-100 text-slate-700' }}">
                                {{ $L }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input name="q" value="{{ $filters['q'] }}" placeholder="Cari kata..." class="w-full rounded-xl border border-slate-200 px-4 py-2 outline-none focus:ring-2 focus:ring-sky-200" />
                    <button class="rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold px-5 py-2">Cari</button>
                </div>
            </form>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <div class="text-sm text-slate-600">
                {{ $lemmas->total() }} kata ditemukan
            </div>
        </div>

        <div class="mt-4 space-y-2">
            @foreach($lemmas as $row)
                <a href="{{ route('tematis.lemma', \Illuminate\Support\Str::slug($row->name) ?: $row->id) }}"
                   class="block rounded-2xl border border-slate-100 bg-white px-5 py-4 hover:shadow-sm transition">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 flex-wrap">
                            <div class="text-lg font-semibold text-sky-800">{{ $row->name }}</div>
                            @if(!empty($row->word_class_name))
                                <span class="rounded-full bg-sky-100 text-sky-700 px-3 py-1 text-xs">{{ $row->word_class_name }}</span>
                            @endif
                            @if(!empty($row->bidang_title))
                                <span class="rounded-full bg-slate-100 text-slate-700 px-3 py-1 text-xs">{{ $row->bidang_title }}</span>
                            @endif
                            @if(!empty($row->subbidang_title))
                                <span class="rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-xs">{{ $row->subbidang_title }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-500">
                            lihat →
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 flex items-center justify-center">
            {{ $lemmas->links() }}
        </div>
    </section>
@endsection

