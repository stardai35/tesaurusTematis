@extends('admin.layouts.app')

@section('title', 'Daftar Relasi Kata')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Daftar Relasi Kata</h1>
        <p class="page-subtitle">Kelola relasi sinonim, antonim, contoh, dll</p>
    </div>
    <a href="{{ route('admin.word-relations.create') }}" class="btn btn-primary">+ Tambah Relasi</a>
</div>

<div class="card">
    <form method="GET" style="margin-bottom: 1.5rem;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 100px; gap: 1rem;">
            <select name="article_id" class="form-control">
                <option value="">Semua Artikel</option>
                @foreach($articles as $article)
                    <option value="{{ $article->id }}" {{ request('article_id') == $article->id ? 'selected' : '' }}>
                        {{ $article->title }}
                    </option>
                @endforeach
            </select>
            <select name="lemma_id" class="form-control">
                <option value="">Semua Lemma</option>
                @foreach($lemmas->take(50) as $lemma)
                    <option value="{{ $lemma->id }}" {{ request('lemma_id') == $lemma->id ? 'selected' : '' }}>
                        {{ $lemma->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Artikel</th>
                <th>Lemma</th>
                <th>Kelas Kata</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($relations as $relation)
            <tr>
                <td>{{ $relation->id }}</td>
                <td>{{ $relation->article->title }}</td>
                <td><strong>{{ $relation->lemma->name }}</strong></td>
                <td>{{ $relation->wordClass->name }}</td>
                <td><span class="badge badge-nomina">{{ $relation->type->name }}</span></td>
                <td>
                    <a href="{{ route('admin.word-relations.edit', $relation) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.word-relations.destroy', $relation) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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

    @if($relations->hasPages())
    <div class="pagination">
        {{ $relations->links() }}
    </div>
    @endif
</div>
@endsection
