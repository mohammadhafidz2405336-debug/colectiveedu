<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- HEADER PROFIL --}}
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-indigo-600"></div>
                <div>
                    <h1 class="text-xs font-black uppercase tracking-[0.3em] text-indigo-600 mb-2">Laporan Analisis Peminatan Perguruan Tinggi (Hybrid System)</h1>
                    
                    <div class="flex items-center gap-3 mb-1">
                        <h2 class="text-3xl font-black text-slate-900">{{ Auth::user()->name }}</h2>
                        @if(Auth::user()->gender == 'Laki-laki')
                            <span class="text-xs font-black text-blue-600 bg-blue-100 px-2 py-1 rounded-full">L</span>
                        @elseif(Auth::user()->gender == 'Perempuan')
                            <span class="text-xs font-black text-pink-600 bg-pink-100 px-2 py-1 rounded-full">P</span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('recommendation.pdf', $recommendation->id) }}" 
                    class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition flex items-center gap-2">
                        <span>📥</span> Download PDF Laporan Lengkap
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: ASPEK PSIKOLOGI DATA ACUAN --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-6 sticky top-6">
                        <h4 class="font-black text-slate-400 uppercase text-[10px] tracking-[0.2em]">Karakteristik & Potensi Diri</h4>
                        
                        {{-- Minat Bakat RIASEC --}}
                        <div class="p-5 bg-violet-50 rounded-3xl border border-violet-100 text-center">
                            <span class="text-[10px] font-black text-violet-400 uppercase block mb-1">Minat & Bakat (RIASEC)</span>
                            <span class="text-2xl font-black text-violet-800">{{ $recommendation->assessment?->dominant_talent ?? '-' }}</span>
                            <div class="text-[11px] text-violet-700 font-medium mt-3 leading-relaxed text-justify bg-white/60 p-3 rounded-xl border border-violet-100/50">
                                {{ is_array($analisisDiri['penjelasan_riasec'] ?? null) ? implode(' ', $analisisDiri['penjelasan_riasec']) : ($analisisDiri['penjelasan_riasec'] ?? 'Merupakan kluster orientasi aktivitas dan lingkungan kerja alami yang paling mendominasi potensi Anda.') }}
                            </div>
                        </div>

                        {{-- Tipe Kepribadian --}}
                        <div class="p-5 bg-indigo-50 rounded-3xl border border-indigo-100">
                            <span class="text-[10px] font-black text-indigo-400 uppercase block mb-2 text-center">Tipe Kepribadian</span>
                            @php
                                $rawScores = is_array($recommendation->assessment?->academic_scores) 
                                    ? $recommendation->assessment->academic_scores 
                                    : json_decode($recommendation->assessment?->academic_scores ?? '{}', true);
                                $personality = $rawScores['saved_personality'] ?? ($recommendation->assessment?->personality ?? 'Tidak ada data kepribadian');
                            @endphp
                            <p class="text-sm font-bold text-indigo-900 text-center leading-relaxed mb-3">
                                {{ $personality }}
                            </p>
                            <div class="text-[11px] text-indigo-700 font-medium leading-relaxed text-justify bg-white/60 p-3 rounded-xl border border-indigo-100/50">
                                {{ is_array($analisisDiri['penjelasan_kepribadian'] ?? null) ? implode(' ', $analisisDiri['penjelasan_kepribadian']) : ($analisisDiri['penjelasan_kepribadian'] ?? 'Menunjukkan gaya berinteraksi, pola pikir, dan kenyamanan adaptasi Anda di lingkungan perkuliahan.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: TOP 3 REKOMENDASI JURUSAN TERBAIK --}}
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-xl font-black text-slate-800 flex items-center gap-2">
                        📊 Top 3 Jurusan Terbaik Hasil Analisis Sistem
                    </h3>

                    @foreach($top10Jurusan as $index => $item)
                    @php
                        // Memberikan aksen premium khusus untuk visualisasi Top 3 (Emas, Perak, Perunggu)
                        $rankBadges = [
                            0 => ['bg' => 'bg-amber-500 text-white ring-4 ring-amber-100', 'border' => 'border-amber-200 shadow-amber-50/50'], // Peringkat 1
                            1 => ['bg' => 'bg-slate-400 text-white ring-4 ring-slate-100', 'border' => 'border-slate-200 shadow-slate-50/50'], // Peringkat 2
                            2 => ['bg' => 'bg-amber-700 text-white ring-4 ring-amber-900/10', 'border' => 'border-orange-200 shadow-orange-50/50']  // Peringkat 3
                        ];
                        
                        $currentStyle = $rankBadges[$index] ?? ['bg' => 'bg-slate-900 text-white', 'border' => 'border-slate-200 shadow-sm'];
                    @endphp

                    <div class="bg-white rounded-[2.5rem] p-8 shadow-md border {{ $currentStyle['border'] }} space-y-6 relative overflow-hidden transition-all duration-300 hover:shadow-lg">
                        
                        {{-- Badge Peringkat & Persentase --}}
                        <div class="flex flex-wrap justify-between items-start gap-4 border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-4">
                                <span class="w-10 h-10 rounded-full {{ $currentStyle['bg'] }} text-sm font-black flex items-center justify-center shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h4 class="text-xl font-black text-slate-900">{{ is_array($item['nama_jurusan'] ?? null) ? implode(', ', $item['nama_jurusan']) : ($item['nama_jurusan'] ?? '-') }}</h4>
                                </div>
                            </div>
                        </div>

                        {{-- Analisis AI --}}
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs font-black text-indigo-600 uppercase tracking-wider block mb-1">💡 Alasan Rekomendasi (Integrasi RIASEC & Kepribadian)</span>
                                <p class="text-sm text-slate-600 leading-relaxed font-medium bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                                    {{ is_array($item['alasan_rekomendasi'] ?? null) ? implode(', ', $item['alasan_rekomendasi']) : ($item['alasan_rekomendasi'] ?? '-') }}
                                </p>
                            </div>

                            {{-- Grid Analisis Potensi --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                                <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100/60">
                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-wider block mb-1">💪 Kelebihan Anda</span>
                                    <p class="text-xs font-semibold text-blue-950 leading-relaxed">
                                        {{ is_array($item['kelebihan_siswa'] ?? null) ? implode(', ', $item['kelebihan_siswa']) : ($item['kelebihan_siswa'] ?? '-') }}
                                    </p>
                                </div>
                                <div class="p-4 bg-violet-50/50 rounded-2xl border border-violet-100/60">
                                    <span class="text-[10px] font-black text-violet-500 uppercase tracking-wider block mb-1">🔮 Potensi Terpendam</span>
                                    <p class="text-xs font-semibold text-violet-950 leading-relaxed">
                                        {{ is_array($item['potensi_yang_dimiliki'] ?? null) ? implode(', ', $item['potensi_yang_dimiliki']) : ($item['potensi_yang_dimiliki'] ?? '-') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Aspek Evaluasi Diri --}}
                            <div class="p-4 bg-amber-50/60 rounded-2xl border border-amber-200/60">
                                <span class="text-[10px] font-black text-amber-600 uppercase tracking-wider block mb-1">⚠️ Hal Yang Perlu Ditingkatkan</span>
                                <p class="text-xs font-medium text-amber-950 leading-relaxed">
                                    {{ is_array($item['hal_yang_perlu_ditingkatkan'] ?? null) ? implode(', ', $item['hal_yang_perlu_ditingkatkan']) : ($item['hal_yang_perlu_ditingkatkan'] ?? 'Tidak ada data analisis untuk aspek ini.') }}
                                </p>
                            </div>

                            {{-- Atribut Pendukung Akademik & Skill --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-slate-100/80">
                                <div>
                                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider block mb-1">📚 Mapel Pendukung</span>
                                    <p class="text-xs font-bold text-slate-700">
                                        {{ is_array($item['mata_pelajaran_pendukung'] ?? null) ? implode(', ', $item['mata_pelajaran_pendukung']) : ($item['mata_pelajaran_pendukung'] ?? '-') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider block mb-1">🛠️ Skill Yang Dibutuhkan</span>
                                    <p class="text-xs font-bold text-slate-700">
                                        @php $skill = $item['skill_yang_dibutuhkan'] ?? ($item['skill_yang_needed'] ?? '-'); @endphp
                                        {{ is_array($skill) ? implode(', ', $skill) : $skill }}
                                    </p>
                                </div>
                            </div>

                            {{-- Aspek Karir --}}
                            <div class="grid grid-cols-1 pt-2">
                                <div class="bg-slate-50/80 p-4 rounded-2xl">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-0.5">💼 Prospek Kerja</span>
                                    <p class="text-xs font-bold text-slate-800">
                                        {{ is_array($item['prospek_kerja'] ?? null) ? implode(', ', $item['prospek_kerja']) : ($item['prospek_kerja'] ?? '-') }}
                                    </p>
                                </div>
                            </div>

                            {{-- REFERENSI KAMPUS & KEKETATAN DARI DATABASE LOKAL --}}
                            @php
                                $namaJurusanAi = is_array($item['nama_jurusan'] ?? null) ? implode(' ', $item['nama_jurusan']) : ($item['nama_jurusan'] ?? '');
                                
                                // Memfilter data dari $dataDatabaseJurusan yang mengandung kata kunci jurusan ini
                                $kampusTerkait = collect($dataDatabaseJurusan)->filter(function($db) use ($namaJurusanAi) {
                                    return stripos($db['jurusan'], $namaJurusanAi) !== false;
                                })->take(5); // Ambil 5 kampus teratas
                            @endphp

                            <div class="pt-4 border-t border-slate-100/80">
                                <span class="text-xs font-black text-slate-800 uppercase tracking-wider block mb-3">🏛️ Referensi Kampus & Keketatan (Data SNPMB)</span>
                                
                                @if($kampusTerkait->isNotEmpty())
                                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-slate-100 text-slate-600 text-[10px] uppercase tracking-wider">
                                                    <th class="p-3 font-black">Universitas & Program Studi</th>
                                                    <th class="p-3 font-black text-center">SNBP (Kapasitas / Peminat)</th>
                                                    <th class="p-3 font-black text-center">SNBT (Kapasitas / Peminat)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs bg-white">
                                                @foreach($kampusTerkait as $kampus)
                                                <tr class="border-b border-slate-100 last:border-0 hover:bg-slate-50/70 transition">
                                                    <td class="p-3">
                                                        <div class="font-bold text-indigo-700">{{ $kampus['universitas'] }}</div>
                                                        <div class="text-slate-500 font-medium mt-0.5">{{ $kampus['jurusan'] }}</div>
                                                    </td>
                                                    <td class="p-3 text-center">
                                                        <span class="font-bold text-slate-700">{{ $kampus['snbp_capacity'] }} / {{ $kampus['snbp_applicants'] }}</span>
                                                        <div class="text-[9px] text-emerald-600 font-black mt-1 bg-emerald-50 py-0.5 px-2 rounded-full inline-block">Ket: {{ $kampus['snbp_keketatan'] }}</div>
                                                    </td>
                                                    <td class="p-3 text-center">
                                                        <span class="font-bold text-slate-700">{{ $kampus['snbt_capacity'] }} / {{ $kampus['snbt_applicants'] }}</span>
                                                        <div class="text-[9px] text-amber-600 font-black mt-1 bg-amber-50 py-0.5 px-2 rounded-full inline-block">Ket: {{ $kampus['snbt_keketatan'] }}</div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl text-center">
                                        <p class="text-xs font-medium text-slate-500">Belum ada data detail kampus terkait di database untuk jurusan <span class="font-bold text-slate-700">"{{ $namaJurusanAi }}"</span>.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>