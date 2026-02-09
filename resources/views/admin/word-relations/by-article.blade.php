@extends('admin.layouts.app')

@section('page-title', 'Word Relations untuk Artikel: ' . $article->title)

@section('content')
<div class="page-header">
    <h1 class="page-title">Word Relations untuk Artikel: {{ $article->title }}</h1>
    <div class="page-actions">
        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-secondary">Edit Artikel</a>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-primary">Kembali ke Daftar Artikel</a>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1rem; font-size: 1rem;">Info Artikel</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div>
            <p style="margin-bottom: 0.5rem; font-size: 0.875rem; color: #6b7280;">Judul</p>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937; font-weight: 600;">{{ $article->title }}</p>
        </div>
        <div>
            <p style="margin-bottom: 0.5rem; font-size: 0.875rem; color: #6b7280;">Kategori</p>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937; font-weight: 600;">{{ $article->category?->name ?? '-' }}</p>
        </div>
        <div>
            <p style="margin-bottom: 0.5rem; font-size: 0.875rem; color: #6b7280;">Sub Kategori</p>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937; font-weight: 600;">{{ $article->subcategory?->name ?? '-' }}</p>
        </div>
        <div>
            <p style="margin-bottom: 0.5rem; font-size: 0.875rem; color: #6b7280;">Jumlah Word Relations</p>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937; font-weight: 600;">{{ $wordRelations->count() }}</p>
        </div>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0; font-size: 1.125rem;">Daftar Word Relations</h2>
        <a href="{{ route('admin.word-relations.create') }}" class="btn btn-primary">+ Tambah Word Relation</a>
    </div>

    @if($wordRelations->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Lemma</th>
                    <th>Word Class</th>
                    <th>Tipe</th>
                    <th>Par. Num</th>
                    <th>Word Order</th>
                    <th>Group Num</th>
                    <th>Meaning Group</th>
                    <th>Deskripsi</th>
                    <th>Superordinate</th>
                    <th>Foreign Lang</th>
                    <th>Lang Variant</th>
                    <th>Bold</th>
                    <th>Relasi Tipe</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wordRelations as $wr)
                    <tr>
                        <td>#{{ $wr->id }}</td>
                        <td><strong>{{ $wr->lemma?->name ?? '-' }}</strong></td>
                        <td>{{ $wr->wordClass?->name ?? '-' }}</td>
                        <td>{{ $wr->type?->name ?? '-' }}</td>
                        <td>{{ $wr->par_num ?? '-' }}</td>
                        <td>{{ $wr->word_order ?? '-' }}</td>
                        <td>{{ $wr->group_num ?? '-' }}</td>
                        <td>{{ $wr->meaning_group ?? '-' }}</td>
                        <td>{{ $wr->description ?? '-' }}</td>
                        <td>@if($wr->is_superordinate) <span style="color:green;">Ya</span> @else Tidak @endif</td>
                        <td>{{ $wr->foreign_language ?? '-' }}</td>
                        <td>{{ $wr->language_variant ?? '-' }}</td>
                        <td>@if($wr->is_bold) <span style="font-weight:bold;">Ya</span> @else Tidak @endif</td>
                        <td>{{ $wr->relationshipType?->name ?? '-' }}</td>
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
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 2rem; color: #9ca3af;">
            <p style="margin-bottom: 1rem;">Tidak ada word relation untuk artikel ini</p>
            <a href="{{ route('admin.word-relations.create') }}" class="btn btn-primary">Tambah Word Relation</a>
        </div>
    @endif
</div>
@endsection
