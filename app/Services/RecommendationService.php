<?php

namespace App\Services;

class RecommendationService
{
    public function calculateScores($assessment)
    {
        // 1. ASPEK 3: AMBIL DATA PRESTASI & PENGALAMAN
        $achievement = strtolower($assessment->achievements['primary']['level'] ?? '');
        $ach = match($achievement) {
            'nasional' => 1.0, 
            'provinsi' => 0.8, 
            'kecamatan/kabupaten' => 0.6, 
            'sekolah' => 0.4, 
            default => 0.2
        };

        // 2. ASPEK 1: AMBIL DATA MINAT BAKAT (RIASEC)
        $riasec = strtolower($assessment->dominant_talent ?? '');

        // 3. ASPEK 2: AMBIL DATA KEPRIBADIAN
        $personality = strtolower($assessment->personality ?? '');

        // KALKULASI SKOR PENJURUSAN UNIVERSITAS
        // Bobot: 60% Minat Bakat + 25% Prestasi + 15% Kesesuaian Kepribadian
        $result = [];
        
        // Rumpun 1: Sains, Teknologi & Kedokteran (SAINTEK)
        $result['Sains, Teknologi & Kedokteran'] = 0.60 * $this->riasecMatch($riasec, 'SAINTEK') 
                                                 + 0.25 * $ach 
                                                 + 0.15 * $this->personalityMatch($personality, 'SAINTEK');
        
        // Rumpun 2: Sosial, Hukum & Humaniora (SOSHUM)
        $result['Sosial, Hukum & Humaniora'] = 0.60 * $this->riasecMatch($riasec, 'SOSHUM') 
                                             + 0.25 * $ach 
                                             + 0.15 * $this->personalityMatch($personality, 'SOSHUM');
        
        // Rumpun 3: Bisnis, Ekonomi & Manajemen
        $result['Bisnis, Ekonomi & Manajemen'] = 0.60 * $this->riasecMatch($riasec, 'BISNIS') 
                                               + 0.25 * $ach 
                                               + 0.15 * $this->personalityMatch($personality, 'BISNIS');

        // Rumpun 4: Seni, Desain & Media
        $result['Seni, Desain & Media'] = 0.60 * $this->riasecMatch($riasec, 'SENI') 
                                        + 0.25 * $ach 
                                        + 0.15 * $this->personalityMatch($personality, 'SENI');

        // Rumpun 5: Pendidikan & Keguruan
        $result['Pendidikan & Keguruan'] = 0.60 * $this->riasecMatch($riasec, 'PENDIDIKAN') 
                                         + 0.25 * $ach 
                                         + 0.15 * $this->personalityMatch($personality, 'PENDIDIKAN');

        // 4. ASPEK 4: TERAPKAN BOOST PREFERENSI (Siswa & Orang Tua)
        $result = $this->applyPreferenceBoost($result, $assessment);
        
        // Urutkan dari skor tertinggi ke terendah
        arsort($result);

        // 5. Susun struktur data agar kompatibel dengan Controller (Top 10 Jurusan)
        $top10Jurusan = [];
        foreach ($result as $type => $score) {
            // Konversi ke persentase & batasi maksimal 98%
            $percentage = min(round($score * 100), 98);
            
            $top10Jurusan[] = [
                'nama_jurusan' => 'Rumpun Ilmu ' . $type,
                'nama_universitas' => 'Fakultas ' . $type . ' Terkait',
                'match_percentage' => $percentage
            ];
        }

        return [
            'ranked_types' => array_keys($result),
            'top_10_jurusan' => $top10Jurusan,
            'focus_field' => $this->determineFocusField($riasec)
        ];
    }

