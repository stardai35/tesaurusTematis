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
        $categories = Category::with(['subcategories.articles'])->get();

        return view('home', compact('stats', 'wordClasses', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('home');
        }

        // Search for articles that contain the search term
        // This matches the tesaurus structure where articles group related words
        $articles = Article::with([
            'wordRelations' => function($q) {
                $q->with(['lemma', 'type', 'wordClass'])
                  ->orderBy('type_id', 'asc'); // article title first, then superordinate, then ordinary
            },
            'category',
            'subcategory'
        ])
        ->whereHas('wordRelations.lemma', function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
        ->paginate(10);

        return view('search', compact('articles', 'query'));
    }

    public function lemma($slug)
    {
        // Parse slug to get lemma name
        $name = str_replace('-', ' ', $slug);
        
        // Load lemma with all necessary relationships
        $lemma = Lemma::with(['label', 'wordRelations.wordClass', 'wordRelations.article'])
            ->where('name', $name)
            ->firstOrFail();

        // Get all article IDs where this lemma appears
        $articleIds = $lemma->wordRelations->pluck('article_id')->unique()->filter();

        // Initialize arrays
        $synonyms = collect();
        $antonyms = collect();
        $examples = collect();
        $relatedWords = collect();
        $relatedLemmas = collect();

        // If lemma has articles, get related words from those articles
        if ($articleIds->isNotEmpty()) {
            // Get all word relations in the same articles
            $allRelations = WordRelation::with(['lemma', 'type'])
                ->whereIn('article_id', $articleIds)
                ->where('lemma_id', '!=', $lemma->id)
                ->get();

            // Organize by type
            foreach ($allRelations as $relation) {
                if ($relation->lemma) {
                    // Check type safely
                    if ($relation->type) {
                        $typeName = strtolower($relation->type->name);
                        
                        if (in_array($typeName, ['sinonim', 'synonym'])) {
                            $synonyms->push($relation);
                        } elseif (in_array($typeName, ['antonim', 'antonym'])) {
                            $antonyms->push($relation);
                        } elseif (in_array($typeName, ['contoh', 'example'])) {
                            $examples->push($relation);
                        } else {
                            $relatedWords->push($relation);
                        }
                    } else {
                        // If no type, treat as related word
                        $relatedWords->push($relation);
                    }
                }
            }

            // Get unique related lemmas (all words in same article group)
            $relatedLemmas = $allRelations
                ->pluck('lemma')
                ->filter()
                ->unique('id')
                ->take(20); // Limit to 20 related words
        }

        // Convert collections to arrays for blade compatibility
        $synonyms = $synonyms->unique('lemma_id')->values()->all();
        $antonyms = $antonyms->unique('lemma_id')->values()->all();
        $examples = $examples->take(5)->all(); // Limit examples
        $relatedWords = $relatedWords->unique('lemma_id')->take(15)->all();

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

        // Filter by subcategory
        if (request('subcategory')) {
            $lemmas->whereHas('wordRelations.article', function ($q) {
                $q->where('subcat_id', request('subcategory'));
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
