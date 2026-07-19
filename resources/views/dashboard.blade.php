<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-50 border border-blue-100 rounded-xl shadow-md shadow-blue-50 group-hover:-translate-y-1 transition-all duration-300">
                {{-- Menggunakan tag img dengan filter untuk memperjelas kontras --}}
                <img 
                    src="{{ asset('images/logo.png') }}" 
                    alt="Logo Kampus" 
                    class="w-6 h-6 object-contain contrast-125 brightness-50"
                >
            </div>
            <h2 class="font-black text-2xl text-slate-800 tracking-tight">
                {{ __('Collective Edu Workspace') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Hero Section --}}
            <div class="bg-gradient-to-br from-blue-800 via-indigo-900 to-slate-900 overflow-hidden shadow-2xl rounded-[2.5rem] relative">
                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 opacity-10 rounded-full blur-3xl transform translate-x-1/4 -translate-y-1/4"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-500 opacity-20 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
                
                {{-- Grid Pattern Overlay --}}
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-[size:24px_24px]"></div>

                <div class="p-10 sm:p-14 text-white relative z-10">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                        <div class="text-center lg:text-left flex-1">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                AI-Powered Campus Navigator
                            </span>
                            <h3 class="text-4xl sm:text-5xl font-black mb-5 leading-tight tracking-tight">
                                Tembus Kampus Impian, <br class="hidden sm:block"/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-indigo-300">{{ Auth::user()->name }}!</span> 🎓
                            </h3>
                            <p class="text-blue-100/90 text-lg max-w-2xl leading-relaxed font-medium">
                                Strategi rasional adalah kunci. Ikuti asesmen komprehensif Collective Edu dan biarkan AI kami memetakan probabilitas lolos serta merekomendasikan Program Studi PTN terbaik untukmu.
                            </p>
                        </div>
                        
                        <div class="flex-shrink-0">
                            <a href="{{ route('assessment') }}" class="group relative inline-flex items-center justify-center px-10 py-5 text-lg font-black text-blue-900 bg-white rounded-2xl shadow-[0_0_40px_rgba(255,255,255,0.2)] hover:shadow-[0_0_60px_rgba(255,255,255,0.4)] hover:-translate-y-1 transition-all duration-300">
                                Mulai Asesmen PTN
                                <svg class="w-6 h-6 ml-3 text-blue-600 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Feature Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Info Card --}}
                <div class="md:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/80 flex flex-col sm:flex-row items-center gap-8 hover:shadow-md transition-shadow">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 rounded-3xl flex items-center justify-center text-4xl shrink-0 border border-blue-100">
                        🎯
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-800 mb-2">Analisis Berbasis Data Objektif</h4>
                        <p class="text-slate-500 leading-relaxed">
                            Penilaian ini mengkalkulasi <strong>Nilai Rapor, Minat Bakat, hingga Sertifikat Prestasi</strong>. Jawablah dengan akurat agar algoritma kami dapat memberikan prediksi SNBP/SNBT yang paling relevan dengan potensimu.
                        </p>
                    </div>
                </div>

                {{-- Privacy Card --}}
                <div class="bg-slate-900 p-8 rounded-[2rem] shadow-xl text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center text-2xl mb-6 border border-white/10 group-hover:bg-white/20 transition-colors">
                            🛡️
                        </div>
                        <h4 class="text-lg font-bold mb-2">Privasi Terjamin</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Data akademis dan preferensimu dienkripsi secara aman dan eksklusif hanya digunakan untuk pemrosesan rekomendasi di Collective Edu.
                        </p>
                    </div>
                    <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500/20 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-indigo-500/30 transition-colors duration-500"></div>
                </div>

                {{-- Logic Tracker --}}
                @php
                    $assessment = \App\Models\Assessment::where('user_id', auth()->id())->latest()->first();
                    
                    $progress = 0;
                    $statusLabel = 'Belum Dimulai';
                    $barColor = 'bg-slate-300';
                    $message = 'Mulai input data akademismu untuk analisis AI.';
                    $isPulsing = false;

                    if ($assessment) {
                        if ($assessment->status === 'completed') {
                            $progress = 100;
                            $statusLabel = 'Analisis Selesai';
                            $barColor = 'bg-green-500';
                            $message = 'Data lengkap! Rekomendasi PTN siap dilihat.';
                        } else {
                            $filledSteps = 0;
                            $totalSteps = 5; 

                            if (!empty($assessment->academic_scores)) $filledSteps++;
                            if (!empty($assessment->iq_score) || !empty($assessment->dominant_talent)) $filledSteps++;
                            if (!empty($assessment->achievements)) $filledSteps++;
                            if (!empty($assessment->student_preference) || !empty($assessment->parent_preference)) $filledSteps++;
                            if (!empty($assessment->q2_learning_style)) $filledSteps++;

                            $progress = ($filledSteps / $totalSteps) * 100;
                            $statusLabel = "Memproses ($progress%)";
                            $barColor = 'bg-blue-600';
                            $message = 'Lengkapi profil akademismu untuk hasil maksimal.';
                            $isPulsing = true; 
                        }
                    }
                @endphp

                {{-- Status Tracker Card --}}
                <div class="bg-gradient-to-b from-blue-50 to-white p-8 rounded-[2rem] border border-blue-100 flex flex-col justify-between shadow-sm">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 rounded-full {{ $progress == 100 ? 'bg-green-500' : ($progress > 0 ? 'bg-blue-500 animate-pulse' : 'bg-slate-400') }}"></div>
                            <h4 class="text-blue-950 font-bold text-lg">Status Kesiapan AI</h4>
                        </div>
                        <p class="text-blue-800/70 text-sm font-medium">{{ $message }}</p>
                    </div>
                    
                    <div class="mt-8">
                        <div class="flex justify-between text-xs font-bold text-blue-900 mb-3 uppercase tracking-widest">
                            <span>Progress Tracker</span>
                            <span class="{{ $progress == 100 ? 'text-green-600' : 'text-blue-600' }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                        
                        <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner border border-slate-200">
                            <div class="h-full {{ $barColor }} transition-all duration-1000 ease-in-out {{ $isPulsing ? 'relative overflow-hidden' : '' }}" 
                                style="width: {{ $progress }}%;">
                                @if($isPulsing)
                                    <div class="absolute top-0 left-0 w-full h-full bg-white/20 animate-[shimmer_2s_infinite]"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Extra Resource Card (Edukasi PTN) --}}
                <div class="md:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/80 flex items-center justify-between group cursor-pointer hover:border-blue-400 hover:shadow-md transition-all">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl border border-blue-100 group-hover:scale-105 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            📚
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-slate-800 mb-1 group-hover:text-blue-700 transition-colors">Pusat Informasi SNBP & SNBT</h4>
                            <p class="text-slate-500 text-sm leading-relaxed">Pelajari ketetatan jurusan, portofolio yang dibutuhkan, dan rasio penerimaan berbagai PTN di Indonesia.</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex w-10 h-10 rounded-full bg-slate-50 items-center justify-center group-hover:bg-blue-50 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Shimmer Animation Keyframes untuk Progress Bar --}}
    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</x-app-layout>