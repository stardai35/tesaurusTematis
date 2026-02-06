@extends('admin.layouts.app')

@section('page-title', 'Daftar Lemma')

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Lemma</h1>
    <div class="page-actions">
        <a href="{{ route('admin.lemmas.create') }}" class="btn btn-primary">+ Tambah Lemma</a>
    </div>
</div>

<div class="card">
    <form method="GET" action="{{ route('admin.lemmas.index') }}" style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem;">
        <input type="text" name="search" class="form-control" placeholder="Cari lemma..." value="{{ request('search') }}" style="flex: 1;">
        <button type="submit" class="btn btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.lemmas.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Nama Lemma</th>
                <th>Label</th>
                <th>Slug</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lemmas as $lemma)
                <tr>
                    <td>#{{ $lemma->id }}</td>
                    <td><strong>{{ $lemma->name }}</strong></td>
                    <td>
                        @if($lemma->label)
                            <span class="badge badge-primary">{{ $lemma->label->name }}</span>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td><code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">{{ $lemma->slug }}</code></td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.lemmas.show', $lemma) }}" class="btn btn-sm btn-primary">Lihat</a>
                            <a href="{{ route('admin.lemmas.edit', $lemma) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.lemmas.destroy', $lemma) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #9ca3af; padding: 2rem;">Tidak ada lemma</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($lemmas->hasPages())
        <div class="pagination" style="margin-top: 1.5rem;">
            @if($lemmas->onFirstPage())
                <span>« Sebelumnya</span>
            @else
                <a href="{{ $lemmas->previousPageUrl() }}">« Sebelumnya</a>
            @endif

            @foreach($lemmas->getUrlRange(1, $lemmas->lastPage()) as $page => $url)
                @if($page == $lemmas->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($lemmas->hasMorePages())
                <a href="{{ $lemmas->nextPageUrl() }}">Berikutnya »</a>
            @else
                <span>Berikutnya »</span>
            @endif
        </div>
    @endif
</div>
@endsection
