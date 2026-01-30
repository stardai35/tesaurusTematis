<?php

namespace App\Http\Controllers\Tematis;

use App\Http\Controllers\Controller;
use App\Models\Lemma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $wordClassId = $request->integer('kelas');

        if ($q === '') {
            return redirect()->route('tematis.home');
        }

        // Subquery untuk mendapatkan relasi pertama per lemma
        $firstRelSubquery = DB::table('word_relation as wr')
            ->select([
                'wr.lemma_id',
                DB::raw('MIN(wr.id) AS min_wr_id'),
            ])
            ->where('wr.type_id', 1)
            ->groupBy('wr.lemma_id');

        // Query utama dengan DISTINCT untuk menghindari duplikat
        $lemmas = Lemma::query()
            ->select([
                'lemma.id',
                'lemma.name',
                'lemma.name_tagged',
                'lemma.label_id',
                'wc.name as word_class_name',
                'wc.abbr as word_class_abbr',
                'c.title as bidang_title',
            ])
            ->leftJoinSub($firstRelSubquery, 'fr', function ($join) {
                $join->on('fr.lemma_id', '=', 'lemma.id');
            })
            ->leftJoin('word_relation as wr', function ($join) {
                $join->on('wr.id', '=', 'fr.min_wr_id')
                    ->where('wr.type_id', '=', 1);
            })
            ->leftJoin('word_class as wc', 'wc.id', '=', 'wr.wordclass_id')
            ->leftJoin('article as a', 'a.id', '=', 'wr.article_id')
            ->leftJoin('category as c', 'c.id', '=', 'a.cat_id')
            ->where('lemma.name', 'like', "%{$q}%")
            ->when($wordClassId, function ($query) use ($wordClassId) {
                return $query->where('wr.wordclass_id', $wordClassId);
            })
            ->groupBy('lemma.id', 'lemma.name', 'lemma.name_tagged', 'lemma.label_id', 'wc.name', 'wc.abbr', 'c.title')
            ->orderBy('lemma.name')
            ->paginate(10)
            ->withQueryString();

        return view('tematis.search', [
            'q' => $q,
            'lemmas' => $lemmas,
            'wordClassId' => $wordClassId,
        ]);
    }
}

