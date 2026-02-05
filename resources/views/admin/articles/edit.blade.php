@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@push('styles')
<style>
    .word-relation-item {
        background: #f9fafb;
        padding: 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1.25rem;
        border-left: 4px solid #3b82f6;
        border: 1px solid #e5e7eb;
    }

    .word-relation-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .lemma-info-box {
        background: #e3f2fd;
        padding: 0.75rem;
        border-radius: 0.375rem;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #1e56a0;
        border-left: 3px solid #1e56a0;
        display: none;
    }

    .lemma-info-box.show {
        display: block;
    }

    .quick-add-section {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        padding: 1.25rem;
        border-radius: 0.75rem;
        margin-bottom: 1.75rem;
        border: 2px solid #d1e0ff;
    }

    .quick-add-section h5 {
        margin-bottom: 1rem;
        color: #1e56a0;
        font-weight: 700;
    }

    .wordclass-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 0.75rem;
    }

    .btn-quick-add {
        transition: all 0.2s;
        font-weight: 600;
        border: 2px solid #1e56a0;
    }

    .btn-quick-add:hover {
        background: #1e56a0;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 86, 160, 0.25);
    }

    .form-section-title {
        background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 100%);
        color: white;
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .word-count-badge {
        background: #1e56a0;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-left: 0.5rem;
    }

    .form-group-compact {
        margin-bottom: 1rem;
    }

    .form-group-compact label {
        font-weight: 600;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        width: 90%;
        max-width: 500px;
        animation: slideDown 0.3s;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .modal-header h3 {
        margin: 0;
        color: #1e56a0;
        font-weight: 700;
    }

    .close-modal {
        font-size: 2rem;
        font-weight: bold;
        color: #999;
        cursor: pointer;
        line-height: 1;
        border: none;
        background: none;
        padding: 0;
    }

    .close-modal:hover {
        color: #1e56a0;
    }

    .modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">✏️ Edit Artikel: {{ $article->title }}</h1>
    <p style="color: #666; margin-top: 0.5rem;">Ubah informasi artikel dan kelola kata-kata di dalamnya</p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>⚠️ Terjadi kesalahan!</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form method="POST" action="{{ route('admin.articles.update', $article) }}" id="articleForm">
        @csrf
        @method('PUT')
        
        <!-- Bagian Dasar Artikel -->
        <div style="padding: 1.5rem; border-bottom: 2px solid #f0f0f0;">
            <h5 style="color: #1e56a0; font-weight: 700; margin-bottom: 1.5rem;">📋 Informasi Dasar Artikel</h5>
            
            <div class="form-group">
                <label class="form-label">Judul Artikel *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $article->title) }}" placeholder="Contoh: Bilangan, Keluarga, Profesi" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Kategori *</label>
                    <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('cat_id', $article->cat_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('cat_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Sub-Kategori</label>
                    <select name="subcat_id" id="subcat_id" class="form-control @error('subcat_id') is-invalid @enderror">
                        <option value="">Pilih Sub-Kategori (Opsional)</option>
                    </select>
                    @error('subcat_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Urut</label>
                    <input type="number" name="num" class="form-control @error('num') is-invalid @enderror" value="{{ old('num', $article->num) }}" placeholder="Opsional">
                    @error('num')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bagian Kata-Kata dalam Artikel -->
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                <h5 style="color: #1e56a0; font-weight: 700; margin: 0;">📝 Pengelolaan Kata & Relasi</h5>
                <span class="word-count-badge" id="wordCountBadge">0 kata</span>
            </div>

            <!-- Quick Add by Word Class -->
            <div class="quick-add-section">
                <h5>⚡ Tambah Kata Cepat (Pilih Kelas Kata):</h5>
                <div class="wordclass-grid">
                    @foreach($wordClasses as $wc)
                        <button type="button" class="btn btn-outline-primary btn-quick-add quick-add-wordclass" data-wordclass="{{ $wc->id }}" data-wordclass-name="{{ $wc->name }}" title="Tambah {{ $wc->name }}">
                            {{ strtoupper($wc->abbr ?? substr($wc->name, 0, 3)) }} - {{ $wc->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
                <button type="button" class="btn btn-secondary" id="addWordBtn">
                    + Tambah Kata Manual
                </button>
                <small style="display: flex; align-items: center; color: #666;">
                    💡 Gunakan tombol kelas kata di atas untuk tambah cepat, atau gunakan tombol ini untuk kontrol penuh
                </small>
            </div>

            <!-- Word Relations Container -->
            <div id="wordRelationsContainer"></div>
        </div>

        <!-- Tombol Aksi -->
        <div style="padding: 1.5rem; border-top: 2px solid #f0f0f0; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary btn-lg">
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-lg">
                Batal
            </a>
        </div>
    </form>
</div>

<!-- Quick Lemma Creation Modal -->
<div id="quickLemmaModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>➕ Tambah Kata Baru</h3>
            <button type="button" class="close-modal" id="closeLemmaModal">&times;</button>
        </div>

        <form id="quickLemmaForm">
            <div class="form-group">
                <label class="form-label">Nama Kata *</label>
                <input type="text" id="quickLemmaName" class="form-control" placeholder="Contoh: membilang, berapa, desimal" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Label / Kategori *</label>
                <select id="quickLemmaLabel" class="form-control" required>
                    <option value="">-- Pilih Label --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
                <small class="text-muted">💡 Label adalah kategori klasifikasi kata (contoh: Istilah, Formal, Slang, dll)</small>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Tagged (Opsional)</label>
                <input type="text" id="quickLemmaTagged" class="form-control" placeholder="Versi kata dengan markup khusus (jika ada)">
                <small class="text-muted">💡 Biarkan kosong jika tidak perlu</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelLemmaBtn">Batal</button>
                <button type="submit" class="btn btn-success">✅ Buat Kata</button>
            </div>
        </form>
    </div>
</div>

<!-- Template untuk word relation dengan enhancement -->
<template id="wordRelationTemplate">
    <div class="word-relation-item">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
            <!-- Lemma Selection -->
            <div class="form-group-compact">
                <label class="form-label">Kata (Lemma) *</label>
                <div style="display: flex; gap: 0.5rem; align-items: flex-start;">
                    <div style="flex: 1;">
                        <select class="form-control lemma-select" name="word_relations[][lemma_id]" required onchange="updateLemmaInfo(this)">
                            <option value="">-- Cari & Pilih Kata --</option>
                            @foreach($lemmas as $lemma)
                                <option value="{{ $lemma->id }}" data-label="{{ $lemma->label->abbr ?? '-' }}" data-label-name="{{ $lemma->label->name ?? '-' }}">
                                    {{ $lemma->name }} ({{ $lemma->label->abbr ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-success mt-0" style="margin-top: 0; padding: 0.5rem 0.75rem;" onclick="openQuickLemmaModal(this)" title="Tambah kata baru">
                        ➕ Buat Baru
                    </button>
                </div>
                <small class="lemma-info-box" style="margin-top: 0.5rem;">
                    ℹ️ <span class="lemma-label-info"></span>
                </small>
            </div>

            <!-- Word Class Selection -->
            <div class="form-group-compact">
                <label class="form-label">Kelas Kata *</label>
                <select class="form-control wordclass-select" name="word_relations[][wordclass_id]" required>
                    <option value="">-- Pilih Kelas Kata --</option>
                    @foreach($wordClasses as $wc)
                        <option value="{{ $wc->id }}">{{ strtoupper($wc->abbr ?? substr($wc->name, 0, 3)) }} - {{ $wc->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type Selection -->
            <div class="form-group-compact">
                <label class="form-label">Tipe Relasi</label>
                <select class="form-control" name="word_relations[][type_id]">
                    <option value="">-- Pilih (Opsional) --</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Word Order -->
            <div class="form-group-compact">
                <label class="form-label">Urutan</label>
                <input type="number" class="form-control" name="word_relations[][word_order]" min="1" value="1" placeholder="1">
            </div>
        </div>

        <!-- Description -->
        <div class="form-group-compact">
            <label class="form-label">Deskripsi / Makna</label>
            <textarea class="form-control" name="word_relations[][description]" rows="2" placeholder="Jelaskan makna, penggunaan, atau catatan tentang kata ini..."></textarea>
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 0.5rem; justify-content: space-between; align-items: center;">
            <button type="button" class="btn btn-danger btn-sm remove-word">
                🗑️ Hapus Kata
            </button>
            <small class="text-muted">
                ID Relasi akan diperbarui setelah disimpan
            </small>
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
    const quickAddBtns = document.querySelectorAll('.quick-add-wordclass');
    const wordCountBadge = document.getElementById('wordCountBadge');

    // Load subcategories when category changes
    function loadSubcategories(catId) {
        subcategorySelect.innerHTML = '<option value="">Pilih Sub-Kategori (Opsional)</option>';

        if (catId) {
            fetch(`/api/categories/${catId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.title;
                        
                        // Select the current subcategory if editing
                        if (option.value == '{{ $article->subcat_id }}') {
                            option.selected = true;
                        }
                        
                        subcategorySelect.appendChild(option);
                    });
                });
        }
    }

    categorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });

    // Load initial subcategories
    if (categorySelect.value) {
        loadSubcategories(categorySelect.value);
    }

    // Quick add word by word class
    quickAddBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const wordclassId = this.dataset.wordclass;
            
            addWordRelation();
            
            // Set wordclass value to the last added item
            const lastSelect = document.querySelector('#wordRelationsContainer .wordclass-select:last-child');
            if (lastSelect) {
                lastSelect.value = wordclassId;
            }
            
            updateWordCount();
        });
    });

    // Add word relation
    function addWordRelation() {
        const clone = wordTemplate.content.cloneNode(true);
        wordContainer.appendChild(clone);
        attachRemoveListener();
    }

    addWordBtn.addEventListener('click', function() {
        addWordRelation();
        updateWordCount();
    });

    // Populate existing word relations
    function populateWordRelations() {
        const relations = {!! json_encode($article->wordRelations) !!};
        
        if (relations.length === 0) {
            addWordRelation();
        } else {
            relations.forEach(relation => {
                const clone = wordTemplate.content.cloneNode(true);
                
                // Set lemma
                const lemmaSelect = clone.querySelector('select[name*="lemma_id"]');
                lemmaSelect.value = relation.lemma_id;
                
                // Set wordclass
                const wordclassSelect = clone.querySelector('select[name*="wordclass_id"]');
                wordclassSelect.value = relation.wordclass_id;
                
                // Set type
                const typeSelect = clone.querySelector('select[name*="type_id"]');
                typeSelect.value = relation.type_id || '';
                
                // Set word_order
                const wordOrderInput = clone.querySelector('input[name*="word_order"]');
                wordOrderInput.value = relation.word_order;
                
                // Set description
                const descriptionTextarea = clone.querySelector('textarea[name*="description"]');
                descriptionTextarea.value = relation.description || '';
                
                // Trigger lemma info update
                const label = relation.lemma?.label;
                if (label) {
                    const infoBox = clone.querySelector('.lemma-info-box');
                    infoBox.querySelector('.lemma-label-info').textContent = `Label: ${label.name} (${label.abbr})`;
                    infoBox.classList.add('show');
                }
                
                wordContainer.appendChild(clone);
            });
        }
        
        attachRemoveListener();
        updateWordCount();
    }

    // Remove word relation
    function attachRemoveListener() {
        document.querySelectorAll('.remove-word').forEach(btn => {
            btn.removeEventListener('click', removeWordHandler);
            btn.addEventListener('click', removeWordHandler);
        });
    }

    function removeWordHandler() {
        if (confirm('Hapus kata ini dari artikel?')) {
            this.closest('.word-relation-item').remove();
            updateWordCount();
        }
    }

    // Update word count badge
    function updateWordCount() {
        const count = document.querySelectorAll('.word-relation-item').length;
        wordCountBadge.textContent = count + ' kata';
    }

    // Update lemma info
    window.updateLemmaInfo = function(select) {
        const option = select.options[select.selectedIndex];
        const label = option.getAttribute('data-label');
        const labelName = option.getAttribute('data-label-name');
        
        const infoBox = select.closest('.form-group-compact').querySelector('.lemma-info-box');
        if (infoBox) {
            if (option.value) {
                infoBox.querySelector('.lemma-label-info').textContent = `Label: ${labelName} (${label})`;
                infoBox.classList.add('show');
            } else {
                infoBox.classList.remove('show');
            }
        }
    };

    // Quick lemma creation
    window.openQuickLemmaModal = function(btn) {
        const modal = document.getElementById('quickLemmaModal');
        const targetSelect = btn.closest('.form-group-compact').querySelector('.lemma-select');
        modal.dataset.targetSelect = targetSelect.name;
        modal.style.display = 'block';
    };

    // Close modal
    document.getElementById('closeLemmaModal')?.addEventListener('click', function() {
        document.getElementById('quickLemmaModal').style.display = 'none';
    });

    // Cancel button
    document.getElementById('cancelLemmaBtn')?.addEventListener('click', function() {
        document.getElementById('quickLemmaModal').style.display = 'none';
    });

    // Close modal on outside click
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('quickLemmaModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Submit quick lemma form
    document.getElementById('quickLemmaForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const lemmaName = document.getElementById('quickLemmaName').value;
        const labelId = document.getElementById('quickLemmaLabel').value;
        const nameTagged = document.getElementById('quickLemmaTagged').value;

        if (!lemmaName || !labelId) {
            alert('Nama kata dan label wajib diisi');
            return;
        }

        // Submit via AJAX
        fetch('/api/lemmas/quick-create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                name: lemmaName,
                label_id: labelId,
                name_tagged: nameTagged
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reset form
                document.getElementById('quickLemmaForm').reset();

                // Add new option to lemma selects
                const newOption = document.createElement('option');
                newOption.value = data.data.id;
                newOption.textContent = data.data.name + ' (' + data.data.label.abbr + ')';
                newOption.setAttribute('data-label', data.data.label.abbr);
                newOption.setAttribute('data-label-name', data.data.label.name);

                // Add to all lemma selects
                document.querySelectorAll('.lemma-select').forEach(select => {
                    const option = newOption.cloneNode(true);
                    select.appendChild(option);
                });

                // Set to current select
                const modal = document.getElementById('quickLemmaModal');
                const selectName = modal.dataset.targetSelect;
                const currentSelect = document.querySelector(`select[name="${selectName}"]`);
                if (currentSelect) {
                    currentSelect.value = data.data.id;
                    currentSelect.dispatchEvent(new Event('change'));
                }

                // Close modal
                modal.style.display = 'none';

                // Show success
                alert('Kata "' + data.data.name + '" berhasil ditambahkan!');
            } else {
                alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error);
        });
    });

    populateWordRelations();
});
</script>
@endsection
