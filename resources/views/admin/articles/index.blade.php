@extends('admin.layouts.app')

@section('title', 'Daftar Artikel')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Daftar Artikel</h1>
        <p class="page-subtitle">Kelola semua artikel/tema kata</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">+ Tambah Artikel</a>
</div>

<div class="card">
    <form method="GET" style="margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 1rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}" style="flex: 1;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Slug</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td><strong>{{ $article->title }}</strong></td>
                <td>{{ $article->category->title }}</td>
                <td><code>{{ $article->slug }}</code></td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($articles->hasPages())
    <div class="pagination">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection
