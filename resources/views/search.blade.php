@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $query)

@push('styles')
<style>
    .search-container {
        max-width: 1200px;
        margin: 0 auto;
    }

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

    .search-header {
        margin-bottom: 2rem;
    }

    .search-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .search-query {
        color: var(--primary-blue);
    }

    .search-filters {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .filter-title {
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .filter-group select {
        padding: 0.6rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.9rem;
        background: white;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .filter-group select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
    }

    .btn-filter {
        padding: 0.6rem 1.5rem;
        background: var(--primary-blue);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .btn-filter:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-clear {
        padding: 0.6rem 1.5rem;
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .btn-clear:hover {
        background: var(--bg-light);
    }

    .search-results {
        margin-bottom: 2rem;
    }

    .results-header {
        margin-bottom: 1.5rem;
    }

    .results-count {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .results-tabs {
        display: flex;
        gap: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .results-tab {
        padding: 0.75rem 1rem;
        font-weight: 500;
        border: none;
        background: none;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.2s;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
    }

    .results-tab.active {
        color: var(--primary-blue);
        border-bottom-color: var(--primary-blue);
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
    }

    .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .result-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.75rem;
    }

    .result-card-title a {
        color: inherit;
        text-decoration: none;
    }

    .result-card-title a:hover {
        text-decoration: underline;
    }

    .result-badges {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        background: #e5e7eb;
        color: var(--text-dark);
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    .result-content {
        margin-top: 1rem;
    }

    .result-text {
        line-height: 1.8;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .result-label {
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .highlight-yellow {
        background-color: #fef08a;
        padding: 2px 4px;
        border-radius: 2px;
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
    }

    .no-results-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .no-results h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
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
        padding: 0.6rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        color: var(--text-dark);
        background: white;
        border: 1px solid var(--border-color);
        transition: all 0.2s;
    }

    .pagination a:hover {
        background: var(--bg-light);
    }

    .pagination .active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr;
        }

        .search-title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="search-container">
    <a href="{{ route('home') }}" class="back-link">
        ← Kembali ke Beranda
    </a>

    <div class="search-header">
        <h1 class="search-title">
            Hasil pencarian: <span class="search-query">"{{ $query }}"</span>
        </h1>
    </div>

    {{-- Search Filters --}}
    <form method="GET" action="{{ route('search') }}" class="search-filters">
        <div class="filter-title">PENYARING HASIL PENCARIAN</div>
        
        <div class="filter-row">
            <div class="filter-group">
                <label for="word_class">Kelas Kata:</label>
                <select name="word_class" id="word_class">
                    <option value="">Semua Kelas Kata</option>
                    @foreach($wordClasses as $wc)
                        <option value="{{ $wc->id }}" 
                            {{ $wordClassFilter == $wc->id ? 'selected' : '' }}>
                            {{ $wc->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="category">Kategori:</label>
                <select name="category" id="category" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" 
                            {{ $categoryFilter == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="subcategory">Subkategori:</label>
                <select name="subcategory" id="subcategory">
                    <option value="">Semua Subkategori</option>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->id }}" 
                            {{ $subcategoryFilter == $subcat->id ? 'selected' : '' }}>
                            {{ $subcat->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <input type="hidden" name="q" value="{{ $query }}">

        <div class="filter-actions">
            <button type="submit" class="btn-filter">Terapkan Filter</button>
            <a href="{{ route('search', ['q' => $query]) }}" class="btn-clear">Hapus Filter</a>
        </div>
    </form>

    {{-- Results Section --}}
    <div class="search-results">
        <div class="results-header">
            @php
                $totalResults = $lemmas->total() + $articles->total();
            @endphp
            <div class="results-count">
                Ditemukan <strong>{{ $totalResults }}</strong> hasil
            </div>
        </div>

        @if($totalResults > 0)
            {{-- ARTICLES RESULTS --}}
            @if($articles->count() > 0)
                <div class="results-grid">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; margin-top: 2rem; color: var(--text-dark);">
                        Hasil dari Artikel ({{ $articles->total() }})
                    </h2>

                    @foreach($articles as $article)
                    <div class="result-card">
                        {{-- Article Title --}}
                        @php
                            $titleRelation = $article->wordRelations->first();
                            $displayTitle = $article->title ?? ($titleRelation ? $titleRelation->lemma->name : 'Tanpa Judul');
                        @endphp
                        
                        <div class="result-card-title">
                            <a href="{{ route('articles.show', $article) }}">
                                {{ strtoupper($displayTitle) }}
                            </a>
                        </div>

                        {{-- Category and Subcategory --}}
                        <div class="result-badges">
                            @if($article->category)
                                <span class="badge badge-primary">{{ $article->category->title }}</span>
                            @endif
                            @if($article->subcategory)
                                <span class="badge">{{ $article->subcategory->title }}</span>
                            @endif
                        </div>

                        {{-- Article Content Structure --}}
                        <div class="result-content">
                            @php
                                $superordinates = $article->wordRelations->where('is_superordinate', true);
                                $ordinaryLemmas = $article->wordRelations->whereNotIn('id', $superordinates->pluck('id'));
                                $searchTerm = strtolower($query);
                            @endphp
                            
                            {{-- Superordinates Section --}}
                            @if($superordinates->count() > 0)
                                <div class="result-text">
                                    <strong>Makna Umum:</strong>
                                    @foreach($superordinates as $index => $relation)
                                        @if($relation->lemma)
                                            <a href="{{ route('lemma', str_replace(' ', '-', strtolower($relation->lemma->name))) }}" 
                                               style="color: #2563eb; text-decoration: none; font-weight: 600;">
                                                {{ $relation->lemma->name }}
                                            </a>
                                            @if($index < $superordinates->count() - 1), @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            
                            {{-- Ordinary Lemmas Section --}}
                            @if($ordinaryLemmas->count() > 0)
                                <div class="result-text" style="margin-top: 0.75rem;">
                                    <strong>Makna Khusus:</strong>
                                    @php
                                        $lemmasList = [];
                                    @endphp
                                    @foreach($ordinaryLemmas as $relation)
                                        @if($relation->lemma && !in_array($relation->lemma->id, $lemmasList))
                                            @php $lemmasList[] = $relation->lemma->id; @endphp
                                            @php
                                                $lemmaName = $relation->lemma->name;
                                                $isSearchMatch = str_contains(strtolower($lemmaName), $searchTerm);
                                            @endphp
                                            
                                            @if($isSearchMatch)
                                                <span class="highlight-yellow">
                                            @endif
                                            
                                            <a href="{{ route('lemma', str_replace(' ', '-', strtolower($lemmaName))) }}" 
                                               style="color: #1f2937; text-decoration: none;">
                                                {{ $lemmaName }}
                                            </a>
                                            
                                            @if($isSearchMatch)
                                                </span>
                                            @endif,
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($articles->hasPages())
                    <div class="pagination">
                        {{ $articles->links() }}
                    </div>
                @endif
            @endif

            {{-- LEMMAS RESULTS --}}
            @if($lemmas->count() > 0)
                <div class="results-grid" style="margin-top: 2rem;">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-dark);">
                        Hasil dari Lemma ({{ $lemmas->total() }})
                    </h2>

                    @foreach($lemmas as $lemma)
                    <div class="result-card">
                        <div class="result-card-title">
                            <a href="{{ route('lemma', str_replace(' ', '-', strtolower($lemma->name))) }}">
                                {{ strtoupper($lemma->name) }}
                            </a>
                        </div>

                        @if($lemma->label)
                            <div class="result-badges">
                                <span class="badge badge-primary">{{ strtoupper($lemma->label->name) }}</span>
                            </div>
                        @endif

                        <div class="result-content">
                            @php
                                $articlesCount = $lemma->wordRelations->pluck('article_id')->unique()->count();
                                $wordClassesList = $lemma->wordRelations->pluck('wordClass.name')->unique()->filter();
                            @endphp

                            <div class="result-text">
                                <strong>Ditemukan dalam:</strong>
                                {{ $articlesCount }} artikel
                                @if($wordClassesList->count() > 0)
                                    | <strong>Kelas Kata:</strong> {{ $wordClassesList->join(', ') }}
                                @endif
                            </div>

                            @if($lemma->wordRelations->count() > 0)
                                <div class="result-label">Ditemukan dalam Artikel:</div>
                                <div class="result-text">
                                    @php
                                        $contexts = $lemma->wordRelations
                                            ->take(5)
                                            ->pluck('article')
                                            ->filter()
                                            ->unique('id');
                                    @endphp
                                    @foreach($contexts as $index => $context)
                                        <a href="{{ route('articles.show', $context) }}" 
                                           style="color: #2563eb; text-decoration: none; font-weight: 500;">
                                            {{ $context->title ?? 'Artikel tanpa judul' }}
                                        </a>@if($index < $contexts->count() - 1) | @endif
                                    @endforeach
                                    @if($articlesCount > 5)
                                        <span style="color: var(--text-light);">dan {{ $articlesCount - 5 }} artikel lainnya</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($lemmas->hasPages())
                    <div class="pagination">
                        {{ $lemmas->links() }}
                    </div>
                @endif
            @endif
        @else
            <div class="no-results">
                <div class="no-results-icon">🔍</div>
                <h2>Tidak ada hasil ditemukan</h2>
                <p>Coba gunakan kata kunci lain atau sesuaikan filter pencarian</p>
            </div>
        @endif
    </div>
</div>
@endsection
