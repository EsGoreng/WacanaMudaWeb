<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'description' => 'Fokus pada diskusi, perawatan wacana, dan uji nalar.',
            ],
            [
                'name' => 'Jejak Karya',
                'description' => 'Fokus pada aksi pengabdian nyata dan dampak sosial.',
            ],
            [
                'name' => 'Jelajah Rasa',
                'description' => 'Fokus pada refleksi, perenungan, dan pembelajaran pengalaman.',
            ],
            [
                'name' => 'Isu Terkini',
                'description' => 'Tanggapan terhadap isu-isu hangat yang sedang terjadi.',
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
