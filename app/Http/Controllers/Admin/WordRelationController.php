<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\WordClass;
use App\Models\Type;
use App\Models\Lemma;
use App\Models\WordRelation;
use Illuminate\Http\Request;

class WordRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wordRelations = WordRelation::with(['article', 'lemma', 'wordClass', 'type'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('article', function ($q) use ($request) {
                    $q->where('title', 'LIKE', "%{$request->search}%");
                })->orWhereHas('lemma', function ($q) use ($request) {
                    $q->where('word', 'LIKE', "%{$request->search}%");
                });
            })
            ->paginate(20);

        return view('admin.word-relations.index', compact('wordRelations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        $wordClasses = WordClass::all();
        $types = Type::all();
        $lemmas = Lemma::all();

        return view('admin.word-relations.create', compact('articles', 'wordClasses', 'types', 'lemmas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:article,id',
            'wordclass_id' => 'required|exists:word_class,id',
            'type_id' => 'nullable|exists:type,id',
            'lemma_id' => 'nullable|exists:lemma,id',
            'lemma_manual' => 'nullable|string',
            'par_num' => 'nullable|integer|min:1',
            'word_order' => 'nullable|integer|min:1',
            'group_num' => 'nullable|integer|min:1',
            'meaning_group' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_superordinate' => 'nullable|boolean',
            'foreign_language' => 'nullable|string',
            'language_variant' => 'nullable|string',
            'is_bold' => 'nullable|boolean',
            'relationship_type' => 'nullable|string',
        ]);

        // Prioritaskan lemma_manual jika diisi
        if (!empty($validated['lemma_manual'])) {
            $lemma = Lemma::create(['name' => $validated['lemma_manual']]);
            $validated['lemma_id'] = $lemma->id;
        }
        unset($validated['lemma_manual']);

        WordRelation::create($validated);

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Word Relation berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(WordRelation $wordRelation)
    {
        $wordRelation->load(['article', 'lemma', 'wordClass', 'type']);
        return view('admin.word-relations.show', compact('wordRelation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WordRelation $wordRelation)
    {
        $wordRelation->load(['article', 'lemma', 'wordClass', 'type']);
        $articles = Article::all();
        $wordClasses = WordClass::all();
        $types = Type::all();
        $lemmas = Lemma::all();

        return view('admin.word-relations.edit', compact('wordRelation', 'articles', 'wordClasses', 'types', 'lemmas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WordRelation $wordRelation)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:article,id',
            'wordclass_id' => 'required|exists:word_class,id',
            'type_id' => 'nullable|exists:type,id',
            'lemma_id' => 'nullable|exists:lemma,id',
            'lemma_manual' => 'nullable|string',
            'par_num' => 'nullable|integer|min:1',
            'word_order' => 'nullable|integer|min:1',
            'group_num' => 'nullable|integer|min:1',
            'meaning_group' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_superordinate' => 'nullable|boolean',
            'foreign_language' => 'nullable|string',
            'language_variant' => 'nullable|string',
            'is_bold' => 'nullable|boolean',
            'relationship_type' => 'nullable|string',
        ]);

        if (!empty($validated['lemma_manual'])) {
            $lemma = Lemma::create(['name' => $validated['lemma_manual']]);
            $validated['lemma_id'] = $lemma->id;
        }
        unset($validated['lemma_manual']);

        $wordRelation->update($validated);

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Word Relation berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WordRelation $wordRelation)
    {
        $wordRelation->delete();

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Word Relation berhasil dihapus');
    }

    /**
     * Get word relations by article.
     */
    public function byArticle(Article $article)
    {
        $wordRelations = $article->wordRelations()
            ->with(['lemma', 'wordClass', 'type'])
            ->orderBy('par_num')
            ->orderBy('word_order')
            ->get();

        return view('admin.word-relations.by-article', compact('article', 'wordRelations'));
    }
}
