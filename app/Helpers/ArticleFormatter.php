<?php

namespace App\Helpers;

use App\Models\Article;

class ArticleFormatter
{
    /**
     * Format article data untuk ditampilkan
     */
    public static function formatForDisplay(Article $article)
    {
        $article->load('wordRelations.lemma.label', 'wordRelations.wordClass', 'wordRelations.type', 'category', 'subcategory');

        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'category' => $article->category->title ?? null,
            'subcategory' => $article->subcategory->title ?? null,
            'word_classes_grouped' => self::groupWordsByClass($article),
        ];
    }

    /**
     * Kelompokkan kata berdasarkan kelas kata
     */
    private static function groupWordsByClass(Article $article)
    {
        $grouped = [];

        foreach ($article->wordRelations->sortBy('word_order') as $relation) {
            $wordClassId = $relation->wordclass_id;
            $wordClassCode = $relation->wordClass->code ?? 'TIDAK DIKETAHUI';

            if (!isset($grouped[$wordClassId])) {
                $grouped[$wordClassId] = [
                    'code' => $wordClassCode,
                    'words' => [],
                ];
            }

            $grouped[$wordClassId]['words'][] = [
                'lemma' => $relation->lemma->name,
                'type' => $relation->type->name ?? null,
                'description' => $relation->description,
                'label' => $relation->lemma->label->name ?? null,
            ];
        }

        return $grouped;
    }

    /**
     * Get article teaser untuk list view
     */
    public static function getTeaser(Article $article, $length = 150)
    {
        $firstWordDescription = $article->wordRelations->first()?->description;

        if ($firstWordDescription && strlen($firstWordDescription) > $length) {
            return substr($firstWordDescription, 0, $length) . '...';
        }

        return $firstWordDescription ?? 'Tidak ada deskripsi';
    }
}
