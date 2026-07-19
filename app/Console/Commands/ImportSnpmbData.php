<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\University;
use App\Models\StudyProgram;
use Exception;

class ImportSnpmbData extends Command
{
    protected $signature = 'snpmb:import';
    protected $description = 'Fetch data SNPMB dengan retry logic dan timeout handling';

    protected $headers = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'Accept' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest',
    ];

    public function handle()
    {
        $this->info('Memulai pengambilan data SNPMB...');
        $jalurSeleksi = ['snbp' => 'sn', 'snbt' => 'sb'];

        foreach ($jalurSeleksi as $namaJalur => $kodeJalur) {
            $this->info("=== MEMPROSES JALUR {$namaJalur} ===");
            $this->prosesJalur($namaJalur, $kodeJalur);
        }

        $this->info('Import selesai!');
        return Command::SUCCESS;
    }

    private function prosesJalur($namaJalur, $kodeJalur)
    {
        $ptnUrl = "https://snpmb.id/proxy-ptn-{$kodeJalur}.php";
        
        // Menggunakan retry untuk pengambilan daftar PTN
        try {
            $response = Http::withHeaders($this->headers)
                ->withOptions(['verify' => false, 'timeout' => 30])
                ->retry(3, 2000)
                ->get($ptnUrl);

            $ptnList = $response->json();
            $ptnList = $ptnList['data'] ?? $ptnList['ptn'] ?? $ptnList;

            foreach ($ptnList as $ptn) {
                $idPtn = $ptn['id_ptn'] ?? $ptn['id'] ?? null;
                $kodePtn = $ptn['kode_ptn'] ?? $ptn['kode'] ?? null;
                $namaPtn = $ptn['nama'] ?? $ptn['nama_ptn'] ?? 'Unknown';

                $university = University::updateOrCreate(
                    ['kode_ptn' => $kodePtn ?? $idPtn],
                    ['name' => $namaPtn]
                );

                // Tambah delay lebih panjang agar server tidak memblokir IP Anda
                sleep(2); 
                $this->prosesProdi($idPtn, $kodePtn, $university, $namaJalur, $kodeJalur);
            }
        } catch (Exception $e) {
            $this->error("Error Fatal: " . $e->getMessage());
        }
    }

    private function prosesProdi($idPtn, $kodePtn, $university, $namaJalur, $kodeJalur)
    {
        $url = "https://snpmb.id/proxy-prodi-{$kodeJalur}.php?ptn=" . ($idPtn ?? $kodePtn);

        // Menambahkan Retry Logic dan Timeout yang lebih luas
        $response = Http::withHeaders($this->headers)
            ->withOptions([
                'verify' => false, 
                'connect_timeout' => 30, // Tunggu koneksi hingga 30 detik
                'timeout' => 60          // Tunggu respon data hingga 60 detik
            ])
            ->retry(3, 3000, function ($exception, $request) {
                // Hanya retry jika error koneksi
                return $exception instanceof \Illuminate\Http\Client\ConnectionException;
            })
            ->get($url);
        
        if (!$response->successful()) {
            $this->warn("Gagal fetch prodi untuk PTN ID: {$idPtn}. Melompati...");
            return;
        }
        
        $data = $response->json();
        $prodiList = $data['data'] ?? $data['prodi'] ?? $data ?? [];

        if (empty($prodiList)) return;

        foreach ($prodiList as $prodi) {
            $kodeProdi = $prodi['kode_prodi'] ?? $prodi['id_prodi'] ?? $prodi['kode'] ?? null;
            if (!$kodeProdi) continue;

            if ($namaJalur === 'snbp') {
                $capacity = (int) ($prodi['daya_tampung_snbp'] ?? $prodi['daya_tampung'] ?? 0);
            } else {
                $capacity = (int) ($prodi['daya_tampung_snbt'] ?? $prodi['daya_tampung'] ?? 0);
            }

            $history = $prodi['history_daya_tampung'] ?? [];
            $latestData = !empty($history) ? end($history) : [];
            $applicants = (int) ($latestData['peminat'] ?? 0);

            $updateData = [
                'university_id'  => $university->id,
                'name'           => $prodi['nama'] ?? $prodi['nama_prodi'] ?? 'Unknown',
            ];

            if ($namaJalur === 'snbp') {
                $updateData['snbp_capacity'] = $capacity;
                $updateData['snbp_applicants'] = $applicants;
            } else {
                $updateData['snbt_capacity'] = $capacity;
                $updateData['snbt_applicants'] = $applicants;
            }

            StudyProgram::updateOrCreate(['kode_prodi' => $kodeProdi], $updateData);
        }
    }
}