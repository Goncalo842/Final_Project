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
        Schema::table('user_disciplina', function (Blueprint $table) {
            $table->integer('nota')->nullable()->after('disciplina_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_disciplina', function (Blueprint $table) {
            $table->dropColumn('nota');
        });
    }
};
