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
        Schema::table('discussions', function (Blueprint $table) {
            $table->unsignedBigInteger('tryout_id')->after('id');

            $table->foreign('tryout_id')
                ->references('tryout_id') 
                ->on('tryouts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discussion', function (Blueprint $table) {
            $table->dropForeign(['tryout_id']);
            $table->dropColumn('tryout_id');
        });
    }
};
