<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class WritingSeeder extends Seeder
{
    public function run(): void
    {
        
        $user = User::first();
        $catRuangKata = DB::table('categories')->where('slug', 'ruang-kata')->first()->category_id;
        $catJelajahRasa = DB::table('categories')->where('slug', 'jelajah-rasa')->first()->category_id;
        $series = DB::table('series')->first();

        $writings = [
            
            [
                'user_id' => $user->id,
                'category_id' => $catRuangKata,
                'series_id' => null,
                'title' => 'Pentingnya Literasi di Era Digital',
                'content' => '<p>Ini adalah contoh konten artikel tentang literasi...</p>',
                'reading_time' => 3, 
                'is_anonymous' => false,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(2),
            ],
            
            [
                'user_id' => $user->id,
                'category_id' => $catJelajahRasa,
                'series_id' => null,
                'title' => 'Sebuah Refleksi Tengah Malam',
                'content' => '<p>Terkadang kita perlu diam untuk mendengar...</p>',
                'reading_time' => 5,
                'is_anonymous' => true, 
                'status' => 'published',
                'published_at' => Carbon::now()->subDay(),
            ],
            
            [
                'user_id' => $user->id,
                'category_id' => $catRuangKata,
                'series_id' => $series->series_id, 
                'title' => 'Tutorial Menulis: Bagian 1',
                'content' => '<p>Langkah pertama dalam menulis adalah membaca...</p>',
                'reading_time' => 7,
                'is_anonymous' => false,
                'status' => 'published',
                'published_at' => Carbon::now(),
            ],
            
            [
                'user_id' => $user->id,
                'category_id' => $catRuangKata,
                'series_id' => null,
                'title' => 'Konsep Kegiatan Bulan Depan',
                'content' => '<p>Draf kasar rencana kegiatan...</p>',
                'reading_time' => 2,
                'is_anonymous' => false,
                'status' => 'draft', 
                'published_at' => null,
            ],
        ];

        foreach ($writings as $write) {
            DB::table('writings')->insert([
                'user_id' => $write['user_id'],
                'category_id' => $write['category_id'],
                'series_id' => $write['series_id'],
                'title' => $write['title'],
                'slug' => Str::slug($write['title']) . '-' . Str::random(5),
                'content' => $write['content'], 
                'reading_time' => $write['reading_time'], 
                'is_anonymous' => $write['is_anonymous'], 
                'status' => $write['status'], 
                'published_at' => $write['published_at'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}