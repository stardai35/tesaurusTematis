@extends('admin.layouts.app')

@section('page-title', 'Edit Word Relation')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Word Relation</h1>
</div>

<div class="card">
    <form action="{{ route('admin.word-relations.update', $wordRelation) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Artikel <span style="color: #ef4444;">*</span></label>
                <select name="article_id" class="form-control" required>
                    <option value="">- Pilih Artikel -</option>
                    @foreach($articles as $article)
                        <option value="{{ $article->id }}" @selected($wordRelation->article_id == $article->id)>{{ $article->title }}</option>
                    @endforeach
                </select>
                @error('article_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Lemma <span style="color: #ef4444;">*</span></label>
                <select name="lemma_id" class="form-control" required>
                    <option value="">- Pilih Lemma -</option>
                    @foreach($lemmas as $lemma)
                        <option value="{{ $lemma->id }}" @selected($wordRelation->lemma_id == $lemma->id)>{{ $lemma->name }}</option>
                    @endforeach
                </select>
                @error('lemma_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Word Class <span style="color: #ef4444;">*</span></label>
                <select name="wordclass_id" class="form-control" required>
                    <option value="">- Pilih Word Class -</option>
                    @foreach($wordClasses as $wc)
                        <option value="{{ $wc->id }}" @selected($wordRelation->wordclass_id == $wc->id)>{{ $wc->name }}</option>
                    @endforeach
                </select>
                @error('wordclass_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipe</label>
                <select name="type_id" class="form-control">
                    <option value="">- Pilih Tipe -</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" @selected($wordRelation->type_id == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('type_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nomor Paragraf</label>
                <input type="number" name="par_num" class="form-control" placeholder="Nomor paragraf" value="{{ old('par_num', $wordRelation->par_num) }}" min="1">
                @error('par_num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Urutan Kata</label>
                <input type="number" name="word_order" class="form-control" placeholder="Urutan kata" value="{{ old('word_order', $wordRelation->word_order) }}" min="1">
                @error('word_order') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Group Num</label>
                <input type="number" name="group_num" class="form-control" placeholder="Group num" value="{{ old('group_num', $wordRelation->group_num) }}" min="1">
                @error('group_num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Meaning Group</label>
                <input type="number" name="meaning_group" class="form-control" placeholder="Meaning group" value="{{ old('meaning_group', $wordRelation->meaning_group) }}" min="1">
                @error('meaning_group') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" placeholder="Masukkan deskripsi" style="resize: vertical; min-height: 100px;">{{ old('description', $wordRelation->description) }}</textarea>
            @error('description') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Bahasa Asing</label>
                <input type="text" name="foreign_language" class="form-control" placeholder="Bahasa asing" value="{{ old('foreign_language', $wordRelation->foreign_language) }}">
                @error('foreign_language') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Variasi Bahasa</label>
                <input type="text" name="language_variant" class="form-control" placeholder="Variasi bahasa" value="{{ old('language_variant', $wordRelation->language_variant) }}">
                @error('language_variant') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Tipe Relasi</label>
                <input type="text" name="relationship_type" class="form-control" placeholder="Tipe relasi" value="{{ old('relationship_type', $wordRelation->relationship_type) }}">
                @error('relationship_type') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: flex-end;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_superordinate" value="1" @checked(old('is_superordinate', $wordRelation->is_superordinate))>
                    <span>Is Superordinate</span>
                </label>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group" style="display: flex; align-items: flex-end;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_bold" value="1" @checked(old('is_bold', $wordRelation->is_bold))>
                    <span>Is Bold</span>
                </label>
            </div>
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.word-relations.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui Word Relation</button>
        </div>
    </form>
</div>
@endsection
