<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    // Tambahkan 'kode_prodi', 'jenjang', dan 'portfolio_type'
    protected $fillable = [
        'university_id',
        'kode_prodi',
        'name',
        'jenjang',
        'cluster',
        'snbp_capacity',
        'snbp_applicants',
        'snbt_capacity',
        'snbt_applicants',
        'portfolio_type'
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function getSnbpTightnessAttribute()
    {
        if ($this->snbp_applicants <= 0) {
            return 0;
        }
        
        $result = ($this->snbp_capacity / $this->snbp_applicants) * 100;
        return number_format($result, 2); // Menampilkan 2 angka di belakang koma
    }

    /**
     * Hitung Keketatan SNBT
     */
    public function getSnbtTightnessAttribute()
    {
        if ($this->snbt_applicants <= 0) {
            return 0;
        }

        $result = ($this->snbt_capacity / $this->snbt_applicants) * 100;
        return number_format($result, 2);
    }
}