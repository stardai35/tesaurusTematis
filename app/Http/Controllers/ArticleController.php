<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\WordRelation;
use App\Models\Lemma;
use App\Models\WordClass;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles (admin)
     */
    public function index()
    {
        $articles = Article::with('category', 'subcategory')
            ->orderBy('cat_id')
            ->paginate(15);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        $categories = Category::all();
        $wordClasses = WordClass::all();
        $types = Type::all();
        $lemmas = Lemma::all();

        return view('articles.create', compact('categories', 'wordClasses', 'types', 'lemmas'));
    }

    /**
     * Store a newly created article in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'subcat_id' => 'nullable|exists:subcategory,id',
            'title' => 'required|string|max:255',
            'num' => 'nullable|integer',
            'word_relations' => 'array',
            'word_relations.*.wordclass_id' => 'required|exists:word_class,id',
            'word_relations.*.type_id' => 'nullable|exists:type,id',
            'word_relations.*.lemma_id' => 'required|exists:lemma,id',
            'word_relations.*.description' => 'nullable|string',
            'word_relations.*.par_num' => 'nullable|integer',
            'word_relations.*.word_order' => 'nullable|integer',
        ]);

        // Create article
        $article = Article::create([
            'cat_id' => $validated['cat_id'],
            'subcat_id' => $validated['subcat_id'] ?? null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'num' => $validated['num'] ?? null,
        ]);

        // Create word relations
        if (!empty($validated['word_relations'])) {
            foreach ($validated['word_relations'] as $index => $relation) {
                WordRelation::create([
                    'article_id' => $article->id,
                    'wordclass_id' => $relation['wordclass_id'],
                    'type_id' => $relation['type_id'] ?? null,
                    'lemma_id' => $relation['lemma_id'],
                    'description' => $relation['description'] ?? null,
                    'par_num' => $relation['par_num'] ?? ($index + 1),
                    'word_order' => $relation['word_order'] ?? ($index + 1),
                    'group_num' => 1,
                    'meaning_group' => 1,
                ]);
            }
        }

        return redirect()->route('articles.show', $article)
            ->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified article
     */
    public function show(Article $article)
    {
        $article->load('category', 'subcategory', 'wordRelations.lemma.label', 'wordRelations.wordClass', 'wordRelations.type');

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article
     */
    public function edit(Article $article)
    {
        $article->load('wordRelations');
        $categories = Category::all();
        $subcategories = Subcategory::where('cat_id', $article->cat_id)->get();
        $wordClasses = WordClass::all();
        $types = Type::all();
        $lemmas = Lemma::all();

        return view('articles.edit', compact('article', 'categories', 'subcategories', 'wordClasses', 'types', 'lemmas'));
    }

    /**
     * Update the specified article in storage
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'subcat_id' => 'nullable|exists:subcategory,id',
            'title' => 'required|string|max:255',
            'num' => 'nullable|integer',
            'word_relations' => 'array',
            'word_relations.*.wordclass_id' => 'required|exists:word_class,id',
            'word_relations.*.type_id' => 'nullable|exists:type,id',
            'word_relations.*.lemma_id' => 'required|exists:lemma,id',
            'word_relations.*.description' => 'nullable|string',
            'word_relations.*.par_num' => 'nullable|integer',
            'word_relations.*.word_order' => 'nullable|integer',
        ]);

        $article->update([
            'cat_id' => $validated['cat_id'],
            'subcat_id' => $validated['subcat_id'] ?? null,
            'title' => $validated['title'],
            'num' => $validated['num'] ?? null,
        ]);

        // Delete old word relations
        $article->wordRelations()->delete();

        // Create new word relations
        if (!empty($validated['word_relations'])) {
            foreach ($validated['word_relations'] as $index => $relation) {
                WordRelation::create([
                    'article_id' => $article->id,
                    'wordclass_id' => $relation['wordclass_id'],
                    'type_id' => $relation['type_id'] ?? null,
                    'lemma_id' => $relation['lemma_id'],
                    'description' => $relation['description'] ?? null,
                    'par_num' => $relation['par_num'] ?? ($index + 1),
                    'word_order' => $relation['word_order'] ?? ($index + 1),
                    'group_num' => 1,
                    'meaning_group' => 1,
                ]);
            }
        }

        return redirect()->route('articles.show', $article)
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified article from storage
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Display article by subcategory slug with grouped word classes
     */
    public function showBySubcategory($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();
        
        $articles = Article::where('subcat_id', $subcategory->id)
            ->with([
                'wordRelations' => function ($query) {
                    $query->orderBy('wordclass_id')->orderBy('word_order');
                },
                'wordRelations.lemma.label',
                'wordRelations.wordClass',
                'wordRelations.type'
            ])
            ->get();

        // Group word relations by word class
        $groupedByWordClass = [];
        foreach ($articles as $article) {
            foreach ($article->wordRelations as $relation) {
                $wordClassName = $relation->wordClass->name;
                if (!isset($groupedByWordClass[$wordClassName])) {
                    $groupedByWordClass[$wordClassName] = [];
                }
                $groupedByWordClass[$wordClassName][] = $relation;
            }
        }

        return view('articles.subcategory', compact('subcategory', 'articles', 'groupedByWordClass'));
    }

    /**
     * Get subcategories by category
     */
    public function getSubcategories(Category $category)
    {
        $subcategories = Subcategory::where('cat_id', $category->id)->get();

        return response()->json($subcategories);
    }
}
