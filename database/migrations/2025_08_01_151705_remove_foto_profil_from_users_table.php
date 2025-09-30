<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Prioritaskan foto_profil jika ada
        DB::statement("
            UPDATE users 
            SET avatar = CASE 
                WHEN foto_profil IS NOT NULL THEN foto_profil
                WHEN avatar IS NOT NULL THEN avatar
                ELSE NULL
            END
        ");
        
        // Hapus kolom foto_profil
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto_profil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan kolom foto_profil
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_profil')->nullable()->after('jenis_kelamin');
        });
        
        // Kembalikan data dari avatar ke foto_profil
        DB::statement("
            UPDATE users 
            SET foto_profil = avatar 
            WHERE avatar IS NOT NULL
        ");
    }
};