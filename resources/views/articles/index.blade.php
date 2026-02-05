@extends('layouts.app')

@section('title', 'Daftar Artikel - Tesaurus Tematis')

@push('styles')
<style>
    .articles-header {
        background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 100%);
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2.5rem;
        border-radius: 0 0 12px 12px;
    }

    .articles-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .articles-header p {
        opacity: 0.95;
        margin: 0;
    }

    .article-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .article-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        border-color: #1e56a0;
    }

    .article-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .article-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e56a0;
        margin: 0;
        flex: 1;
    }

    .article-title a {
        color: #1e56a0;
        text-decoration: none;
        transition: color 0.2s;
    }

    .article-title a:hover {
        color: #163d6f;
        text-decoration: underline;
    }

    .article-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1rem 0;
        padding: 1rem 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }

    .article-meta-item {
        font-size: 0.9rem;
        color: #666;
    }

    .article-meta-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .article-stats {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .stat-badge {
        background: #f0f0f0;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e56a0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stat-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        background: #1e56a0;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .article-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-view {
        flex: 1;
        text-align: center;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #999;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .article-card-header {
            flex-direction: column;
        }

        .article-meta {
            grid-template-columns: 1fr;
        }

        .article-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="articles-header">
    <div class="container">
        <h1>Daftar Artikel</h1>
        <p>Kelola semua artikel dalam tesaurus Anda</p>
    </div>
</div>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($articles->count())
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('articles.create') }}" class="btn btn-primary btn-lg">
                ✏️ Buat Artikel Baru
            </a>
        </div>

        @foreach($articles as $article)
            <div class="article-card">
                <div class="article-card-header">
                    <h2 class="article-title">
                        <a href="{{ route('articles.show', $article) }}">
                            {{ $article->title }}
                        </a>
                    </h2>
                </div>

                <div class="article-meta">
                    <div class="article-meta-item">
                        <span class="article-meta-label">Kategori</span>
                        {{ $article->category->title ?? '—' }}
                    </div>
                    <div class="article-meta-item">
                        <span class="article-meta-label">Sub-Kategori</span>
                        {{ $article->subcategory->title ?? '—' }}
                    </div>
                    <div class="article-meta-item">
                        <span class="article-meta-label">Nomor Urut</span>
                        {{ $article->num ?? '—' }}
                    </div>
                </div>

                <div class="article-stats">
                    <div class="stat-badge">
                        <span class="stat-icon">📝</span>
                        {{ $article->wordRelations->count() }} Kata
                    </div>
                    <div class="stat-badge">
                        <span class="stat-icon">📂</span>
                        {{ $article->wordRelations->groupBy('wordclass_id')->count() }} Kelas Kata
                    </div>
                </div>

                <div class="article-actions">
                    <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-view">
                        👁️ Lihat Artikel
                    </a>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline; flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3>Belum Ada Artikel</h3>
            <p style="color: #999; margin-bottom: 1.5rem;">Mulai buat artikel pertama Anda sekarang</p>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-lg">
                ✏️ Buat Artikel Pertama
            </a>
        </div>
    @endif
</div>
@endsection
