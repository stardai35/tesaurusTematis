@extends('layouts.app')

@section('title', $article->title . ' - Tesaurus Tematis')
@section('description', 'Daftar kata dan padanan untuk ' . $article->title)

@push('styles')
<style>
    .article-show-header {
        background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 35%, #5ba89f 70%, #a8dadc 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 3rem;
    }

    .article-show-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .article-show-header .breadcrumb {
        background: rgba(255,255,255,0.2);
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-size: 0.95rem;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .article-show-header .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: opacity 0.3s;
    }

    .article-show-header .breadcrumb a:hover {
        opacity: 0.8;
        text-decoration: underline;
    }

    .wordclass-section {
        margin-bottom: 4rem;
        padding: 2.5rem 0;
        border-bottom: 2px solid #f0f0f0;
    }

    .wordclass-section:last-child {
        border-bottom: none;
    }

    .wordclass-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #1e56a0;
    }

    .wordclass-badge {
        display: inline-block;
        background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        margin-right: 1rem;
        min-width: 140px;
        text-align: center;
    }

    .wordclass-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1e56a0;
        margin: 0;
    }

    .wordclass-count {
        margin-left: auto;
        background: #f0f0f0;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #666;
        font-weight: 600;
    }

    .lemma-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .lemma-card {
        background: white;
        border: 1px solid #e8e8e8;
        border-radius: 10px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .lemma-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-color: #1e56a0;
    }

    .lemma-card-header {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .lemma-name-link {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e56a0;
        text-decoration: none;
        word-break: break-word;
        flex: 1;
        transition: color 0.2s;
    }

    .lemma-name-link:hover {
        color: #163d6f;
        text-decoration: underline;
    }

    .lemma-type-tag {
        display: inline-block;
        background: #f0f0f0;
        color: #666;
        padding: 0.3rem 0.65rem;
        border-radius: 18px;
        font-size: 0.7rem;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .lemma-label {
        display: inline-block;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1e56a0;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid #1e56a0;
        margin-bottom: 0.75rem;
    }

    .lemma-description {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        padding: 0.75rem 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        flex: 1;
    }

    .lemma-metadata {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        font-size: 0.8rem;
        color: #999;
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f0f0;
    }

    .metadata-badge {
        background: #f8f8f8;
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #999;
        background: #f9f9f9;
        border-radius: 12px;
    }

    .empty-state-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        margin-top: 2rem;
    }

    .stat-box {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        padding: 1.5rem;
        border-radius: 10px;
        text-align: center;
        border-left: 4px solid #1e56a0;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e56a0;
        display: block;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #666;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .article-show-header h1 {
            font-size: 1.8rem;
        }

        .wordclass-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .wordclass-count {
            margin-left: 0;
            margin-top: 0.75rem;
            width: 100%;
        }

        .lemma-list {
            grid-template-columns: 1fr;
        }

        .summary-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="article-show-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span> / </span>
            <a href="{{ route('category') }}">Kategori</a>
            <span> / </span>
            @if($article->category)
                <a href="{{ route('category') }}?cat={{ $article->category->id }}">
                    {{ $article->category->title }}
                </a>
                <span> / </span>
            @endif
            @if($article->subcategory)
                <a href="{{ route('articles.subcategory', $article->subcategory->slug) }}">
                    {{ $article->subcategory->title }}
                </a>
                <span> / </span>
            @endif
            <strong>{{ $article->title }}</strong>
        </div>
        <h1>{{ $article->title }}</h1>
        <p style="margin-top: 0.5rem; opacity: 0.95; font-size: 1.05rem;">
            Temukan daftar lengkap kata dan padanannya dalam artikel ini
        </p>
    </div>
</div>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Summary Stats -->
    @php
        $totalWords = $article->wordRelations->count();
        $totalWordClasses = $article->wordRelations->groupBy('wordclass_id')->count();
    @endphp
    @if($totalWords > 0)
        <div class="summary-stats">
            <div class="stat-box">
                <span class="stat-number">{{ $totalWords }}</span>
                <span class="stat-label">Total Kata</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $totalWordClasses }}</span>
                <span class="stat-label">Kelas Kata</span>
            </div>
        </div>
    @endif

    <!-- Daftar Kata Berdasarkan Word Class -->
    @if($article->wordRelations->count() > 0)
        @foreach($article->wordRelations->groupBy('wordclass_id') as $wordclassId => $wordsByClass)
            @php
                $wordClass = $wordsByClass->first()->wordClass;
                $uniqueLemmas = $wordsByClass->map(fn($w) => $w->lemma_id)->unique()->count();
            @endphp
            
            <div class="wordclass-section">
                <div class="wordclass-header">
                    <div class="wordclass-badge">
                        {{ strtoupper($wordClass->abbr ?? substr($wordClass->name, 0, 3)) }}
                    </div>
                    <h2 class="wordclass-title">{{ $wordClass->name }}</h2>
                    <div class="wordclass-count">{{ $uniqueLemmas }} kata</div>
                </div>

                <div class="lemma-list">
                    @foreach($wordsByClass->sortBy('word_order') as $relation)
                        <div class="lemma-card">
                            <div class="lemma-card-header">
                                <a href="{{ route('lemma', $relation->lemma->slug) }}" class="lemma-name-link">
                                    {{ $relation->lemma->name }}
                                </a>
                                @if($relation->type)
                                    <span class="lemma-type-tag">{{ strtoupper($relation->type->name) }}</span>
                                @endif
                            </div>

                            <!-- Label -->
                            @if($relation->lemma->label)
                                <span class="lemma-label">
                                    {{ $relation->lemma->label->abbr ?? $relation->lemma->label->name }}
                                </span>
                            @endif

                            <!-- Description -->
                            @if($relation->description)
                                <div class="lemma-description">
                                    {{ $relation->description }}
                                </div>
                            @endif

                            <!-- Metadata -->
                            <div class="lemma-metadata">
                                @if($relation->meaning_group)
                                    <span class="metadata-badge">Grup: {{ $relation->meaning_group }}</span>
                                @endif
                                @if($relation->word_order)
                                    <span class="metadata-badge">Urutan: {{ $relation->word_order }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem;">Belum Ada Kata</h3>
            <p style="margin-bottom: 1.5rem;">Artikel ini belum memiliki daftar kata. Silakan tambahkan melalui admin panel.</p>
            @if(auth()->check())
                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary">
                    Tambah Kata
                </a>
            @endif
        </div>
    @endif

    <!-- Admin Actions -->
    @if(auth()->check())
        <div class="mt-5" style="border-top: 1px solid #e0e0e0; padding-top: 2rem;">
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning">
                    ✏️ Edit Artikel
                </a>
                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                        🗑️ Hapus Artikel
                    </button>
                </form>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                    ← Kembali ke Daftar Artikel
                </a>
            </div>
        </div>
    @else
        <!-- Public Navigation -->
        <div class="mt-5" style="border-top: 1px solid #e0e0e0; padding-top: 2rem;">
            @if($article->subcategory)
                <a href="{{ route('articles.subcategory', $article->subcategory->slug) }}" class="btn btn-outline-primary">
                    ← Kembali ke {{ $article->subcategory->title }}
                </a>
            @else
                <a href="{{ route('articles.index') }}" class="btn btn-outline-primary">
                    ← Kembali ke Artikel
                </a>
            @endif
        </div>
    @endif
</div>
@endsection

<style>
    /* Content Display Styling */
    .content-display {
        background: #f9f7f4;
        padding: 2rem;
        border-radius: 0.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .word-class-section {
        margin-bottom: 2rem;
    }

    .word-class-label {
        background: #333;
        color: white;
        padding: 0.5rem 1rem;
        display: inline-block;
        font-size: 0.85rem;
        font-weight: bold;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
    }

    .word-entry {
        margin-left: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #ddd;
    }

    .word-entry:last-child {
        border-bottom: none;
    }

    .lemma-main {
        margin-bottom: 0.5rem;
    }

    .lemma-name {
        font-size: 1.1rem;
        color: #333;
    }

    .type-badge {
        display: inline-block;
        background: #e9ecef;
        color: #495057;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.85rem;
        margin-left: 0.5rem;
    }

    .description {
        margin-top: 0.5rem;
        color: #555;
        line-height: 1.6;
    }

    .labels-related {
        margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-display {
            padding: 1rem;
        }

        .word-entry {
            margin-left: 0.5rem;
        }
    }
</style>
@endsection
