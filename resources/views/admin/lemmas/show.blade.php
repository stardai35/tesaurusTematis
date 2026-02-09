@extends('admin.layouts.app')

@section('page-title', 'Lihat Lemma: ' . $lemma->name)

@section('content')
<div class="page-header">
    <h1 class="page-title">Lihat Lemma: {{ $lemma->name }}</h1>
    <div class="page-actions">
        <a href="{{ route('admin.lemmas.edit', $lemma) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('admin.lemmas.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nama Lemma</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;"><strong>{{ $lemma->name }}</strong></p>
        </div>
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Label</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">
                @if($lemma->label)
                    <span class="badge badge-primary">{{ $lemma->label->name }}</span>
                @else
                    <span style="color: #9ca3af;">-</span>
                @endif
            </p>
        </div>
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Kelas Kata</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $lemma->wordClass?->name ?? '-' }}</p>
        </div>
        <div>
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Tipe</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $lemma->type?->name ?? '-' }}</p>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Slug</h3>
        <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">
            <code style="background: #f3f4f6; padding: 0.5rem; border-radius: 0.25rem; display: inline-block;">{{ $lemma->slug }}</code>
        </p>
    </div>

    @if($lemma->name_tagged)
        <div style="margin-top: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nama Tagged</h3>
            <p style="margin-bottom: 0; font-size: 1rem; color: #1f2937;">{{ $lemma->name_tagged }}</p>
        </div>
    @endif
</div>

@if($lemma->wordRelations->count() > 0)
    <div class="card">
        <h2 style="margin-bottom: 1.5rem; font-size: 1.125rem;">Word Relations ({{ $lemma->wordRelations->count() }})</h2>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Artikel</th>
                    <th>Word Class</th>
                    <th>Tipe</th>
                    <th>Par. Num</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lemma->wordRelations as $wr)
                    <tr>
                        <td>#{{ $wr->id }}</td>
                        <td><strong>{{ $wr->article?->title ?? '-' }}</strong></td>
                        <td>{{ $wr->wordClass?->name ?? '-' }}</td>
                        <td>{{ $wr->type?->name ?? '-' }}</td>
                        <td>{{ $wr->par_num ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.word-relations.show', $wr) }}" class="btn btn-sm btn-primary">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
    <form action="{{ route('admin.lemmas.destroy', $lemma) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus lemma ini? Lemma yang terkait dengan word relations akan tetap ada.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
    <a href="{{ route('admin.lemmas.edit', $lemma) }}" class="btn btn-secondary">Edit</a>
</div>
@endsection
