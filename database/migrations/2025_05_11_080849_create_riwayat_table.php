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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->integer('id_riwayat', true);
            $table->integer('id_user')->index('id_user');
            $table->timestamp('tanggal')->useCurrentOnUpdate()->useCurrent();
            $table->integer('id_penyakit')->index('id_penyakit');
            $table->string('nilai', 99);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
