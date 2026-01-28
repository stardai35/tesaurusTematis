@extends('admin.layouts.app')

@section('title', 'Edit Lemma')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Lemma</h1>
    <p class="page-subtitle">Ubah informasi lemma: <strong>{{ $lemma->name }}</strong></p>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.lemmas.update', $lemma) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Label (Jenis Kata) *</label>
            <select name="label_id" class="form-control" required>
                <option value="">Pilih Label</option>
                @foreach($labels as $label)
                    <option value="{{ $label->id }}" {{ old('label_id', $lemma->label_id) == $label->id ? 'selected' : '' }}>
                        {{ $label->name }}
                    </option>
                @endforeach
            </select>
            @error('label_id')
                <small style="color: var(--danger);">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Lemma *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $lemma->name) }}" required>
            @error('name')
                <small style="color: var(--danger);">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Tagged (Opsional)</label>
            <input type="text" name="name_tagged" class="form-control" value="{{ old('name_tagged', $lemma->name_tagged) }}">
            @error('name_tagged')
                <small style="color: var(--danger);">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.lemmas.index') }}" class="btn" style="background: #e5e7eb;">Batal</a>
        </div>
    </form>
</div>
@endsection
