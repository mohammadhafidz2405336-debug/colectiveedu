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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            // --- ASPEK 1: Nilai Raport --- 
            $table->json('academic_scores')->nullable();


            // --- ASPEK 2: Tes IQ dan Bakat --- 
            $table->integer('iq_score')->nullable();
            $table->string('dominant_talent')->nullable();

            // --- ASPEK 3: Prestasi ---
            $table->json('achievements')->nullable();

            // --- ASPEK 4: Pilihan ---
            $table->string('student_preference')->nullable();
            $table->string('parent_preference')->nullable();
            $table->text('preference_notes')->nullable();

            $table->string('q2_learning_style')->nullable();
            $table->string('status')->default('draft'); // 'draft' atau 'completed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
