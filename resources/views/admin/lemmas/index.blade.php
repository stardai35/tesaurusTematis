@extends('admin.layouts.app')

@section('title', 'Daftar Lemma')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Daftar Lemma</h1>
        <p class="page-subtitle">Kelola semua lemma/kata dalam tesaurus</p>
    </div>
    <a href="{{ route('admin.lemmas.create') }}" class="btn btn-primary">+ Tambah Lemma</a>
</div>

<div class="card">
    <form method="GET" style="margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 1rem;">
            <input type="text" name="search" class="form-control" placeholder="Cari lemma..." value="{{ request('search') }}" style="flex: 1;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Label</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lemmas as $lemma)
            <tr>
                <td>{{ $lemma->id }}</td>
                <td><strong>{{ $lemma->name }}</strong></td>
                <td><span class="badge badge-nomina">{{ $lemma->label ? $lemma->label->name : '-' }}</span></td>
                <td>
                    <a href="{{ route('admin.lemmas.edit', $lemma) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.lemmas.destroy', $lemma) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-light);">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($lemmas->hasPages())
    <div class="pagination">
        {{ $lemmas->links() }}
    </div>
    @endif
</div>
@endsection
