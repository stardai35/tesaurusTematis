@extends('admin.layouts.app')

@section('title', 'Relasi Kata - ' . $article->title)

@push('styles')
<style>
    .article-header {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .article-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .word-relation-list {
        display: grid;
        gap: 1rem;
    }

    .relation-item {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #2563eb;
    }

    .relation-lemma {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 0.5rem;
    }

    .relation-meta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .badge-small {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        background: #e5e7eb;
        border-radius: 3px;
        font-size: 0.8rem;
    }

    .add-relation-btn {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary-blue);
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .add-relation-btn:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')
<a href="{{ route('admin.word-relations.index') }}" class="back-link">← Kembali ke Manajemen Relasi Kata</a>

<div class="article-header">
    <div class="article-title">{{ $article->title ?? 'Artikel Tanpa Judul' }}</div>
    <div style="color: var(--text-light);">
        <strong>Kategori:</strong> {{ $article->category->title ?? '-' }}<br>
        <strong>Subkategori:</strong> {{ $article->subcategory->title ?? '-' }}<br>
        <strong>ID Artikel:</strong> #{{ $article->id }}
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700;">Daftar Relasi Kata ({{ $wordRelations->count() }})</h2>
        <a href="{{ route('admin.word-relations.create', ['article_id' => $article->id]) }}" 
           class="add-relation-btn">+ Tambah Relasi</a>
    </div>

    @if($wordRelations->count() > 0)
        <div class="word-relation-list">
            @foreach($wordRelations as $relation)
                <div class="relation-item" style="display: flex; justify-content: space-between; align-items: start;">
                    <div style="flex: 1;">
                        <div class="relation-lemma">
                            {{ $relation->lemma->name }}
                        </div>
                        <div class="relation-meta">
                            @if($relation->lemma && $relation->lemma->label)
                                <span class="badge-small">{{ $relation->lemma->label->name }}</span>
                            @endif
                            @if($relation->wordClass)
                                <span class="badge-small">{{ $relation->wordClass->name }}</span>
                            @endif
                            @if($relation->is_superordinate)
                                <span class="badge-small" style="background: #fef08a; color: #854d0e;">⭐ Superordinate</span>
                            @endif
                        </div>
                        @if($relation->description)
                            <div style="color: var(--text-light); font-size: 0.9rem; margin-top: 0.5rem;">
                                {{ $relation->description }}
                            </div>
                        @endif
                    </div>
                    <div style="margin-left: 1rem;">
                        <a href="{{ route('admin.word-relations.edit', $relation) }}" 
                           style="display: inline-block; padding: 0.5rem 1rem; background: #dbeafe; color: #1e40af; border-radius: 6px; text-decoration: none; font-size: 0.9rem; margin-bottom: 0.5rem; width: 100%; text-align: center;">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.word-relations.destroy', $relation) }}" 
                              style="display: inline;" onsubmit="return confirm('Hapus relasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="display: block; padding: 0.5rem 1rem; background: #fee2e2; color: #991b1b; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; width: 100%; text-align: center;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 2rem; color: var(--text-light);">
            <p style="margin-bottom: 1rem;">Artikel ini belum memiliki relasi kata.</p>
            <a href="{{ route('admin.word-relations.create', ['article_id' => $article->id]) }}" 
               class="add-relation-btn">Tambah Relasi Kata Pertama</a>
        </div>
    @endif
</div>
@endsection
