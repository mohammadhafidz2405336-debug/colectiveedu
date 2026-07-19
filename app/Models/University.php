<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    // Tambahkan 'kode_ptn' dan 'jenis' di sini
    protected $fillable = [
        'kode_ptn', 
        'name', 
        'short_name', 
        'location', 
        'jenis'
    ];

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class);
    }
}