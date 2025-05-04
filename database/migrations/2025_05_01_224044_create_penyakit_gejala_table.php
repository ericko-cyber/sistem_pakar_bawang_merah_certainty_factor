<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyakitGejalaTable extends Migration
{
    public function up()
    {
        Schema::create('penyakit_gejala', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penyakit_id');
            $table->unsignedBigInteger('gejala_id');
            $table->foreign('penyakit_id')->references('id')->on('penyakit')->onDelete('cascade');
            $table->foreign('gejala_id')->references('id')->on('gejala')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyakit_gejala');
    }
}
