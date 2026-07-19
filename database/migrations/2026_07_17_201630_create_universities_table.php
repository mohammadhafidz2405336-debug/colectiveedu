<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            // Tambahan: Kode PTN dari API wajib ada untuk proses pencocokan data
            $table->string('kode_ptn')->unique(); 
            
            $table->string('name'); // Contoh: Universitas Indonesia
            $table->string('short_name')->nullable(); // Contoh: UI
            $table->string('location')->nullable(); // Contoh: Depok, Jawa Barat
            
            // Tambahan: Jenis kampus (Akademik, Vokasi, PTKIN) sesuai API
            $table->enum('jenis', ['akademik', 'vokasi', 'ptkin'])->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};