@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<h1 class="page-title" style="margin-bottom: 2rem;">Dashboard</h1>

<!-- Statistics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #1e56a0; margin-bottom: 0.5rem;">
            {{ $stats['total_words'] ?? 0 }}
        </div>
        <div style="color: #6b7280; font-size: 0.95rem;">Total Lemma</div>
    </div>

    <div class="card" style="text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #10b981; margin-bottom: 0.5rem;">
            {{ $stats['total_articles'] ?? 0 }}
        </div>
        <div style="color: #6b7280; font-size: 0.95rem;">Total Artikel</div>
    </div>

    <div class="card" style="text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #f59e0b; margin-bottom: 0.5rem;">
            {{ $stats['total_categories'] ?? 0 }}
        </div>
        <div style="color: #6b7280; font-size: 0.95rem;">Total Kategori</div>
    </div>

    <div class="card" style="text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #8b5cf6; margin-bottom: 0.5rem;">
            {{ $stats['total_relations'] ?? 0 }}
        </div>
        <div style="color: #6b7280; font-size: 0.95rem;">Total Relasi Kata</div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1rem;">Aksi Cepat</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary" style="text-align: center; padding: 1rem;">
            + Tambah Artikel
        </a>
        <a href="{{ route('admin.lemmas.create') }}" class="btn btn-primary" style="text-align: center; padding: 1rem;">
            + Tambah Lemma
        </a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-secondary" style="text-align: center; padding: 1rem;">
            + Tambah Kategori
        </a>
        <a href="{{ route('admin.word-relations.index') }}" class="btn btn-secondary" style="text-align: center; padding: 1rem;">
            🔗 Kelola Relasi Kata
        </a>
    </div>
</div>
<!-- Recent Data -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Recent Articles -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 1.125rem;">Artikel Terbaru</h3>
            <a href="{{ route('admin.articles.index') }}" style="color: #1e56a0; text-decoration: none; font-size: 0.875rem;">Lihat Semua →</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($recentArticles as $article)
                <div style="padding: 0.75rem; background: #f9fafb; border-radius: 6px; border-left: 3px solid #1e56a0;">
                    <div style="font-weight: 500; margin-bottom: 0.25rem;">{{ $article->title }}</div>
                    <div style="font-size: 0.8rem; color: #6b7280;">
                        📁 {{ $article->category?->name ?? '-' }} / 
                        <span class="badge" style="font-size: 0.75rem;">{{ $article->wordRelations->count() }} lemma</span>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #9ca3af; padding: 1rem;">Belum ada artikel</div>
            @endforelse
        </div>
    </div>

    <!-- Recent Lemmas -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 1.125rem;">Lemma Terbaru</h3>
            <a href="{{ route('admin.lemmas.index') }}" style="color: #1e56a0; text-decoration: none; font-size: 0.875rem;">Lihat Semua →</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @forelse($recentLemmas as $lemma)
                <div style="padding: 0.75rem; background: #f9fafb; border-radius: 6px; border-left: 3px solid #10b981;">
                    <div style="font-weight: 500; margin-bottom: 0.25rem;">{{ $lemma->name }}</div>
                    <div style="font-size: 0.8rem; color: #6b7280;">
                        @if($lemma->label)
                            🏷️ {{ $lemma->label->name }}
                        @else
                            <span style="color: #d1d5db;">-</span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #9ca3af; padding: 1rem;">Belum ada lemma</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
