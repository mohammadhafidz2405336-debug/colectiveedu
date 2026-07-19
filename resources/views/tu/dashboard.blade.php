<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <span></span> Ruang Kendali Tata Usaha
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. KARTU STATISTIK GLOBAL --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Siswa --}}
                <div class="bg-white p-8 rounded-[2rem] border-2 border-slate-100 shadow-sm flex items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full z-0"></div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-3xl z-10">👥</div>
                    <div class="z-10">
                        <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Total Siswa</p>
                        <p class="text-4xl font-black text-slate-800">{{ $totalSiswa }}</p>
                    </div>
                </div>

                {{-- Total Guru BK --}}
                <div class="bg-white p-8 rounded-[2rem] border-2 border-slate-100 shadow-sm flex items-center gap-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 rounded-full z-0"></div>
                    <div class="w-16 h-16 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-3xl z-10">👨‍🏫</div>
                    <div class="z-10">
                        <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Guru BK Aktif</p>
                        <p class="text-4xl font-black text-slate-800">{{ $totalGuruBk }}</p>
                    </div>
                </div>

                {{-- Progress Global Sekolah --}}
                <div class="bg-slate-900 p-8 rounded-[2rem] shadow-lg flex flex-col justify-center relative overflow-hidden text-white">
                    <p class="text-sm font-black text-slate-400 uppercase tracking-widest mb-1">Penyelesaian Tes Global</p>
                    <div class="flex items-end gap-2 mb-3">
                        <p class="text-4xl font-black">{{ $persentaseSelesai }}%</p>
                        <p class="text-sm text-slate-400 font-medium mb-1">({{ $totalSelesaiTes }} dari {{ $totalSiswa }} siswa)</p>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-green-400 h-full" style="width: {{ $persentaseSelesai }}%"></div>
                    </div>
                </div>
            </div>

            {{-- 2. MENU PINTASAN (QUICK ACTIONS) --}}
            <div>
                <h3 class="text-lg font-black text-slate-800 mb-4 px-2">Menu Kelola Sistem</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    {{-- Menu Manajemen Siswa --}}
                    <a href="{{ route('tu.siswa.index') }}" class="group block bg-white p-8 rounded-[2rem] border-2 border-slate-100 hover:border-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                        <span class="text-4xl mb-4 block group-hover:scale-110 transition-transform">🗂️</span>
                        <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-indigo-700">Manajemen Siswa</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Tambah, edit, hapus, atau reset password akun siswa dan atur penempatan kelas.</p>
                    </a>

                    {{-- Menu Data Kampus (Route tetap tu.sekolah.index sesuai struktur file Anda) --}}
                    <a href="{{ route('tu.sekolah.index') }}" class="group block bg-white p-8 rounded-[2rem] border-2 border-slate-100 hover:border-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                        <span class="text-4xl mb-4 block group-hover:scale-110 transition-transform">🏛️</span>
                        <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-blue-700">Data Master Kampus</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Kelola daftar Universitas (PTN) beserta jurusan, daya tampung, dan peminat untuk referensi AI.</p>
                    </a>

                    {{-- Menu Rekap Global --}}
                    <a href="{{ route('tu.laporan.index') }}" class="group block bg-white p-8 rounded-[2rem] border-2 border-slate-100 hover:border-emerald-600 hover:bg-emerald-50 transition-all shadow-sm">
                        <span class="text-4xl mb-4 block group-hover:scale-110 transition-transform">📊</span>
                        <h4 class="text-xl font-black text-slate-800 mb-2 group-hover:text-emerald-700">Cetak Laporan Global</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Unduh rekapitulasi data seluruh angkatan dalam format PDF atau Excel untuk arsip sekolah.</p>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>