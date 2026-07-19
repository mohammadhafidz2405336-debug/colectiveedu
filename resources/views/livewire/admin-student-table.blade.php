<div>
    {{-- 1. KOTAK FILTER KELAS (GRID KARTU) --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Filter Berdasarkan Kelas</h3>
            @if($kelasFilter)
                <button wire:click="$set('kelasFilter', '')" class="text-xs font-bold text-rose-500 hover:text-rose-700 transition">✕ Reset Filter Kelas</button>
            @endif
        </div>
        
        <div class="flex overflow-x-auto pb-4 pt-2 sm:grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 hide-scrollbar">
            
            {{-- Kartu "Semua Kelas" --}}
            <button wire:click="$set('kelasFilter', '')" class="min-w-[140px] text-left p-4 rounded-3xl border-2 transition-all duration-300 {{ $kelasFilter === '' ? 'border-indigo-600 bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'border-slate-100 bg-white hover:border-indigo-300 text-slate-700' }}">
                {{-- <div class="flex items-center justify-between mb-2">
                    <span class="text-2xl">🏫</span>
                </div> --}}
                <p class="font-black text-lg">Semua Kelas</p>
                <p class="text-[10px] uppercase tracking-widest font-bold mt-1 {{ $kelasFilter === '' ? 'text-indigo-200' : 'text-slate-400' }}">Tampilkan Semua</p>
            </button>

            {{-- Looping Kartu Kelas (9A, 9B, dst) --}}
            @foreach($kelasStats as $kelas => $stat)
                @php 
                    // Menghitung persentase selesai
                    $persentase = $stat['total'] > 0 ? round(($stat['selesai'] / $stat['total']) * 100) : 0; 
                    $isAktif = $kelasFilter === $kelas;
                    
                    // Menentukan warna progress bar secara dinamis
                    $colorClass = 'bg-blue-500'; // Default sedang berjalan
                    if($persentase == 100) $colorClass = 'bg-green-500'; // Selesai semua
                    if($persentase < 50) $colorClass = 'bg-amber-500'; // Masih di bawah 50%
                @endphp
                <button wire:click="$set('kelasFilter', '{{ $kelas }}')" class="min-w-[150px] text-left p-4 rounded-3xl border-2 transition-all duration-300 {{ $isAktif ? 'border-indigo-600 bg-indigo-50 shadow-md transform -translate-y-1' : 'border-slate-100 bg-white hover:border-indigo-300 hover:bg-slate-50' }}">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-black text-xl {{ $isAktif ? 'text-indigo-700' : 'text-slate-800' }}">Kelas {{ $kelas }}</h4>
                        {{-- @if($persentase == 100)
                            <span class="text-green-500 text-sm" title="Tuntas 100%">✅</span>
                        @endif --}}
                    </div>
                    <p class="text-[11px] font-bold mb-3 {{ $isAktif ? 'text-indigo-400' : 'text-slate-400' }}">
                        {{ $stat['selesai'] }} / {{ $stat['total'] }} Siswa Selesai
                    </p>
                    
                    {{-- Progress Bar --}}
                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                        <div class="{{ $colorClass }} h-full transition-all duration-1000" style="width: {{ $persentase }}%"></div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    {{-- 2. BARIS PENCARIAN & FILTER STATUS --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="relative w-full sm:w-1/2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">🔍</span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau NISN siswa..." 
                class="w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-indigo-600 focus:ring-0 text-slate-700 bg-slate-50 transition">
        </div>
        
        <div class="w-full sm:w-1/4">
            <select wire:model.live="statusFilter" class="w-full py-3 border-2 border-slate-200 rounded-2xl focus:border-indigo-600 focus:ring-0 text-slate-700 bg-slate-50 transition cursor-pointer font-bold text-sm">
                <option value="">Semua Status Tes</option>
                <option value="completed">✅ Selesai Tes</option>
                <option value="draft">✍️ Sedang Tes (Draft)</option>
                <option value="belum_tes">💤 Belum Tes</option>
            </select>
        </div>
    </div>

    {{-- 3. TABEL DATA (Lebar Ala Excel) --}}
    <div class="overflow-x-auto rounded-2xl border border-slate-200 relative">
        <table class="w-full text-left text-sm text-slate-600 whitespace-nowrap">
            <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[10px] tracking-widest border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 sticky left-0 bg-slate-50 z-10 shadow-[1px_0_0_0_#e2e8f0]">Nama, Kelas, NISN</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center bg-blue-50/50">MTK</th>
                    <th class="px-4 py-4 text-center bg-blue-50/50">IPA</th>
                    <th class="px-4 py-4 text-center bg-blue-50/50">IPS</th>
                    <th class="px-4 py-4 text-center bg-blue-50/50">B.Indo</th>
                    <th class="px-4 py-4 text-center bg-blue-50/50">B.Ing</th>
                    <th class="px-4 py-4 text-center bg-indigo-50/50">IQ</th>
                    <th class="px-4 py-4 bg-violet-50/50">Bakat (RIASEC)</th>
                    <th class="px-6 py-4">Minat Siswa</th>
                    <th class="px-6 py-4">Rekomendasi AI</th>
                    <th class="px-6 py-4 text-center sticky right-0 bg-slate-50 z-10 shadow-[-1px_0_0_0_#e2e8f0]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($students as $siswa)
                    @php
                        $scores = $siswa->assessment?->academic_scores ?? [];
                        $avg = function($subject) use ($scores) {
                            $s = $scores[$subject] ?? [];
                            return count($s) > 0 ? round(array_sum($s) / count($s), 1) : '-';
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition duration-150 group">
                        
                        {{-- Kolom Nama (Sticky Left) --}}
                        <td class="px-6 py-4 sticky left-0 bg-white group-hover:bg-slate-50 z-10 shadow-[1px_0_0_0_#e2e8f0]">
                            <div class="flex items-center gap-2 mb-1">
                                <p class="font-bold text-slate-800">{{ $siswa->name }}</p>
                                @if($siswa->gender == 'Laki-laki') 
                                    <span title="Laki-laki" class="text-[10px] font-black text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">L</span>
                                @elseif($siswa->gender == 'Perempuan') 
                                    <span title="Perempuan" class="text-[10px] font-black text-pink-600 bg-pink-100 px-2 py-0.5 rounded-full">P</span> 
                                @endif
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                KELAS {{ $siswa->kelas ?? '-' }} • NISN: {{ $siswa->nisn }}
                            </p>
                        </td>
                        
                        <td class="px-6 py-4 text-center">
                            @if(!$siswa->assessment)
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase tracking-wide">Belum Mulai</span>
                            @elseif($siswa->assessment->status == 'draft')
                                <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-wide">Draft</span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wide">Selesai</span>
                            @endif
                        </td>

                        {{-- Kolom Nilai Rata-rata --}}
                        <td class="px-4 py-4 text-center font-bold text-slate-700 bg-blue-50/10">{{ $avg('math') }}</td>
                        <td class="px-4 py-4 text-center font-bold text-slate-700 bg-blue-50/10">{{ $avg('science') }}</td>
                        <td class="px-4 py-4 text-center font-bold text-slate-700 bg-blue-50/10">{{ $avg('social') }}</td>
                        <td class="px-4 py-4 text-center font-bold text-slate-700 bg-blue-50/10">{{ $avg('indonesian') }}</td>
                        <td class="px-4 py-4 text-center font-bold text-slate-700 bg-blue-50/10">{{ $avg('english') }}</td>
                        
                        {{-- Kolom Psikologi --}}
                        <td class="px-4 py-4 text-center font-black text-indigo-600 bg-indigo-50/10">{{ $siswa->assessment->iq_score ?? '-' }}</td>
                        <td class="px-4 py-4 font-bold text-violet-700 bg-violet-50/10">{{ $siswa->assessment->dominant_talent ?? '-' }}</td>
                        
                        {{-- Kolom Preferensi --}}
                        <td class="px-6 py-4">
                            <span class="truncate max-w-[150px] inline-block font-medium text-slate-700" title="{{ $siswa->assessment->student_preference ?? '-' }}">
                                {{ Str::limit($siswa->assessment->student_preference ?? '-', 20) }}
                            </span>
                        </td>

                        {{-- Kolom AI --}}
                        <td class="px-6 py-4">
                            @if($siswa->recommendation)
                                <span class="font-bold text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100 inline-block text-[10px] uppercase tracking-wider">
                                    {{ Str::limit($siswa->recommendation->primary_recommendation, 25) }}
                                </span>
                            @else
                                <span class="text-slate-400 italic text-[10px] uppercase">Menunggu AI</span>
                            @endif
                        </td>

                        {{-- Kolom Aksi (Sticky Right) --}}
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-slate-50 z-10 shadow-[-1px_0_0_0_#e2e8f0]">
                            <a href="{{ route('bk.siswa.detail', $siswa->id) }}" class="inline-block px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-[10px] uppercase tracking-wider font-bold rounded-xl transition shadow-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-6 py-12 text-center text-slate-500">
                            <div class="text-4xl mb-2">🤷‍♂️</div>
                            <p class="font-bold">Tidak ada data siswa di kelas ini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 4. PAGINATION --}}
    <div class="mt-6">
        {{ $students->links() }}
    </div>
</div>  