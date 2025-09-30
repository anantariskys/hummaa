<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryout_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tryout_id')->constrained('tryouts', 'tryout_id')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions', 'question_id')->onDelete('cascade');
            $table->unsignedInteger('question_number');
            $table->timestamps();

            // Soal yang sama tidak boleh muncul dua kali dalam tryout yang sama
            $table->unique(['tryout_id', 'question_id']);
            // Nomor urut soal harus unik dalam satu tryout
            $table->unique(['tryout_id', 'question_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_questions');
    }
};