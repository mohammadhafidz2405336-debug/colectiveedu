<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Assessment;

class TuController extends Controller
{
    public function dashboard()
    {
        // Menghitung statistik global sekolah
        $totalSiswa = User::where('role', 'student')->count();
        $totalGuruBk = User::where('role', 'guru_bk')->count();
        
        // Menghitung berapa banyak tes yang sudah diselesaikan di seluruh sekolah
        $totalSelesaiTes = Assessment::where('status', 'completed')->count();
        
        // Persentase penyelesaian (mencegah error pembagian dengan nol)
        $persentaseSelesai = $totalSiswa > 0 ? round(($totalSelesaiTes / $totalSiswa) * 100) : 0;

        return view('tu.dashboard', compact('totalSiswa', 'totalGuruBk', 'totalSelesaiTes', 'persentaseSelesai'));
    }

    public function siswaIndex()
    {
        return view('tu.siswa-index');
    }

    public function sekolahIndex()
    {
        return view('tu.sekolah-index');
    }

    public function laporanIndex()
    {
        $siswa = User::where('role', 'student')->with('assessment')->get();
        
        $statistikKelas = [];
        $totalSelesai = 0;

        // Mengelompokkan data siswa berdasarkan kelas
        foreach($siswa->groupBy('kelas') as $kelas => $murid) {
            $namaKelas = $kelas ? "Kelas " . $kelas : "Belum Ada Kelas";
            $selesai = $murid->filter(fn($m) => $m->assessment && $m->assessment->status === 'completed')->count();
            
            $totalSelesai += $selesai;
            $statistikKelas[$namaKelas] = [
                'total' => $murid->count(),
                'selesai' => $selesai,
                'persentase' => $murid->count() > 0 ? round(($selesai / $murid->count()) * 100) : 0
            ];
        }

        ksort($statistikKelas);

        // Mengambil Top 5 Rekomendasi Jurusan terbanyak
        $topRekomendasi = \App\Models\Recommendation::get()
            ->groupBy('primary_recommendation')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(5);

        $totalSiswa = $siswa->count();

        return view('tu.laporan-index', compact('statistikKelas', 'totalSiswa', 'totalSelesai', 'topRekomendasi'));
    }
}