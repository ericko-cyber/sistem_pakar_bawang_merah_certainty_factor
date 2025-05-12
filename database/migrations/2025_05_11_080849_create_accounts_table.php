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
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 50);
            $table->string('password');
            $table->string('alamat', 99);
            $table->string('email', 100);
            $table->string('umur', 11);
            $table->string('telp', 20);
            $table->string('role', 11);
            $table->dateTime('registered');
            $table->string('otp_code', 20)->nullable();
            $table->string('otp_expires_at', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
