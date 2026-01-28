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

        // Ambil 1 relasi (paling awal) per lemma untuk badge kelas kata + bidang.
        $firstRel = DB::table('word_relation as wr')
            ->select([
                'wr.lemma_id',
                DB::raw('MIN(wr.id) AS wr_id'),
            ])
            ->where('wr.type_id', 1)
            ->when($wordClassId, fn ($qq) => $qq->where('wr.wordclass_id', $wordClassId))
            ->groupBy('wr.lemma_id');

        $lemmas = Lemma::query()
            ->select([
                'lemma.*',
                'wc.name as word_class_name',
                'c.title as bidang_title',
            ])
            ->leftJoinSub($firstRel, 'fr', fn ($join) => $join->on('fr.lemma_id', '=', 'lemma.id'))
            ->leftJoin('word_relation as wr', 'wr.id', '=', 'fr.wr_id')
            ->leftJoin('word_class as wc', 'wc.id', '=', 'wr.wordclass_id')
            ->leftJoin('article as a', 'a.id', '=', 'wr.article_id')
            ->leftJoin('category as c', 'c.id', '=', 'a.cat_id')
            ->where('lemma.name', 'like', "%{$q}%")
            ->orderBy('lemma.name')
            ->paginate(10)
            ->withQueryString();

        return view('tematis.search', [
            'q' => $q,
            'lemmas' => $lemmas,
        ]);
    }
}

