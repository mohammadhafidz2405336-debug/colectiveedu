<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            // 'iq' untuk tes logika, 'interest' untuk minat bakat RIASEC
            $table->enum('category', ['interest' , 'personality']); 
            
            $table->text('question_text');
            $table->string('image_path')->nullable(); // Untuk menyimpan file gambar soal IQ visual
            
            // Kolom pilihan jawaban disimpan dalam format JSON agar fleksibel (A, B, C, D)
            $table->json('options'); 
            
            // Jawaban benar (Hanya untuk kategori IQ)
            $table->string('correct_answer')->nullable(); 
            
            // Tipe minat berdasarkan Holland Code (R, I, A, S, E, C)
            // Ini untuk kategori 'interest'
            $table->string('interest_type')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};