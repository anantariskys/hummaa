<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Materi;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materiData = [
            [
                'title' => 'Kompetensi Wawancara',
                'description' => 'Kumpulan soal dan jawaban wawancara untuk menguji integritas dan motivasi.',
                'status' => 'Progres',
                'duration' => '45 menit',
                'file_size' => 'PDF 31 KB',
                'progress' => 50,
                'file_path' => 'materials/materi-wawancara.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Kompetensi Sosio-Kultural',
                'description' => 'Bank soal pilihan ganda untuk mengukur kemampuan adaptasi dan interaksi sosial.',
                'status' => 'Selesai',
                'duration' => '90 menit',
                'file_size' => 'PDF 145 KB',
                'progress' => 100,
                'file_path' => 'materials/materi-kompetensi-sosio-kultural.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Kompetensi Manajerial',
                'description' => 'Materi konseptual tentang 8 aspek kompetensi manajerial, POAC, dan SWOT.',
                'status' => 'Progres',
                'duration' => '120 menit',
                'file_size' => 'PDF 1.2 MB',
                'progress' => 25,
                'file_path' => 'materials/materi-manajerial.pdf',
                'is_active' => true,
            ],
        ];

        foreach ($materiData as $data) {
            Materi::create($data);
        }
    }
}