@extends('admin.layouts.app')

@section('page-title', 'Daftar Subkategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Subkategori</h1>
    <div class="page-actions">
        <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">+ Tambah Subkategori</a>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Nama Subkategori</th>
                <th>Kategori</th>
                <th style="width: 80px;">Urutan</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subcategories as $subcategory)
                <tr>
                    <td>#{{ $subcategory->id }}</td>
                    <td><strong>{{ $subcategory->title }}</strong></td>
                    <td>{{ $subcategory->category?->title ?? '-' }}</td>
                    <td>{{ $subcategory->num ?? '-' }}</td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #9ca3af;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($subcategories->hasPages())
        <div style="margin-top: 1.5rem;">
            {{ $subcategories->links() }}
        </div>
    @endif
</div>
@endsection
