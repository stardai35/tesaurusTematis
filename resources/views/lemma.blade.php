@extends('layouts.app')

@section('title', $lemma->name . ' - Tesaurus Tematis')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
        margin: 2rem 0 1.5rem;
        transition: all 0.2s;
    }

    .back-link:hover {
        gap: 0.75rem;
    }

    .lemma-header {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 2rem;
    }

    .lemma-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .lemma-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .lemma-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.25rem;
    }

    .action-btn:hover {
        background: var(--bg-light);
        transform: translateY(-2px);
    }

    .lemma-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .content-section {
        margin-bottom: 2.5rem;
    }

    .content-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .word-list {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .word-tag {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .word-tag-blue {
        background: #e3f2fd;
        color: #1976d2;
    }

    .word-tag-blue:hover {
        background: #bbdefb;
    }

    .word-tag-red {
        background: #ffebee;
        color: #c62828;
    }

    .word-tag-red:hover {
        background: #ffcdd2;
    }

    .example-box {
        background: var(--bg-light);
        border-left: 4px solid var(--primary-blue);
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        border-radius: 4px;
    }

    .example-text {
        font-style: italic;
        color: var(--text-dark);
        line-height: 1.7;
    }

    .related-words {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 0.75rem;
    }

    .related-word-tag {
        background: #f5f5f5;
        color: var(--text-dark);
    }

    .related-word-tag:hover {
        background: #e0e0e0;
    }

    @media (max-width: 768px) {
        .lemma-title {
            font-size: 2rem;
        }

        .lemma-header,
        .lemma-content {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="back-link">
        ← Kembali
    </a>

    <!-- Lemma Header -->
    <div class="lemma-header">
        <h1 class="lemma-title">{{ $lemma->name }}</h1>
        <div class="lemma-badges">
            @if($lemma->label)
                <span class="badge badge-nomina">{{ $lemma->label->name }}</span>
            @endif
            @if($lemma->wordRelations->first() && $lemma->wordRelations->first()->wordClass)
                <span class="badge badge-teknologi">{{ $lemma->wordRelations->first()->wordClass->name }}</span>
            @endif
        </div>

    <!-- Lemma Content -->
    <div class="lemma-content">
        <!-- Sinonim -->
        @if(count($synonyms) > 0)
        <div class="content-section">
            <h2 class="section-title">Sinonim</h2>
            <div class="word-list">
                @foreach($synonyms as $syn)
                    @if($syn->lemma)
                        <a href="{{ route('lemma', $syn->lemma->slug) }}" class="word-tag word-tag-blue">
                            {{ $syn->lemma->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Antonim -->
        @if(count($antonyms) > 0)
        <div class="content-section">
            <h2 class="section-title">Antonim</h2>
            <div class="word-list">
                @foreach($antonyms as $ant)
                    @if($ant->lemma)
                        <a href="{{ route('lemma', $ant->lemma->slug) }}" class="word-tag word-tag-red">
                            {{ $ant->lemma->name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Contoh Penggunaan -->
        @if(count($examples) > 0)
        <div class="content-section">
            <h2 class="section-title">Contoh Penggunaan</h2>
            @foreach($examples as $example)
                @if($example->lemma)
                <div class="example-box">
                    <p class="example-text">"{{ $example->lemma->name }}"</p>
                </div>
                @endif
            @endforeach
        </div>
        @endif

        <!-- Kata Terkait -->
        @if(count($relatedWords) > 0 || $relatedLemmas->count() > 0)
        <div class="content-section">
            <h2 class="section-title">Kata Terkait</h2>
            <div class="related-words">
                @foreach($relatedWords as $related)
                    @if($related->lemma)
                        <a href="{{ route('lemma', $related->lemma->slug) }}" class="word-tag related-word-tag">
                            {{ $related->lemma->name }}
                        </a>
                    @endif
                @endforeach
                @foreach($relatedLemmas as $related)
                    <a href="{{ route('lemma', $related->slug) }}" class="word-tag related-word-tag">
                        {{ $related->name }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if(count($synonyms) == 0 && count($antonyms) == 0 && count($examples) == 0 && count($relatedWords) == 0)
        <p style="text-align: center; color: var(--text-light); padding: 2rem;">
            Belum ada informasi lengkap untuk kata ini.
        </p>
        @endif
    </div>
</div>
@endsection
