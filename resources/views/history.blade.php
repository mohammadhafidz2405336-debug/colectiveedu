<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
            {{ __('Riwayat Tes Saya') }} 📜
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if($recommendations->isEmpty())
                <div class="bg-white p-12 rounded-[2.5rem] shadow-xl text-center border border-slate-100">
                    <div class="text-6?l mb-6 text-slate-300">🔍</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum ada riwayat tes</h3>
                    <p class="text-slate-500 mb-8 text-lg">Kamu belum melakukan tes penjurusan. Yuk, mulai sekarang!</p>
                    <a href="{{ route('assessment') }}" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-bold rounded-full shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                        Mulai Tes Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($recommendations as $item)
                        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl border border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 transition hover:shadow-indigo-50 border-l-8 border-l-indigo-600">
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-black rounded-full uppercase tracking-wider">
                                        Hasil Analisis AI
                                    </span>
                                    <span class="text-slate-400 text-sm font-medium">
                                        • {{ $item->created_at->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 mb-1">
                                    {{ $item->primary_recommendation }}
                                </h3>
                                <p class="text-slate-500 line-clamp-1 max-w-xl">
                                    {{ $item->reasoning }}
                                </p>
                            </div>
                            
                            <div class="flex gap-3 w-full sm:w-auto">
                                <a href="{{ route('recommendation.result') }}" class="flex-1 text-center px-6 py-2.5 bg-slate-800 text-white font-bold rounded-full hover:bg-slate-700 transition shadow-md">
                                    Detail
                                </a>
                                </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <p class="text-slate-400 text-sm">
                        Ingin mencoba tes lagi? <a href="{{ route('assessment') }}" class="text-indigo-600 font-bold hover:underline">Klik di sini</a>
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>