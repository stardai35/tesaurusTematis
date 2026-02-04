<?php

namespace App\Helpers;

/**
 * TesaurusFormatter - Helper untuk formatting teks sesuai aturan ortografi Tesaurus
 * Mengatur: cetak tebal, cetak miring, tanda baca, label ragam bahasa
 */
class TesaurusFormatter
{
    /**
     * Format kata dengan cetak tebal untuk menandai acuan ke artikel lain
     */
    public static function bold($text): string
    {
        return "<strong>{$text}</strong>";
    }

    /**
     * Format kata asing dengan cetak miring
     */
    public static function italic($text): string
    {
        return "<em>{$text}</em>";
    }

    /**
     * Format label ragam bahasa: cak (cakapan), kas (kasar), hor (hormat)
     */
    public static function languageVariant($variant, $text): string
    {
        $labels = [
            'cak' => 'ragam cakapan',
            'kas' => 'ragam kasar',
            'hor' => 'ragam hormat',
        ];

        $label = $labels[$variant] ?? $variant;
        return "{$text} <span class='language-variant'>({$label})</span>";
    }

    /**
     * Format hubungan sinonimi dengan koma
     * Hubungan antara kata yang maknanya mirip atau sama
     */
    public static function synonymRelation($words): string
    {
        return implode(', ', $words);
    }

    /**
     * Format hubungan hiponimi dengan koma
     * Hubungan antara kata yang memiliki makna lebih sempit
     */
    public static function hyponymyRelation($words): string
    {
        return implode(', ', $words);
    }

    /**
     * Format hubungan meronimi dengan koma
     * Hubungan suatu kata dengan bagian dari makna kata lain
     */
    public static function meronymyRelation($words): string
    {
        return implode(', ', $words);
    }

    /**
     * Format superordinat dengan titik dua
     */
    public static function superordinate($superordinate, $items): string
    {
        $itemsStr = implode(', ', $items);
        return "<strong>{$superordinate}</strong>: {$itemsStr}";
    }

    /**
     * Format bentuk terikat dengan tanda hubung
     */
    public static function boundForm($form): string
    {
        return "-{$form}";
    }

    /**
     * Format bentuk pilihan dengan tanda kurung
     */
    public static function optionalForm($mainForm, $optionalForm): string
    {
        return "{$mainForm} ({$optionalForm})";
    }

    /**
     * Format dengan tambahan penjelasan dalam tanda kurung
     */
    public static function withExplanation($text, $explanation): string
    {
        return "{$text} <span class='explanation'>({$explanation})</span>";
    }

    /**
     * Pisahkan dengan titik koma untuk nuansa makna berbeda
     */
    public static function differentNuanceGroup($items): string
    {
        return implode('; ', $items);
    }

    /**
     * Format judul artikel dengan cetak tebal dan huruf kapital
     */
    public static function articleTitle($title): string
    {
        return "<strong>" . strtoupper($title) . "</strong>";
    }

    /**
     * Format judul artikel dalam paragraf (untuk acuan ke artikel lain)
     * Jika diklik, akan teralih ke halaman artikel terkait
     */
    public static function linkedArticleTitle($title, $slug): string
    {
        $titleFormatted = strtoupper($title);
        return "<a href='" . route('lemma', ['slug' => $slug]) . "' class='article-reference'><strong>{$titleFormatted}</strong></a>";
    }

    /**
     * Urutkan kata secara abjad
     */
    public static function sortAlphabetically($words): array
    {
        usort($words, function($a, $b) {
            $textA = is_array($a) ? $a['name'] : (is_object($a) ? $a->name : $a);
            $textB = is_array($b) ? $b['name'] : (is_object($b) ? $b->name : $b);
            return strcasecmp($textA, $textB);
        });
        return $words;
    }

