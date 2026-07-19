<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <span>👤</span> Laporan Lengkap: {{ $siswa->name }}
            </h2>
            <a href="{{ route('bk.dashboard') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm">
                &larr; Kembali ke Tabel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(!$siswa->assessment)
                <div class="bg-white p-12 rounded-3xl border border-slate-200 text-center shadow-sm">
                    <span class="text-4xl">💤</span>
                    <h3 class="text-xl font-bold text-slate-800 mt-4">Siswa belum memulai tes</h3>
                    <p class="text-slate-500">Data akademik, psikologi, dan rekomendasi AI belum tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    {{-- KOLOM KIRI: Profil & Psikologi --}}
                    <div class="space-y-6">
                        
                        {{-- Data Diri Singkat --}}
                        <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-50 pb-2">Informasi Dasar</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <p class="text-slate-500 font-semibold mb-0.5">NISN:</p>
                                    <p class="font-bold text-slate-800">{{ $siswa->nisn }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-500 font-semibold mb-0.5">Status Pengisian:</p>
                                    @if($siswa->assessment->status == 'completed')
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 font-bold rounded-lg text-xs uppercase">Selesai</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-100 text-amber-700 font-bold rounded-lg text-xs uppercase">Draft (Sedang Tes)</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Aspek Psikologi --}}
                        <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-50 pb-2">Aspek Psikologi</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-indigo-50 p-4 rounded-2xl text-center border border-indigo-100">
                                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Skor IQ</p>
                                    <p class="text-3xl font-black text-indigo-700 mt-1">{{ $siswa->assessment->iq_score ?? '-' }}</p>
                                </div>
                                <div class="bg-violet-50 p-4 rounded-2xl text-center border border-violet-100">
                                    <p class="text-[10px] font-black text-violet-400 uppercase tracking-widest">RIASEC</p>
                                    <p class="text-lg font-black text-violet-700 mt-2 line-clamp-1">{{ $siswa->assessment->dominant_talent ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Prestasi & Pilihan --}}
                        <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-50 pb-2">Preferensi Peminatan</h3>
                            <div class="space-y-4 text-sm">
                                <div>
                                    <p class="text-slate-500 font-semibold mb-1">Prestasi Menonjol:</p>
                                    @php $prestasi = $siswa->assessment->achievements['primary'] ?? null; @endphp
                                    @if($prestasi && !empty($prestasi['name']) && $prestasi['name'] !== 'Belum Ada')
                                        <p class="font-bold text-slate-800">{{ $prestasi['name'] }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $prestasi['level'] }} • {{ $prestasi['type'] }}</p>
                                    @else
                                        <p class="text-slate-400 italic">Belum memiliki sertifikat.</p>
                                    @endif
                                </div>
                                <div class="pt-2 border-t border-slate-50">
                                    <p class="text-slate-500 font-semibold mb-1">Minat Pribadi Siswa:</p>
                                    <p class="font-bold text-slate-800">{{ $siswa->assessment->student_preference ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-500 font-semibold mb-1">Harapan Orang Tua:</p>
                                    <p class="font-bold text-slate-800">{{ $siswa->assessment->parent_preference ?: '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: AI & Nilai Akademik --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- Keputusan AI --}}
                        <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-200 mb-4 bg-black/20 inline-block px-3 py-1 rounded-full">Rekomendasi Utama AI</h3>
                            @if($siswa->recommendation)
                                <p class="text-3xl sm:text-4xl font-black mb-6 leading-tight">{{ $siswa->recommendation->primary_recommendation }}</p>
                                <div class="bg-white/10 p-5 rounded-2xl border border-white/20 backdrop-blur-sm">
                                    <p class="text-[11px] font-black uppercase tracking-wider text-indigo-200 mb-2">Alasan Objektif Sistem:</p>
                                    <p class="text-white leading-relaxed italic">"{{ $siswa->recommendation->reasoning }}"</p>
                                </div>
                            @else
                                <div class="py-8 text-center bg-white/10 rounded-2xl border border-white/20">
                                    <p class="text-xl font-bold opacity-90">AI belum menerbitkan rekomendasi.</p>
                                    <p class="text-sm opacity-70 mt-2">Siswa harus menekan tombol "Analisis Masa Depan" di akhir form tes.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Rata-Rata Nilai Akademik --}}
                        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-100 shadow-sm">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Rata-rata Nilai Akademik (Semester 1-5)</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @php
                                    $mapels = [
                                        'math' => 'MTK', 'science' => 'IPA', 'social' => 'IPS',
                                        'indonesian' => 'B. Indo', 'english' => 'B. Inggris', 'PKN' => 'PKN', 'religion' => 'Agama'
                                    ];
                                @endphp
                                @foreach($mapels as $key => $label)
                                    @php
                                        $scores = $siswa->assessment->academic_scores[$key] ?? [];
                                        $avg = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;
                                    @endphp
                                    <div class="bg-slate-50 p-4 rounded-2xl text-center border border-slate-100">
                                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">{{ $label }}</p>
                                        <p class="text-2xl font-black text-slate-800">{{ round($avg, 1) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>