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
        Schema::table('word_relation', function (Blueprint $table) {
            $table->foreignId('lemma_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('word_relation', function (Blueprint $table) {
            $table->foreignId('lemma_id')->nullable(false)->change();
        });
    }
};
