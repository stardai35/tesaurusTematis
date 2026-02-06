@extends('admin.layouts.app')

@section('page-title', 'Tambah Artikel Baru')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Artikel Baru</h1>
</div>

<div class="card">
    <form action="{{ route('admin.articles.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Kategori <span style="color: #ef4444;">*</span></label>
                <select name="cat_id" class="form-control" required>
                    <option value="">- Pilih Kategori -</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('cat_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('cat_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Sub Kategori</label>
                <select name="subcat_id" class="form-control">
                    <option value="">- Pilih Sub Kategori -</option>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->id }}" @selected(old('subcat_id') == $subcat->id)>{{ $subcat->name }}</option>
                    @endforeach
                </select>
                @error('subcat_id') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Judul Artikel <span style="color: #ef4444;">*</span></label>
            <input type="text" name="title" class="form-control" required placeholder="Masukkan judul artikel" value="{{ old('title') }}">
            @error('title') <small style="color: #ef4444;">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nomor Urut</label>
                <input type="number" name="num" class="form-control" placeholder="Nomor urut" value="{{ old('num') }}">
                @error('num') <small style="color: #ef4444;">{{ $message }}</small> @enderror
            </div>
        </div>

        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

        <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Tambahkan Lemma ke Artikel</h3>

        <div id="lemma-container">
            <div class="lemma-item card" style="margin-bottom: 1rem; padding: 1rem; background: #f9fafb;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Lemma <span style="color: #ef4444;">*</span></label>
                        <select name="word_relations[0][lemma_id]" class="form-control" required>
                            <option value="">- Pilih Lemma -</option>
                            @foreach($lemmas as $lemma)
                                <option value="{{ $lemma->id }}">{{ $lemma->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Word Class <span style="color: #ef4444;">*</span></label>
                        <select name="word_relations[0][wordclass_id]" class="form-control" required>
                            <option value="">- Pilih Word Class -</option>
                            @foreach($wordClasses as $wc)
                                <option value="{{ $wc->id }}">{{ $wc->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Tipe</label>
                        <select name="word_relations[0][type_id]" class="form-control">
                            <option value="">- Pilih Tipe -</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Paragraf</label>
                        <input type="number" name="word_relations[0][par_num]" class="form-control" placeholder="Nomor paragraf">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="word_relations[0][description]" class="form-control" placeholder="Deskripsi">
                    </div>
                </div>

                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Hapus</button>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" id="add-lemma-btn">+ Tambah Lemma Lain</button>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
let lemmaCount = 1;
document.getElementById('add-lemma-btn').addEventListener('click', function() {
    const container = document.getElementById('lemma-container');
    const newItem = `
        <div class="lemma-item card" style="margin-bottom: 1rem; padding: 1rem; background: #f9fafb;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Lemma <span style="color: #ef4444;">*</span></label>
                    <select name="word_relations[${lemmaCount}][lemma_id]" class="form-control" required>
                        <option value="">- Pilih Lemma -</option>
                        @foreach($lemmas as $lemma)
                            <option value="{{ $lemma->id }}">{{ $lemma->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Word Class <span style="color: #ef4444;">*</span></label>
                    <select name="word_relations[${lemmaCount}][wordclass_id]" class="form-control" required>
                        <option value="">- Pilih Word Class -</option>
                        @foreach($wordClasses as $wc)
                            <option value="{{ $wc->id }}">{{ $wc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Tipe</label>
                    <select name="word_relations[${lemmaCount}][type_id]" class="form-control">
                        <option value="">- Pilih Tipe -</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Paragraf</label>
                    <input type="number" name="word_relations[${lemmaCount}][par_num]" class="form-control" placeholder="Nomor paragraf">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="word_relations[${lemmaCount}][description]" class="form-control" placeholder="Deskripsi">
                </div>
            </div>

            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Hapus</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newItem);
    lemmaCount++;
});
</script>
@endsection
