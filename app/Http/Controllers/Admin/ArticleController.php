<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Subcategory;
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

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.articles.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'subcat_id' => 'nullable|exists:subcategory,id',
            'num' => 'nullable|integer',
            'title' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.articles.edit', compact('article', 'categories', 'subcategories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'subcat_id' => 'nullable|exists:subcategory,id',
            'num' => 'nullable|integer',
            'title' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus');
    }
}
