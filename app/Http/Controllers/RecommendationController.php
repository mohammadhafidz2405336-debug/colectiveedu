<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Assessment;
use App\Models\Recommendation;
use App\Models\University; 
use App\Models\StudyProgram; // Ditambahkan untuk query daya tampung jurusan
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    public function generate()
    {
        // 1. Ambil data assessment terbaru siswa
        $assessment = Assessment::where('user_id', Auth::id())->latest()->first();

        if (!$assessment) {
            return redirect()->route('assessment')->with('error', 'Data tes tidak ditemukan. Pastikan Anda sudah menyelesaikan semua tahap tes.');
        }

        // 2. SESUAI ALUR: Ambil data Kepribadian dan Preferensi sesuai kolomnya masing-masing
        $savedPersonality = $assessment->personality ?? 'Umum / Fleksibel';
        $studentPreferenceSecondary = $assessment->student_preference_secondary ?? 'Tidak ada';

        // 3. JALANKAN HYBRID RECOMMENDATION SYSTEM
        $service = new RecommendationService();
        $hybridAnalysis = $service->calculateScores($assessment); 
        
        // Memotong hasil analisis lokal hanya untuk mengambil TOP 3 rumpun/jurusan terbaik
        $top10JurusanLokal = $hybridAnalysis['top_10_jurusan'] ?? [];
        $top3JurusanLokal = collect($top10JurusanLokal)->take(3)->toArray();
        $fokusBidang = $hybridAnalysis['focus_field'] ?? 'Umum';

        if (empty($top3JurusanLokal)) {
            return redirect()->route('assessment')->with('error', 'Gagal menghitung skor kecocokan jurusan. Pastikan kriteria algoritma di RecommendationService sudah sesuai.');
        }

        // 4. SIAPKAN API LLM (GROQ) SEBAGAI EXPLAINABLE AI
        $apiKey = env('GROQ_API_KEY');
        $url = "https://api.groq.com/openai/v1/chat/completions";

        if (!$apiKey) {
            return redirect()->route('assessment')->with('error', 'Konfigurasi API AI belum terpasang di server.');
        }

        // Pengamanan decode data prestasi untuk mencegah error
        $achievementsData = is_array($assessment->achievements) 
            ? $assessment->achievements 
            : json_decode($assessment->achievements ?? '[]', true);

        $primaryAchievement = $achievementsData['primary']['name'] ?? 'Tidak ada';
        $secondaryAchievement = $achievementsData['secondary']['name'] ?? 'Tidak ada';
        $preferenceNotes = $assessment->preference_notes ?? 'Tidak ada';

        // PROMPT EXPLAINABLE AI (Dioptimalkan untuk Analisis Diri & Rekomendasi Jurusan Saja)
        $prompt = <<<PROMPT
TUGAS UTAMA:
Anda adalah Explainable AI (XAI) yang bertugas memberikan narasi analisis psikologi pendidikan mendalam terkait RIASEC dan Kepribadian, serta merekomendasikan 3 jurusan kuliah (TANPA MENYEBUTKAN NAMA UNIVERSITAS) berdasarkan profil siswa.

PROFIL DATA SISWA:
- Kepribadian Siswa: {$savedPersonality}
- RIASEC Dominan (Minat & Bakat): {$assessment->dominant_talent} (Kluster keilmuan: {$fokusBidang})
- Sertifikat Prestasi: {$primaryAchievement} & {$secondaryAchievement}
- Preferensi Siswa: Pilihan 1 ({$assessment->student_preference}), Pilihan 2 ({$studentPreferenceSecondary})
- Preferensi Orang Tua: {$assessment->parent_preference}
- Catatan Tambahan: {$preferenceNotes}

STRUKTUR OUTPUT JSON YANG DIWAJIBKAN:
Hasilkan data dalam bentuk JSON valid dengan struktur berikut:
{
  "analisis_diri": {
    "penjelasan_riasec": "Jelaskan secara logis dan mendalam apa arti dari tipe RIASEC dominan siswa ini dan mengapa mereka berbakat di bidang tersebut.",
    "penjelasan_kepribadian": "Jelaskan bagaimana tipe kepribadian siswa ini mempengaruhi gaya belajar, interaksi, dan kecocokannya di dunia perkuliahan."
  },
  "top_3_rekomendasi": [
    {
      "nama_jurusan": "Nama Jurusan Saja (Misal: Kedokteran, Ilmu Komunikasi, Teknik Informatika)",
      "alasan_rekomendasi": "Ulasan logis mendalam mengapa jurusan ini selaras dengan gabungan RIASEC dan Kepribadian siswa.",
      "kelebihan_siswa": "Uraikan kelebihan spesifik siswa yang mendukung untuk jurusan ini.",
      "potensi_yang_dimiliki": "Bakat potensial terpendam siswa jika mendalami bidang ilmu ini.",
      "hal_yang_perlu_ditingkatkan": "Kelemahan atau gap kompetensi siswa yang harus diperbaiki sebelum masuk ke jurusan ini.",
      "mata_pelajaran_pendukung": "Daftar mata pelajaran sekolah yang menjadi pilar utama di jurusan ini.",
      "prospek_kerja": "Contoh-contoh karier konkret masa depan yang relevan.",
      "skill_yang_dibutuhkan": "Daftar hard skill atau soft skill teknis yang wajib dikuasai."
    }
  ]
}
PROMPT;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post($url, [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system', 
                        'content' => 'Anda adalah Explainable AI khusus penjurusan kuliah. Respon Anda WAJIB berupa objek JSON valid sesuai struktur yang diminta.'
                    ],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'response_format' => ['type' => 'json_object'] 
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '{}';
                
                $content = preg_replace('/```json\s*/', '', $content);$content = preg_replace('/```\s*/', '', $content);
                
                $data = json_decode(trim($content), true);

                if (!isset($data['top_3_rekomendasi']) || !is_array($data['top_3_rekomendasi'])) {
                    throw new \Exception("Format output Explainable AI tidak sesuai.");
                }

                $analisisDiri = $data['analisis_diri'] ?? [];
                $top3Rekomendasi = $data['top_3_rekomendasi'] ?? [];

                $primaryRec = $top3Rekomendasi[0]['nama_jurusan'] ?? 'Belum ada rekomendasi';
                $reasoning = $top3Rekomendasi[0]['alasan_rekomendasi'] ?? '';

                // Simpan format JSON baru yang membungkus analisis dan jurusan
                Recommendation::updateOrCreate(
                    ['user_id' => Auth::id()],
                    [
                        'primary_recommendation' => $primaryRec,
                        'reasoning' => $reasoning,
                        'alternatives' => json_encode([
                            'analisis' => $analisisDiri,
                            'jurusan' => $top3Rekomendasi
                        ]) 
                    ]
                );

                return redirect()->route('recommendation.result');
            }

            return redirect()->route('assessment')->with('error', 'Explainable AI gagal merespon permintaan.');

        } catch (\Exception $e) {
            Log::error('Hybrid Recommendation System Error: ' . $e->getMessage());
            return redirect()->route('assessment')->with('error', 'Gagal memproses rekomendasi hybrid: ' . $e->getMessage());
        }
    }

    public function result()
    {
        $recommendation = Recommendation::with('assessment')
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        if (!$recommendation) {
            return redirect()->route('assessment')->with('error', 'Hasil analisis kuliah belum siap.');
        }

        // Parsing JSON dari database (mendukung format baru dan handle data lama)
        $aiData = json_decode($recommendation->alternatives, true) ?? [];
        $analisisDiri = $aiData['analisis'] ?? [];
        $top3Jurusan = $aiData['jurusan'] ?? (isset($aiData[0]) ? $aiData : []);
        
        // Kita set $top10Jurusan agar kompatibel dengan variable loop di Blade Anda yang sudah ada
        $top10Jurusan = $top3Jurusan;

        // Ambil semua nama jurusan dari array hasil rekomendasi
        $namaJurusanDicari = collect($top3Jurusan)->pluck('nama_jurusan')->toArray();

        // Query ke database untuk mencari program studi dan perhitungan keketatan daya tampung
        $dataDatabaseJurusan = [];
        if (!empty($namaJurusanDicari)) {
            $dataDatabaseJurusan = StudyProgram::with('university')
                ->where(function ($query) use ($namaJurusanDicari) {
                    foreach ($namaJurusanDicari as $nama) {
                        // Mencari jurusan yang mirip dari database
                        $query->orWhere('name', 'LIKE', '%' . $nama . '%');
                    }
                })
                ->get()
                ->map(function ($prodi) {
                    // Perhitungan persentase keketatan: (Daya Tampung / Peminat) * 100
                    $keketatanSnbp = $prodi->snbp_applicants > 0 ? round(($prodi->snbp_capacity / $prodi->snbp_applicants) * 100, 2) : 0;
                    $keketatanSnbt = $prodi->snbt_applicants > 0 ? round(($prodi->snbt_capacity / $prodi->snbt_applicants) * 100, 2) : 0;

                    return [
                        'universitas' => $prodi->university->name ?? 'Kampus Tidak Diketahui',
                        'jurusan' => $prodi->name,
                        'snbp_capacity' => $prodi->snbp_capacity,
                        'snbp_applicants' => $prodi->snbp_applicants,
                        'snbp_keketatan' => $keketatanSnbp . '%',
                        'snbt_capacity' => $prodi->snbt_capacity,
                        'snbt_applicants' => $prodi->snbt_applicants,
                        'snbt_keketatan' => $keketatanSnbt . '%',
                    ];
                });
        }

        // Passing seluruh variabel ke halaman result
        return view('result', compact('recommendation', 'top10Jurusan', 'analisisDiri', 'dataDatabaseJurusan'));
    }

    public function history()
    {
        $recommendations = Recommendation::where('user_id', Auth::id())->latest()->get();
        return view('history', compact('recommendations'));
    }

    public function downloadPdf($id)
    {
        $recommendation = Recommendation::with('assessment')->findOrFail($id);
        
        $aiData = json_decode($recommendation->alternatives, true) ?? [];
        $top10Jurusan = $aiData['jurusan'] ?? (isset($aiData[0]) ? $aiData : []);
        $analisisDiri = $aiData['analisis'] ?? [];
        
        $data = [
            'recommendation' => $recommendation,
            'top10Jurusan' => $top10Jurusan,
            'analisisDiri' => $analisisDiri,
            'user' => auth()->user(),
            'date' => now()->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pdf.analysis-report', $data);
        return $pdf->download('Laporan_Rekomendasi_Hybrid_' . auth()->user()->name . '.pdf');
    }
}