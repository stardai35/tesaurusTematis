<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\Subcategory;
use App\Models\WordClass;
use App\Models\WordRelation;
use App\Helpers\TesaurusFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $formatter;

    public function __construct()
    {
        $this->formatter = new TesaurusFormatter();
    }

    public function index()
    {
        $stats = [
            'total_words' => Lemma::count(),
            'total_entries' => Article::count(),
            'total_synonyms' => WordRelation::where('type_id', 1)->count(),
        ];

        $wordClasses = WordClass::withCount('wordRelations')->get();
        $categories = Category::with([
            'subcategories' => function($q) {
                $q->with(['articles' => function($qa) {
                    $qa->orderBy('num', 'asc');
                }])->orderBy('num', 'asc');
            }
        ])->get();

        return view('home', compact('stats', 'wordClasses', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $wordClassFilter = $request->input('word_class');
        $categoryFilter = $request->input('category');
        $subcategoryFilter = $request->input('subcategory');
        
        if (empty($query)) {
            return redirect()->route('home');
        }

        // Build lemmas query with optional filters
        $lemmasQuery = Lemma::where('name', 'LIKE', "%{$query}%");
        
        if ($wordClassFilter) {
            $lemmasQuery->whereHas('wordRelations', function($q) use ($wordClassFilter) {
                $q->where('wordclass_id', $wordClassFilter);
            });
        }
        
        if ($categoryFilter) {
            $lemmasQuery->whereHas('wordRelations.article', function($q) use ($categoryFilter) {
                $q->where('cat_id', $categoryFilter);
            });
        }
        
        if ($subcategoryFilter) {
            $lemmasQuery->whereHas('wordRelations.article', function($q) use ($subcategoryFilter) {
                $q->where('subcat_id', $subcategoryFilter);
            });
        }

        $lemmas = $lemmasQuery
            ->with([
                'wordRelations' => function($q) {
                    $q->with([
                        'article',
                        'lemma',
                        'type',
                        'wordClass',
                        'relationshipType'
                    ])->orderBy('article_id', 'asc')
                      ->orderBy('par_num', 'asc')
                      ->orderBy('word_order', 'asc');
                },
                'label'
            ])
            ->paginate(10);

        // Build articles query with optional filters
        $articlesQuery = Article::with([
            'wordRelations' => function($q) {
                $q->with(['lemma', 'type', 'wordClass', 'relationshipType'])
                  ->orderBy('par_num', 'asc')
                  ->orderBy('word_order', 'asc');
            },
            'category',
            'subcategory'
        ])
        ->whereHas('wordRelations.lemma', function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        });
        
        if ($wordClassFilter) {
            $articlesQuery->whereHas('wordRelations', function($q) use ($wordClassFilter) {
                $q->where('wordclass_id', $wordClassFilter);
            });
        }
        
        if ($categoryFilter) {
            $articlesQuery->where('cat_id', $categoryFilter);
        }
        
        if ($subcategoryFilter) {
            $articlesQuery->where('subcat_id', $subcategoryFilter);
        }

        $articles = $articlesQuery->paginate(5);
        
        // Get available filters for display
        $wordClasses = WordClass::all();
        $categories = Category::all();
        $subcategories = $categoryFilter ? Subcategory::where('cat_id', $categoryFilter)->get() : collect();

        return view('search', compact('lemmas', 'articles', 'query', 'wordClasses', 'categories', 'subcategories', 'wordClassFilter', 'categoryFilter', 'subcategoryFilter'));
    }

    public function lemma($slug)
    {
        // Parse slug to get lemma name
        $name = str_replace('-', ' ', $slug);
        
        // Load lemma with all necessary relationships
        $lemma = Lemma::with([
            'label',
            'wordRelations' => function($q) {
                $q->with([
                    'wordClass',
                    'article',
                    'type',
                    'relationshipType'
                ])->orderBy('article_id', 'asc')
                  ->orderBy('par_num', 'asc')
                  ->orderBy('group_num', 'asc')
                  ->orderBy('word_order', 'asc');
            }
        ])
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
        $articles = collect();

        // If lemma has articles, get related words from those articles
        if ($articleIds->isNotEmpty()) {
            // Get all word relations in the same articles, grouped by relationship type
            $allRelations = WordRelation::with([
                'lemma',
                'type',
                'relationshipType',
                'article' => function($q) {
                    $q->with(['category', 'subcategory']);
                }
            ])
            ->whereIn('article_id', $articleIds)
            ->where('lemma_id', '!=', $lemma->id)
            ->orderBy('article_id', 'asc')
            ->orderBy('par_num', 'asc')
            ->orderBy('group_num', 'asc')
            ->orderBy('word_order', 'asc')
            ->get();

            // Organize by relationship type
            foreach ($allRelations as $relation) {
                if ($relation->lemma) {
                    // Check relationship type (sinonimi, hiponimi, meronimi, dll)
                    if ($relation->relationshipType) {
                        $relTypeName = strtolower($relation->relationshipType->name);
                        
                        if ($relTypeName === 'sinonimi') {
                            $synonyms->push($relation);
                        } elseif ($relTypeName === 'hiponimi') {
                            // Hyponyms are more specific
                            $relatedWords->push($relation);
                        } elseif ($relTypeName === 'meronimi') {
                            // Meronyms are parts
                            $relatedWords->push($relation);
                        } elseif ($relTypeName === 'antonimi') {
                            $antonyms->push($relation);
                        } else {
                            $relatedWords->push($relation);
                        }
                    } else {
                        // If no relationship type, treat as related word
                        $relatedWords->push($relation);
                    }
                }
            }

            // Get unique related lemmas
            $relatedLemmas = $allRelations
                ->pluck('lemma')
                ->filter()
                ->unique('id')
                ->take(20);

            // Get articles for context
            $articles = $allRelations
                ->pluck('article')
                ->filter()
                ->unique('id')
                ->take(3);
        }

        // Smart sort collections
        $synonyms = $this->formatter->smartSort($synonyms->unique('lemma_id')->values()->all());
        $antonyms = $this->formatter->smartSort($antonyms->unique('lemma_id')->values()->all());
        $examples = $examples->take(5)->all();
        $relatedWords = $this->formatter->smartSort($relatedWords->unique('lemma_id')->take(15)->all());

        return view('lemma', compact(
            'lemma',
            'synonyms',
            'antonyms',
            'examples',
            'relatedWords',
            'relatedLemmas',
            'articles'
        ));
    }

    public function category()
    {
        $categories = Category::with([
            'subcategories' => function($q) {
                $q->with(['articles' => function($qa) {
                    $qa->orderBy('num', 'asc');
                }])->orderBy('num', 'asc');
            }
        ])->get();
        
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

        // Smart sort hasil
        $lemmasCollection = $lemmas->with(['label', 'wordRelations.wordClass'])
            ->get();
        
        $lemmasCollection = collect($this->formatter->smartSort($lemmasCollection->toArray()));
        $lemmas = $lemmasCollection->paginate(15);

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
