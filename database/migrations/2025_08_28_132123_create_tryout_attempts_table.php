<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryout_attempts', function (Blueprint $table) {
            $table->id('attempt_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tryout_id')->constrained('tryouts', 'tryout_id')->onDelete('cascade');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_attempts');
    }
};