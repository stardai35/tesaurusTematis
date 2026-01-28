@extends('admin.layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Daftar Kategori</h1>
        <p class="page-subtitle">Kelola kategori bidang ilmu</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nomor</th>
                <th>Judul</th>
                <th>Slug</th>
                <th>Jumlah Artikel</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->num }}</td>
                <td><strong>{{ $category->title }}</strong></td>
                <td><code>{{ $category->slug }}</code></td>
                <td>{{ $category->articles_count ?? 0 }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
    <div class="pagination">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
