<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('word_relation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('article')->onDelete('cascade');
            $table->integer('par_num')->nullable();
            $table->foreignId('wordclass_id')->constrained('word_class')->onDelete('cascade');
            $table->integer('group_num')->nullable();
            $table->foreignId('type_id')->constrained('type')->onDelete('cascade');
            $table->integer('word_order')->nullable();
            $table->foreignId('lemma_id')->constrained('lemma')->onDelete('cascade');
            
            $table->index(['article_id', 'lemma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_relation');
    }
};
