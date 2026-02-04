<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Menggabungkan semua seeding: Labels, Word Classes, Types, Categories, dan Lemmas
     */
    public function run(): void
    {
        // 1. Seed Labels (Jenis Kata)
        DB::table('label')->insert([
            ['name' => 'nomina', 'abbr' => 'n'],
            ['name' => 'verba', 'abbr' => 'v'],
            ['name' => 'adjektiva', 'abbr' => 'a'],
            ['name' => 'adverbia', 'abbr' => 'adv'],
            ['name' => 'numeralia', 'abbr' => 'num'],
            ['name' => 'pronomina', 'abbr' => 'pron'],
        ]);

        // 2. Seed Word Classes
        DB::table('word_class')->insert([
            ['name' => 'Adjektiva', 'abbr' => 'a'],
            ['name' => 'Adverbia', 'abbr' => 'adv'],
            ['name' => 'Konjungsi', 'abbr' => 'konj'],
            ['name' => 'Nomina', 'abbr' => 'n'],
            ['name' => 'Numeralia', 'abbr' => 'num'],
            ['name' => 'Partikel', 'abbr' => 'p'],
            ['name' => 'Verba', 'abbr' => 'v'],
        ]);

        // 3. Seed Types (Relasi Kata)
        DB::table('type')->insert([
            ['name' => 'sinonim'],
            ['name' => 'antonim'],
            ['name' => 'contoh'],
            ['name' => 'kata_terkait'],
        ]);

        // 4. Seed Label Types (Jenis Relasi Makna - Tesaurus)
        DB::table('label_type')->insertOrIgnore([
            ['name' => 'sinonimi', 'description' => 'Hubungan antara kata yang maknanya mirip atau sama'],
            ['name' => 'hiponimi', 'description' => 'Hubungan antara kata yang memiliki makna lebih sempit'],
            ['name' => 'meronimi', 'description' => 'Hubungan suatu kata dengan bagian dari makna kata lain'],
            ['name' => 'antonimi', 'description' => 'Hubungan antara kata yang memiliki makna berlawanan'],
        ]);

        // 5. Seed Categories dengan Subcategories dan Articles (Struktur Tesaurus Lengkap)
        $this->seedCategoriesWithStructure();

        // 6. Seed Lemma
        $this->call([
            LemmaSeeder::class,
        ]);

        // 7. Create admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@tesaurus.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Database seeding completed successfully!');
    }

    /**
     * Seed Categories, Subcategories, dan Articles sesuai struktur Tesaurus
     */
    private function seedCategoriesWithStructure(): void
    {
        $data = [
            [
                'category' => ['num' => 1, 'title' => 'I. Ukuran dan Bentuk'],
                'subcategories' => [
                    [
                        'num' => '1.1',
                        'title' => 'Bilangan',
                        'articles' => ['Bilangan', 'Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Puluh', 'Belas', 'Ratus', 'Ribu', 'Hitung', 'Angka', 'Tambah', 'Kurang', 'Kali', 'Bagi', 'Matematika']
                    ],
                    [
                        'num' => '1.2',
                        'title' => 'Ukuran',
                        'articles' => ['Ukuran', 'Panjang', 'Pendek', 'Lebar', 'Luas', 'Tinggi', 'Rendah', 'Besar', 'Kecil', 'Sempit', 'Dalam', 'Dangkal', 'Berat', 'Ringan']
                    ],
                    [
                        'num' => '1.3',
                        'title' => 'Bentuk',
                        'articles' => ['Bentuk', 'Sudut', 'Lengkung', 'Lingkar', 'Struktur', 'Garis', 'Tanda Silang']
                    ]
                ]
            ],
            [
                'category' => ['num' => 2, 'title' => 'II. Gerak, Arah, dan Waktu'],
                'subcategories' => [
                    [
                        'num' => '2.1',
                        'title' => 'Gerak',
                        'articles' => ['Gerak', 'Arah', 'Dekat', 'Jauh', 'Datang', 'Berangkat', 'Masuk', 'Keluar', 'Penetrasi', 'Naik', 'Turun', 'Lompat', 'Jatuh', 'Putar']
                    ],
                    [
                        'num' => '2.2',
                        'title' => 'Arah',
                        'articles' => ['Depan', 'Belakang', 'Samping', 'Atas', 'Bawah', 'Tengah', 'Horizontal', 'Vertikal']
                    ],
                    [
                        'num' => '2.3',
                        'title' => 'Waktu',
                        'articles' => ['Waktu', 'Kelangsungan', 'Durasi', 'Abadi', 'Semerta', 'Kronologi', 'Kalender', '(Masa) Lampau', '(Masa) Kini', '(Masa) Mendatang', 'Dini', 'Lambat', 'Simultan', '(Ke)kerap(an)', 'Jarang', 'Periode', 'Saat', 'Musim', 'Pagi', 'Petang', 'Evolusi', 'Sejarah', 'Peristiwa', 'Perubahan', 'Baru', 'Kuno', 'Usang']
                    ]
                ]
            ],
            [
                'category' => ['num' => 3, 'title' => 'III. Geografi, Geologi, dan Meteorologi'],
                'subcategories' => [
                    [
                        'num' => '3.1',
                        'title' => 'Geografi, Geologi, dan Meteorologi',
                        'articles' => ['Geografi', 'Geologi', 'Meteorologi']
                    ]
                ]
            ],
            [
                'category' => ['num' => 4, 'title' => 'IV. Kehidupan dan Makhluk Hidup'],
                'subcategories' => [
                    [
                        'num' => '4.1',
                        'title' => 'Kehidupan',
                        'articles' => ['Reproduksi', 'Keturunan', 'Embriologi', 'Ekologi', 'Sel', 'Mikroorganisme']
                    ],
                    [
                        'num' => '4.2',
                        'title' => 'Tumbuhan',
                        'articles' => ['Botani', 'Spora', 'Biologi', 'Sayur-mayur', 'Pohon', 'Perdu', 'Bunga', 'Buah', 'Herba', 'Jamur', 'Lumut', 'Ganggang']
                    ],
                    [
                        'num' => '4.3',
                        'title' => 'Zoologi',
                        'articles' => ['Zoologi', 'Mamalia', 'Burung/Unggas', 'Ikan', 'Reptilia', 'Amfibi', 'Insekta dan Araknida', 'Krustasea', 'Moluska', 'Cacing', 'Suara Binatang']
                    ],
                    [
                        'num' => '4.4',
                        'title' => 'Manusia',
                        'articles' => ['Manusia', 'Pria', 'Wanita', 'Hidup', 'Mati', 'Usia', 'Lahir', '(Masa) Kanak-kanak', 'Remaja', 'Dewasa', 'Tua']
                    ]
                ]
            ],
            [
                'category' => ['num' => 5, 'title' => 'V. Organ Tubuh'],
                'subcategories' => [
                    [
                        'num' => '5.1',
                        'title' => 'Organ Luar',
                        'articles' => ['Kepala', 'Tangan', 'Kaki', 'Punggung', 'Dada', 'Perut', 'Kelamin', 'Gigi', 'Kulit', 'Rambut']
                    ],
                    [
                        'num' => '5.2',
                        'title' => 'Organ Dalam',
                        'articles' => ['Otak', 'Saraf', 'Otot', 'Tulang dan Sendi', 'Jantung dan Pembuluh', 'Paru-paru', 'Darah', 'Kelenjar', 'Jaringan']
                    ]
                ]
            ],
            [
                'category' => ['num' => 6, 'title' => 'VI. Pengindraan'],
                'subcategories' => [
                    [
                        'num' => '6.1',
                        'title' => 'Pengindraan',
                        'articles' => ['Pengindraan']
                    ],
                    [
                        'num' => '6.2',
                        'title' => 'Penglihatan',
                        'articles' => ['Penglihatan', 'Kasatmata', 'Satmata', 'Masalah Penglihatan', 'Terang', 'Gelap', 'Warna', 'Putih', 'Hitam', 'Abu-abu', 'Cokelat', 'Merah', 'Kuning', 'Hijau', 'Biru', 'Ungu', 'Warna-warni']
                    ],
                    [
                        'num' => '6.3',
                        'title' => 'Pendengaran',
                        'articles' => ['Pendengaran', 'Tuli', 'Suara', 'Bunyi', 'Sunyi', 'Gaduh', 'Siul(an)', 'Lengking(an)']
                    ],
                    [
                        'num' => '6.4',
                        'title' => 'Pengecapan',
                        'articles' => ['Pengecapan']
                    ],
                    [
                        'num' => '6.5',
                        'title' => 'Perabaan',
                        'articles' => ['Perabaan', 'Rasa Sakit']
                    ],
                    [
                        'num' => '6.6',
                        'title' => 'Penghiduan',
                        'articles' => ['Penghiduan', 'Bau', 'Aroma', 'Bau Taksedap']
                    ]
                ]
            ],
            [
                'category' => ['num' => 7, 'title' => 'VII. Keadaan Tubuh dan Pengobatan'],
                'subcategories' => [
                    [
                        'num' => '7.1',
                        'title' => 'Keadaan Tubuh',
                        'articles' => ['Kuat', 'Lemah', 'Berjaga', 'Kantuk', 'Bersih', 'Kotor', 'Sehat', 'Sakit', 'Sembuh', 'Parah', 'Cacat', 'Ketaksadaran', 'Luka', 'Benjol', 'Keracunan', 'Kecanduan']
                    ],
                    [
                        'num' => '7.2',
                        'title' => 'Pengobatan',
                        'articles' => ['Ilmu Kedokteran', 'Ilmu Bedah', 'Perawatan Tubuh', 'Obat-obatan', 'Ilmu Gizi']
                    ]
                ]
            ],
            [
                'category' => ['num' => 8, 'title' => 'VIII. Minda, Pengetahuan, dan Upaya'],
                'subcategories' => [
                    [
                        'num' => '8.1',
                        'title' => 'Minda',
                        'articles' => ['Inteligensi', 'Bodoh', 'Pandai', 'Daya Tangkap', 'Ingat(an)', 'Lupa', 'Perhatian', '(Ke)lengah(an)', 'Imajinasi', 'Kemelitan', 'Kepekaan', 'Pernalaran', 'Negasi', 'Pertanyaan', 'Jawaban', 'Gagasan', 'Dugaan', 'Intuisi', 'Perbandingan', 'Pendapat', 'Persetujuan', 'Kepastian', 'Keraguan', 'Mutu', 'Nilai Tinggi', 'Nilai Rendah']
                    ],
                    [
                        'num' => '8.2',
                        'title' => 'Pengetahuan',
                        'articles' => ['Pengetahuan', 'Kebenaran', 'Kesalahan', 'Penemuan', 'Penelitian', 'Pemelajaran', 'Pengajaran', 'Pendidikan']
                    ],
                    [
                        'num' => '8.3',
                        'title' => 'Upaya',
                        'articles' => ['Usaha', 'Tujuan', 'Persiapan', 'Pelaksanaan', 'Percobaan', 'Proyek', 'Sukses', 'Gagal', 'Istirahat']
                    ]
                ]
            ],
            [
                'category' => ['num' => 9, 'title' => 'IX. Kata Hati/Emosi dan Perilaku'],
                'subcategories' => [
                    [
                        'num' => '9.1',
                        'title' => 'Emosi/Kata Hati',
                        'articles' => ['Gembira', 'Sedih', 'Jenaka', 'Tragis', 'Kegemaran', 'Benci', 'Puas', 'Kecewa', 'Marah', 'Takut', 'Lega', 'Harapan', 'Putus Asa']
                    ],
                    [
                        'num' => '9.2',
                        'title' => 'Perilaku',
                        'articles' => ['Ramah', 'Kongsi', 'Sendiri', 'Baik', 'Buruk', 'Jahat', 'Dermawan', 'Egoisme', 'Optimisme', 'Pesimisme', 'Semangat', 'Sabar', 'Malas', 'Rajin', 'Tenang', 'Cinta', 'Nafsu', 'Penyesalan', 'Persahabatan', 'Permusuhan', 'Kekurangan', 'Curiga', 'Cemburu', 'Rasa Iba', 'Rasa Malu', 'Rendah Hati', 'Mulia', 'Kepura-puraan', 'Sederhana', 'Angkuh', 'Pamer', 'Rendah Diri', 'Geli', 'Santun', 'Lancang', 'Wibawa', 'Dominasi', 'Kendali', 'Pengaruh', 'Kepatuhan', 'Pembangkangan', 'Hormat', 'Pertentangan', 'Hina', 'Diskredit', 'Perintah', 'Izin', 'Larangan', 'Permintaan', 'Pemberian', 'Penerimaan', 'Sanjungan', 'Teguran', 'Maaf', 'Kejayaan', 'Pengucilan', 'Penyingkiran', 'Promosi']
                    ],
                    [
                        'num' => '9.3',
                        'title' => 'Moral',
                        'articles' => ['Moral', 'Kewajiban', 'Norma', 'Nilai', 'Etiket', 'Kejujuran', 'Kecurangan', 'Penghargaan', 'Penebusan', 'Kebajikan', 'Pencemaran']
                    ],
                    [
                        'num' => '9.4',
                        'title' => 'Religi',
                        'articles' => ['Religi', 'Ketuhanan', 'Kepercayaan', 'Kafir', 'Suci', 'Dosa', 'Ilmu Gaib', 'Tenung', 'Yahudi', 'Nasrani', 'Islam', 'Buddha', 'Hindu', 'Khonghucu', 'Pemujaan', 'Rohaniwan', 'Doa', 'Tempat Ibadah', 'Khotbah', 'Ibadah', 'Hari Besar Agama', 'Kitab Suci dan Sumber Ajaran', 'Tuhan', 'Malaikat', 'Iblis', 'Surga', 'Neraka']
                    ]
                ]
            ],
            [
                'category' => ['num' => 10, 'title' => 'X. Kehidupan Masyarakat'],
                'subcategories' => [
                    [
                        'num' => '10.1',
                        'title' => 'Status',
                        'articles' => ['Bangsawan', 'Rakyat', 'Gelar']
                    ],
                    [
                        'num' => '10.2',
                        'title' => 'Kewarganegaraan',
                        'articles' => ['Warga Negara', 'Nasionalisme', 'Penduduk', 'Orang Asing']
                    ],
                    [
                        'num' => '10.3',
                        'title' => 'Keluarga',
                        'articles' => ['Keluarga', 'Ayah', 'Ibu', 'Hubungan Kekerabatan', 'Kawin', 'Lajang', 'Cerai']
                    ],
                    [
                        'num' => '10.4',
                        'title' => 'Masyarakat dan Politik',
                        'articles' => ['Masyarakat', 'Pemerintahan', 'Rezim', 'Politik', 'Pemilu', 'Parlemen/Dewan Perwakilan Rakyat']
                    ],
                    [
                        'num' => '10.5',
                        'title' => 'Perang dan Perdamaian',
                        'articles' => ['Konflik', 'Perang', 'Revolusi', 'Damai', 'Kompromi', 'Perjanjian', 'Penyerangan', 'Pertahanan', 'Penghinaan', 'Pukul(an)', 'Perlawanan', 'Kemenangan', 'Kekalahan', 'Angkatan Bersenjata', 'Senjata', 'Pelatihan (Militer)', 'Hukum']
                    ],
                    [
                        'num' => '10.6',
                        'title' => 'Hukum',
                        'articles' => ['Keadilan', 'Ketakadilan', 'Pengadilan', 'Pembelaan', 'Polisi', 'Pencurian', 'Penipuan', 'Pelacuran', 'Kriminal', 'Komunikasi', 'Rahasia', 'Tanda', 'Perwujudan', 'Ambiguitas']
                    ]
                ]
            ],
            [
                'category' => ['num' => 11, 'title' => 'XI. Humaniora'],
                'subcategories' => [
                    [
                        'num' => '11.1',
                        'title' => 'Komunikasi',
                        'articles' => ['Keeksplisitan', 'Keimplisitan', 'Interpretasi']
                    ],
                    [
                        'num' => '11.2',
                        'title' => 'Bahasa',
                        'articles' => ['Bahasa', 'Tata Bahasa', 'Huruf', 'Kata', 'Frasa', 'Wicara', 'Pidato', 'Makna']
                    ],
                    [
                        'num' => '11.3',
                        'title' => 'Seni',
                        'articles' => ['Lukisan', 'Ikonografi', 'Fotografi', 'Ukiran', 'Musik', 'Lagu', 'Tari', 'Teater', 'Panggung', 'Sandiwara', 'Pertunjukan', 'Puisi', 'Sinema']
                    ]
                ]
            ],
            [
                'category' => ['num' => 12, 'title' => 'XII. Ekonomi dan Keuangan'],
                'subcategories' => [
                    [
                        'num' => '12.1',
                        'title' => 'Pekerjaan dan Produksi',
                        'articles' => ['Pekerjaan', 'Perkantoran', 'Tempat Kerja', 'Gaji', 'Produksi', 'Pengangguran', 'Kegiatan']
                    ],
                    [
                        'num' => '12.2',
                        'title' => 'Perdagangan',
                        'articles' => ['Pemilikan', 'Pengalihan', 'Restitusi', 'Perdagangan', 'Mata Dagangan']
                    ],
                    [
                        'num' => '12.3',
                        'title' => 'Ekonomi',
                        'articles' => ['Kekayaan', 'Kemiskinan', 'Harga', 'Pemasukan', 'Pengeluaran', 'Penghematan', 'Pemborosan', 'Manajemen']
                    ],
                    [
                        'num' => '12.4',
                        'title' => 'Keuangan',
                        'articles' => ['Utang', 'Uang', 'Perbankan', 'Pasar Modal', 'Surat Berharga', 'Perpajakan', 'Asuransi']
                    ]
                ]
            ],
            [
                'category' => ['num' => 13, 'title' => 'XIII. Transportasi'],
                'subcategories' => [
                    [
                        'num' => '13.1',
                        'title' => 'Transportasi',
                        'articles' => ['Transportasi', 'Transportasi Darat', 'Transportasi Air', 'Transportasi Udara', 'Astronautika']
                    ]
                ]
            ],
            [
                'category' => ['num' => 14, 'title' => 'XIV. Arsitektur'],
                'subcategories' => [
                    [
                        'num' => '14.1',
                        'title' => 'Arsitektur',
                        'articles' => ['Arsitektur', 'Bangunan', 'Interior', 'Eksterior', 'Lanskap']
                    ]
                ]
            ],
            [
                'category' => ['num' => 15, 'title' => 'XV. Hunian dan Perabot'],
                'subcategories' => [
                    [
                        'num' => '15.1',
                        'title' => 'Hunian dan Perabot',
                        'articles' => ['Permukiman', 'Penginapan', 'Perabot Dapur', 'Peranti Makan', 'Pembersih', 'Mebel dan Perabot Elektronik', 'Penerang', 'Peranti Mandi']
                    ]
                ]
            ],
            [
                'category' => ['num' => 16, 'title' => 'XVI. Tata Boga'],
                'subcategories' => [
                    [
                        'num' => '16.1',
                        'title' => 'Tata Boga',
                        'articles' => ['Tata Boga', 'Makanan', 'Minuman']
                    ]
                ]
            ],
            [
                'category' => ['num' => 17, 'title' => 'XVII. Mode'],
                'subcategories' => [
                    [
                        'num' => '17.1',
                        'title' => 'Mode',
                        'articles' => ['Busana', 'Mode', 'Jahit', 'Sepatu', 'Permata', 'Aksesori', 'Tata Rambut', 'Tata Rias']
                    ]
                ]
            ],
            [
                'category' => ['num' => 18, 'title' => 'XVIII. Kegemaran dan Hobi'],
                'subcategories' => [
                    [
                        'num' => '18.1',
                        'title' => 'Kegemaran dan Hobi',
                        'articles' => ['Pengisian Waktu', 'Wisata', 'Berkebun', 'Beternak', 'Memancing', 'Berburu']
                    ]
                ]
            ],
            [
                'category' => ['num' => 19, 'title' => 'XIX. Olahraga dan Permainan'],
                'subcategories' => [
                    [
                        'num' => '19.1',
                        'title' => 'Olahraga dan Permainan',
                        'articles' => ['Atletik', 'Sepak Bola', 'Basket', 'Golf', 'Tenis', 'Tenis Meja', 'Olahraga Air', 'Sofbol', 'Sepak Takraw', 'Bola Voli', 'Senam', 'Bela Diri', 'Olahraga Berkuda', 'Olahraga Kecermatan dan Ketepatan', 'Olahraga Bersepeda', 'Olahraga Dirgantara', 'Olahraga Kekuatan', 'Olahraga Gunung', 'Rekreasi Luar Ruang', 'Olahraga Kebugaran', 'Binaraga dan Angkat Berat', 'Bulu Tangkis', 'Tinju', 'Olahraga Otomotif', '(Per)main(an)']
                    ]
                ]
            ]
        ];

        foreach ($data as $item) {
            $categoryData = $item['category'];
            $categoryData['slug'] = Str::slug($categoryData['title']);
            
            $category = DB::table('category')->insertGetId($categoryData);

            foreach ($item['subcategories'] as $subcatData) {
                // Extract articles sebelum insert
                $articles = $subcatData['articles'];
                
                // Remove articles dari data sebelum insert ke DB
                unset($subcatData['articles']);
                
                $subcatData['cat_id'] = $category;
                $subcatData['slug'] = Str::slug($subcatData['title']);
                
                $subcategory = DB::table('subcategory')->insertGetId($subcatData);

                // Insert articles
                foreach ($articles as $articleIndex => $articleTitle) {
                    DB::table('article')->insert([
                        'cat_id' => $category,
                        'subcat_id' => $subcategory,
                        'num' => $articleIndex + 1,
                        'title' => $articleTitle,
                        'slug' => Str::slug($articleTitle),
                    ]);
                }
            }
        }

        $this->command->info('Categories, Subcategories, and Articles seeded successfully!');
    }
}
