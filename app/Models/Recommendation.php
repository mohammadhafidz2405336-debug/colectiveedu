<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'user_id', 
        'primary_recommendation', 
        'reasoning', 
        'alternatives'
    ];

    /**
     * Menghubungkan rekomendasi kembali ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Menghubungkan rekomendasi ke data penilaian (Assessment)
     * Kita gunakan user_id sebagai foreign key karena satu user satu penilaian
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'user_id', 'user_id');
    }
}