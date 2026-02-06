<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\Subcategory;
use App\Models\WordClass;
use App\Models\WordRelation;
use Illuminate\Http\Request;

class TematisController extends Controller
{
    /**
     * Halaman utama Tematis
     */
    public function home()
    {
        $stats = [
            'jumlah_kata' => Lemma::count(),
            'jumlah_entri' => WordRelation::distinct('article_id')->count(),
            'relasi_sinonim' => WordRelation::whereHas('type', function($q) {
                $q->where('name', 'sinonim');
            })->count(),
        ];

        $wordClasses = WordClass::withCount('lemmas')->get();
        
        $categories = Category::with(['subcategories' => function($q) {
            $q->orderBy('num', 'asc');
        }])->orderBy('num', 'asc')->get();

        return view('tematis.home', compact('stats', 'wordClasses', 'categories'));
    }

    /**
     * Pencarian dalam Tematis
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return redirect()->route('tematis.home');
        }

        $lemmas = Lemma::where('name', 'LIKE', "%{$query}%")
            ->with(['wordRelations' => function($q) {
                $q->with(['wordClass', 'type']);
            }])
            ->paginate(15);

        return view('tematis.search', compact('lemmas', 'query'));
    }

    /**
     * Detail Lemma
     */
    public function lemma($slug)
    {
        $lemma = Lemma::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $wordRelations = $lemma->wordRelations()->with(['wordClass'])->get();
        $wordClass = $wordRelations->first()?->wordClass;

        // Get synonyms
        $synonyms = Lemma::where('id', '!=', $lemma->id)
            ->where('name', 'LIKE', '%' . substr($lemma->name, 0, 3) . '%')
            ->limit(10)
            ->get();

        // Get antonyms (if exists)
        $antonyms = collect();

        // Get related words
        $related = Lemma::whereHas('wordRelations', function($q) use ($lemma) {
            $q->whereIn('article_id', function($subQ) use ($lemma) {
                $subQ->select('article_id')
                    ->from('word_relations')
                    ->where('lemma_id', $lemma->id);
            });
        })
        ->where('id', '!=', $lemma->id)
        ->limit(10)
        ->get();

        // Get category/bidang
        $bidang = Category::whereHas('articles', function($q) use ($lemma) {
            $q->whereHas('wordRelations', function($subQ) use ($lemma) {
                $subQ->where('lemma_id', $lemma->id);
            });
        })->first();

        return view('tematis.lemma', compact(
            'lemma',
            'wordClass',
            'synonyms',
            'antonyms',
            'related',
            'bidang'
        ));
    }

    /**
     * Kategori / Bidang Ilmu
     */
    public function category(Request $request)
    {
        $kelasId = $request->input('kelas');
        $bidangId = $request->input('bidang');
        $subbidangId = $request->input('subbidang');

        $lemmasQuery = Lemma::query();

        if ($kelasId) {
            $lemmasQuery->whereHas('wordRelations', function($q) use ($kelasId) {
                $q->where('wordclass_id', $kelasId);
            });
        }

        if ($bidangId) {
            $lemmasQuery->whereHas('wordRelations', function($q) use ($bidangId) {
                $q->whereHas('article', function($qa) use ($bidangId) {
                    $qa->where('cat_id', $bidangId);
                });
            });
        }

        if ($subbidangId) {
            $lemmasQuery->whereHas('wordRelations', function($q) use ($subbidangId) {
                $q->whereHas('article', function($qa) use ($subbidangId) {
                    $qa->where('subcat_id', $subbidangId);
                });
            });
        }

        $lemmas = $lemmasQuery->paginate(20);

        return view('tematis.category', compact('lemmas'));
    }
}
