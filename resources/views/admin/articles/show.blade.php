@extends('admin.layouts.app')

@section('page-title', $article->title)

@push('styles')
<style>
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .card h3 {
        margin-bottom: 1rem;
        font-size: 1rem;
        color: #6b7280;
    }

    .info-section {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .info-value {
        font-weight: 600;
        color: #1f2937;
    }

    .stat-value {
        font-size: 1.5rem;
        color: #1e56a0;
        font-weight: 700;
    }

    .table-wrapper {
        margin-top: 1rem;
    }

    .action-button {
        margin-top: 1rem;
    }

    .empty-state {
        text-align: center;
        color: #9ca3af;
        padding: 2rem;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $article->title }}</h1>
    <div class="page-actions">
        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="info-grid">
    <div class="card">
        <h3>Informasi Dasar</h3>
        <div class="info-section">
            <div class="info-item">
                <div class="info-label">ID</div>
                <div class="info-value">#{{ $article->id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Kategori</div>
                <div class="info-value">{{ $article->category?->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Sub Kategori</div>
                <div class="info-value">{{ $article->subcategory?->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Nomor Urut</div>
                <div class="info-value">{{ $article->num ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3>Statistik</h3>
        <div class="info-section">
            <div class="info-item">
                <div class="info-label">Total Lemma</div>
                <div class="stat-value">{{ $article->wordRelations->count() }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Paragraf</div>
                <div class="stat-value">{{ $article->wordRelations->max('par_num') ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <h3>Lemma dalam Artikel</h3>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 200px;">Lemma</th>
                <th>Word Class</th>
                <th>Tipe</th>
                <th style="width: 100px;">Paragraf</th>
                <th>Deskripsi</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($article->wordRelations as $relation)
                <tr>
                    <td><strong>{{ $relation->lemma?->name ?? '-' }}</strong></td>
                    <td><span class="badge">{{ $relation->wordClass?->name ?? '-' }}</span></td>
                    <td>{{ $relation->type?->name ?? '-' }}</td>
                    <td>{{ $relation->par_num ?? '-' }}</td>
                    <td style="font-size: 0.875rem; color: #6b7280;">{{ $relation->description ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.word-relations.destroy', $relation) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus lemma ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-state">Belum ada lemma</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="action-button">
        <a href="{{ route('admin.word-relations.by-article', $article) }}" class="btn btn-primary">Tambah / Kelola Lemma</a>
    </div>
</div>
@endsection
