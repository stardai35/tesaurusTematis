<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LemmaController as AdminLemmaController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SubcategoryController as AdminSubcategoryController;
use App\Http\Controllers\Admin\WordRelationController as AdminWordRelationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari', [HomeController::class, 'search'])->name('search');
Route::get('/kategori', [HomeController::class, 'category'])->name('category');
Route::get('/lema/{slug}', [HomeController::class, 'lemma'])->name('lemma');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/petunjuk-penggunaan', [HomeController::class, 'guide'])->name('guide');
Route::get('/tim-redaksi', [HomeController::class, 'team'])->name('team');

// Article Routes (Public)
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/artikel/subcategory/{slug}', [ArticleController::class, 'showBySubcategory'])->name('articles.subcategory');

// Auth Routes
require __DIR__.'/auth.php';

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Lemma Management
    Route::resource('lemmas', AdminLemmaController::class);
    
    // Article Management
    Route::resource('articles', AdminArticleController::class);
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Subcategory Management
    Route::resource('subcategories', AdminSubcategoryController::class);
    
    // Word Relation Management (Most Important)
    Route::resource('word-relations', AdminWordRelationController::class);
    Route::get('/articles/{article}/word-relations', [AdminWordRelationController::class, 'byArticle'])
        ->name('word-relations.by-article');
});

// API Routes
Route::get('/api/categories/{category}/subcategories', [ArticleController::class, 'getSubcategories']);
Route::post('/api/lemmas/quick-create', [AdminLemmaController::class, 'quickCreate'])->middleware('auth');
