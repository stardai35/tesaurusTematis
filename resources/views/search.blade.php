@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $query)

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
        margin: 2rem 0 1rem;
        transition: all 0.2s;
    }

    .back-link:hover {
        gap: 0.75rem;
    }

    .search-info {
        margin: 1rem 0 2rem;
        color: var(--text-light);
    }

    .results-grid {
        display: grid;
        gap: 1.5rem;
    }

    .result-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .result-word {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.75rem;
    }

    .result-badges {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .result-info {
        margin-top: 1rem;
    }

    .result-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .result-text {
        color: var(--text-light);
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-results-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .no-results h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .no-results p {
        color: var(--text-light);
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

    <div class="search-info">
        "{{ $query }}" - {{ $results->total() }} hasil ditemukan
    </div>

    @if($results->count() > 0)
        <div class="results-grid">
            @foreach($results as $lemma)
            <a href="{{ route('lemma', $lemma->slug) }}" class="result-card">
                <div class="result-word">{{ $lemma->name }}</div>
                <div class="result-badges">
                    <span class="badge badge-nomina">{{ $lemma->label->name }}</span>
                    @foreach($lemma->wordRelations->take(1) as $relation)
                        @if($relation->wordClass)
                            <span class="badge badge-teknologi">{{ $relation->wordClass->name }}</span>
                        @endif
                    @endforeach
                </div>
                
                @php
                    $synonyms = $lemma->wordRelations->where('type.name', 'sinonim')->take(3);
                    $antonyms = $lemma->wordRelations->where('type.name', 'antonim')->take(3);
                @endphp
                
                @if($synonyms->count() > 0)
                <div class="result-info">
                    <div class="result-label">Sinonim:</div>
                    <div class="result-text">
                        {{ $synonyms->pluck('lemma.name')->filter()->implode(', ') }}
                    </div>
                </div>
                @endif
                
                @if($antonyms->count() > 0)
                <div class="result-info">
                    <div class="result-label">Antonim:</div>
                    <div class="result-text">
                        {{ $antonyms->pluck('lemma.name')->filter()->implode(', ') }}
                    </div>
                </div>
                @endif
            </a>
            @endforeach
        </div>

        <div class="pagination">
            {{ $results->links() }}
        </div>
    @else
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h2>Tidak ada hasil ditemukan</h2>
            <p>Coba Kata Kunci Berbeda</p>
        </div>
    @endif
</div>
@endsection
