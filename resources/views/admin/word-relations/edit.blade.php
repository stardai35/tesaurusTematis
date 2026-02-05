@extends('admin.layouts.app')

@section('title', 'Edit Relasi Kata')

@push('styles')
<style>
    .form-section {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
    }

    .form-section-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
        border-bottom: 2px solid var(--primary-blue);
        padding-bottom: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="email"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.95rem;
        background: white;
        font-family: inherit;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-help {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-row-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-submit {
        padding: 0.75rem 2rem;
        background: var(--primary-blue);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-cancel {
        padding: 0.75rem 2rem;
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancel:hover {
        background: var(--bg-light);
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .checkbox-group label {
        margin: 0;
        cursor: pointer;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-row-3 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<a href="{{ route('admin.word-relations.index') }}" class="back-link">← Kembali ke Daftar Relasi Kata</a>

<h1 class="page-title">Edit Relasi Kata</h1>
<p class="page-subtitle">Ubah hubungan lemma dengan artikel</p>

@if ($errors->any())
    <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 6px; margin-bottom: 2rem; border-left: 4px solid #dc2626;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin-top: 0.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.word-relations.update', $wordRelation) }}">
    @csrf
    @method('PUT')

    {{-- SECTION 1: ARTICLE & LEMMA --}}
    <div class="form-section">
        <div class="form-section-title">📄 Pilih Artikel dan Lemma</div>

        <div class="form-row">
            <div class="form-group">
                <label for="article_id">Artikel *</label>
                <select name="article_id" id="article_id" required>
                    <option value="">-- Pilih Artikel --</option>
                    @foreach($articles as $article)
                        <option value="{{ $article->id }}" 
                            {{ old('article_id', $wordRelation->article_id) == $article->id ? 'selected' : '' }}>
                            {{ $article->title ?? 'Artikel #'.$article->id }}
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Artikel yang akan memiliki lemma ini</div>
            </div>

            <div class="form-group">
                <label for="lemma_id">Lemma/Kata *</label>
                <select name="lemma_id" id="lemma_id" required>
                    <option value="">-- Pilih Lemma --</option>
                    @foreach($lemmas as $lemma)
                        <option value="{{ $lemma->id }}" 
                            {{ old('lemma_id', $wordRelation->lemma_id) == $lemma->id ? 'selected' : '' }}>
                            {{ $lemma->name }} ({{ $lemma->label ? $lemma->label->name : 'Tanpa label' }})
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Lemma yang akan dihubungkan ke artikel</div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: WORD CLASS & TYPE --}}
    <div class="form-section">
        <div class="form-section-title">🏷️ Klasifikasi Kata</div>

        <div class="form-row">
            <div class="form-group">
                <label for="wordclass_id">Kelas Kata *</label>
                <select name="wordclass_id" id="wordclass_id" required>
                    <option value="">-- Pilih Kelas Kata --</option>
                    @foreach($wordClasses as $wc)
                        <option value="{{ $wc->id }}" 
                            {{ old('wordclass_id', $wordRelation->wordclass_id) == $wc->id ? 'selected' : '' }}>
                            {{ $wc->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Nomina, Verba, Adjektiva, dll</div>
            </div>

            <div class="form-group">
                <label for="relationship_type">Tipe Hubungan (Relasi Tesaurus)</label>
                <select name="relationship_type" id="relationship_type">
                    <option value="">-- Pilih Tipe Hubungan --</option>
                    @foreach($labelTypes as $lt)
                        <option value="{{ $lt->id }}" 
                            {{ old('relationship_type', $wordRelation->relationship_type) == $lt->id ? 'selected' : '' }}>
                            {{ $lt->name }} ({{ $lt->description }})
                        </option>
                    @endforeach
                </select>
                <div class="form-help">Sinonimi, Hiponimi, Meronimi, dll</div>
            </div>
        </div>
    </div>

    {{-- SECTION 3: POSITION & ORDERING --}}
    <div class="form-section">
        <div class="form-section-title">📍 Posisi dalam Artikel</div>

        <div class="form-row form-row-3">
            <div class="form-group">
                <label for="par_num">Nomor Paragraf</label>
                <input type="number" name="par_num" id="par_num" min="0" value="{{ old('par_num', $wordRelation->par_num) }}">
                <div class="form-help">Paragraf ke berapa (opsional)</div>
            </div>

            <div class="form-group">
                <label for="group_num">Nomor Grup</label>
                <input type="number" name="group_num" id="group_num" min="0" value="{{ old('group_num', $wordRelation->group_num) }}">
                <div class="form-help">Grup ke berapa dalam paragraf (opsional)</div>
            </div>

            <div class="form-group">
                <label for="word_order">Urutan Kata</label>
                <input type="number" name="word_order" id="word_order" min="0" value="{{ old('word_order', $wordRelation->word_order) }}">
                <div class="form-help">Posisi ke berapa dalam grup (opsional)</div>
            </div>
        </div>
    </div>

    {{-- SECTION 4: SEMANTIC PROPERTIES --}}
    <div class="form-section">
        <div class="form-section-title">💡 Properti Semantik</div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" name="is_superordinate" id="is_superordinate" value="1" 
                    {{ old('is_superordinate', $wordRelation->is_superordinate) ? 'checked' : '' }}>
                <label for="is_superordinate">
                    ⭐ Superordinate (Makna Umum - Hypernym)
                </label>
            </div>
            <div class="form-help" style="margin-left: 2rem;">Centang jika ini adalah makna umum dari artikel</div>
        </div>

        <div class="form-group">
            <label for="meaning_group">Grup Makna</label>
            <input type="text" name="meaning_group" id="meaning_group" placeholder="Contoh: makna1, makna2" 
                   value="{{ old('meaning_group', $wordRelation->meaning_group) }}">
            <div class="form-help">Kelompok makna yang ini kurangi</div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi / Catatan</label>
            <textarea name="description" id="description" placeholder="Penjelasan tentang relasi kata ini...">{{ old('description', $wordRelation->description) }}</textarea>
            <div class="form-help">Penjelasan tambahan tentang hubungan kata (opsional)</div>
        </div>
    </div>

    {{-- SECTION 5: LANGUAGE VARIANTS --}}
    <div class="form-section">
        <div class="form-section-title">🌍 Bahasa Asing dan Varian</div>

        <div class="form-row">
            <div class="form-group">
                <label for="foreign_language">Bahasa Asing</label>
                <input type="text" name="foreign_language" id="foreign_language" 
                       placeholder="Contoh: English equivalent" value="{{ old('foreign_language', $wordRelation->foreign_language) }}">
                <div class="form-help">Padanan dalam bahasa asing (opsional)</div>
            </div>

            <div class="form-group">
                <label for="language_variant">Varian Bahasa</label>
                <input type="text" name="language_variant" id="language_variant" 
                       placeholder="Contoh: Bahasa Melayu, Dialek Betawi" value="{{ old('language_variant', $wordRelation->language_variant) }}">
                <div class="form-help">Varian atau dialek (opsional)</div>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" name="is_bold" id="is_bold" value="1" 
                    {{ old('is_bold', $wordRelation->is_bold) ? 'checked' : '' }}>
                <label for="is_bold">
                    <strong>Bold</strong> - Tampilkan kata ini dengan bold
                </label>
            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="form-actions">
        <button type="submit" class="btn-submit">✅ Simpan Perubahan</button>
        <a href="{{ route('admin.word-relations.index') }}" class="btn-cancel">Batal</a>
    </div>
</form>
@endsection
