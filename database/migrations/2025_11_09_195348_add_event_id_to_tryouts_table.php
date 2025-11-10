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
        Schema::table('tryouts', function (Blueprint $table) {
            // Tambahkan kolom event_id setelah tryout_id
            $table->unsignedBigInteger('event_id')->nullable()->after('tryout_id');
            
            // Tambahkan foreign key constraint
            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tryouts', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['event_id']);
            
            // Kemudian hapus kolom
            $table->dropColumn('event_id');
        });
    }
};