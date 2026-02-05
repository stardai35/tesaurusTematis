<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $subcategories = Subcategory::with('category')
            ->when($request->category_id, function($q) use ($request) {
                $q->where('cat_id', $request->category_id);
            })
            ->when($request->search, function($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->search}%");
            })
            ->orderBy('cat_id', 'asc')
            ->orderBy('num', 'asc')
            ->paginate(20);

        $categories = Category::all();

        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'num' => 'required|integer|min:0',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategory,slug',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        Subcategory::create($validated);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subkategori berhasil ditambahkan');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'num' => 'required|integer|min:0',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subcategory,slug,' . $subcategory->id,
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subkategori berhasil diperbarui');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subkategori berhasil dihapus');
    }
}
