@extends('admin.layouts.app')

@section('page-title', 'Daftar Kategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Kategori</h1>
    <div class="page-actions">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Nama Kategori</th>
                <th style="width: 80px;">Urutan</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>#{{ $category->id }}</td>
                    <td><strong>{{ $category->title }}</strong></td>
                    <td>{{ $category->num ?? '-' }}</td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
        <div style="margin-top: 1.5rem;">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
