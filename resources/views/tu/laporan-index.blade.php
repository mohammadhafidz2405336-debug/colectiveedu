<x-app-layout>
    {{-- Header (Tidak akan ikut tercetak saat di-print) --}}
    <x-slot name="header">
        <div class="flex items-center justify-between print:hidden">
            <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <span>📊</span> Rekapitulasi Global
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('tu.dashboard') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm">
                    &larr; Kembali
                </a>
                {{-- Tombol Print Javacript --}}
                <button onclick="window.print()" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition shadow-md shadow-emerald-200 flex items-center gap-2">
                    🖨️ Cetak PDF / Dokumen
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-white sm:bg-slate-50 print:bg-white print:py-0 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- KERTAS LAPORAN --}}
            <div class="bg-white sm:rounded-[2rem] sm:shadow-sm sm:border border-slate-100 p-8 sm:p-12 print:shadow-none print:border-none print:p-0">
                
                {{-- KOP SURAT LAPORAN --}}
                <div class="text-center border-b-4 border-slate-800 pb-6 mb-8">
                    <h1 class="text-3xl font-black text-slate-900 uppercase tracking-widest mb-1">ArahCita</h1>
                    <h2 class="text-xl font-bold text-slate-700">Laporan Analisis Peminatan Siswa Global</h2>
                    <p class="text-sm text-slate-500 mt-2">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y - H:i') }}</p>
                </div>

                {{-- SUMMARY BOX --}}
                <div class="flex justify-between items-center bg-slate-50 p-6 rounded-2xl border border-slate-200 mb-8 print:bg-transparent print:border-slate-800">
                    <div class="text-center w-1/2 border-r border-slate-200 print:border-slate-800">
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Total Populasi Siswa</p>
                        <p class="text-4xl font-black text-slate-800">{{ $totalSiswa }}</p>
                    </div>
                    <div class="text-center w-1/2">
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Tuntas Melakukan Tes</p>
                        <p class="text-4xl font-black text-emerald-600">{{ $totalSelesai }} <span class="text-lg text-slate-400">({{ $totalSiswa > 0 ? round(($totalSelesai/$totalSiswa)*100) : 0 }}%)</span></p>
                    </div>
                </div>

                {{-- BAGIAN 1: STATISTIK PER KELAS --}}
                <div class="mb-10 block" style="page-break-inside: avoid;">
                    <h3 class="text-lg font-black text-slate-800 border-b-2 border-slate-200 pb-2 mb-4 uppercase tracking-wider">A. Rincian Penyelesaian Per Kelas</h3>
                    <table class="w-full text-left text-sm text-slate-700 border-collapse">
                        <thead>
                            <tr class="bg-slate-100 print:bg-slate-200">
                                <th class="px-4 py-3 border border-slate-300">Nama Kelas</th>
                                <th class="px-4 py-3 border border-slate-300 text-center">Total Siswa</th>
                                <th class="px-4 py-3 border border-slate-300 text-center">Selesai Tes</th>
                                <th class="px-4 py-3 border border-slate-300 text-center">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statistikKelas as $namaKelas => $stat)
                            <tr>
                                <td class="px-4 py-3 border border-slate-300 font-bold">{{ $namaKelas }}</td>
                                <td class="px-4 py-3 border border-slate-300 text-center">{{ $stat['total'] }}</td>
                                <td class="px-4 py-3 border border-slate-300 text-center text-emerald-600 font-bold">{{ $stat['selesai'] }}</td>
                                <td class="px-4 py-3 border border-slate-300 text-center">{{ $stat['persentase'] }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- BAGIAN 2: TREN MINAT / REKOMENDASI TERBANYAK --}}
                <div class="block" style="page-break-inside: avoid;">
                    <h3 class="text-lg font-black text-slate-800 border-b-2 border-slate-200 pb-2 mb-4 uppercase tracking-wider">B. Top 5 Rekomendasi Sekolah Terbanyak (AI)</h3>
                    <div class="space-y-3">
                        @forelse($topRekomendasi as $sekolah => $jumlah)
                            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl print:bg-transparent print:border-slate-800">
                                <p class="font-bold text-slate-800">🎓 {{ $sekolah }}</p>
                                <p class="font-black text-indigo-600 text-lg">{{ $jumlah }} <span class="text-xs text-slate-500 font-normal uppercase">Siswa</span></p>
                            </div>
                        @empty
                            <p class="text-slate-500 italic p-4 text-center border border-dashed border-slate-300 rounded-xl">Belum ada data rekomendasi AI yang dihasilkan.</p>
                        @endforelse
                    </div>
                </div>
                
                {{-- TANDA TANGAN (Hanya muncul saat dicetak) --}}
                <div class="hidden print:block mt-20 text-right">
                    <p class="text-sm mb-16">Mengetahui,<br>Kepala Tata Usaha</p>
                    <p class="font-bold underline text-sm">..........................................</p>
                    <p class="text-xs mt-1">NIP. </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>