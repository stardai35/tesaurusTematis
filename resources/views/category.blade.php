@extends('layouts.app')

@section('title', 'Jelajahi Kategori - Tesaurus Tematis')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
        margin: 2rem 0 1.5rem;
        transition: all 0.2s;
    }

    .back-link:hover {
        gap: 0.75rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    .filter-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 2rem;
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .filter-group {
        margin-bottom: 2rem;
    }

    .filter-group:last-child {
        margin-bottom: 0;
    }

    .filter-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--text-dark);
    }

    .filter-options {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .filter-btn:hover {
        background: var(--bg-light);
    }

    .filter-btn.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    .alphabet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
        gap: 0.5rem;
    }

    .alphabet-btn {
        padding: 0.5rem;
        text-align: center;
        border-radius: 6px;
    }

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .results-count {
        font-weight: 600;
        color: var(--text-dark);
    }

    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }

    .view-btn {
        width: 36px;
        height: 36px;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .view-btn.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    .words-grid {
        display: grid;
        gap: 1.5rem;
    }

    .word-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .word-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .word-info {
        flex: 1;
    }

    .word-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
    }

    .word-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .word-count {
        color: var(--text-light);
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        color: var(--text-dark);
        background: white;
        border: 1px solid var(--border-color);
    }

    .pagination .active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }
</style>
@endpush

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="back-link">
        ← Kembali
    </a>

    <h1 class="page-title">Jelajahi Kategori</h1>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            🎯 Filter
        </div>

        <!-- Kelas Kata Filter -->
        <div class="filter-group">
            <div class="filter-label">Kelas Kata</div>
            <div class="filter-options">
                <a href="{{ route('category') }}" class="filter-btn {{ !request('word_class') ? 'active' : '' }}">
                    Semua Kata
                </a>
                @foreach($wordClasses as $wc)
                <a href="{{ route('category', ['word_class' => $wc->id] + request()->except('word_class')) }}" 
                   class="filter-btn {{ request('word_class') == $wc->id ? 'active' : '' }}">
                    {{ $wc->name }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Bidang Filter -->
        <div class="filter-group">
            <div class="filter-label">Bidang</div>
            <div class="filter-options">
                <a href="{{ route('category', request()->except('category')) }}" 
                   class="filter-btn {{ !request('category') ? 'active' : '' }}">
                    Semua Bidang
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('category', ['category' => $cat->id] + request()->except('category')) }}" 
                   class="filter-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                    {{ $cat->title }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Alphabet Filter -->
        <div class="filter-group">
            <div class="filter-label">Abjad</div>
            <div class="alphabet-grid">
                @foreach(range('A', 'Z') as $letter)
                <a href="{{ route('category', ['letter' => $letter] + request()->except('letter')) }}" 
                   class="filter-btn alphabet-btn {{ request('letter') == $letter ? 'active' : '' }}">
                    {{ $letter }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="results-header">
        <div class="results-count">{{ $lemmas->total() }} kata ditemukan</div>
        <div class="view-toggle">
            <button class="view-btn active">☰</button>
            <button class="view-btn">⊞</button>
        </div>
    </div>

    <div class="words-grid">
        @forelse($lemmas as $lemma)
        <a href="{{ route('lemma', $lemma->slug) }}" class="word-card">
            <div class="word-info">
                <div class="word-name">{{ $lemma->name }}</div>
                <div class="word-badges">
                    @if($lemma->label)
                        <span class="badge badge-nomina">{{ $lemma->label->name }}</span>
                    @endif
                    @foreach($lemma->wordRelations->take(1) as $relation)
                        @if($relation->wordClass)
                            <span class="badge badge-teknologi">{{ $relation->wordClass->name }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="word-count">
                {{ $lemma->wordRelations->count() }} {{ $lemma->wordRelations->count() == 1 ? 'relasi' : 'relasi' }}
            </div>
        </a>
        @empty
        <div style="text-align: center; padding: 3rem; color: var(--text-light);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
            <p>Tidak ada kata ditemukan dengan filter ini</p>
        </div>
        @endforelse
    </div>

    @if($lemmas->hasPages())
    <div class="pagination">
        {{ $lemmas->links() }}
    </div>
    @endif
</div>
@endsection
