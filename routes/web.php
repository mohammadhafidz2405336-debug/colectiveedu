<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\BkController;
use App\Http\Controllers\TuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

Route::get('/refresh-soal', function () {
    // 1. Kosongkan isi tabel questions (matikan cek relasi sementara agar tidak error)
    DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
    DB::table('questions')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

    // 2. Jalankan QuestionSeeder yang baru
    Artisan::call('db:seed', [
        '--class' => 'QuestionSeeder',
        '--force' => true // Wajib pakai force karena di server production
    ]);

    return "Mantap! Tabel questions sukses dikosongkan dan diisi ulang dengan soal versi terbaru!";
});

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Menampilkan halaman assessment untuk siswa yang sudah Login
Route::get('/assessment', function () {
    return view('assessment');
})->middleware(['auth'])->name('assessment');

// Generate rekomendasi berdasarkan hasil assessment dengan GROQ API
Route::get('/recommendation/generate', [RecommendationController::class, 'generate'])
    ->middleware(['auth'])
    ->name('recommendation.generate');

// Hasil analisis dan rekomendasi
Route::get('/recommendation/result', [RecommendationController::class, 'result'])
    ->middleware(['auth'])
    ->name('recommendation.result');

// History
Route::get('/history', [RecommendationController::class, 'history'])
    ->middleware(['auth'])
    ->name('recommendation.history');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Daftar Kampus untuk Siswa
Route::get('/daftar-kampus', function () {
    // Memuat data universitas beserta relasi studyPrograms-nya
    $universities = \App\Models\University::with('studyPrograms')->get();
    return view('kampus.index', compact('universities'));
})->middleware(['auth'])->name('kampus.index');

Route::get('/recommendation/pdf/{id}', [RecommendationController::class, 'downloadPdf'])->name('recommendation.pdf');

//Guru BK
Route::middleware(['auth', 'is_guru_bk'])->prefix('bk')->group(function () {
    Route::get('/dashboard', [BkController::class, 'dashboard'])->name('bk.dashboard');
    Route::get('/siswa/{id}', [BkController::class, 'detailSiswa'])->name('bk.siswa.detail');
});

//Admin
Route::middleware(['auth', 'is_admin_tu'])->prefix('tu')->group(function () {
    Route::get('/dashboard', [TuController::class, 'dashboard'])->name('tu.dashboard');
    Route::get('/siswa', [TuController::class, 'siswaIndex'])->name('tu.siswa.index');
    Route::get('/sekolah', [TuController::class, 'sekolahIndex'])->name('tu.sekolah.index');
    Route::get('/laporan', [TuController::class, 'laporanIndex'])->name('tu.laporan.index');

    // Rute Baru untuk Halaman Daftar Jurusan per Kampus
    Route::get('/kampus/{id}/jurusan', function ($id) {
        $university = \App\Models\University::findOrFail($id);
        return view('tu.jurusan-index', compact('university'));
    })->name('tu.kampus.jurusan');
});


require __DIR__.'/auth.php';
