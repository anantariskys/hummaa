<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new profile fields
            $table->string('nama_depan')->nullable()->after('name');
            $table->string('nama_belakang')->nullable()->after('nama_depan');
            $table->string('no_whatsapp')->nullable()->after('email');
            $table->date('tanggal_lahir')->nullable()->after('no_whatsapp');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            $table->string('foto_profil')->nullable()->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nama_depan',
                'nama_belakang',
                'no_whatsapp', 
                'tanggal_lahir',
                'jenis_kelamin',
                'foto_profil'
            ]);
        });
    }
};