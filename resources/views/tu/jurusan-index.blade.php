<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-2">
                <span>🎓</span> Program Studi: {{ $university->name }}
            </h2>
            <a href="{{ route('tu.sekolah.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition shadow-sm">
                &larr; Kembali ke Daftar Kampus
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem] border-2 border-slate-100">
                <div class="p-6 sm:p-8">
                    {{-- Memanggil Komponen Livewire Baru dan mengirim ID Kampus --}}
                    @livewire('tu-study-program-table', ['universityId' => $university->id])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>