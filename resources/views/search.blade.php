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
        Hasil pencarian "<strong>{{ $query }}</strong>" dari semua kelas kata.
    </div>

    @if($articles->count() > 0)
        <div class="results-grid">
            @foreach($articles as $article)
            <div class="result-card">
                {{-- Article Title (clickable, bold) --}}
                @php
                    $titleRelation = $article->wordRelations->firstWhere('type_id', 2);
                @endphp
                @if($titleRelation && $titleRelation->lemma)
                    <div class="result-word">
                        <a href="{{ route('lemma', str_replace(' ', '-', strtolower($titleRelation->lemma->name))) }}" 
                           style="color: inherit; text-decoration: none;">
                            {{ strtoupper($titleRelation->lemma->name) }}
                        </a>
                    </div>
                @endif

                {{-- Article Content --}}
                <div class="result-text" style="margin-top: 1rem; line-height: 1.8;">
                    @php
                        $superordinates = $article->wordRelations->where('type_id', 3);
                        $ordinaryLemmas = $article->wordRelations->where('type_id', 1);
                        $searchTerm = strtolower($query);
                    @endphp
                    
                    {{-- Superordinates (bold, clickable, followed by colon) --}}
                    @foreach($superordinates as $index => $relation)
                        @if($relation->lemma)
                            <strong>
                                <a href="{{ route('lemma', str_replace(' ', '-', strtolower($relation->lemma->name))) }}" 
                                   style="color: #2563eb; text-decoration: none;">
                                    {{ $relation->lemma->name }}
                                </a>
                            </strong>:
                            @if($index < $superordinates->count() - 1), @endif
                        @endif
                    @endforeach
                    
                    {{-- Ordinary Lemmas (with search term highlighted in yellow) --}}
                    @foreach($ordinaryLemmas as $index => $relation)
                        @if($relation->lemma)
                            @php
                                $lemmaName = $relation->lemma->name;
                                $isSearchMatch = str_contains(strtolower($lemmaName), $searchTerm);
                            @endphp
                            
                            @if($isSearchMatch)
                                <span style="background-color: #fef08a; padding: 2px 4px;">
                            @endif
                            
                            <a href="{{ route('lemma', str_replace(' ', '-', strtolower($lemmaName))) }}" 
                               style="color: #1f2937; text-decoration: none;">
                                {{ $lemmaName }}
                            </a>
                            
                            @if($isSearchMatch)
                                </span>
                            @endif
                            
                            @if($index < $ordinaryLemmas->count() - 1), @endif
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $articles->links() }}
        </div>
    @else
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h2>Tidak ada hasil ditemukan</h2>
            <p>Coba kata kunci berbeda</p>
        </div>
    @endif
</div>
@endsection
