<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Lemma;
use App\Models\WordClass;
use App\Models\WordRelation;
use App\Models\LabelType;
use Illuminate\Http\Request;

class WordRelationController extends Controller
{
    public function index(Request $request)
    {
        $wordRelations = WordRelation::with([
            'article',
            'lemma',
            'wordClass',
            'type',
            'relationshipType'
        ])
        ->when($request->search, function($q) use ($request) {
            $q->whereHas('lemma', function($q2) use ($request) {
                $q2->where('name', 'LIKE', "%{$request->search}%");
            });
        })
        ->when($request->article_id, function($q) use ($request) {
            $q->where('article_id', $request->article_id);
        })
        ->orderBy('article_id', 'desc')
        ->orderBy('par_num', 'asc')
        ->orderBy('word_order', 'asc')
        ->paginate(20);

        $articles = Article::orderBy('title', 'asc')->get();

        return view('admin.word-relations.index', compact('wordRelations', 'articles'));
    }

    public function create(Article $article = null)
    {
        $articles = Article::orderBy('title', 'asc')->get();
        $lemmas = Lemma::orderBy('name', 'asc')->get();
        $wordClasses = WordClass::orderBy('name', 'asc')->get();
        $labelTypes = LabelType::orderBy('name', 'asc')->get();
        
        return view('admin.word-relations.create', compact('articles', 'lemmas', 'wordClasses', 'labelTypes', 'article'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:article,id',
            'lemma_id' => 'required|exists:lemma,id',
            'wordclass_id' => 'required|exists:word_class,id',
            'type_id' => 'nullable|exists:type,id',
            'relationship_type' => 'nullable|exists:label_type,id',
            'par_num' => 'nullable|integer|min:0',
            'group_num' => 'nullable|integer|min:0',
            'word_order' => 'nullable|integer|min:0',
            'is_superordinate' => 'boolean',
            'meaning_group' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'foreign_language' => 'nullable|string|max:255',
            'language_variant' => 'nullable|string|max:255',
            'is_bold' => 'boolean',
        ]);

        WordRelation::create($validated);

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Relasi kata berhasil ditambahkan');
    }

    public function edit(WordRelation $wordRelation)
    {
        $articles = Article::orderBy('title', 'asc')->get();
        $lemmas = Lemma::orderBy('name', 'asc')->get();
        $wordClasses = WordClass::orderBy('name', 'asc')->get();
        $labelTypes = LabelType::orderBy('name', 'asc')->get();
        
        return view('admin.word-relations.edit', compact('wordRelation', 'articles', 'lemmas', 'wordClasses', 'labelTypes'));
    }

    public function update(Request $request, WordRelation $wordRelation)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:article,id',
            'lemma_id' => 'required|exists:lemma,id',
            'wordclass_id' => 'required|exists:word_class,id',
            'type_id' => 'nullable|exists:type,id',
            'relationship_type' => 'nullable|exists:label_type,id',
            'par_num' => 'nullable|integer|min:0',
            'group_num' => 'nullable|integer|min:0',
            'word_order' => 'nullable|integer|min:0',
            'is_superordinate' => 'boolean',
            'meaning_group' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'foreign_language' => 'nullable|string|max:255',
            'language_variant' => 'nullable|string|max:255',
            'is_bold' => 'boolean',
        ]);

        $wordRelation->update($validated);

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Relasi kata berhasil diperbarui');
    }

    public function destroy(WordRelation $wordRelation)
    {
        $wordRelation->delete();

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Relasi kata berhasil dihapus');
    }

    public function byArticle(Article $article)
    {
        $wordRelations = $article->wordRelations()
            ->with(['lemma', 'wordClass', 'type', 'relationshipType'])
            ->orderBy('par_num', 'asc')
            ->orderBy('word_order', 'asc')
            ->get();

        return view('admin.word-relations.by-article', compact('article', 'wordRelations'));
    }
}