    /**
     * Cek apakah kata adalah nama bulan untuk diurutkan khusus
     */
    public static function isMonth($text): bool
    {
        $months = [
            'januari', 'februari', 'maret', 'april', 'mei', 'juni',
            'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ];
        return in_array(strtolower($text), $months);
    }

    /**
     * Urutkan bulan berdasarkan urutan waktu
     */
    public static function sortMonths($months): array
    {
        $monthOrder = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
        ];

        usort($months, function($a, $b) use ($monthOrder) {
            $nameA = is_array($a) ? $a['name'] : (is_object($a) ? $a->name : $a);
            $nameB = is_array($b) ? $b['name'] : (is_object($b) ? $b->name : $b);
            $orderA = $monthOrder[strtolower($nameA)] ?? 999;
            $orderB = $monthOrder[strtolower($nameB)] ?? 999;
            return $orderA - $orderB;
        });

        return $months;
    }

    /**
     * Cek apakah kata adalah nama hari
     */
    public static function isDay($text): bool
    {
        $days = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        return in_array(strtolower($text), $days);
    }

    /**
     * Urutkan hari berdasarkan urutan waktu
     */
    public static function sortDays($days): array
    {
        $dayOrder = [
            'minggu' => 1, 'senin' => 2, 'selasa' => 3, 'rabu' => 4,
            'kamis' => 5, 'jumat' => 6, 'sabtu' => 7
        ];

        usort($days, function($a, $b) use ($dayOrder) {
            $nameA = is_array($a) ? $a['name'] : (is_object($a) ? $a->name : $a);
            $nameB = is_array($b) ? $b['name'] : (is_object($b) ? $b->name : $b);
            $orderA = $dayOrder[strtolower($nameA)] ?? 999;
            $orderB = $dayOrder[strtolower($nameB)] ?? 999;
            return $orderA - $orderB;
        });

        return $days;
    }

    /**
     * Cek apakah kata adalah pangkat militer
     */
    public static function isMilitaryRank($text): bool
    {
        $ranks = [
            'prajurit', 'kopral', 'sersan', 'sersan satu', 'sersan mayor', 'letnan', 'letnan satu',
            'kapten', 'mayor', 'letnan kolonel', 'kolonel', 'brigadir jenderal', 'mayor jenderal',
            'letnan jenderal', 'jenderal'
        ];
        return in_array(strtolower($text), $ranks);
    }

    /**
     * Urutkan pangkat militer berdasarkan jenjang
     */
    public static function sortMilitaryRanks($ranks): array
    {
        $rankOrder = [
            'prajurit' => 1, 'kopral' => 2, 'sersan' => 3, 'sersan satu' => 4, 'sersan mayor' => 5,
            'letnan' => 6, 'letnan satu' => 7, 'kapten' => 8, 'mayor' => 9,
            'letnan kolonel' => 10, 'kolonel' => 11, 'brigadir jenderal' => 12, 'mayor jenderal' => 13,
            'letnan jenderal' => 14, 'jenderal' => 15
        ];

        usort($ranks, function($a, $b) use ($rankOrder) {
            $nameA = is_array($a) ? $a['name'] : (is_object($a) ? $a->name : $a);
            $nameB = is_array($b) ? $b['name'] : (is_object($b) ? $b->name : $b);
            $orderA = $rankOrder[strtolower($nameA)] ?? 999;
            $orderB = $rankOrder[strtolower($nameB)] ?? 999;
            return $orderA - $orderB;
        });

        return $ranks;
    }

    /**
     * Smart sort - otomatis deteksi jenis urutan berdasarkan konten
     */
    public static function smartSort($items): array
    {
        if (empty($items)) {
            return $items;
        }

        $firstItem = is_array($items[0]) ? $items[0]['name'] : (is_object($items[0]) ? $items[0]->name : $items[0]);

        if (self::isMonth($firstItem)) {
            return self::sortMonths($items);
        } elseif (self::isDay($firstItem)) {
            return self::sortDays($items);
        } elseif (self::isMilitaryRank($firstItem)) {
            return self::sortMilitaryRanks($items);
        }

        // Default: sort alphabetically
        return self::sortAlphabetically($items);
    }
}
