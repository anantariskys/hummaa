<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignId('category_id')->constrained('question_bank_categories');
            $table->foreignId('question_type_id')->constrained('question_types');
            $table->text('question_text');
            $table->string('image_url')->nullable();
            $table->text('explanation');
            $table->text('correct_answer_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};