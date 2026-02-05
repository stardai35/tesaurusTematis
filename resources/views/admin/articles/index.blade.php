@extends('admin.layouts.app')

@section('title', 'Daftar Artikel')

@push('styles')
<style>
    .article-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
    }

    .article-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .article-info {
        flex: 1;
    }

    .article-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .article-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .article-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-count {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .badge-empty {
        background: #fee2e2;
        color: #991b1b;
    }

    .article-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-edit {
        background: var(--primary-blue);
        color: white;
    }

    .btn-edit:hover {
        background: #1d4ed8;
    }

    .btn-relations {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-relations:hover {
        background: #fce7a0;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #fecaca;
    }

    @media (max-width: 768px) {
        .article-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .article-actions {
            margin-top: 1rem;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 class="page-title">Daftar Artikel</h1>
        <p class="page-subtitle">Kelola semua artikel/tema kata dan relasi katanya</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">+ Tambah Artikel</a>
</div>

@if(session('success'))
    <div style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 6px; margin-bottom: 2rem; border-left: 4px solid #2563eb;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <form method="GET" style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari artikel..." 
               value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    @forelse($articles as $article)
        <div class="article-card">
            <div class="article-info">
                <div class="article-title">
                    {{ $article->title ?? 'Artikel Tanpa Judul' }}
                </div>
                <div class="article-meta">
                    <span>📄 #{{ $article->id }}</span>
                    @if($article->category)
                        <span>📂 {{ $article->category->title }}</span>
                    @endif
                    @if($article->subcategory)
                        <span>📁 {{ $article->subcategory->title }}</span>
                    @endif
                </div>
                <div class="article-badges">
                    <span class="badge">Nomor: {{ $article->num }}</span>
                    @php
                        $relationsCount = $article->wordRelations->count();
                    @endphp
                    @if($relationsCount > 0)
                        <span class="badge badge-count">🔗 {{ $relationsCount }} relasi kata</span>
                    @else
                        <span class="badge badge-empty">⚠️ Belum ada relasi kata</span>
                    @endif
                </div>
            </div>

            <div class="article-actions">
                <a href="{{ route('admin.articles.edit', $article) }}" class="btn-action btn-edit">✏️ Edit</a>
                <a href="{{ route('admin.word-relations.index', ['article_id' => $article->id]) }}" 
                   class="btn-action btn-relations">🔗 Kelola Relasi</a>
                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" 
                      style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">🗑️ Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 3rem 2rem; color: var(--text-light);">
            <p style="font-size: 1rem; margin-bottom: 0.5rem;">Tidak ada artikel ditemukan</p>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Buat Artikel Pertama</a>
        </div>
    @endforelse

    @if($articles->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
