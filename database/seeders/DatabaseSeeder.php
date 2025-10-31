<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => \Carbon\Carbon::now(),
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        $this->call([
            QuestionBankCategorySeeder::class,
            MateriSeeder::class,
            DummyTryoutSeeder::class,
        ]);
    }
}
