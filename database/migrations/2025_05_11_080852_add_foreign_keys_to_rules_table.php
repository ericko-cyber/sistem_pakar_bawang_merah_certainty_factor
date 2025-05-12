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
        Schema::table('rules', function (Blueprint $table) {
            $table->foreign(['id_penyakit'], 'rules_ibfk_1')->references(['id'])->on('penyakit')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_gejala'], 'rules_ibfk_2')->references(['id'])->on('gejala')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rules', function (Blueprint $table) {
            $table->dropForeign('rules_ibfk_1');
            $table->dropForeign('rules_ibfk_2');
        });
    }
};
