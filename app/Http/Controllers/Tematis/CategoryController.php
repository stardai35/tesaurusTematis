<?php

namespace App\Http\Controllers\Tematis;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\WordClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $kelas = $request->integer('kelas');
        $bidang = $request->integer('bidang');
        $subbidang = $request->integer('subbidang');
        $abjad = strtoupper((string) $request->query('abjad', ''));
        $q = trim((string) $request->query('q', ''));

        $wordClasses = WordClass::query()->orderBy('name')->get(['id', 'name', 'abbr']);
        
        // Load categories dengan subcategories
        $categories = Category::query()
            ->with(['subcategories' => function ($query) {
                $query->orderBy('num');
            }])
            ->orderBy('num')
            ->get(['id', 'num', 'title', 'slug']);

        $base = DB::table('lemma as l')
            ->select([
                'l.id',
                'l.name',
                'wc.name as word_class_name',
                'wc.abbr as word_class_abbr',
                'c.title as bidang_title',
                'sc.title as subbidang_title',
            ])
            ->leftJoin('word_relation as wr', function ($join) {
                $join->on('wr.lemma_id', '=', 'l.id')
                    ->where('wr.type_id', '=', 1);
            })
            ->leftJoin('word_class as wc', 'wc.id', '=', 'wr.wordclass_id')
            ->leftJoin('article as a', 'a.id', '=', 'wr.article_id')
            ->leftJoin('category as c', 'c.id', '=', 'a.cat_id')
            ->leftJoin('subcategory as sc', 'sc.id', '=', 'a.subcat_id')
            ->when($kelas, fn ($qq) => $qq->where('wr.wordclass_id', $kelas))
            ->when($bidang, fn ($qq) => $qq->where('a.cat_id', $bidang))
            ->when($subbidang, fn ($qq) => $qq->where('a.subcat_id', $subbidang))
            ->when($abjad !== '' && preg_match('/^[A-Z]$/', $abjad), fn ($qq) => $qq->where('l.name', 'like', $abjad.'%'))
            ->when($q !== '', fn ($qq) => $qq->where('l.name', 'like', "%{$q}%"))
            ->groupBy('l.id', 'l.name', 'wc.name', 'wc.abbr', 'c.title', 'sc.title')
            ->orderBy('l.name');

        // Laravel paginator dari query builder (manual).
        $perPage = 20;
        $page = max(1, (int) $request->query('page', 1));

        $total = DB::query()
            ->fromSub($base, 't')
            ->count();

        $items = DB::query()
            ->fromSub($base, 't')
            ->forPage($page, $perPage)
            ->get();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => url()->current(),
                'query' => $request->query(),
            ]
        );

        return view('tematis.category', [
            'wordClasses' => $wordClasses,
            'categories' => $categories,
            'lemmas' => $paginator,
            'filters' => [
                'kelas' => $kelas,
                'bidang' => $bidang,
                'subbidang' => $subbidang,
                'abjad' => $abjad,
                'q' => $q,
            ],
        ]);
    }
}

