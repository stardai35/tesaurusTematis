<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Lemma;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LemmaController extends Controller
{
    public function index(Request $request)
    {
        $lemmas = Lemma::with('label')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            })
            ->paginate(20);

        return view('admin.lemmas.index', compact('lemmas'));
    }

    public function create()
    {
        $labels = Label::all();
        return view('admin.lemmas.create', compact('labels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label_id' => 'required|exists:label,id',
            'name' => 'required|string|max:255',
            'name_tagged' => 'nullable|string|max:255',
        ]);

        Lemma::create($validated);

        return redirect()->route('admin.lemmas.index')
            ->with('success', 'Lemma berhasil ditambahkan');
    }

    public function edit(Lemma $lemma)
    {
        $labels = Label::all();
        return view('admin.lemmas.edit', compact('lemma', 'labels'));
    }

    public function update(Request $request, Lemma $lemma)
    {
        $validated = $request->validate([
            'label_id' => 'required|exists:label,id',
            'name' => 'required|string|max:255',
            'name_tagged' => 'nullable|string|max:255',
        ]);

        $lemma->update($validated);

        return redirect()->route('admin.lemmas.index')
            ->with('success', 'Lemma berhasil diperbarui');
    }

    public function destroy(Lemma $lemma)
    {
        $lemma->delete();

        return redirect()->route('admin.lemmas.index')
            ->with('success', 'Lemma berhasil dihapus');
    }
}
