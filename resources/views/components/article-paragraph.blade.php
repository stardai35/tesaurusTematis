@props(['wordRelations', 'formatter'])

@if($wordRelations && count($wordRelations) > 0)
    @php
        // Group word relations by paragraph and meaning group
        $groupedByParagraph = $wordRelations->groupBy('par_num');
    @endphp

    @foreach($groupedByParagraph as $parNum => $relations)
        <div class="paragraph">
            @if($parNum)
                <div class="paragraph-title">
                    Paragraf {{ $parNum }}
                </div>
            @endif

            @php
                // Group by meaning group (sinonimi, hiponimi, meronimi)
                $groupedByMeaning = $relations->groupBy('meaning_group');
            @endphp

            @foreach($groupedByMeaning as $meaningGroup => $words)
                <div class="meaning-group">
                    @if($words->first()->is_superordinate)
                        {{-- Superordinate dengan format: SUPERORDINAT: kata1, kata2, kata3 --}}
                        <strong>{{ strtoupper($words->first()->description ?? 'Superordinat') }}</strong>:
                    @endif

                    <span class="synonym-relation">
                        @foreach($words as $index => $word)
                            @php
                                $lemmaName = $word->lemma?->name;
                                $lemmaSlug = $word->lemma?->slug;
                            @endphp

                            @if($word->is_bold && $lemmaSlug)
                                {{-- Kata yang dicetak tebal untuk acuan ke artikel lain --}}
                                <a href="{{ route('lemma', ['slug' => $lemmaSlug]) }}" 
                                   class="article-reference font-bold">
                                    {{ strtoupper($lemmaName) }}
                                </a>
                            @else
                                {{-- Kata normal --}}
                                @if($word->foreign_language)
                                    <span class="foreign-text" title="{{ $word->foreign_language }}">
                                        {{ $lemmaName }}
                                    </span>
                                @else
                                    {{ $lemmaName }}
                                @endif
                            @endif

                            {{-- Language variant label (cak, kas, hor) --}}
                            @if($word->language_variant)
                                <span class="language-variant variant-{{ $word->language_variant }}">
                                    @php
                                        $variantLabels = [
                                            'cak' => 'ragam cakapan',
                                            'kas' => 'ragam kasar',
                                            'hor' => 'ragam hormat',
                                        ];
                                    @endphp
                                    {{ $variantLabels[$word->language_variant] ?? $word->language_variant }}
                                </span>
                            @endif

                            {{-- Separator untuk hubungan makna berbeda --}}
                            @if($index < count($words) - 1)
                                @php
                                    $nextWord = $words->get($index + 1);
                                    if ($word->relationshipType?->name === $nextWord->relationshipType?->name) {
                                        echo ','; // Hubungan sama, pisahkan dengan koma
                                    } else {
                                        echo ';'; // Hubungan berbeda, pisahkan dengan titik koma
                                    }
                                @endphp
                            @endif
                        @endforeach
                    </span>

                    {{-- Description atau explanation --}}
                    @if($words->first()->description && !$words->first()->is_superordinate)
                        <span class="explanation">
                            ({{ $words->first()->description }})
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
@endif
