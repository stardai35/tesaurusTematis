@extends('admin.layouts.app')

@section('page-title', 'Edit Kategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Kategori</h1>
</div>

<div class="card">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama Kategori <span style="color: #ef4444;">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $category->title) }}" required>
            @error('title') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Urutan</label>
            <input type="number" name="num" class="form-control" value="{{ old('num', $category->num) }}">
            @error('num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
