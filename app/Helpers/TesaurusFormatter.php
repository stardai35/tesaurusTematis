<?php

namespace App\Helpers;

/**
 * TesaurusFormatter Helper
 * 
 * This class provides formatting utilities for the Tesaurus application.
 * It handles formatting of word relations, articles, and other tesaurus-related content.
 */
class TesaurusFormatter
{
    /**
     * Format a word with proper capitalization
     *
     * @param string $word
     * @return string
     */
    public function formatWord(string $word): string
    {
        return strtoupper($word);
    }

    /**
     * Format a list of words with proper separator
     *
     * @param array $words
     * @param string $separator
     * @return string
     */
    public function formatWordList(array $words, string $separator = ', '): string
    {
        return implode($separator, $words);
    }

    /**
     * Format article text with proper markdown or HTML
     *
     * @param string $text
     * @return string
     */
    public function formatArticle(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Format paragraph number
     *
     * @param int $parNum
     * @return string
     */
    public function formatParagraphNumber(int $parNum): string
    {
        return "Paragraf {$parNum}";
    }

    /**
     * Format relation type
     *
     * @param string $relationType
     * @return string
     */
    public function formatRelationType(string $relationType): string
    {
        return ucfirst(strtolower($relationType));
    }

    /**
     * Check if text is foreign language
     *
     * @param string $text
     * @return bool
     */
    public function isForeignLanguage(string $text): bool
    {
        // Simple check - can be expanded based on requirements
        return preg_match('/[^a-zA-Z\s]/', $text) === 0 && strlen($text) > 0;
    }

    /**
     * Smart sort - intelligently sort word relations or lemmas
     * Sorts by name field in alphabetical order
     *
     * @param array $items
     * @return array
     */
    public function smartSort(array $items): array
    {
        usort($items, function ($a, $b) {
            $nameA = $this->getItemName($a);
            $nameB = $this->getItemName($b);
            return strcasecmp($nameA, $nameB);
        });
        
        return $items;
    }

    /**
     * Get the name/label from an item (lemma or word relation)
     *
     * @param mixed $item
     * @return string
     */
    private function getItemName($item): string
    {
        if (is_array($item)) {
            // Check for lemma name
            if (isset($item['name'])) {
                return $item['name'];
            }
            // Check for lemma relationship through word_relation
            if (isset($item['lemma']['name'])) {
                return $item['lemma']['name'];
            }
            // Check for lemma name in nested structure
            if (isset($item['lemma_id']) && is_array($item) && isset($item['lemma']) && is_array($item['lemma'])) {
                return $item['lemma']['name'] ?? '';
            }
        } elseif (is_object($item)) {
            // Handle object-based items
            if (isset($item->name)) {
                return $item->name;
            }
            if (isset($item->lemma) && isset($item->lemma->name)) {
                return $item->lemma->name;
            }
        }
        
        return '';
    }
}
