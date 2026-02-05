@extends('layouts.app')

@section('title', $subcategory->title . ' - Tesaurus Tematis')
@section('description', 'Daftar kata dan padanan untuk ' . $subcategory->title)

@push('styles')
<style>
    .article-header {
        background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 35%, #5ba89f 70%, #a8dadc 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 3rem;
    }

    .article-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .article-header .breadcrumb {
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .article-header .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: opacity 0.3s;
    }

    .article-header .breadcrumb a:hover {
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
        font-size: 1.1rem;
        margin-right: 1rem;
        min-width: 150px;
        text-align: center;
    }

    .wordclass-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e56a0;
        margin: 0;
    }

    .words-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .word-card {
        background: white;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .word-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-color: #1e56a0;
    }

    .word-main {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .word-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e56a0;
        word-break: break-word;
        flex: 1;
    }

    .type-tag {
        display: inline-block;
        background: #f0f0f0;
        color: #666;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 0.5rem;
    }

    .label-info {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .label-badge {
        background: #e3f2fd;
        color: #1e56a0;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid #1e56a0;
    }

    .description-text {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        padding: 1rem 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }

    .words-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .word-link {
        display: inline-block;
        background: #f8f8f8;
        color: #1e56a0;
        padding: 0.5rem 0.8rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .word-link:hover {
        background: #1e56a0;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #999;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .article-header h1 {
            font-size: 1.75rem;
        }

        .wordclass-header {
            flex-wrap: wrap;
        }

        .wordclass-badge {
            width: 100%;
            margin-bottom: 1rem;
        }

        .words-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="article-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span> > </span>
            <a href="{{ route('category') }}">Kategori</a>
            <span> > </span>
            <a href="{{ route('category') }}?cat={{ $articles->first()?->category->id ?? 1 }}">
                {{ $articles->first()?->category->title ?? 'Kategori' }}
            </a>
            <span> > </span>
            <strong>{{ $subcategory->title }}</strong>
        </div>
        <h1 class="mt-3">{{ $subcategory->title }}</h1>
        <p style="margin-top: 0.5rem; opacity: 0.9;">
            Temukan daftar lengkap kata dan padanannya dalam kategori ini
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

    @if(count($groupedByWordClass) > 0)
        <!-- Tampilkan berdasarkan Word Class -->
        @foreach($groupedByWordClass as $wordClassName => $relations)
            <div class="wordclass-section">
                <div class="wordclass-header">
                    <div class="wordclass-badge">{{ strtoupper($wordClassName) }}</div>
                    <h2 class="wordclass-title">{{ $wordClassName }}</h2>
                </div>

                <div class="words-grid">
                    @foreach($relations as $relation)
                        <div class="word-card">
                            <div class="word-main">
                                <a href="{{ route('lemma', $relation->lemma->slug) }}" class="word-name">
                                    {{ $relation->lemma->name }}
                                </a>
                                @if($relation->type)
                                    <span class="type-tag">{{ $relation->type->name }}</span>
                                @endif
                            </div>

                            <!-- Label Info -->
                            @if($relation->lemma->label)
                                <div class="label-info">
                                    <span class="label-badge">
                                        {{ $relation->lemma->label->abbr ?? $relation->lemma->label->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Description -->
                            @if($relation->description)
                                <div class="description-text">
                                    {{ $relation->description }}
                                </div>
                            @endif

                            <!-- Related Words -->
                            @php
                                $relatedLemmas = \App\Models\Lemma::where('label_id', $relation->lemma->label_id ?? null)
                                    ->where('id', '!=', $relation->lemma->id)
                                    ->limit(5)
                                    ->get();
                            @endphp
                            @if($relatedLemmas->count() > 0)
                                <div class="words-list">
                                    @foreach($relatedLemmas as $lemma)
                                        <a href="{{ route('lemma', $lemma->slug) }}" class="word-link">
                                            {{ $lemma->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3>Belum Ada Data</h3>
            <p>Subcategori ini belum memiliki artikel. Silakan tambahkan artikel melalui admin panel.</p>
            @if(auth()->check())
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mt-3">
                    Tambah Artikel
                </a>
            @endif
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-5">
        <a href="{{ route('category') }}" class="btn btn-outline-primary">
            ← Kembali ke Kategori
        </a>
    </div>
</div>
@endsection
