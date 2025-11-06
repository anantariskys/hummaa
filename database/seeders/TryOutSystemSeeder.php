<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TryOutSystemSeeder extends Seeder
{
    public function run()
    {
        // OPTIONAL: Clear existing data (uncomment jika ingin reset semua)
        // echo "Clearing existing data...\n";
        // DB::table('discussion_commentar')->truncate();
        // DB::table('discussions')->truncate();
        // DB::table('user_answers')->truncate();
        // DB::table('tryout_attempts')->truncate();
        // DB::table('tryout_questions')->truncate();
        // DB::table('options')->truncate();
        // DB::table('questions')->truncate();
        // DB::table('tryouts')->truncate();
        // DB::table('materi')->truncate();
        // DB::table('users')->where('id', '>', 3)->delete(); // Keep existing users
        
        // 1. SEED USERS (Admin & Peserta) - Skip if exists
        echo "Seeding Users...\n";
        $users = [
            [
                'name' => 'Admin Utama',
                'email' => 'admin@tryout.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'nama_depan' => 'Budi',
                'nama_belakang' => 'Santoso',
                'email' => 'budi@test.com',
                'no_whatsapp' => '081234567890',
                'tanggal_lahir' => '2000-05-15',
                'jenis_kelamin' => 'Laki-Laki',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'nama_depan' => 'Siti',
                'nama_belakang' => 'Nurhaliza',
                'email' => 'siti@test.com',
                'no_whatsapp' => '081234567891',
                'tanggal_lahir' => '1999-08-20',
                'jenis_kelamin' => 'Perempuan',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi',
                'nama_depan' => 'Ahmad',
                'nama_belakang' => 'Fauzi',
                'email' => 'ahmad@test.com',
                'no_whatsapp' => '081234567892',
                'tanggal_lahir' => '2001-03-10',
                'jenis_kelamin' => 'Laki-Laki',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($users as $user) {
            if (!DB::table('users')->where('email', $user['email'])->exists()) {
                DB::table('users')->insert($user);
            }
        }

        // 2. SEED MATERI
        echo "Seeding Materi...\n";
        $materis = [
            [
                'title' => 'Pengantar Tes Potensi Akademik',
                'description' => 'Materi dasar untuk memahami konsep dan strategi mengerjakan soal TPA',
                'status' => 'Selesai',
                'duration' => '45 menit',
                'file_size' => '2.5 MB',
                'progress' => 100,
                'file_path' => 'materials/tpa-introduction.pdf',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Strategi Mengerjakan TKD',
                'description' => 'Panduan lengkap untuk menghadapi Tes Kompetensi Dasar',
                'status' => 'Progres',
                'duration' => '60 menit',
                'file_size' => '3.2 MB',
                'progress' => 65,
                'file_path' => 'materials/tkd-strategy.pdf',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tips & Trik TIU',
                'description' => 'Kumpulan tips mengerjakan soal Tes Intelegensi Umum dengan cepat',
                'status' => 'Belum Dimulai',
                'duration' => '30 menit',
                'file_size' => '1.8 MB',
                'progress' => 0,
                'file_path' => 'materials/tiu-tips.pdf',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($materis as $materi) {
            if (!DB::table('materi')->where('title', $materi['title'])->exists()) {
                DB::table('materi')->insert($materi);
            }
        }

        // 3. SEED TRYOUTS (Tambahan)
        echo "Seeding Tryouts...\n";
        $tryouts = [
            [
                'title' => 'Try Out TPA Batch 1',
                'duration_minutes' => 90,
                'year' => 2025,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Try Out TIU Komprehensif',
                'duration_minutes' => 75,
                'year' => 2025,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Try Out TKD Persiapan',
                'duration_minutes' => 60,
                'year' => 2025,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Simulasi PPPK 2025 - Full Test',
                'duration_minutes' => 120,
                'year' => 2025,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        $tryoutIds = [];
        foreach ($tryouts as $tryout) {
            $existing = DB::table('tryouts')->where('title', $tryout['title'])->first();
            if (!$existing) {
                $id = DB::table('tryouts')->insertGetId($tryout);
                $tryoutIds[] = $id;
            } else {
                $tryoutIds[] = $existing->tryout_id;
            }
        }

        // 4. SEED QUESTIONS (Soal)
        echo "Seeding Questions...\n";
        
        $questions = [
            [
                'category_id' => 1,
                'question_type_id' => 1,
                'question_text' => 'BUKU : PERPUSTAKAAN = ... : ...',
                'explanation' => 'Hubungan analogi tempat. Buku disimpan di perpustakaan, sama seperti mobil disimpan di garasi.',
                'correct_answer_text' => 'MOBIL : GARASI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'question_type_id' => 1,
                'question_text' => 'Semua siswa yang rajin pasti lulus ujian. Budi lulus ujian. Kesimpulan yang tepat adalah...',
                'explanation' => 'Dari premis yang ada, kita tidak bisa menyimpulkan Budi pasti rajin, karena bisa saja ada siswa yang tidak rajin tetapi tetap lulus.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'question_type_id' => 1,
                'question_text' => 'Tentukan angka yang hilang dalam deret: 2, 6, 12, 20, 30, ...',
                'explanation' => 'Pola: +4, +6, +8, +10, maka selanjutnya +12 = 42',
                'correct_answer_text' => '42',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'question_type_id' => 1,
                'question_text' => 'Jika 3x + 5 = 20, maka nilai x adalah...',
                'explanation' => '3x + 5 = 20, maka 3x = 15, sehingga x = 5',
                'correct_answer_text' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'question_type_id' => 1,
                'question_text' => 'Sebuah mobil menempuh jarak 300 km dengan kecepatan 60 km/jam. Berapa lama waktu tempuh?',
                'explanation' => 'Waktu = Jarak / Kecepatan = 300/60 = 5 jam',
                'correct_answer_text' => '5 jam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'question_type_id' => 1,
                'question_text' => 'Seorang ASN menemukan rekan kerjanya melakukan pelanggaran. Sikap yang paling tepat adalah...',
                'explanation' => 'Integritas ASN mengharuskan untuk melaporkan pelanggaran sesuai prosedur yang berlaku.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'question_type_id' => 1,
                'question_text' => 'Nilai dasar ASN yang berkaitan dengan pelayanan publik adalah...',
                'explanation' => 'Profesionalisme adalah nilai dasar yang mengutamakan kualitas pelayanan kepada masyarakat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $questionIds = [];
        foreach ($questions as $question) {
            $existing = DB::table('questions')
                ->where('question_text', $question['question_text'])
                ->first();
                
            if (!$existing) {
                $id = DB::table('questions')->insertGetId($question);
                $questionIds[] = $id;
            } else {
                $questionIds[] = $existing->question_id;
            }
        }

        // 5. SEED OPTIONS
        echo "Seeding Options...\n";
        
        $options = [
            // Question 1
            [$questionIds[0], 'MOBIL : GARASI', true],
            [$questionIds[0], 'IKAN : LAUT', false],
            [$questionIds[0], 'BURUNG : POHON', false],
            [$questionIds[0], 'GURU : SEKOLAH', false],
            
            // Question 2
            [$questionIds[1], 'Budi pasti rajin', false],
            [$questionIds[1], 'Budi mungkin rajin atau tidak rajin', true],
            [$questionIds[1], 'Budi tidak rajin', false],
            [$questionIds[1], 'Tidak dapat disimpulkan', false],
            
            // Question 3
            [$questionIds[2], '40', false],
            [$questionIds[2], '42', true],
            [$questionIds[2], '44', false],
            [$questionIds[2], '46', false],
            
            // Question 4
            [$questionIds[3], '3', false],
            [$questionIds[3], '5', true],
            [$questionIds[3], '7', false],
            [$questionIds[3], '10', false],
            
            // Question 5
            [$questionIds[4], '3 jam', false],
            [$questionIds[4], '4 jam', false],
            [$questionIds[4], '5 jam', true],
            [$questionIds[4], '6 jam', false],
            
            // Question 6
            [$questionIds[5], 'Diam saja', false],
            [$questionIds[5], 'Melaporkan sesuai prosedur', true],
            [$questionIds[5], 'Ikut melakukan pelanggaran', false],
            [$questionIds[5], 'Mengancam rekan', false],
            
            // Question 7
            [$questionIds[6], 'Integritas', false],
            [$questionIds[6], 'Profesionalisme', true],
            [$questionIds[6], 'Komitmen', false],
            [$questionIds[6], 'Disiplin', false],
        ];

        foreach ($options as $option) {
            $exists = DB::table('options')
                ->where('question_id', $option[0])
                ->where('option_text', $option[1])
                ->exists();
                
            if (!$exists) {
                DB::table('options')->insert([
                    'question_id' => $option[0],
                    'option_text' => $option[1],
                    'is_correct' => $option[2],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 6. SEED TRYOUT_QUESTIONS
        echo "Seeding Tryout Questions...\n";
        
        // Tryout 1: 3 soal pertama
        for ($i = 0; $i < 3 && $i < count($questionIds); $i++) {
            $exists = DB::table('tryout_questions')
                ->where('tryout_id', $tryoutIds[0])
                ->where('question_number', $i + 1)
                ->exists();
                
            if (!$exists) {
                DB::table('tryout_questions')->insert([
                    'tryout_id' => $tryoutIds[0],
                    'question_id' => $questionIds[$i],
                    'question_number' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Tryout 2: soal 3-5
        if (count($tryoutIds) > 1 && count($questionIds) > 4) {
            for ($i = 3; $i < 5; $i++) {
                $exists = DB::table('tryout_questions')
                    ->where('tryout_id', $tryoutIds[1])
                    ->where('question_number', $i - 2)
                    ->exists();
                    
                if (!$exists) {
                    DB::table('tryout_questions')->insert([
                        'tryout_id' => $tryoutIds[1],
                        'question_id' => $questionIds[$i],
                        'question_number' => $i - 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        // Tryout 3: soal TKD
        if (count($tryoutIds) > 2 && count($questionIds) > 6) {
            for ($i = 5; $i < 7; $i++) {
                $exists = DB::table('tryout_questions')
                    ->where('tryout_id', $tryoutIds[2])
                    ->where('question_number', $i - 4)
                    ->exists();
                    
                if (!$exists) {
                    DB::table('tryout_questions')->insert([
                        'tryout_id' => $tryoutIds[2],
                        'question_id' => $questionIds[$i],
                        'question_number' => $i - 4,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 7. SEED TRYOUT_ATTEMPTS
        echo "Seeding Tryout Attempts...\n";
        
        $userIds = DB::table('users')->where('role', 'user')->pluck('id')->toArray();
        
        if (count($userIds) >= 2 && count($tryoutIds) >= 2) {
            $attempts = [
                [
                    'user_id' => $userIds[0],
                    'tryout_id' => $tryoutIds[0],
                    'start_time' => Carbon::now()->subHours(2),
                    'end_time' => Carbon::now()->subHours(1),
                    'score' => 85,
                    'status' => 'submitted',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $userIds[1],
                    'tryout_id' => $tryoutIds[0],
                    'start_time' => Carbon::now()->subHours(3),
                    'end_time' => Carbon::now()->subHours(2),
                    'score' => 92,
                    'status' => 'submitted',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $userIds[0],
                    'tryout_id' => $tryoutIds[1],
                    'start_time' => Carbon::now()->subMinutes(30),
                    'end_time' => null,
                    'score' => null,
                    'status' => 'in_progress',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            $attemptIds = [];
            foreach ($attempts as $attempt) {
                $exists = DB::table('tryout_attempts')
                    ->where('user_id', $attempt['user_id'])
                    ->where('tryout_id', $attempt['tryout_id'])
                    ->where('status', $attempt['status'])
                    ->exists();
                    
                if (!$exists) {
                    $id = DB::table('tryout_attempts')->insertGetId($attempt);
                    $attemptIds[] = $id;
                }
            }

            // 8. SEED USER_ANSWERS
            if (count($attemptIds) > 0) {
                echo "Seeding User Answers...\n";
                
                $tryout1Questions = DB::table('tryout_questions')
                    ->where('tryout_id', $tryoutIds[0])
                    ->get();
                    
                foreach ($tryout1Questions as $tq) {
                    $correctOption = DB::table('options')
                        ->where('question_id', $tq->question_id)
                        ->where('is_correct', true)
                        ->first();
                        
                    if ($correctOption) {
                        $exists = DB::table('user_answers')
                            ->where('attempt_id', $attemptIds[0])
                            ->where('question_id', $tq->question_id)
                            ->exists();
                            
                        if (!$exists) {
                            DB::table('user_answers')->insert([
                                'attempt_id' => $attemptIds[0],
                                'question_id' => $tq->question_id,
                                'selected_option_id' => $correctOption->option_id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }

        // 9. SEED DISCUSSIONS
        echo "Seeding Discussions...\n";
        
        if (count($userIds) >= 2 && count($tryoutIds) > 0) {
            $discussions = [
                [
                    'tryout_id' => $tryoutIds[0],
                    'user_id' => $userIds[0],
                    'title' => 'Pembahasan Soal Nomor 3 - Deret Angka',
                    'desc' => 'Saya masih bingung dengan pola deret angka pada soal nomor 3. Apakah ada yang bisa menjelaskan lebih detail?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'tryout_id' => $tryoutIds[0],
                    'user_id' => $userIds[1],
                    'title' => 'Tips Mengerjakan Soal Analogi',
                    'desc' => 'Ada tips khusus untuk mengerjakan soal analogi dengan cepat? Share dong pengalamannya!',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            $discussionIds = [];
            foreach ($discussions as $discussion) {
                $exists = DB::table('discussions')
                    ->where('title', $discussion['title'])
                    ->exists();
                    
                if (!$exists) {
                    $id = DB::table('discussions')->insertGetId($discussion);
                    $discussionIds[] = $id;
                }
            }

            // 10. SEED DISCUSSION COMMENTS
            if (count($discussionIds) >= 2) {
                echo "Seeding Discussion Comments...\n";
                
                $comments = [
                    [
                        'user_id' => $userIds[1],
                        'discussion_id' => $discussionIds[0],
                        'commentar' => 'Coba perhatikan selisih antar angkanya. Polanya bertambah 2 setiap kali: +4, +6, +8, +10, jadi selanjutnya +12',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'user_id' => $userIds[0],
                        'discussion_id' => $discussionIds[0],
                        'commentar' => 'Oh iya, sekarang paham. Terima kasih banyak penjelasannya!',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'user_id' => $userIds[0],
                        'discussion_id' => $discussionIds[1],
                        'commentar' => 'Saya biasanya cari hubungan logisnya dulu, misalnya tempat, fungsi, atau bagian dari keseluruhan.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ];

                foreach ($comments as $comment) {
                    $exists = DB::table('discussion_commentar')
                        ->where('user_id', $comment['user_id'])
                        ->where('discussion_id', $comment['discussion_id'])
                        ->where('commentar', $comment['commentar'])
                        ->exists();
                        
                    if (!$exists) {
                        DB::table('discussion_commentar')->insert($comment);
                    }
                }
            }
        }

        echo "\n✅ Seeding completed successfully!\n\n";
        
        echo "=== INFORMASI LOGIN ===\n";
        echo "Admin:\n";
        echo "  Email: admin@tryout.com\n";
        echo "  Password: password123\n\n";
        echo "Users:\n";
        echo "  Email: budi@test.com | Password: password123\n";
        echo "  Email: siti@test.com | Password: password123\n";
        echo "  Email: ahmad@test.com | Password: password123\n";
    }
}