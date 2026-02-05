<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ruang Kata',
                'description' => 'Ruang dialog dan pertukaran gagasan, tempat kata-kata tumbuh menjadi pemahaman dan nalar diasah melalui diskusi yang bermakna.',
            ],
            [
                'name' => 'Jejak Karya',
                'description' => 'Wujud nyata dari pemikiran dan kepedulian, melalui aksi dan pengabdian yang meninggalkan dampak bagi sekitar.',
            ],
            [
                'name' => 'Jelajah Rasa',
                'description' => 'Perjalanan untuk merasakan, memahami, dan merefleksikan makna dari setiap langkah, waktu, dan pengalaman yang dilalui.',
            ],
            [
                'name' => 'Technology',
                'description' => 'Membahas perkembangan teknologi, software, hardware, dan inovasi digital.',
            ],
            [
                'name' => 'Programming',
                'description' => 'Tutorial, tips, dan best practice seputar pemrograman dan pengembangan aplikasi.',
            ],
            [
                'name' => 'Web Development',
                'description' => 'Topik seputar frontend, backend, framework, dan arsitektur web modern.',
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Pengembangan aplikasi Android, iOS, dan cross-platform.',
            ],
            [
                'name' => 'Design',
                'description' => 'UI/UX, desain grafis, visual branding, dan pengalaman pengguna.',
            ],
            [
                'name' => 'Business',
                'description' => 'Strategi bisnis, startup, manajemen, dan dunia profesional.',
            ],
            [
                'name' => 'Finance',
                'description' => 'Keuangan pribadi, investasi, ekonomi, dan literasi finansial.',
            ],
            [
                'name' => 'Politics',
                'description' => 'Analisis isu politik, kebijakan publik, dan dinamika pemerintahan.',
            ],
            [
                'name' => 'Education',
                'description' => 'Pembelajaran, akademik, pengembangan diri, dan dunia pendidikan.',
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Gaya hidup, kebiasaan, produktivitas, dan keseimbangan hidup.',
            ],
            [
                'name' => 'Productivity',
                'description' => 'Manajemen waktu, fokus kerja, dan peningkatan efektivitas.',
            ],
            [
                'name' => 'Opinion',
                'description' => 'Sudut pandang, pemikiran personal, dan refleksi penulis.',
            ],
            [
                'name' => 'Social',
                'description' => 'Isu sosial, budaya, komunitas, dan fenomena masyarakat.',
            ],
            [
                'name' => 'Career',
                'description' => 'Pengembangan karier, dunia kerja, dan pengalaman profesional.',
            ],
            [
                'name' => 'Creative Writing',
                'description' => 'Tulisan kreatif seperti esai, cerita pendek, dan narasi.',
            ],
            [
                'name' => 'Tutorial',
                'description' => 'Panduan langkah demi langkah untuk mempelajari suatu topik.',
            ],
            [
                'name' => 'Review',
                'description' => 'Ulasan produk, buku, aplikasi, atau layanan.',
            ],
            [
                'name' => 'News & Update',
                'description' => 'Informasi terbaru, pengumuman, dan pembaruan penting.',
            ],
            [
                'name' => 'Romance',
                'description' => 'Cerita cinta, perasaan, hubungan, dan dinamika emosi manusia.',
            ],
            [
                'name' => 'Poetry',
                'description' => 'Puisi bebas, sajak, dan ungkapan rasa dalam bentuk kata.',
            ],
            [
                'name' => 'Short Story',
                'description' => 'Cerita pendek fiksi dengan gaya naratif yang ringan dan personal.',
            ],
            [
                'name' => 'Fiction',
                'description' => 'Karya fiksi imajinatif, baik realistis maupun fantasi.',
            ],
            [
                'name' => 'Slice of Life',
                'description' => 'Kisah sederhana dari kehidupan sehari-hari yang dekat dan relevan.',
            ],
            [
                'name' => 'Diary',
                'description' => 'Catatan personal, refleksi harian, dan pengalaman pribadi.',
            ],
            [
                'name' => 'Personal Thoughts',
                'description' => 'Isi pikiran acak, keresahan, dan sudut pandang penulis.',
            ],
            [
                'name' => 'Healing',
                'description' => 'Tulisan yang menenangkan, menyembuhkan, dan memberi ruang jeda.',
            ],
            [
                'name' => 'Letters',
                'description' => 'Surat terbuka atau tertutup yang ditulis untuk seseorang atau sesuatu.',
            ],
            [
                'name' => 'Quotes',
                'description' => 'Kutipan singkat, reflektif, dan bermakna.',
            ],
            [
                'name' => 'Fantasy',
                'description' => 'Cerita imajinatif dengan dunia, karakter, dan alur rekaan.',
            ],
            [
                'name' => 'Drama',
                'description' => 'Cerita dengan konflik emosional dan dinamika karakter.',
            ],
            [
                'name' => 'Coming of Age',
                'description' => 'Kisah pertumbuhan, pencarian jati diri, dan proses pendewasaan.',
            ],
            [
                'name' => 'Random Thoughts',
                'description' => 'Tulisan bebas tanpa batas topik, spontan, dan apa adanya.',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
