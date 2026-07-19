<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Analisis Peminatan Perguruan Tinggi</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #334155; 
            line-height: 1.6; 
            font-size: 13px; 
            margin: 0; 
            padding: 0; 
        }
        
        /* HEADER STYLES */
        .header-container { 
            text-align: center; 
            padding: 30px 20px; 
            border-bottom: 4px solid #4f46e5; 
            margin-bottom: 30px; 
            background-color: #f8fafc; 
            border-radius: 8px 8px 0 0; 
        }
        .header-title { 
            color: #4f46e5; 
            text-transform: uppercase; 
            font-size: 13px; 
            font-weight: 800; 
            letter-spacing: 2px; 
            margin-bottom: 8px; 
        }
        .student-name { 
            font-size: 26px; 
            font-weight: bold; 
            color: #0f172a; 
            margin: 5px 0; 
            text-transform: capitalize;
        }
        .gender-badge {
            font-size: 14px;
            color: #4f46e5;
            background-color: #e0e7ff;
            padding: 2px 8px;
            border-radius: 12px;
            vertical-align: middle;
            margin-left: 5px;
        }
        .meta-info { 
            font-size: 12px; 
            color: #64748b; 
            margin-top: 10px;
        }

        /* SECTION TITLES */
        .section-title { 
            font-size: 14px; 
            font-weight: bold; 
            color: #ffffff; 
            background-color: #4f46e5; 
            padding: 8px 16px; 
            border-radius: 6px; 
            margin: 20px 0 15px 0; 
            display: inline-block; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
        }

        /* PROFILE CARD */
        .profile-card { 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 20px; 
            background-color: #fafafa; 
            margin-bottom: 30px; 
        }
        .profile-item { 
            margin-bottom: 15px; 
        }
        .profile-item:last-child { 
            margin-bottom: 0; 
            border-top: 1px dashed #cbd5e1;
            padding-top: 15px;
        }
        .profile-label { 
            font-size: 11px; 
            font-weight: bold; 
            color: #64748b; 
            text-transform: uppercase; 
            display: block; 
            margin-bottom: 4px; 
            letter-spacing: 0.5px;
        }
        .profile-value { 
            font-size: 18px; 
            font-weight: bold; 
            color: #4338ca; 
            margin-bottom: 6px; 
        }
        .profile-desc { 
            font-size: 12.5px; 
            color: #475569; 
            text-align: justify; 
        }

        /* JURUSAN CARDS */
        .jurusan-card { 
            border: 2px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 20px; 
            margin-bottom: 25px; 
            page-break-inside: avoid; 
        }
        .jurusan-header {
            margin-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        .rank-badge { 
            background-color: #f59e0b; 
            color: white; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: bold; 
            margin-right: 10px; 
            vertical-align: middle; 
        }
        .rank-1 { background-color: #f59e0b; } /* Gold */
        .rank-2 { background-color: #94a3b8; } /* Silver */
        .rank-3 { background-color: #b45309; } /* Bronze */
        
        .jurusan-title-text { 
            font-size: 18px; 
            font-weight: bold; 
            color: #1e293b; 
            vertical-align: middle; 
        }

        /* REASON BOX */
        .reason-box { 
            background-color: #eff6ff; 
            border-left: 4px solid #3b82f6; 
            padding: 12px 15px; 
            margin-bottom: 15px; 
            border-radius: 0 8px 8px 0; 
        }
        .reason-title { 
            font-size: 11px; 
            font-weight: bold; 
            color: #2563eb; 
            text-transform: uppercase; 
            margin-bottom: 4px; 
        }
        .reason-text { 
            font-size: 12.5px; 
            color: #1e3a8a; 
            text-align: justify;
        }

        /* GRID TABLES FOR PDF COMPATIBILITY */
        .grid-table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 10px; 
            margin: -10px; 
        }
        .grid-table td { 
            background-color: #f8fafc; 
            border: 1px solid #e2e8f0; 
            border-radius: 8px; 
            padding: 15px; 
            vertical-align: top; 
            width: 50%; 
        }
        .grid-title { 
            font-size: 11px; 
            font-weight: bold; 
            text-transform: uppercase; 
            margin-bottom: 8px; 
            display: block; 
            border-bottom: 1px solid #e2e8f0; 
            padding-bottom: 5px; 
        }
        
        /* Custom Colors for Grids */
        .title-blue { color: #0284c7; }
        .title-purple { color: #7c3aed; }
        .title-amber { color: #d97706; }
        .title-slate { color: #475569; }

        .grid-text { 
            font-size: 12.5px; 
            color: #334155; 
            font-weight: 500; 
        }

        /* FOOTER */
        .footer { 
            margin-top: 40px; 
            text-align: center; 
            font-size: 11px; 
            color: #94a3b8; 
            border-top: 1px solid #e2e8f0; 
            padding-top: 15px; 
        }
    </style>
</head>
<body>
    
    <!-- HEADER -->
    <div class="header-container">
        <div class="header-title">Laporan Analisis Peminatan Perguruan Tinggi</div>
        <div class="student-name">
            {{ $user->name }}
            @if(isset($user->gender))
                <span class="gender-badge">{{ $user->gender == 'Laki-laki' ? 'L' : 'P' }}</span>
            @endif
        </div>
        <div class="meta-info">Tanggal Cetak: {{ $date ?? now()->format('d/m/Y') }}</div>
    </div>

    <!-- PROFIL & KARAKTER -->
    <div class="section-title">Karakteristik & Potensi Diri</div>
    
    <div class="profile-card">
        @php
            $rawScores = is_array($recommendation->assessment?->academic_scores) 
                ? $recommendation->assessment->academic_scores 
                : json_decode($recommendation->assessment?->academic_scores ?? '{}', true);
            $personality = $rawScores['saved_personality'] ?? ($recommendation->assessment?->personality ?? 'Tidak ada data kepribadian');
        @endphp
        
        <div class="profile-item">
            <span class="profile-label">Minat & Bakat Dominan (RIASEC)</span>
            <div class="profile-value">{{ $recommendation->assessment?->dominant_talent ?? '-' }}</div>
            <div class="profile-desc">
                {{ is_array($analisisDiri['penjelasan_riasec'] ?? null) ? implode(' ', $analisisDiri['penjelasan_riasec']) : ($analisisDiri['penjelasan_riasec'] ?? 'Merupakan kluster orientasi aktivitas dan lingkungan kerja alami yang paling mendominasi potensi Anda.') }}
            </div>
        </div>

        <div class="profile-item">
            <span class="profile-label">Tipe Kepribadian</span>
            <div class="profile-value">{{ $personality }}</div>
            <div class="profile-desc">
                {{ is_array($analisisDiri['penjelasan_kepribadian'] ?? null) ? implode(' ', $analisisDiri['penjelasan_kepribadian']) : ($analisisDiri['penjelasan_kepribadian'] ?? 'Menunjukkan gaya berinteraksi, pola pikir, dan kenyamanan adaptasi Anda di lingkungan perkuliahan.') }}
            </div>
        </div>
    </div>

    <!-- JURUSAN TERBAIK -->
    <div class="section-title" style="background-color: #0f172a;">Top 3 Rekomendasi Jurusan Terbaik</div>
    
    @foreach($top10Jurusan ?? [] as $index => $item)
        @if($index < 3)
        <div class="jurusan-card">
            <div class="jurusan-header">
                @php
                    $rankClass = 'rank-1';
                    if($index == 1) $rankClass = 'rank-2';
                    if($index == 2) $rankClass = 'rank-3';
                @endphp
                <span class="rank-badge {{ $rankClass }}">Peringkat {{ $index + 1 }}</span>
                <span class="jurusan-title-text">{{ is_array($item['nama_jurusan'] ?? null) ? implode(', ', $item['nama_jurusan']) : ($item['nama_jurusan'] ?? '-') }}</span>
            </div>
            
            <div class="reason-box">
                <div class="reason-title">💡 Alasan Rekomendasi</div>
                <div class="reason-text">
                    {{ is_array($item['alasan_rekomendasi'] ?? null) ? implode(', ', $item['alasan_rekomendasi']) : ($item['alasan_rekomendasi'] ?? '-') }}
                </div>
            </div>
            
            <table class="grid-table">
                <tr>
                    <td>
                        <span class="grid-title title-blue">💪 Kelebihan Anda</span>
                        <div class="grid-text">
                            {{ is_array($item['kelebihan_siswa'] ?? null) ? implode(', ', $item['kelebihan_siswa']) : ($item['kelebihan_siswa'] ?? '-') }}
                        </div>
                    </td>
                    <td>
                        <span class="grid-title title-purple">🔮 Potensi Terpendam</span>
                        <div class="grid-text">
                            {{ is_array($item['potensi_yang_dimiliki'] ?? null) ? implode(', ', $item['potensi_yang_dimiliki']) : ($item['potensi_yang_dimiliki'] ?? '-') }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="grid-title title-amber">⚠️ Perlu Ditingkatkan</span>
                        <div class="grid-text">
                            {{ is_array($item['hal_yang_perlu_ditingkatkan'] ?? null) ? implode(', ', $item['hal_yang_perlu_ditingkatkan']) : ($item['hal_yang_perlu_ditingkatkan'] ?? '-') }}
                        </div>
                    </td>
                    <td>
                        <span class="grid-title title-slate">📚 Mapel Pendukung</span>
                        <div class="grid-text">
                            {{ is_array($item['mata_pelajaran_pendukung'] ?? null) ? implode(', ', $item['mata_pelajaran_pendukung']) : ($item['mata_pelajaran_pendukung'] ?? '-') }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="grid-title title-slate">🛠️ Skill Dibutuhkan</span>
                        <div class="grid-text">
                            @php $skill = $item['skill_yang_dibutuhkan'] ?? ($item['skill_yang_needed'] ?? '-'); @endphp
                            {{ is_array($skill) ? implode(', ', $skill) : $skill }}
                        </div>
                    </td>
                    <td>
                        <span class="grid-title title-slate">💼 Prospek Kerja</span>
                        <div class="grid-text">
                            {{ is_array($item['prospek_kerja'] ?? null) ? implode(', ', $item['prospek_kerja']) : ($item['prospek_kerja'] ?? '-') }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        @endif
    @endforeach

    <!-- FOOTER -->
    <div class="footer">
        Dicetak melalui Sistem Analisis CollectiveEdu pada {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>