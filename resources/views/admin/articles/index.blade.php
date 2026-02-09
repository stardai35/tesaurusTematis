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
        <style>
        .futuristic-pagination {
            display: flex;
            justify-content: center;
            gap: 0.3rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            background: rgba(36,37,70,0.10);
            border-radius: 1.5rem;
            box-shadow: 0 2px 16px 0 rgba(80,80,180,0.10);
            padding: 0.7rem 1.5rem;
        }
        .futuristic-pagination a, .futuristic-pagination span {
            padding: 0.5rem 1.1rem;
            border-radius: 0.7rem;
            background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border: none;
            box-shadow: 0 2px 8px 0 rgba(99,102,241,0.10);
            margin: 0 2px;
            transition: box-shadow 0.2s, background 0.2s, color 0.2s, filter 0.2s;
            filter: brightness(0.95);
        }
        .futuristic-pagination a:hover {
            filter: brightness(1.15) drop-shadow(0 0 6px #6366f1cc);
            background: linear-gradient(90deg, #6366f1 0%, #3b82f6 100%);
            color: #fff;
        }
        .futuristic-pagination .active {
            background: linear-gradient(90deg, #6366f1 0%, #3b82f6 100%);
            color: #fff;
            font-weight: bold;
            box-shadow: 0 0 0 2px #6366f1, 0 2px 8px 0 rgba(99,102,241,0.15);
            filter: brightness(1.2);
        }
        .futuristic-pagination .disabled {
            color: #c7d2fe;
            background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(0.5);
        }
        </style>
        <div class="futuristic-pagination">
            @if($articles->onFirstPage())
                <span class="disabled">« Sebelumnya</span>
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
                <span class="disabled">Selanjutnya »</span>
            @endif
        </div>
    @endif
</div>
@endsection
