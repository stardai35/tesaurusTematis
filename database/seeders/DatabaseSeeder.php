<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Labels (Jenis Kata)
        DB::table('label')->insert([
            ['name' => 'nomina', 'abbr' => 'n'],
            ['name' => 'verba', 'abbr' => 'v'],
            ['name' => 'adjektiva', 'abbr' => 'a'],
            ['name' => 'adverbia', 'abbr' => 'adv'],
            ['name' => 'numeralia', 'abbr' => 'num'],
            ['name' => 'pronomina', 'abbr' => 'pron'],
        ]);

        // Seed Word Classes
        DB::table('word_class')->insert([
            ['name' => 'Adjektiva', 'abbr' => 'a'],
            ['name' => 'Adverbia', 'abbr' => 'adv'],
            ['name' => 'Konjungsi', 'abbr' => 'konj'],
            ['name' => 'Nomina', 'abbr' => 'n'],
            ['name' => 'Numeralia', 'abbr' => 'num'],
            ['name' => 'Partikel', 'abbr' => 'p'],
            ['name' => 'Verba', 'abbr' => 'v'],
        ]);

        // Seed Types (Relasi Kata)
        DB::table('type')->insert([
            ['name' => 'sinonim'],
            ['name' => 'antonim'],
            ['name' => 'contoh'],
            ['name' => 'kata_terkait'],
        ]);

        // Seed Categories (Bidang Ilmu)
        DB::table('category')->insert([
            ['num' => 1, 'title' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['num' => 2, 'title' => 'Hukum', 'slug' => 'hukum'],
            ['num' => 3, 'title' => 'Sastra', 'slug' => 'sastra'],
            ['num' => 4, 'title' => 'Teknologi', 'slug' => 'teknologi'],
        ]);

        // Seed Lemma dengan data yang lebih lengkap
        $this->call([
            LemmaSeeder::class,
        ]);

        // Create admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@tesaurus.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}
