<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <span></span> Dashboard Guru BK
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- 1. KARTU STATISTIK (OVERVIEW CARDS) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Total Siswa --}}
                <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">👥</div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                        <p class="text-3xl font-black text-slate-800">{{ $totalSiswa }}</p>
                    </div>
                </div>

                {{-- Selesai Tes --}}
                <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-500 flex items-center justify-center text-2xl">✅</div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Selesai Tes</p>
                        <p class="text-3xl font-black text-slate-800">{{ $selesaiTes }}</p>
                    </div>
                </div>

                {{-- Sedang Mengisi (Draft) --}}
                <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl">✍️</div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Sedang Tes</p>
                        <p class="text-3xl font-black text-slate-800">{{ $sedangTes }}</p>
                    </div>
                </div>

                {{-- Belum Mulai --}}
                <div class="bg-white p-6 rounded-3xl border-2 border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl">💤</div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Belum Mulai</p>
                        <p class="text-3xl font-black text-slate-800">{{ $belumTes }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. TABEL DATA SISWA (Memanggil komponen Livewire yang baru kita buat) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem] border-2 border-slate-100">
                <div class="p-6 sm:p-8 text-gray-900">
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-black text-slate-800">Manajemen Data Siswa</h3>
                            <p class="text-slate-500 text-sm mt-1">Pantau perkembangan tes dan hasil rekomendasi AI setiap siswa.</p>
                        </div>
                    </div>
                    
                    {{-- Render tabel pencarian --}}
                    @livewire('admin-student-table')

                </div>
            </div>

        </div>
    </div>
</x-app-layout>