<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lemma;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LemmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lemmas = Lemma::with('label')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('name_tagged', 'LIKE', "%{$request->search}%");
            })
            ->paginate(20);

        return view('admin.lemmas.index', compact('lemmas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labels = Label::all();
        return view('admin.lemmas.create', compact('labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label_id' => 'required|exists:label,id',
            'name' => 'required|string|max:255|unique:lemma,name',
            'name_tagged' => 'nullable|string|max:255',
        ]);

        Lemma::create($validated);

        return redirect()->route('admin.lemmas.index')
            ->with('success', 'Lemma berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lemma $lemma)
    {
        $lemma->load('label', 'wordRelations');
        return view('admin.lemmas.show', compact('lemma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lemma $lemma)
    {
        $labels = Label::all();
        return view('admin.lemmas.edit', compact('lemma', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lemma $lemma)
    {
        $validated = $request->validate([
            'label_id' => 'required|exists:label,id',
            'name' => 'required|string|max:255|unique:lemma,name,' . $lemma->id,
            'name_tagged' => 'nullable|string|max:255',
        ]);

        $lemma->update($validated);

        return redirect()->route('admin.lemmas.index')
            ->with('success', 'Lemma berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lemma $lemma)
    {
        $lemma->delete();

        return redirect()->route('admin.lemmas.index')
            ->with('success', 'Lemma berhasil dihapus');
    }

    /**
     * Quick create lemma via AJAX.
     */
    public function quickCreate(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'label_id' => 'required|exists:label,id',
            ]);

            $lemma = Lemma::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Lemma berhasil ditambahkan',
                'lemma' => $lemma,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan lemma: ' . $e->getMessage(),
            ], 422);
        }
    }
}
