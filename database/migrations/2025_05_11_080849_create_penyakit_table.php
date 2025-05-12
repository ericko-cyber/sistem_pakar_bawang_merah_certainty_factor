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
        Schema::create('penyakit', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('kode_penyakit', 11);
            $table->string('nama_penyakit', 11);
            $table->string('subjudul', 99);
            $table->text('deskripsi');
            $table->text('penanganan');
            $table->string('gambar', 40);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
