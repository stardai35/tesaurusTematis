<?php

namespace App\Http\Controllers\Tematis;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\WordClass;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'jumlah_kata' => Lemma::query()->count(),
            'jumlah_entri' => DB::table('word_relation')->distinct('lemma_id')->count('lemma_id'),
            'relasi_sinonim' => DB::table('word_relation')->count(),
        ];

        $wordClasses = WordClass::query()
            ->select([
                'word_class.id',
                'word_class.name',
                'word_class.abbr',
                DB::raw('COUNT(DISTINCT wr.lemma_id) AS lemma_count'),
            ])
            ->leftJoin('word_relation as wr', 'wr.wordclass_id', '=', 'word_class.id')
            ->groupBy('word_class.id', 'word_class.name', 'word_class.abbr')
            ->orderBy('word_class.name')
            ->get();

        $categories = Category::query()
            ->with(['subcategories' => function ($query) {
                $query->orderBy('num');
            }])
            ->orderBy('num')
            ->get(['id', 'num', 'title', 'slug']);

        return view('tematis.home', compact('stats', 'wordClasses', 'categories'));
    }
}

