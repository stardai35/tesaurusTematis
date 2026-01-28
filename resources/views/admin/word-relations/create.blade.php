@extends('admin.layouts.app')

@section('title', 'Tambah Relasi Kata')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Relasi Kata Baru</h1>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.word-relations.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Artikel *</label>
            <select name="article_id" class="form-control" required>
                <option value="">Pilih Artikel</option>
                @foreach($articles as $article)
                    <option value="{{ $article->id }}">{{ $article->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Lemma *</label>
            <select name="lemma_id" class="form-control" required>
                <option value="">Pilih Lemma</option>
                @foreach($lemmas as $lemma)
                    <option value="{{ $lemma->id }}">{{ $lemma->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Kelas Kata *</label>
            <select name="wordclass_id" class="form-control" required>
                <option value="">Pilih Kelas Kata</option>
                @foreach($wordClasses as $wc)
                    <option value="{{ $wc->id }}">{{ $wc->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Tipe Relasi *</label>
            <select name="type_id" class="form-control" required>
                <option value="">Pilih Tipe</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Paragraf</label>
            <input type="number" name="par_num" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Grup</label>
            <input type="number" name="group_num" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">Urutan Kata</label>
            <input type="number" name="word_order" class="form-control">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.word-relations.index') }}" class="btn" style="background: #e5e7eb;">Batal</a>
        </div>
    </form>
</div>
@endsection
