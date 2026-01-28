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
        Schema::create('lemma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('label_id')->constrained('label')->onDelete('cascade');
            $table->string('name');
            $table->string('name_tagged')->nullable();
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemma');
    }
};
