@extends('admin.layouts.app')

@section('page-title', 'Tambah Kategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Kategori Baru</h1>
</div>

<div class="card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Nama Kategori <span style="color: #ef4444;">*</span></label>
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
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
