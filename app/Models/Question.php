<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'category', 
        'question_text', 
        'image_path', 
        'options', 
        'correct_answer', 
        'interest_type'
    ];

    // Tambahkan casting json ke array ini:
    protected $casts = [
        'options' => 'array',
    ];
}