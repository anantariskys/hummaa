<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionType;

class QuestionTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['type' => 'multiple_choice'],
            ['type' => 'essay'],
        ];

        foreach ($types as $type) {
            QuestionType::firstOrCreate(
                ['type' => $type['type']]
            );
        }
    }
}