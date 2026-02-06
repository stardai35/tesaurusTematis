@extends('admin.layouts.app')

@section('page-title', 'Daftar Word Relation')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Word Relation</h1>
    <div class="page-actions">
        <a href="{{ route('admin.word-relations.create') }}" class="btn btn-primary">+ Tambah Word Relation</a>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.word-relations.index') }}" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan artikel atau lemma..." value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.word-relations.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Artikel</th>
                <th>Lemma</th>
                <th>Word Class</th>
                <th>Tipe</th>
                <th>Par. Num</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($wordRelations as $wr)
                <tr>
                    <td>#{{ $wr->id }}</td>
                    <td><strong>{{ $wr->article?->title ?? '-' }}</strong></td>
                    <td>{{ $wr->lemma?->name ?? '-' }}</td>
                    <td>{{ $wr->wordClass?->name ?? '-' }}</td>
                    <td>{{ $wr->type?->name ?? '-' }}</td>
                    <td>{{ $wr->par_num ?? '-' }}</td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.word-relations.show', $wr) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('admin.word-relations.edit', $wr) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.word-relations.destroy', $wr) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #9ca3af; padding: 2rem;">Tidak ada word relation</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($wordRelations->hasPages())
        <div class="pagination">
            @if($wordRelations->onFirstPage())
                <span>« Sebelumnya</span>
            @else
                <a href="{{ $wordRelations->previousPageUrl() }}">« Sebelumnya</a>
            @endif

            @foreach($wordRelations->getUrlRange(1, $wordRelations->lastPage()) as $page => $url)
                @if($page == $wordRelations->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($wordRelations->hasMorePages())
                <a href="{{ $wordRelations->nextPageUrl() }}">Berikutnya »</a>
            @else
                <span>Berikutnya »</span>
            @endif
        </div>
    @endif
</div>
@endsection
