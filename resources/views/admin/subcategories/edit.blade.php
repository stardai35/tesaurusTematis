@extends('admin.layouts.app')

@section('page-title', 'Edit Subkategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Subkategori</h1>
</div>

<div class="card">
    <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Kategori <span style="color: #ef4444;">*</span></label>
            <select name="cat_id" class="form-control" required>
                <option value="">- Pilih Kategori -</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('cat_id', $subcategory->cat_id) == $cat->id)>{{ $cat->title }}</option>
                @endforeach
            </select>
            @error('cat_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Subkategori <span style="color: #ef4444;">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $subcategory->title) }}" required>
            @error('title') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Urutan</label>
            <input type="number" name="num" class="form-control" value="{{ old('num', $subcategory->num) }}">
            @error('num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
