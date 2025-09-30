<?php

namespace Database\Seeders;

use App\Models\Discussion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discussionSeeder = [
            [
                'title' => 'Soal X dan Z gimana caranya yaa?',
                'tryout_id' => 1,
                'image' => 'discussion-photos/kS6YWnG4SOz1ljLefWQZbO7L8cDOrbiqsf5utkC5.png',
                'user_id' => 1,
                'desc' => "Ini kan aku udah itu, kok gini?"
            ],
            [
                'title' => 'Soal ini gmn bjir?',
                'tryout_id' => 2,
                'image' => 'discussion-photos/MENsWfCWk9S8ksw8Nw2ZLSB267iCSmt75xqmGN2f.png',
                'user_id' => 1,
                'desc' => "Sumpek banget anjay, ga bisa bisa?"
            ],
            [
                'title' => 'Soal Bahasa Vanuatu?',
                'tryout_id' => 1,
                'image' => 'discussion-photos/oI110sMGl0FZE1K0udV9DlQ5PkHB3GLU1OFdv5Wk.png',
                'user_id' => 1,
                'desc' => "Ini grammarnya udah bener belum yaa"
            ]
        ];

        foreach ($discussionSeeder as $item) {
            Discussion::create($item);
        }
    }
}
