<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussion_commentar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('discussion_id');
            $table->text('commentar');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('discussion_id')
                ->references('id')->on('discussions')
                ->onDelete('cascade');

            $table->index(['discussion_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussion_commentar');
    }
};
