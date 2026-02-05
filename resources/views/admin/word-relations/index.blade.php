@extends('admin.layouts.app')

@section('title', 'Manajemen Relasi Kata')

@push('styles')
<style>
    .word-relation-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
        transition: all 0.2s;
    }

    .word-relation-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .relation-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
    }

    .relation-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .relation-meta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .badge-relation {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-superordinate {
        background: #fef08a;
        color: #854d0e;
    }

    .relation-details {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 6px;
        margin: 1rem 0;
        font-size: 0.85rem;
        color: var(--text-light);
    }

    .relation-details strong {
        color: var(--text-dark);
    }

    .relation-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-relation {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-edit-relation {
        background: var(--primary-blue);
        color: white;
    }

    .btn-edit-relation:hover {
        background: #1d4ed8;
    }

    .btn-delete-relation {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete-relation:hover {
        background: #fecaca;
    }
</style>
@endpush

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 class="page-title">Manajemen Relasi Kata (Word Relations)</h1>
        <p class="page-subtitle">Kelola hubungan antara lemma dan artikel dalam tesaurus</p>
    </div>
    <a href="{{ route('admin.word-relations.create') }}" class="btn btn-primary">+ Tambah Relasi Kata</a>
</div>

@if(session('success'))
    <div style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 6px; margin-bottom: 2rem; border-left: 4px solid #2563eb;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div style="margin-bottom: 1.5rem;">
        <form method="GET" style="display: flex; gap: 1rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan lemma..." 
                   value="{{ request('search') }}" style="flex: 1; max-width: 400px;">
            
            <select name="article_id" class="form-control" style="max-width: 300px;">
                <option value="">Semua Artikel</option>
                @foreach($articles as $article)
                    <option value="{{ $article->id }}" {{ request('article_id') == $article->id ? 'selected' : '' }}>
                        {{ $article->title ?? 'Artikel #'.$article->id }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.word-relations.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    @forelse($wordRelations as $relation)
        <div class="word-relation-card">
            <div class="relation-header">
                <div>
                    <div class="relation-title">
                        <strong>{{ $relation->lemma->name ?? 'N/A' }}</strong>
                        @if($relation->article)
                            dalam <em>"{{ $relation->article->title }}"</em>
                        @endif
                    </div>
                </div>
            </div>

            <div class="relation-meta">
                @if($relation->lemma && $relation->lemma->label)
                    <span class="badge-relation">{{ $relation->lemma->label->name }}</span>
                @endif
                
                @if($relation->wordClass)
                    <span class="badge-relation">{{ $relation->wordClass->name }}</span>
                @endif

                @if($relation->is_superordinate)
                    <span class="badge-relation badge-superordinate">⭐ Superordinate</span>
                @endif

                @if($relation->relationshipType)
                    <span class="badge-relation">{{ $relation->relationshipType->name }}</span>
                @endif
            </div>

            <div class="relation-details">
                <div>
                    <strong>Artikel:</strong> {{ $relation->article->title ?? 'Tanpa Judul' }}<br>
                    <strong>Kata Kelas:</strong> {{ $relation->wordClass->name ?? '-' }}<br>
                    <strong>Paragraf:</strong> {{ $relation->par_num ?? '-' }} | 
                    <strong>Urutan:</strong> {{ $relation->word_order ?? '-' }}
                </div>
                
                @if($relation->description)
                    <div style="margin-top: 0.5rem;">
                        <strong>Deskripsi:</strong> {{ $relation->description }}
                    </div>
                @endif

                @if($relation->foreign_language)
                    <div style="margin-top: 0.5rem;">
                        <strong>Bahasa Asing:</strong> {{ $relation->foreign_language }}
                        @if($relation->language_variant)
                            ({{ $relation->language_variant }})
                        @endif
                    </div>
                @endif
            </div>

            <div class="relation-actions">
                <a href="{{ route('admin.word-relations.edit', $relation) }}" class="btn-relation btn-edit-relation">
                    ✏️ Edit
                </a>
                <form method="POST" action="{{ route('admin.word-relations.destroy', $relation) }}" 
                      style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus relasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-relation btn-delete-relation">🗑️ Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 3rem 2rem; color: var(--text-light);">
            <p style="font-size: 1rem; margin-bottom: 0.5rem;">Tidak ada relasi kata ditemukan</p>
            <a href="{{ route('admin.word-relations.create') }}" class="btn btn-primary">Buat Relasi Kata Pertama</a>
        </div>
    @endforelse

    @if($wordRelations->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $wordRelations->links() }}
        </div>
    @endif
</div>
@endsection
