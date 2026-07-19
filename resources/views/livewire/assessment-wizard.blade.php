<div class="max-w-4xl mx-auto mt-8">
    <div class="text-center mb-8 px-4">
        <h1 class="text-3xl font-black text-slate-900 mb-2">Peta Masa Depanmu 🗺️</h1>
        <p class="text-slate-500 text-sm font-medium">Lengkapi setiap bagian dengan jujur agar AI Gemini bisa memberikan saran terbaik.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100/50 border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 z-0"></div>
        
        <div class="relative z-10 p-6 sm:p-12">
            <div class="flex items-center justify-between mb-12 max-w-2xl mx-auto">
                {{-- Label Step Diperbarui: Minat Bakat, Kepribadian, Prestasi, Pilihan --}}
                @foreach(['Minat Bakat', 'Kepribadian', 'Prestasi', 'Pilihan'] as $index => $label)
                    @php 
                        $currentStep = $index + 1;
                        $isActive = $step == $currentStep;
                        $isCompleted = $step > $currentStep;
                    @endphp
                    <div class="flex flex-col items-center flex-1 relative">
                        @if($index < 3)
                            <div class="absolute top-5 left-1/2 w-full h-[2px] bg-slate-100 -z-10">
                                <div class="h-full bg-indigo-500 transition-all duration-700" style="width: {{ $isCompleted ? '100%' : '0%' }}"></div>
                            </div>
                        @endif

                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-500 border-2 
                            {{ $isActive ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-200 scale-110' : ($isCompleted ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-slate-200 text-slate-400') }}">
                            @if($isCompleted)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <span class="font-black text-sm">{{ $currentStep }}</span>
                            @endif
                        </div>
                        <span class="mt-3 text-[11px] font-black uppercase tracking-widest {{ $isActive ? 'text-indigo-600' : 'text-slate-400' }}">
                            {{ $label }}
                        </span>
                    </div>
                @endforeach
            </div>

            @if ($errors->any())
                <div class="mb-8 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-2xl animate-bounce-short">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">⚠️</span>
                        <p class="text-sm font-bold">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <div class="min-h-[450px] transition-all duration-500">
                <div class="py-4">
                    {{-- Render Komponen Berdasarkan Step Baru --}}
                    @if ($step == 1)
                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                            {{-- Ganti nama view sesuai file komponen Tes Minat Bakat Anda --}}
                            @include('livewire.steps.minat-bakat')
                        </div>
                    @elseif ($step == 2)
                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                            {{-- Ganti nama view sesuai file komponen Tes Kepribadian Anda --}}
                            @include('livewire.steps.kepribadian')
                        </div>
                    @elseif ($step == 3)
                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                            @include('livewire.steps.achievements')
                        </div>
                    @elseif ($step == 4)
                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                            @include('livewire.steps.preference-sync')
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-12 flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t border-slate-50">
                <div class="order-2 sm:order-1">
                    @if ($step > 1)
                        <button wire:click="previousStep" type="button" class="group px-8 py-4 text-slate-400 font-black rounded-2xl hover:text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2">
                            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
                        </button>
                    @endif
                </div>

                <div class="order-1 sm:order-2 w-full sm:w-auto">
                    @if ($step < 4)
                        <button wire:click="nextStep" type="button" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="nextStep">Simpan & Lanjut</span>
                            <span wire:loading wire:target="nextStep" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memvalidasi...
                            </span>
                            <span wire:loading.remove wire:target="nextStep">→</span>
                        </button>
                    @else
                        <button wire:click.prevent="submit" type="button" class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:from-emerald-600 hover:to-teal-700 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submit">Analisis Sekolah Untukmu 🚀</span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mengirim ke AI...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <p class="text-center mt-8 text-slate-400 text-xs font-bold uppercase tracking-[0.2em]">
        Didukung oleh Kecerdasan Buatan &bull;
    </p>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake { animation: shake 0.2s ease-in-out 0s 2; }
    
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .animate-bounce-short { animation: bounce-short 0.5s ease-in-out infinite; }
</style>