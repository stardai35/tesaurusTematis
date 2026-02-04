<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('label_type')->insertOrIgnore([
            [
                'name' => 'sinonimi',
                'description' => 'Hubungan antara kata yang maknanya mirip atau sama dengan pasangan kata yang lain',
            ],
            [
                'name' => 'hiponimi',
                'description' => 'Hubungan antara kata yang memiliki makna yang lebih sempit daripada makna generik',
            ],
            [
                'name' => 'meronimi',
                'description' => 'Hubungan suatu kata dengan kata lain yang merupakan bagian dari makna kata lain tersebut',
            ],
            [
                'name' => 'antonimi',
                'description' => 'Hubungan antara kata yang memiliki makna berlawanan',
            ],
        ]);
    }
}
