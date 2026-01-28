<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\WordRelation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_words' => Lemma::count(),
            'total_articles' => Article::count(),
            'total_categories' => Category::count(),
            'total_relations' => WordRelation::count(),
        ];

        $recentLemmas = Lemma::with('label')->latest('id')->take(10)->get();
        $recentArticles = Article::with('category')->latest('id')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentLemmas', 'recentArticles'));
    }
}
