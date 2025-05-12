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
        Schema::table('riwayat', function (Blueprint $table) {
            $table->foreign(['Id_user'], 'riwayat_ibfk_1')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_penyakit'], 'riwayat_ibfk_2')->references(['id'])->on('penyakit')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_user'], 'riwayat_ibfk_3')->references(['id'])->on('accounts')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat', function (Blueprint $table) {
            $table->dropForeign('riwayat_ibfk_1');
            $table->dropForeign('riwayat_ibfk_2');
            $table->dropForeign('riwayat_ibfk_3');
        });
    }
};
