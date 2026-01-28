@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Kategori</h1>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Nomor Urut</label>
            <input type="number" name="num" class="form-control" value="{{ $category->num }}">
        </div>

        <div class="form-group">
            <label class="form-label">Judul Kategori *</label>
            <input type="text" name="title" class="form-control" value="{{ $category->title }}" required>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.categories.index') }}" class="btn" style="background: #e5e7eb;">Batal</a>
        </div>
    </form>
</div>
@endsection
