<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            
            // Tambahan: Kode Prodi wajib untuk update/insert yang akurat
            $table->string('kode_prodi')->unique(); 
            
            $table->string('name'); // Contoh: Teknik Informatika
            
            // Tambahan: Jenjang studi sangat penting di SNPMB (S1, D3, D4)
            $table->string('jenjang')->nullable(); 
            
            // Cluster dibuat nullable karena pada sistem SNBT baru/Kurikulum Merdeka batasannya mulai pudar
            $table->enum('cluster', ['SAINTEK', 'SOSHUM', 'CAMPURAN'])->nullable(); 
            
            // Data SNBP
            $table->integer('snbp_capacity')->default(0); 
            $table->integer('snbp_applicants')->default(0); 
            
            // Data SNBT
            $table->integer('snbt_capacity')->default(0); 
            $table->integer('snbt_applicants')->default(0); 
            
            // Revisi Portofolio: API biasanya mengembalikan string jenisnya (misal: "Olahraga", "Seni Tari", atau "Tidak Ada")
            $table->string('portfolio_type')->default('Tidak Ada'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_programs');
    }
};