@extends('admin.layouts.app')

@section('page-title', 'Edit Artikel')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Artikel: {{ $article->title }}</h1>
</div>

<div class="card">
    <form action="{{ route('admin.articles.update', $article) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kategori <span style="color: #ef4444;">*</span></label>
                <select name="cat_id" class="form-control" required>
                    <option value="">- Pilih Kategori -</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($article->cat_id == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('cat_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Sub Kategori</label>
                <select name="subcat_id" class="form-control">
                    <option value="">- Pilih Sub Kategori -</option>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->id }}" @selected($article->subcat_id == $subcat->id)>{{ $subcat->name }}</option>
                    @endforeach
                </select>
                @error('subcat_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Judul Artikel <span style="color: #ef4444;">*</span></label>
            <input type="text" name="title" class="form-control" required placeholder="Masukkan judul artikel" value="{{ old('title', $article->title) }}">
            @error('title') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nomor Urut</label>
                <input type="number" name="num" class="form-control" placeholder="Nomor urut" value="{{ old('num', $article->num) }}">
                @error('num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h3 style="font-size: 1.125rem;">Lemma dalam Artikel</h3>
            <a href="{{ route('admin.word-relations.by-article', $article) }}" class="btn btn-secondary btn-sm">Kelola Lemma</a>
        </div>

        <table class="table" style="margin-bottom: 2rem;">
            <thead>
                <tr>
                    <th>Lemma</th>
                    <th>Word Class</th>
                    <th>Tipe</th>
                    <th>Paragraf</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($article->wordRelations as $relation)
                    <tr>
                        <td>{{ $relation->lemma?->name ?? '-' }}</td>
                        <td>{{ $relation->wordClass?->name ?? '-' }}</td>
                        <td>{{ $relation->type?->name ?? '-' }}</td>
                        <td>{{ $relation->par_num ?? '-' }}</td>
                        <td>{{ $relation->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #9ca3af;">Belum ada lemma</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
