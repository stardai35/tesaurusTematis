<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\WordClass;
use App\Models\WordRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_words' => Lemma::count(),
            'total_entries' => Article::count(),
            'total_synonyms' => WordRelation::where('type_id', 1)->count(),
        ];

        $wordClasses = WordClass::withCount('wordRelations')->get();
        $categories = Category::all();

        return view('home', compact('stats', 'wordClasses', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $wordClass = $request->input('word_class');

        $results = Lemma::query()
            ->with(['label', 'wordRelations.type', 'wordRelations.article'])
            ->where('name', 'LIKE', "%{$query}%")
            ->when($wordClass, function ($q) use ($wordClass) {
                $q->whereHas('wordRelations', function ($q) use ($wordClass) {
                    $q->where('wordclass_id', $wordClass);
                });
            })
            ->paginate(20);

        return view('search', compact('results', 'query'));
    }

    public function lemma($slug)
    {
        // Parse slug to get lemma name
        $name = str_replace('-', ' ', $slug);
        
        $lemma = Lemma::with(['label', 'wordRelations.type', 'wordRelations.wordClass', 'wordRelations.lemma', 'wordRelations.article'])
            ->where('name', $name)
            ->firstOrFail();

        // Organize word relations by type
        $synonyms = [];
        $antonyms = [];
        $examples = [];
        $relatedWords = [];

        foreach ($lemma->wordRelations as $relation) {
            switch ($relation->type->name) {
                case 'sinonim':
                    $synonyms[] = $relation;
                    break;
                case 'antonim':
                    $antonyms[] = $relation;
                    break;
                case 'contoh':
                    $examples[] = $relation;
                    break;
                case 'kata_terkait':
                    $relatedWords[] = $relation;
                    break;
            }
        }

        // Get other lemmas in the same article
        $articleIds = $lemma->wordRelations->pluck('article_id')->unique();
        $relatedLemmas = [];
        
        if ($articleIds->isNotEmpty()) {
            $relatedLemmas = WordRelation::whereIn('article_id', $articleIds)
                ->where('lemma_id', '!=', $lemma->id)
                ->with('lemma')
                ->get()
                ->pluck('lemma')
                ->unique('id');
        }

        return view('lemma', compact('lemma', 'synonyms', 'antonyms', 'examples', 'relatedWords', 'relatedLemmas'));
    }

    public function category()
    {
        $categories = Category::all();
        $wordClasses = WordClass::withCount('wordRelations')->get();
        
        $filter = request()->query();
        $lemmas = Lemma::query();

        // Filter by word class
        if (request('word_class')) {
            $lemmas->whereHas('wordRelations', function ($q) {
                $q->where('wordclass_id', request('word_class'));
            });
        }

        // Filter by category
        if (request('category')) {
            $lemmas->whereHas('wordRelations.article', function ($q) {
                $q->where('cat_id', request('category'));
            });
        }

        // Filter by alphabet
        if (request('letter')) {
            $lemmas->where('name', 'LIKE', request('letter') . '%');
        }

        $lemmas = $lemmas->with(['label', 'wordRelations.wordClass'])
            ->paginate(15);

        return view('category', compact('categories', 'wordClasses', 'lemmas', 'filter'));
    }

    public function about()
    {
        return view('about');
    }

    public function guide()
    {
        return view('guide');
    }

    public function team()
    {
        return view('team');
    }
}
