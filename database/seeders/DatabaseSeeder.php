<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin / Tata Usaha
        User::create([
            'name' => 'Admin TU Sekolah',
            'username' => 'admin', // Diubah dari nisn menjadi username
            'password' => Hash::make('rahasia123'),
            'role' => 'admin_tu',
            'kelas' => null, // Admin tidak punya kelas
        ]);

        // 2. Akun Guru Bimbingan Konseling
        User::create([
            'name' => 'Bapak/Ibu Guru BK',
            'username' => 'gurubk', // Diubah dari nisn menjadi username
            'password' => Hash::make('rahasia123'),
            'role' => 'guru_bk',
            'kelas' => null, // Guru BK tidak punya kelas
        ]);

        // Memanggil seeder lainnya
        $this->call([
            QuestionSeeder::class,
        ]);
    }
}