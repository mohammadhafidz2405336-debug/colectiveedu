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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama Sekolah (Unik agar tidak double)
            $table->string('type');           // SMA, SMK, atau MAN
            $table->string('location')->default('Kabupaten Kediri'); 
            $table->text('majors');           // Menggunakan text karena daftar jurusan bisa panjang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