    private function riasecMatch($riasec, $cluster)
    {
        $isR = str_contains($riasec, 'realistic');
        $isI = str_contains($riasec, 'investigative');
        $isA = str_contains($riasec, 'artistic');
        $isS = str_contains($riasec, 'social');
        $isE = str_contains($riasec, 'enterprising');
        $isC = str_contains($riasec, 'conventional');

        // Pencocokan RIASEC dengan Rumpun Kuliah
        return match($cluster) {
            'SAINTEK' => ($isI || $isR) ? 1.0 : (($isC) ? 0.7 : 0.4),
            'SOSHUM' => ($isS || $isA || $isI) ? 1.0 : (($isE) ? 0.8 : 0.5),
            'BISNIS' => ($isE || $isC) ? 1.0 : (($isS) ? 0.8 : 0.5),
            'SENI' => ($isA || $isR) ? 1.0 : (($isI) ? 0.7 : 0.4),
            'PENDIDIKAN' => ($isS || $isC) ? 1.0 : (($isA) ? 0.8 : 0.5),
            default => 0.5
        };
    }

    private function personalityMatch($personality, $cluster)
    {
        $score = 0.7; // Nilai dasar jika kepribadian belum terdeteksi spesifik
        if (empty($personality)) return $score;

        // Logika dasar kepribadian untuk lingkungan kampus
        $isAnalytical = preg_match('/(analitis|pemikir|logis|introvert|fokus)/', $personality);
        $isSocial = preg_match('/(sosial|komunikatif|ekstrovert|aktif|empati)/', $personality);
        $isCreative = preg_match('/(kreatif|imajinatif|fleksibel|bebas)/', $personality);

        if ($cluster === 'SAINTEK' && $isAnalytical) $score = 1.0;
        if ($cluster === 'SOSHUM' && $isSocial) $score = 1.0;
        if ($cluster === 'BISNIS' && $isSocial) $score = 1.0;
        if ($cluster === 'SENI' && $isCreative) $score = 1.0;
        if ($cluster === 'PENDIDIKAN' && $isSocial) $score = 1.0;

        return $score;
    }

    private function applyPreferenceBoost($scores, $assessment)
    {
        // Gabungkan pilihan 1, pilihan 2, dan pilihan orang tua menjadi satu string untuk dipindai
        $pref = strtolower(($assessment->student_preference ?? '') . ' ' . 
                           ($assessment->student_preference_secondary ?? '') . ' ' . 
                           ($assessment->parent_preference ?? ''));
        
        foreach ($scores as $key => $value) {
            // Beri tambahan nilai signifikan (20%) jika inputan pengguna mengandung kata kunci jurusan terkait
            if ($key === 'Sains, Teknologi & Kedokteran' && preg_match('/(teknik|komputer|it|kedokteran|sains|ipa|biologi|kimia|mesin|sistem informasi|perawat|farmasi)/', $pref)) {
                $scores[$key] += 0.20;
            }
            if ($key === 'Sosial, Hukum & Humaniora' && preg_match('/(hukum|hi|komunikasi|sastra|psikologi|soshum|ips|sejarah|antropologi|politik)/', $pref)) {
                $scores[$key] += 0.20;
            }
            if ($key === 'Bisnis, Ekonomi & Manajemen' && preg_match('/(bisnis|ekonomi|manajemen|akuntansi|pemasaran|marketing|administrasi)/', $pref)) {
                $scores[$key] += 0.20;
            }
            if ($key === 'Seni, Desain & Media' && preg_match('/(seni|desain|dkv|animasi|media|film|musik|arsitektur)/', $pref)) {
                $scores[$key] += 0.20;
            }
            if ($key === 'Pendidikan & Keguruan' && preg_match('/(pendidikan|guru|pengajar|keguruan|pgsd|konseling)/', $pref)) {
                $scores[$key] += 0.20;
            }
        }
        
        return $scores;
    }

    private function determineFocusField($riasec)
    {
        if (str_contains($riasec, 'investigative')) return 'Sains, Teknologi, dan Riset Analitis';
        if (str_contains($riasec, 'realistic')) return 'Teknik Terapan, Vokasi, dan Rekayasa';
        if (str_contains($riasec, 'artistic')) return 'Industri Kreatif, Seni, dan Desain';
        if (str_contains($riasec, 'social')) return 'Ilmu Sosial, Pendidikan, dan Humaniora';
        if (str_contains($riasec, 'enterprising')) return 'Ilmu Bisnis, Manajemen, dan Hukum';
        if (str_contains($riasec, 'conventional')) return 'Akuntansi, Administrasi, dan Ekonomi';
        
        return 'Studi Multidisipliner / Umum';
    }
}