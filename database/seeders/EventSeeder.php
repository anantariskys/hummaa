<?php

namespace Database\Seeders;

use App\Models\Events;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $tryouts = [
            [
                'title' => 'TPA',
                'subtitle' => 'Tes Potensi Akademik',
                'description' => 'Menilai kemampuan kognitif dan kapasitas intelektual',
                'badge' => 'Lanjutan',
                'duration' => '120 menit',
                'question_count' => '80 soal',
                'test_parts' => ['Penalaran Verbal', 'Penalaran Kuantitatif', 'Penulisan Analitis'],
            ],
            [
                'title' => 'TKB',
                'subtitle' => 'Tes Kompetensi Dasar',
                'description' => 'Mengevaluasi pengetahuan dasar dan kompetensi umum',
                'badge' => 'Menengah',
                'duration' => '90 menit',
                'question_count' => '60 soal',
                'test_parts' => ['Pengetahuan Umum', 'Matematika Dasar', 'Kemampuan Bahasa'],
            ],
            [
                'title' => 'TIU',
                'subtitle' => 'Tes Intelegensi Umum',
                'description' => 'Menilai kemampuan kognitif dan kapasitas intelektual',
                'badge' => 'Lanjutan',
                'duration' => '60 menit',
                'question_count' => '50 soal',
                'test_parts' => ['Penalaran Logis', 'Pengenalan Pola', 'Intelegensi Spesial'],
            ],
            [
                'title' => 'TIU',
                'subtitle' => 'Tes Intelegensi Umum',
                'description' => 'Menilai kemampuan kognitif dan kapasitas intelektual',
                'badge' => null,
                'duration' => '60 menit',
                'question_count' => '50 soal',
                'test_parts' => ['Penalaran Logis', 'Pengenalan Pola', 'Intelegensi Spesial'],
            ],
        ];

        foreach ($tryouts as $tryout) {
            Events::create($tryout);
        }
    }
}
