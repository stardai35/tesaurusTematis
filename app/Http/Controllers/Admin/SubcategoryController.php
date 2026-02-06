<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->paginate(20);
        return view('admin.subcategories.index', compact('subcategories'));
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
            'title' => 'required|string|max:255',
            'num' => 'nullable|integer',
        ]);

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
            'title' => 'required|string|max:255',
            'num' => 'nullable|integer',
        ]);

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
