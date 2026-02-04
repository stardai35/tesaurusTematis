@props(['lemma', 'relations', 'formatter'])

<article class="lemma-article">
    @if($lemma)
        <header class="lemma-header">
            <h1 class="lemma-title">
                {{ strtoupper($lemma->name) }}
            </h1>
            
            @if($lemma->label)
                <div class="lemma-label">
                    <span class="badge">{{ $lemma->label->name }}</span>
                    @if($lemma->label->abbr)
                        <span class="abbreviation">({{ strtoupper($lemma->label->abbr) }})</span>
                    @endif
                </div>
            @endif
        </header>

        @if($relations && count($relations) > 0)
            <section class="lemma-content">
                <x-article-paragraph :wordRelations="$relations" :formatter="$formatter" />
            </section>
        @endif
    @endif
</article>

<style scoped>
    .lemma-article {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .lemma-header {
        margin-bottom: 2rem;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 1rem;
    }

    .lemma-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .lemma-label {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .badge {
        display: inline-block;
        background: var(--primary-blue);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .abbreviation {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .lemma-content {
        line-height: 1.8;
        color: #374151;
    }
</style>
