@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Artikel Baru</h1>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.articles.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Kategori *</label>
            <select name="cat_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Subkategori</label>
            <select name="subcat_id" class="form-control">
                <option value="">Pilih Subkategori (Opsional)</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}">{{ $subcat->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Urut</label>
            <input type="number" name="num" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Judul Artikel *</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.articles.index') }}" class="btn" style="background: #e5e7eb;">Batal</a>
        </div>
    </form>
</div>
@endsection
