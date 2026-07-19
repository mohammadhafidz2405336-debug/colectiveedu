<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'user_id',
        'academic_scores',
        'iq_score',
        'dominant_talent',
        'achievements',
        'student_preference',
        'parent_preference',
        'preference_notes',
        'status'
    ];

    /**
     * Casting data JSON otomatis menjadi Array PHP
     */
    protected $casts = [
        'academic_scores' => 'array',
        'achievements' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}