@extends('admin.layouts.app')

@section('page-title', 'Tambah Lemma Baru')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Lemma Baru</h1>
</div>

<div class="card">
    <form action="{{ route('admin.lemmas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Label <span style="color: #ef4444;">*</span></label>
            <select name="label_id" class="form-control" required>
                <option value="">- Pilih Label -</option>
                @foreach($labels as $label)
                    <option value="{{ $label->id }}" @selected(old('label_id') == $label->id)>{{ $label->name }}</option>
                @endforeach
            </select>
            @error('label_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Lemma <span style="color: #ef4444;">*</span></label>
            <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lemma" value="{{ old('name') }}">
            @error('name') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Tagged</label>
            <input type="text" name="name_tagged" class="form-control" placeholder="Nama dengan tag (opsional)" value="{{ old('name_tagged') }}">
            @error('name_tagged') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.lemmas.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Lemma</button>
        </div>
    </form>
</div>
@endsection
