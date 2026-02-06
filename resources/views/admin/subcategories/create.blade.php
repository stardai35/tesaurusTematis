@extends('admin.layouts.app')

@section('page-title', 'Tambah Subkategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Subkategori Baru</h1>
</div>

<div class="card">
    <form action="{{ route('admin.subcategories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Kategori <span style="color: #ef4444;">*</span></label>
            <select name="cat_id" class="form-control" required>
                <option value="">- Pilih Kategori -</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('cat_id') == $cat->id)>{{ $cat->title }}</option>
                @endforeach
            </select>
            @error('cat_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Subkategori <span style="color: #ef4444;">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Urutan</label>
            <input type="number" name="num" class="form-control" value="{{ old('num') }}">
            @error('num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
