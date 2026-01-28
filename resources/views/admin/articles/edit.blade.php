@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Artikel</h1>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.articles.update', $article) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Kategori *</label>
            <select name="cat_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $article->cat_id == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Subkategori</label>
            <select name="subcat_id" class="form-control">
                <option value="">Pilih Subkategori (Opsional)</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}" {{ $article->subcat_id == $subcat->id ? 'selected' : '' }}>
                        {{ $subcat->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Urut</label>
            <input type="number" name="num" class="form-control" value="{{ $article->num }}">
        </div>

        <div class="form-group">
            <label class="form-label">Judul Artikel *</label>
            <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.articles.index') }}" class="btn" style="background: #e5e7eb;">Batal</a>
        </div>
    </form>
</div>
@endsection
