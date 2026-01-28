<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Lemma;
use App\Models\Type;
use App\Models\WordClass;
use App\Models\WordRelation;
use Illuminate\Http\Request;

class WordRelationController extends Controller
{
    public function index(Request $request)
    {
        $relations = WordRelation::with(['article', 'lemma', 'wordClass', 'type'])
            ->when($request->article_id, function ($query) use ($request) {
                $query->where('article_id', $request->article_id);
            })
            ->when($request->lemma_id, function ($query) use ($request) {
                $query->where('lemma_id', $request->lemma_id);
            })
            ->paginate(20);

        $articles = Article::all();
        $lemmas = Lemma::all();

        return view('admin.word-relations.index', compact('relations', 'articles', 'lemmas'));
    }

    public function create()
    {
        $articles = Article::all();
        $lemmas = Lemma::all();
        $wordClasses = WordClass::all();
        $types = Type::all();

        return view('admin.word-relations.create', compact('articles', 'lemmas', 'wordClasses', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:article,id',
            'lemma_id' => 'required|exists:lemma,id',
            'wordclass_id' => 'required|exists:word_class,id',
            'type_id' => 'required|exists:type,id',
            'par_num' => 'nullable|integer',
            'group_num' => 'nullable|integer',
            'word_order' => 'nullable|integer',
        ]);

        WordRelation::create($validated);

        return redirect()->route('admin.word-relations.index')
            ->with('success', 'Relasi kata berhasil ditambahkan');
    }

    public function edit(WordRelation $wordRelation)
    {
        $articles = Article::all();
        $lemmas = Lemma::all();
        $wordClasses = WordClass::all();
        $types = Type::all();

        return view('admin.word-relations.edit', compact('wordRelation', 'articles', 'lemmas', 'wordClasses', 'types'));
    }

    public function update(Request $request, WordRelation $wordRelation)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:article,id',
            'lemma_id' => 'required|exists:lemma,id',
            'wordclass_id' => 'required|exists:word_class,id',
            'type_id' => 'required|exists:type,id',
            'par_num' => 'nullable|integer',
            'group_num' => 'nullable|integer',
            'word_order' => 'nullable|integer',
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
}
