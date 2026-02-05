@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <h1 class="mb-4">Buat Artikel Baru</h1>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5>Terjadi kesalahan!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('articles.store') }}" method="POST" id="articleForm">
                @csrf

                <!-- Informasi Artikel -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Artikel</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="num" class="form-label">Nomor</label>
                                <input type="number" class="form-control @error('num') is-invalid @enderror" id="num" name="num" value="{{ old('num') }}">
                                @error('num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cat_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('cat_id') is-invalid @enderror" id="cat_id" name="cat_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cat_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="subcat_id" class="form-label">Subkategori</label>
                                <select class="form-select @error('subcat_id') is-invalid @enderror" id="subcat_id" name="subcat_id">
                                    <option value="">-- Pilih Subkategori --</option>
                                </select>
                                @error('subcat_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kata-Kata dalam Artikel -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Kata-Kata dalam Artikel</h5>
                            <button type="button" class="btn btn-sm btn-light" id="addWordBtn">+ Tambah Kata</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="wordRelationsContainer">
                            <!-- Word relations akan ditambahkan di sini -->
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template untuk word relation -->
<template id="wordRelationTemplate">
    <div class="word-relation-item card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Kata <span class="text-danger">*</span></label>
                    <select class="form-select lemma-select" name="word_relations[][lemma_id]" required>
                        <option value="">-- Pilih Kata --</option>
                        @foreach($lemmas as $lemma)
                            <option value="{{ $lemma->id }}">{{ $lemma->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Kelas Kata <span class="text-danger">*</span></label>
                    <select class="form-select" name="word_relations[][wordclass_id]" required>
                        <option value="">-- Pilih --</option>
                        @foreach($wordClasses as $wc)
                            <option value="{{ $wc->id }}">{{ $wc->code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="form-label">Tipe</label>
                    <select class="form-select" name="word_relations[][type_id]">
                        <option value="">-- Pilih --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Urutan Kata</label>
                    <input type="number" class="form-control" name="word_relations[][word_order]" min="1">
                </div>

                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 remove-word">Hapus</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi / Makna</label>
                    <textarea class="form-control" name="word_relations[][description]" rows="3" placeholder="Masukkan penjelasan atau makna dari kata ini..."></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('cat_id');
    const subcategorySelect = document.getElementById('subcat_id');
    const addWordBtn = document.getElementById('addWordBtn');
    const wordContainer = document.getElementById('wordRelationsContainer');
    const wordTemplate = document.getElementById('wordRelationTemplate');

    // Load subcategories when category changes
    categorySelect.addEventListener('change', function() {
        const catId = this.value;
        subcategorySelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';

        if (catId) {
            fetch(`/api/categories/${catId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.name;
                        subcategorySelect.appendChild(option);
                    });
                });
        }
    });

    // Add word relation
    addWordBtn.addEventListener('click', function() {
        const clone = wordTemplate.content.cloneNode(true);
        wordContainer.appendChild(clone);
        attachRemoveListener();
    });

    // Remove word relation
    function attachRemoveListener() {
        document.querySelectorAll('.remove-word').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Yakin ingin menghapus kata ini?')) {
                    this.closest('.word-relation-item').remove();
                }
            });
        });
    }

    // Add one empty word relation on page load
    addWordBtn.click();
});
</script>

<style>
    .word-relation-item {
        border-left: 4px solid #28a745;
    }
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>
@endsection
