<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuestionBankCategory;

class QuestionBankCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tes Potensi Akademik',
                'logo_url' => 'images/tpa-logo.png',
                'description' => 'PPPKin menyediakan bank soal Tes Potensi Akademik (TPA) yang dirancang untuk mengasah kemampuan berpikir logis, analitis, dan verbal. Soal-soal disusun secara sistematis mencakup berbagai tipe: analogi, silogisme, aritmetika dasar, hingga deret logika. Dengan latihan yang terus-menerus, kamu akan terbiasa menghadapi berbagai variasi soal dan meningkatkan kepercayaan diri dalam menjawab soal-soal TPA.',
            ],
            [
                'name' => 'Tes Intelegensi Umum',
                'logo_url' => 'images/tiu-logo.png',
                'description' => "Bank soal TIU di PPPKin dirancang untuk menguji dan mengembangkan kemampuan intelektual secara menyeluruh, mencakup aspek verbal, numerik, dan figural. Setiap soal disusun agar pengguna mampu berpikir kritis, cepat, dan tepat dalam menyelesaikan berbagai jenis permasalahan logika. Latihan secara rutin melalui soal-soal ini akan membantu kamu menjadi lebih siap dan tanggap dalam menghadapi tantangan seleksi PPPK.",
            ],
            [
                'name' => 'Tes Kompetensi Dasar',
                'logo_url' => 'images/tkd-logo.png',
                'description' => "Melalui bank soal TKD dari PPPKin, kamu dapat memperdalam pemahaman terhadap nilai-nilai dasar ASN seperti integritas, etika pelayanan publik, profesionalisme, serta karakteristik pribadi. Soal-soal disusun mengikuti standar kompetensi yang diujikan, membantu kamu berlatih mengenali situasi, mengambil keputusan, dan menilai sikap yang sesuai dengan peran sebagai ASN profesional.",
            ],
        ];

        foreach ($categories as $category) {
            QuestionBankCategory::firstOrCreate(
                ['name' => $category['name']],
                [
                    'logo_url' => $category['logo_url'],
                    'description' => $category['description']
                ]
            );
        }
    }
}
