@extends('admin.layouts.app')

@section('page-title', 'Lihat Word Relation')

@section('content')
<div class="page-header">
    <h1 class="page-title">Lihat Word Relation</h1>
    <div class="page-actions">
        <a href="{{ route('admin.word-relations.edit', $wordRelation) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('admin.word-relations.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>

<div class="card">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Artikel</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->article?->title ?? '-' }}</strong></p>
        </div>

        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Lemma</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->lemma?->name ?? '-' }}</strong></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Word Class</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->wordClass?->name ?? '-' }}</strong></p>
        </div>

        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Tipe</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->type?->name ?? '-' }}</strong></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nomor Paragraf</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->par_num ?? '-' }}</strong></p>
        </div>

        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Urutan Kata</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->word_order ?? '-' }}</strong></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Group Num</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->group_num ?? '-' }}</strong></p>
        </div>

        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Meaning Group</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $wordRelation->meaning_group ?? '-' }}</strong></p>
        </div>
    </div>

    @if($wordRelation->description)
        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Deskripsi</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $wordRelation->description }}</p>
        </div>
    @endif

    @if($wordRelation->foreign_language)
        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Bahasa Asing</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $wordRelation->foreign_language }}</p>
        </div>
    @endif

    @if($wordRelation->language_variant)
        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Variasi Bahasa</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $wordRelation->language_variant }}</p>
        </div>
    @endif

    @if($wordRelation->relationship_type)
        <div style="margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Tipe Relasi</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $wordRelation->relationship_type }}</p>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Is Superordinate</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">
                @if($wordRelation->is_superordinate)
                    <span style="color: #16a34a; font-weight: 600;">Ya</span>
                @else
                    <span style="color: #dc2626;">Tidak</span>
                @endif
            </p>
        </div>

        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Is Bold</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">
                @if($wordRelation->is_bold)
                    <span style="color: #16a34a; font-weight: 600;">Ya</span>
                @else
                    <span style="color: #dc2626;">Tidak</span>
                @endif
            </p>
        </div>
    </div>

    <hr style="margin: 2rem 0; border: none; border-top: 1px solid #e5e7eb;">

    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
        <form action="{{ route('admin.word-relations.destroy', $wordRelation) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus Word Relation ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        <a href="{{ route('admin.word-relations.edit', $wordRelation) }}" class="btn btn-secondary">Edit</a>
    </div>
</div>
@endsection
