<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // --- PERSONALITY (10 SOAL) - Fokus: Karakter, Gaya Belajar, Respon Situasi ---
            [
                'category' => 'personality',
                'question_text' => 'Anda rutin mendapatkan teman baru',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda senang menggali ide dan sudut pandang yang kurang dikenal',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda tidak mudah terpengaruh oleh argumen yang berlandaskan emosi',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda kesulitan memenuhi tenggat waktu',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda jarang merasa tidak percaya diri',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda menghindari panggilan telepon',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda senang berdebat tentang dilema etika',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda lebih mengutamakan untuk bersikap peka daripada sepenuhnya jujur',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Ruang hidup anda dan kerja anda bersih dan terorganisir',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda sering merasa kewalahan',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda menikmati berpartisipasi dalam kegiatan berbasis tim',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda menikmati bereksperimen dengan pendekatan baru dan belum teruji',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda mengutamakan fakta daripada perasaan orang ketika menentukan langkah tindakan',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda sering membiarkan hari berlalu tanpa jadwal sama sekali',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda jarang khawatir akan membuat kesan yang baik saat bertemu orang lain',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda merasa nyaman untuk mendekati seseorang yang menurut anda menarik dan memulai percakapan',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda tidak terlalu tertarik dalam diskusi tentang berbagai interpretasi karya kreatif',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Kisah dan penghayatan emosi seseorang mempunyai dampak lebih signifikan bagi anda daripada angka atau data',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda secara aktif mencari pengalaman dan area pengetahuan baru untuk dijelajahi',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda mudah merasa khawatir bahwa segala hal akan berubah menjadi lebih buruk',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda lebih menikmati hobi atau aktivitas individual daripada yang perlu dilakukan berkelompok',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda tidak dapat membayangkan diri anda menulis cerita fiksi sebagai mata pencaharian',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda lebih memilih efisiensi dalam pengambilan keputusan, meskipun itu berarti mengabaikan beberapa aspek emosional',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda lebih suka menyelesaikan tugas-tugas terlebih dahulu sebelum bersantai',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Saat terjadi perselisihan, anda lebih mengutamakan membuktikan pendapat anda daripada menjaga perasaan orang lain',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Saat ada acara sosial, anda biasanya menunggu orang lain untuk memperkenalkan diri terlebih dahulu',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Suasana hati anda bisa berubah dengan sangat cepat',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda biasanya merasa lebih terpengaruh oleh apa yang beresonansi secara emosional dengan anda daripada oleh argumen faktual',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda sering menunda pekerjaan hingga detik-detik terakhir',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],
            [
                'category' => 'personality',
                'question_text' => 'Anda memprioritaskan dan merencanakan tugas dengan efektif, seringkali menyelesaikannya jauh sebelum tenggat waktu',
                'options' => ['Sangat Tidak Setuju', 'Tidak Setuju', 'Setuju', 'Sangat Setuju'],
            ],

            // --- REALISTIC (5 SOAL) - Fokus: Fisik, Alat, Mesin, Pertanian ---
            [
                'category' => 'interest',
                'interest_type' => 'Realistic',
                'question_text' => 'Saya suka memperbaiki atau merakit peralatan elektronik yang rusak',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Realistic',
                'question_text' => 'Saya suka bekerja di luar ruangan (outdoor), misalnya berkebun atau menjelajah.',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Realistic',
                'question_text' => 'Saya suka menggunakan perkakas tangan atau mesin-mesin besar (misalnya: memotong kayu, mengelas). ',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Realistic',
                'question_text' => 'Saya suka bekerja dengan hewan atau merawat tanaman.',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Realistic',
                'question_text' => 'Saya suka mengendarai atau mengoperasikan kendaraan berat (misalnya: truk, traktor).',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
        
            // --- INVESTIGATIVE (5 SOAL) - Fokus: IT, Komputer, Riset, Logika ---
            [
                'category' => 'interest',
                'interest_type' => 'Investigative',
                'question_text' => 'Saya suka melakukan eksperimen atau penelitian ilmiah di laboratorium.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Investigative',
                'question_text' => 'Saya suka membaca buku dan artikel tentang teori ilmiah dan konsep yang kompleks.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Investigative',
                'question_text' => 'Saya suka mencari tahu penyebab suatu masalah atau kegagalan sistem.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Investigative',
                'question_text' => 'Saya suka menganalisis data, statistik, dan membuat kesimpulan logis.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Investigative',
                'question_text' => 'Saya suka menyelesaikan teka-teki, puzzle, atau masalah matematika yang rumit.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],

            // --- ARTISTIC (5 SOAL) - Fokus: Kreativitas, Seni, Desain ---
            [
                'category' => 'interest',
                'interest_type' => 'Artistic',
                'question_text' => 'Saya suka menggambar, melukis, atau mematung.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Artistic',
                'question_text' => 'Saya suka menulis puisi, cerita pendek, atau naskah drama.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Artistic',
                'question_text' => 'Saya suka memainkan alat musik, menyanyi, atau menari', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Artistic',
                'question_text' => 'Saya suka merancang pakaian, dekorasi interior, atau desain grafis.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Artistic',
                'question_text' => 'Saya suka menghadiri pertunjukan seni, pameran, atau konser.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],

            // --- SOCIAL (5 SOAL) - Fokus: Layanan, Teman, Sosial, Agama ---
            [
                'category' => 'interest',
                'interest_type' => 'Social',
                'question_text' => 'Saya suka memberikan bimbingan, pelatihan, atau mengajar orang lain.',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Social',
                'question_text' => 'Saya suka menjadi relawan untuk membantu masyarakat atau kelompok yang membutuhkan', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Social',
                'question_text' => 'Saya suka memberikan konseling atau dukungan emosional kepada teman saya.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Social',
                'question_text' => 'Saya suka bekerja dalam tim yang solid untuk mencapai tujuan bersama.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Social',
                'question_text' => 'Saya suka berdiskusi mengenai isu-isu sosial atau kemanusiaan.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],

            // --- ENTERPRISING (5 SOAL) - Fokus: Bisnis, Kepemimpinan, Promosi ---
            [
                'category' => 'interest',
                'interest_type' => 'Enterprising',
                'question_text' => 'Saya suka memimpin sebuah kelompok atau organisasi.',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Enterprising',
                'question_text' => 'Saya suka menjual produk, ide, jasa kepada orang lain.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Enterprising',
                'question_text' => 'Saya suka memberikan pidato atau presentasi di depan banyak orang.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Enterprising',
                'question_text' => 'Saya suka memulai bisnis atau proyek baru yang berisiko tapi menjanjikan', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Enterprising',
                'question_text' => 'Saya suka bernegosiasi dan meyakinkan orang lain untuk mengikuti pendapat Anda.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            // --- CONVENTIONAL (5 SOAL) - Fokus: Data, Akurasi, Ketelitian, Aturan ---
            [
                'category' => 'interest',
                'interest_type' => 'Conventional',
                'question_text' => 'Saya suka menyusun arsip, data, atau dokumen secara sistematis',
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Conventional',
                'question_text' => 'Saya suka bekerja dengan angka, akuntansi, atau pembukuan keuangan.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Conventional',
                'question_text' => 'Saya suka memeriksa ketelitian data dan mencari kesalahan di dalamnya.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Conventional',
                'question_text' => 'Saya suka mengikuti instruksi dan prosedur kerja yang sudah ditetapkan.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
            [
                'category' => 'interest',
                'interest_type' => 'Conventional',
                'question_text' => 'Saya suka merencanakan dan membuat jadwal kerja yang rinci dan teratur.', 
                'options' => ['Sangat Tidak Suka', 'Kurang Suka', 'Suka', 'Sangat Suka'],
            ],
        ];

        foreach ($questions as $q) {
            Question::create($q);
        }
    }
}