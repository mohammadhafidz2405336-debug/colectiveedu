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
        User::create([
            'name' => 'Admin1',
            'username' => 'admin1', // Diubah dari nisn menjadi username
            'password' => Hash::make('rahasia123'),
            'role' => 'admin_tu',
            'kelas' => null, // Admin tidak punya kelas
        ]);

        User::create([
            'name' => 'Admin2',
            'username' => 'admin2', // Diubah dari nisn menjadi username
            'password' => Hash::make('rahasia123'),
            'role' => 'admin_tu',
            'kelas' => null, // Admin tidak punya kelas
        ]);
        User::create([
            'name' => 'Admin3',
            'username' => 'admin3', // Diubah dari nisn menjadi username
            'password' => Hash::make('rahasia123'),
            'role' => 'admin_tu',
            'kelas' => null, // Admin tidak punya kelas
        ]);
        User::create([
            'name' => 'Admin4',
            'username' => 'admin4', // Diubah dari nisn menjadi username
            'password' => Hash::make('rahasia123'),
            'role' => 'admin_tu',
            'kelas' => null, // Admin tidak punya kelas
        ]);

        // Memanggil seeder lainnya
        $this->call([
            QuestionSeeder::class,
        ]);
    }
}