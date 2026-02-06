@extends('admin.layouts.app')

@section('page-title', 'Daftar Artikel')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Artikel</h1>
    <div class="page-actions">
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">+ Tambah Artikel</a>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.articles.index') }}" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Lemma</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>#{{ $article->id }}</td>
                    <td><strong>{{ $article->title }}</strong></td>
                    <td>{{ $article->category?->name ?? '-' }}</td>
                    <td>{{ $article->subcategory?->name ?? '-' }}</td>
                    <td>
                        @if($article->wordRelations->count() > 0)
                            <span class="badge badge-primary">{{ $article->wordRelations->count() }} lemma</span>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #9ca3af; padding: 2rem;">Tidak ada artikel</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($articles->hasPages())
        <div class="pagination">
            @if($articles->onFirstPage())
                <span>« Sebelumnya</span>
            @else
                <a href="{{ $articles->previousPageUrl() }}">« Sebelumnya</a>
            @endif

            @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                @if($page == $articles->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}">Selanjutnya »</a>
            @else
                <span>Selanjutnya »</span>
            @endif
        </div>
    @endif
</div>
@endsection
