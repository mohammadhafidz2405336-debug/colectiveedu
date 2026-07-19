<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    // Mengizinkan pengisian data dari Seeder/Form
    protected $fillable = [
        'name', 
        'type', 
        'location', 
        'majors'
    ];

    /**
     * Scope untuk mempermudah filter berdasarkan tipe (SMA/SMK)
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}