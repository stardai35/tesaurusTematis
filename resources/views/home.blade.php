@extends('layouts.app')

@section('title', 'Tesaurus Tematis Bahasa Indonesia')
@section('description', 'Pusat padanan kata Bahasa Indonesia yang baku dan terstandar')

@push('styles')
<style>
    .hero {
        background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 35%, #5ba89f 70%, #a8dadc 100%);
        color: white;
        padding: 4rem 0;
        text-align: center;
    }

    .hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 2rem;
    }

    .search-box {
        max-width: 750px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        padding: 0.5rem;
        display: flex;
        gap: 0.5rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .search-box input {
        flex: 1;
        border: none;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        border-radius: 8px;
        outline: none;
    }

    .search-box select {
        border: none;
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        border-radius: 8px;
        outline: none;
        background: white;
        cursor: pointer;
        min-width: 180px;
    }

    .search-box button {
        padding: 0.875rem 2rem;
        background: var(--primary-blue);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .search-box button:hover {
        background: #163d6f;
        transform: translateY(-2px);
    }

    .stats {
        padding: 3rem 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-light);
        font-size: 0.95rem;
    }

    .section {
        padding: 3rem 0;
    }

    .section-title {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 2.5rem;
        color: var(--text-dark);
    }

    .word-classes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .word-class-card {
        background: white;
        padding: 2rem 1.5rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: var(--text-dark);
    }

    .word-class-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        color: var(--primary-blue);
    }

    .word-class-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.75rem;
    }

    .icon-adjektiva { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .icon-adverbia { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .icon-konjungsi { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .icon-nomina { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .icon-numeralia { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .icon-partikel { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
    .icon-verba { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }

    .word-class-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .word-class-count {
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .categories {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .category-item {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .category-item:last-child {
        border-bottom: none;
    }

    .category-item:hover {
        background: var(--bg-light);
        padding-left: 1.75rem;
    }

    .category-title {
        font-weight: 600;
        color: var(--text-dark);
    }

    .category-arrow {
        color: var(--text-light);
        font-size: 1.25rem;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Tesaurus Tematis Bahasa Indonesia</h1>
        <p>Pusat padanan kata Bahasa Indonesia yang baku dan terstandar</p>
        
        <form action="{{ route('search') }}" method="GET" class="search-box">
            <input type="text" name="q" placeholder="Masukan Kata" required>
            <select name="word_class">
                <option value="">Semua Kelas Kata</option>
                @foreach($wordClasses as $wc)
                    <option value="{{ $wc->id }}">{{ $wc->name }}</option>
                @endforeach
            </select>
            <button type="submit">Cari</button>
        </form>
    </div>
</section>

<!-- Stats Section -->
<section class="container">
    <div class="stats">
        <div class="stat-card fade-in">
            <div class="stat-number">{{ $stats['total_words'] }}</div>
            <div class="stat-label">Jumlah Kata</div>
        </div>
        <div class="stat-card fade-in">
            <div class="stat-number">{{ $stats['total_entries'] }}</div>
            <div class="stat-label">Jumlah Entri</div>
        </div>
        <div class="stat-card fade-in">
            <div class="stat-number">{{ $stats['total_synonyms'] }}</div>
            <div class="stat-label">Relasi Sinonim</div>
        </div>
    </div>
</section>

<!-- Word Classes Section -->
<section class="section container">
    <h2 class="section-title">Cari berdasarkan Kelas Kata</h2>
    <div class="word-classes">
        @foreach($wordClasses as $wc)
        <a href="{{ route('category', ['word_class' => $wc->id]) }}" class="word-class-card">
            <div class="word-class-icon icon-{{ strtolower($wc->name) }}">
                @switch($wc->name)
                    @case('Adjektiva')
                        📖
                        @break
                    @case('Adverbia')
                        ➕
                        @break
                    @case('Konjungsi')
                        🔗
                        @break
                    @case('Nomina')
                        🔵
                        @break
                    @case('Numeralia')
                        🔢
                        @break
                    @case('Partikel')
                        ⚡
                        @break
                    @case('Verba')
                        ⭐
                        @break
                @endswitch
            </div>
            <div class="word-class-name">{{ $wc->name }}</div>
            <div class="word-class-count">{{ $wc->word_relations_count ?? 0 }} kata</div>
        </a>
        @endforeach
    </div>
</section>

<!-- Categories Section -->
<section class="section container">
    <h2 class="section-title">Bidang Ilmu Kata</h2>
    <div class="categories">
        <div class="category-item">
            <div class="category-title">I. Ukuran dan Bentuk</div>
            <div class="category-arrow">›</div>
        </div>
        @foreach($categories as $category)
        <div class="category-item" onclick="window.location='{{ route('category', ['category' => $category->id]) }}'">
            <div class="category-title">{{ $category->num ? $category->num . '. ' : '' }}{{ $category->title }}</div>
            <div class="category-arrow">›</div>
        </div>
        @endforeach
    </div>
</section>
@endsection
