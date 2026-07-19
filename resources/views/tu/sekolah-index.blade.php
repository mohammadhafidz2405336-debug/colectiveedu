<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <span>🏛️</span> Data Master Kampus
            </h2>
            <a href="{{ route('tu.dashboard') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem] border-2 border-slate-100">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h3 class="text-xl font-black text-slate-800">Daftar Referensi Perguruan Tinggi</h3>
                            <p class="text-slate-500 text-sm mt-1">Daftar PTN dan Program Studi (SNBP/SNBT) yang menjadi dasar akurasi rekomendasi kelulusan siswa oleh AI.</p>
                        </div>
                    </div>

                    {{-- Memanggil Tabel Livewire (Tetap menggunakan tu-school-table sesuai file Anda) --}}
                    @livewire('tu-school-table')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>