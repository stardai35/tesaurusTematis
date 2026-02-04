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
            // Paragraph structure fields - check jika belum ada
            if (!Schema::hasColumn('word_relation', 'meaning_group')) {
                $table->integer('meaning_group')->nullable()->default(1)->comment('Kelompok makna dalam paragraf');
            }
            if (!Schema::hasColumn('word_relation', 'description')) {
                $table->text('description')->nullable()->comment('Penjelasan atau deskripsi kata');
            }
            if (!Schema::hasColumn('word_relation', 'is_superordinate')) {
                $table->boolean('is_superordinate')->default(false)->comment('Menandai jika kata adalah superordinat');
            }
            if (!Schema::hasColumn('word_relation', 'foreign_language')) {
                $table->string('foreign_language')->nullable()->comment('Bahasa asing untuk cetak miring');
            }
            if (!Schema::hasColumn('word_relation', 'language_variant')) {
                $table->string('language_variant')->nullable()->comment('cak=cakapan, kas=kasar, hor=hormat');
            }
            if (!Schema::hasColumn('word_relation', 'is_bold')) {
                $table->boolean('is_bold')->default(false)->comment('Acuan ke artikel lain');
            }
        });

        // Create label_type table if not exists
        if (!Schema::hasTable('label_type')) {
            Schema::create('label_type', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('description')->nullable();
            });
        }

        // Add relationship type foreign key
        Schema::table('word_relation', function (Blueprint $table) {
            if (!Schema::hasColumn('word_relation', 'relationship_type')) {
                $table->foreignId('relationship_type')->nullable()->constrained('label_type')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('word_relation', function (Blueprint $table) {
            if (Schema::hasColumn('word_relation', 'relationship_type')) {
                $table->dropForeignIdFor('LabelType');
                $table->dropColumn('relationship_type');
            }
            if (Schema::hasColumn('word_relation', 'meaning_group')) {
                $table->dropColumn('meaning_group');
            }
            if (Schema::hasColumn('word_relation', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('word_relation', 'is_superordinate')) {
                $table->dropColumn('is_superordinate');
            }
            if (Schema::hasColumn('word_relation', 'foreign_language')) {
                $table->dropColumn('foreign_language');
            }
            if (Schema::hasColumn('word_relation', 'language_variant')) {
                $table->dropColumn('language_variant');
            }
            if (Schema::hasColumn('word_relation', 'is_bold')) {
                $table->dropColumn('is_bold');
            }
        });

        if (Schema::hasTable('label_type')) {
            Schema::dropIfExists('label_type');
        }
    }
};
