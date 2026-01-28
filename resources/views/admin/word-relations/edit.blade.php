@extends('admin.layouts.app')

@section('title', 'Edit Relasi Kata')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Relasi Kata</h1>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.word-relations.update', $wordRelation) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Artikel *</label>
            <select name="article_id" class="form-control" required>
                <option value="">Pilih Artikel</option>
                @foreach($articles as $article)
                    <option value="{{ $article->id }}" {{ $wordRelation->article_id == $article->id ? 'selected' : '' }}>
                        {{ $article->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Lemma *</label>
            <select name="lemma_id" class="form-control" required>
                <option value="">Pilih Lemma</option>
                @foreach($lemmas as $lemma)
                    <option value="{{ $lemma->id }}" {{ $wordRelation->lemma_id == $lemma->id ? 'selected' : '' }}>
                        {{ $lemma->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Kelas Kata *</label>
            <select name="wordclass_id" class="form-control" required>
                <option value="">Pilih Kelas Kata</option>
                @foreach($wordClasses as $wc)
                    <option value="{{ $wc->id }}" {{ $wordRelation->wordclass_id == $wc->id ? 'selected' : '' }}>
                        {{ $wc->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Tipe Relasi *</label>
            <select name="type_id" class="form-control" required>
                <option value="">Pilih Tipe</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ $wordRelation->type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Paragraf</label>
            <input type="number" name="par_num" class="form-control" value="{{ $wordRelation->par_num }}">
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Grup</label>
            <input type="number" name="group_num" class="form-control" value="{{ $wordRelation->group_num }}">
        </div>

        <div class="form-group">
            <label class="form-label">Urutan Kata</label>
            <input type="number" name="word_order" class="form-control" value="{{ $wordRelation->word_order }}">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.word-relations.index') }}" class="btn" style="background: #e5e7eb;">Batal</a>
        </div>
    </form>
</div>
@endsection
