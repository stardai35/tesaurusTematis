<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LemmaController as AdminLemmaController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\WordRelationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cari', [HomeController::class, 'search'])->name('search');
Route::get('/kategori', [HomeController::class, 'category'])->name('category');
Route::get('/lema/{slug}', [HomeController::class, 'lemma'])->name('lemma');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/petunjuk-penggunaan', [HomeController::class, 'guide'])->name('guide');
Route::get('/tim-redaksi', [HomeController::class, 'team'])->name('team');

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
    
    // Word Relation Management
    Route::resource('word-relations', WordRelationController::class);
});
