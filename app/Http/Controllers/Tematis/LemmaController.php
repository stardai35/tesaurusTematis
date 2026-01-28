<?php

namespace App\Http\Controllers\Tematis;

use App\Http\Controllers\Controller;
use App\Models\Lemma;
use App\Models\WordRelation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LemmaController extends Controller
{
    public function show(string $lemma)
    {
        $decoded = urldecode($lemma);

        $model = null;
        if (ctype_digit($decoded)) {
            $model = Lemma::query()->find((int) $decoded);
        }

        if (!$model) {
            // Prioritas: exact match, lalu fallback ke slug match.
            $model = Lemma::query()->where('name', $decoded)->first();
        }

        if (!$model) {
            $needle = Str::slug($decoded);
            $candidates = Lemma::query()
                ->where('name', 'like', $decoded.'%')
                ->limit(50)
                ->get();

            $model = $candidates->first(fn ($l) => Str::slug($l->name) === $needle);
        }

        abort_if(!$model, 404);

        $primaryRel = WordRelation::query()
            ->with(['wordClass', 'article.category'])
            ->where('lemma_id', $model->id)
            ->where('type_id', 1)
            ->orderBy('id')
            ->first();

        $wordClass = $primaryRel?->wordClass;
        $bidang = $primaryRel?->article?->category;

        // Sinonim: kata-kata lain dalam group yang sama (artikel + paragraf + group + kelas kata).
        $occurrences = WordRelation::query()
            ->where('lemma_id', $model->id)
            ->where('type_id', 1)
            ->orderBy('id')
            ->limit(5)
            ->get(['article_id', 'par_num', 'group_num', 'wordclass_id']);

        $synonymIds = collect();
        foreach ($occurrences as $occ) {
            $ids = DB::table('word_relation')
                ->where('type_id', 1)
                ->where('article_id', $occ->article_id)
                ->where('par_num', $occ->par_num)
                ->where('group_num', $occ->group_num)
                ->where('wordclass_id', $occ->wordclass_id)
                ->where('lemma_id', '!=', $model->id)
                ->pluck('lemma_id');

            $synonymIds = $synonymIds->merge($ids);
        }

        $synonyms = Lemma::query()
            ->whereIn('id', $synonymIds->unique()->take(20))
            ->orderBy('name')
            ->get(['id', 'name', 'name_tagged', 'label_id']);

        // Antonym tidak tersedia di schema contoh — akan disembunyikan jika kosong.
        $antonyms = collect();

        // Kata terkait: kata lain dalam artikel yang sama (top 20).
        $relatedIds = WordRelation::query()
            ->where('type_id', 1)
            ->whereIn('article_id', $occurrences->pluck('article_id')->unique())
            ->where('lemma_id', '!=', $model->id)
            ->limit(50)
            ->pluck('lemma_id')
            ->unique()
            ->take(20);

        $related = Lemma::query()
            ->whereIn('id', $relatedIds)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('tematis.lemma', [
            'lemma' => $model,
            'wordClass' => $wordClass,
            'bidang' => $bidang,
            'synonyms' => $synonyms,
            'antonyms' => $antonyms,
            'related' => $related,
        ]);
    }
}

