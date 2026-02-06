<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\WordClass;
use App\Models\Type;
use App\Models\Lemma;
use App\Models\WordRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['category', 'subcategory'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->search}%");
            })
            ->paginate(20);

        return view('admin.articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        $article->load('category', 'subcategory', 'wordRelations.lemma.label', 'wordRelations.wordClass');
        return view('admin.articles.show', compact('article'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $wordClasses = WordClass::all();
        $types = Type::all();
        $lemmas = Lemma::all();
        return view('admin.articles.create', compact('categories', 'subcategories', 'wordClasses', 'types', 'lemmas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'subcat_id' => 'nullable|exists:subcategory,id',
            'num' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'word_relations' => 'array',
            'word_relations.*.wordclass_id' => 'required|exists:word_class,id',
            'word_relations.*.type_id' => 'nullable|exists:type,id',
            'word_relations.*.lemma_id' => 'required|exists:lemma,id',
            'word_relations.*.description' => 'nullable|string',
            'word_relations.*.par_num' => 'nullable|integer',
            'word_relations.*.word_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $article = Article::create($validated);

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

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Article $article)
    {
        $article->load('wordRelations');
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $wordClasses = WordClass::all();
        $types = Type::all();
        $lemmas = Lemma::all();
        return view('admin.articles.edit', compact('article', 'categories', 'subcategories', 'wordClasses', 'types', 'lemmas'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'subcat_id' => 'nullable|exists:subcategory,id',
            'num' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'word_relations' => 'array',
            'word_relations.*.wordclass_id' => 'required|exists:word_class,id',
            'word_relations.*.type_id' => 'nullable|exists:type,id',
            'word_relations.*.lemma_id' => 'required|exists:lemma,id',
            'word_relations.*.description' => 'nullable|string',
            'word_relations.*.par_num' => 'nullable|integer',
            'word_relations.*.word_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $article->update($validated);

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

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus');
    }

    /**
     * Get subcategories by category
     */
    public function getSubcategories(Category $category)
    {
        $subcategories = Subcategory::where('cat_id', $category->id)->get();

        return response()->json($subcategories);
    }

    /**
     * Get lemmas by word class
     */
    public function getLemmasByWordClass(WordClass $wordClass)
    {
        $lemmas = Lemma::all()
            ->map(function ($lemma) {
                return [
                    'id' => $lemma->id,
                    'name' => $lemma->name,
                    'label' => $lemma->label->name ?? '-',
                ];
            });

        return response()->json($lemmas);
    }
}

