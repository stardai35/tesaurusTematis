<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'num' => 1,
                'title' => 'I. Ukuran dan Bentuk',
                'subcategories' => [
                    ['num' => '1.1', 'title' => 'Bilangan'],
                    ['num' => '1.2', 'title' => 'Ukuran'],
                    ['num' => '1.3', 'title' => 'Bentuk'],
                ]
            ],
            [
                'num' => 2,
                'title' => 'II. Gerak, Arah, dan Waktu',
                'subcategories' => [
                    ['num' => '2.1', 'title' => 'Gerak'],
                    ['num' => '2.2', 'title' => 'Arah'],
                    ['num' => '2.3', 'title' => 'Waktu'],
                ]
            ],
            [
                'num' => 3,
                'title' => 'III. Geografi, Geologi, dan Meteorologi',
                'subcategories' => []
            ],
            [
                'num' => 4,
                'title' => 'IV. Kehidupan dan Makhluk Hidup',
                'subcategories' => [
                    ['num' => '4.1', 'title' => 'Kehidupan'],
                    ['num' => '4.2', 'title' => 'Tumbuhan'],
                    ['num' => '4.3', 'title' => 'Zoologi'],
                    ['num' => '4.4', 'title' => 'Manusia'],
                ]
            ],
            [
                'num' => 5,
                'title' => 'V. Organ Tubuh',
                'subcategories' => [
                    ['num' => '5.1', 'title' => 'Organ Luar'],
                    ['num' => '5.2', 'title' => 'Organ Dalam'],
                ]
            ],
            [
                'num' => 6,
                'title' => 'VI. Pengindraan',
                'subcategories' => [
                    ['num' => '6.1', 'title' => 'Pengindraan'],
                    ['num' => '6.2', 'title' => 'Penglihatan'],
                    ['num' => '6.3', 'title' => 'Pendengaran'],
                    ['num' => '6.4', 'title' => 'Pengecapan'],
                    ['num' => '6.5', 'title' => 'Perabaan'],
                    ['num' => '6.6', 'title' => 'Penghiduan'],
                ]
            ],
            [
                'num' => 7,
                'title' => 'VII. Keadaan Tubuh dan Pengobatan',
                'subcategories' => [
                    ['num' => '7.1', 'title' => 'Keadaan Tubuh'],
                    ['num' => '7.2', 'title' => 'Pengobatan'],
                ]
            ],
            [
                'num' => 8,
                'title' => 'VIII. Minda, Pengetahuan, dan Upaya',
                'subcategories' => [
                    ['num' => '8.1', 'title' => 'Minda'],
                    ['num' => '8.2', 'title' => 'Pengetahuan'],
                    ['num' => '8.3', 'title' => 'Upaya'],
                ]
            ],
            [
                'num' => 9,
                'title' => 'IX. Kata Hati/Emosi dan Perilaku',
                'subcategories' => [
                    ['num' => '9.1', 'title' => 'Emosi/Kata Hati'],
                    ['num' => '9.2', 'title' => 'Perilaku'],
                    ['num' => '9.3', 'title' => 'Moral'],
                    ['num' => '9.4', 'title' => 'Religi'],
                ]
            ],
            [
                'num' => 10,
                'title' => 'X. Kehidupan Masyarakat',
                'subcategories' => [
                    ['num' => '10.1', 'title' => 'Status'],
                    ['num' => '10.2', 'title' => 'Kewarganegaraan'],
                    ['num' => '10.3', 'title' => 'Keluarga'],
                    ['num' => '10.4', 'title' => 'Masyarakat dan Politik'],
                    ['num' => '10.5', 'title' => 'Perang dan Perdamaian'],
                    ['num' => '10.6', 'title' => 'Hukum'],
                ]
            ],
            [
                'num' => 11,
                'title' => 'XI. Humaniora',
                'subcategories' => [
                    ['num' => '11.1', 'title' => 'Komunikasi'],
                    ['num' => '11.2', 'title' => 'Bahasa'],
                    ['num' => '11.3', 'title' => 'Seni'],
                ]
            ],
            [
                'num' => 12,
                'title' => 'XII. Ekonomi dan Keuangan',
                'subcategories' => [
                    ['num' => '12.1', 'title' => 'Pekerjaan dan Produksi'],
                    ['num' => '12.2', 'title' => 'Perdagangan'],
                    ['num' => '12.3', 'title' => 'Ekonomi'],
                    ['num' => '12.4', 'title' => 'Keuangan'],
                ]
            ],
            [
                'num' => 13,
                'title' => 'XIII. Transportasi',
                'subcategories' => []
            ],
            [
                'num' => 14,
                'title' => 'XIV. Arsitektur',
                'subcategories' => []
            ],
            [
                'num' => 15,
                'title' => 'XV. Hunian dan Perabot',
                'subcategories' => []
            ],
            [
                'num' => 16,
                'title' => 'XVI. Tata Boga',
                'subcategories' => []
            ],
            [
                'num' => 17,
                'title' => 'XVII. Mode',
                'subcategories' => []
            ],
            [
                'num' => 18,
                'title' => 'XVIII. Kegemaran dan Hobi',
                'subcategories' => []
            ],
            [
                'num' => 19,
                'title' => 'XIX. Olahraga dan Permainan',
                'subcategories' => []
            ],
        ];

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('subcategory')->truncate();
        DB::table('category')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($categories as $categoryData) {
            $categoryId = DB::table('category')->insertGetId([
                'num' => $categoryData['num'],
                'title' => $categoryData['title'],
                'slug' => Str::slug($categoryData['title']),
            ]);

            foreach ($categoryData['subcategories'] as $subcat) {
                DB::table('subcategory')->insert([
                    'cat_id' => $categoryId,
                    'num' => $subcat['num'],
                    'title' => $subcat['title'],
                    'slug' => Str::slug($subcat['title']),
                ]);
            }
        }

        $this->command->info('Categories and subcategories seeded successfully!');
    }
}
