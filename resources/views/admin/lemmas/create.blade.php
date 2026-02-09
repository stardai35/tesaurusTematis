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
            <label class="form-label">Nama Lemma <span style="color: #ef4444;">*</span></label>
            <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lemma" value="{{ old('name') }}">
            @error('name') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Label </label>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.25rem;">
                    <input type="radio" name="label_id" value="" @checked(empty(old('label_id')))>
                    <span style="color:#888;">Tanpa Label</span>
                </label>
                @foreach($labels as $label)
                    <label style="display: flex; align-items: center; gap: 0.25rem;">
                        <input type="radio" name="label_id" value="{{ $label->id }}" @checked(old('label_id') == $label->id)>
                        {{ $label->name }}
                    </label>
                @endforeach
            </div>
                        @error('label_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Tipe</label>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.25rem;">
                    <input type="radio" name="type_id" value="" @checked(empty(old('type_id')))>
                    <span style="color:#888;">Tanpa Tipe</span>
                </label>
                @foreach($types as $type)
                    <label style="display: flex; align-items: center; gap: 0.25rem;">
                        <input type="radio" name="type_id" value="{{ $type->id }}" @checked(old('type_id') == $type->id)>
                        {{ $type->name }}
                    </label>
                @endforeach
            </div>
            @error('type_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Kelas Kata</label>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                <label style="display: flex; align-items: center; gap: 0.25rem;">
                    <input type="radio" name="wordclass_id" value="" @checked(empty(old('wordclass_id')))>
                    <span style="color:#888;">Tanpa Kelas Kata</span>
                </label>
                @foreach($wordClasses as $wc)
                    <label style="display: flex; align-items: center; gap: 0.25rem;">
                        <input type="radio" name="wordclass_id" value="{{ $wc->id }}" @checked(old('wordclass_id') == $wc->id)>
                        {{ $wc->name }}
                    </label>
                @endforeach
            </div>
            @error('wordclass_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label class="form-label">Artikel Sumber </label>
            <select name="article_id" class="form-control">
                <option value="">- Pilih Artikel -</option>
                @if(isset($articles))
                    @foreach($articles as $article)
                        <option value="{{ $article->id }}" @selected(old('article_id') == $article->id)>{{ $article->title }}</option>
                    @endforeach
                @endif
            </select>
            @error('article_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Paragraf pada Artikel</label>
            <input type="number" name="par_num" class="form-control" placeholder="Nomor paragraf dalam artikel (opsional)" value="{{ old('par_num') }}" min="1">
            @error('par_num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.lemmas.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Lemma</button>
        </div>
    </form>
</div>
@endsection
