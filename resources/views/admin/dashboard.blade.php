@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Selamat datang di Admin Panel Tesaurus Tematis</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_words'] }}</div>
        <div class="stat-label">Total Lemma</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_articles'] }}</div>
        <div class="stat-label">Total Artikel</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_categories'] }}</div>
        <div class="stat-label">Total Kategori</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total_relations'] }}</div>
        <div class="stat-label">Total Relasi</div>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 1rem;">Lemma Terbaru</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Label</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentLemmas as $lemma)
            <tr>
                <td><strong>{{ $lemma->name }}</strong></td>
                <td><span class="badge badge-nomina">{{ $lemma->label ? $lemma->label->name : '-' }}</span></td>
                <td>
                    <a href="{{ route('admin.lemmas.edit', $lemma) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; color: var(--text-light);">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <h2 style="margin-bottom: 1rem;">Artikel Terbaru</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentArticles as $article)
            <tr>
                <td><strong>{{ $article->title }}</strong></td>
                <td>{{ $article->category->title }}</td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; color: var(--text-light);">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
