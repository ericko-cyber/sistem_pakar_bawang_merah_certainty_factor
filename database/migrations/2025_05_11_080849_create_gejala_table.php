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
        Schema::create('gejala', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('kode_gejala', 99);
            $table->string('nama_gejala', 99);
            $table->string('gambar', 99);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};
