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
        Schema::table('question_bank_categories', function (Blueprint $table) {
            $table->string('logo_url')->nullable(false);
            $table->text('description')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table_question_bank_categories', function (Blueprint $table) {
            $table->dropColumn('logo_url');
            $table->dropColumn('description');
        });
    }
};
