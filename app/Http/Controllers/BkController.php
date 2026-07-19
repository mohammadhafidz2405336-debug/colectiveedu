<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assessment;
use Illuminate\Http\Request;

class BkController extends Controller
{
    public function dashboard()
    {
        // Hanya hitung user dengan role 'student'
        $totalSiswa = User::where('role', 'student')->count();
        
        $selesaiTes = User::where('role', 'student')->whereHas('assessment', function($q) {
            $q->where('status', 'completed');
        })->count();

        $sedangTes = User::where('role', 'student')->whereHas('assessment', function($q) {
            $q->where('status', 'draft');
        })->count();
        
        $belumTes = $totalSiswa - ($selesaiTes + $sedangTes);

        return view('bk.dashboard', compact('totalSiswa', 'selesaiTes', 'sedangTes', 'belumTes'));
    }

    public function detailSiswa($id)
    {
        $siswa = User::with(['assessment', 'recommendation'])->findOrFail($id);
        
        if ($siswa->role === 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('bk.siswa-detail', compact('siswa'));
    }
}