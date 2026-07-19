<div class="animate-fade-in-up">
    {{-- PENUTUP ERROR: Menampilkan pesan jika database kosong --}}
    @if (session()->has('error'))
        <div class="mb-6 p-5 bg-rose-50 border-2 border-rose-200 text-rose-700 rounded-2xl font-bold text-sm flex items-start gap-3 shadow-sm">
            <span class="text-xl">⚠️</span>
            <div>
                <p class="font-black">Terjadi Masalah:</p>
                <p class="font-medium mt-0.5 text-rose-600/90 leading-relaxed">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-800">Langkah 1: Eksplorasi Minat & Bakat</h2>
        <p class="text-slate-500 mt-2 font-medium">Mari cari tahu bidang apa yang paling cocok dengan passion-mu!</p>
    </div>

    {{-- STATE 1: HALAMAN AWAL (BELUM MULAI TES) --}}
    @if (!$is_testing && !$is_completed)
        <div class="bg-white p-8 sm:p-12 rounded-[2.5rem] border-2 border-slate-100 shadow-xl shadow-violet-100/50 text-center relative overflow-hidden">
            {{-- Dekorasi Latar Belakang --}}
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-violet-50 rounded-full z-0 opacity-70"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-50 rounded-full z-0 opacity-70"></div>
            
            <div class="relative z-10">
                <div class="w-24 h-24 bg-gradient-to-br from-violet-100 to-indigo-100 text-violet-600 rounded-[2rem] flex items-center justify-center text-5xl mx-auto mb-6 transform rotate-3 shadow-inner">
                    🎯
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-4">Kenali Potensi Aslimu</h3>
                <p class="text-slate-500 font-medium max-w-md mx-auto mb-8 leading-relaxed">
                    Tes ini dirancang menggunakan metode psikologi (RIASEC) untuk melihat kecenderunganmu terhadap berbagai aktivitas dan karir. 
                    <br><span class="text-violet-600 font-bold">Tidak ada jawaban benar atau salah</span>, jawablah sejujurnya sesuai kata hatimu.
                </p>
                
                {{-- FIX: Mengubah wire:click agar memanggil fungsi startTest --}}
                <button wire:click="startTest('interest')" class="group w-full sm:w-auto inline-flex items-center justify-center gap-3 px-10 py-4 bg-violet-600 text-white font-black rounded-2xl shadow-lg shadow-violet-200 hover:bg-violet-700 hover:-translate-y-1 active:scale-95 transition-all">
                    <span>Mulai Tes Sekarang</span>
                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center group-hover:translate-x-1 transition-transform">
                        →
                    </div>
                </button>
            </div>
        </div>

    {{-- STATE 2: TAMPILAN KUIS DINAMIS --}}
    @elseif ($is_testing && !$is_completed)
        {{-- FIX: Cek jika array data soal aman dan tersedia sebelum render komponen --}}
        @if(is_array($current_questions) && count($current_questions) > 0 && isset($current_questions[$current_question_index]))
            @php $q = $current_questions[$current_question_index]; @endphp
            
            <div class="space-y-8 animate-in fade-in zoom-in duration-300 bg-white p-6 sm:p-10 rounded-[2.5rem] border-2 border-slate-100 shadow-xl shadow-violet-50/50 relative overflow-hidden">
                {{-- Dekorasi Tipis --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-violet-500 to-indigo-500"></div>

                {{-- Header Kuis & Progress Bar --}}
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pb-4">
                    <span class="inline-block px-4 py-2 bg-violet-50 text-violet-700 rounded-full text-xs font-black uppercase tracking-widest border border-violet-100">
                        Pertanyaan {{ $current_question_index + 1 }} dari {{ count($current_questions) }}
                    </span>
                    
                    <div class="flex-1 w-full sm:max-w-xs h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-violet-500 transition-all duration-500 rounded-full" 
                             style="width: {{ (($current_question_index + 1) / count($current_questions)) * 100 }}%">
                        </div>
                    </div>
                </div>

                {{-- Teks Pertanyaan --}}
                <div class="py-4 text-center sm:text-left">
                    <h3 class="text-2xl font-black text-slate-800 leading-snug">
                        "{{ $q['question_text'] }}"
                    </h3>
                    
                    @if(isset($q['image_path']) && $q['image_path'])
                        <div class="mt-8 flex justify-center p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                            <img src="{{ asset('storage/' . $q['image_path']) }}" alt="Visual Question" class="max-h-64 object-contain rounded-xl">
                        </div>
                    @endif
                </div>

                {{-- Opsi Jawaban --}}
                <div class="grid grid-cols-1 gap-3">
                    @if(isset($q['options']) && is_array($q['options']))
                        @foreach($q['options'] as $option)
                            <button wire:click="nextQuestion('{{ $option }}')" 
                                class="p-5 text-left rounded-2xl border-2 border-slate-100 hover:border-violet-500 hover:bg-violet-50 hover:shadow-md hover:shadow-violet-100 transition-all font-bold text-slate-700 flex justify-between items-center group">
                                <span class="group-hover:text-violet-800 transition-colors text-lg">{{ $option }}</span>
                                <div class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-all transform group-hover:scale-110">
                                    ✓
                                </div>
                            </button>
                        @endforeach
                    @endif
                </div>

                {{-- Tombol Navigasi Bawah (Kembali & Batal) --}}
                <div class="pt-6 mt-4 border-t border-slate-50 flex justify-between items-center">
                    
                    {{-- Tombol Sebelumnya (Hanya muncul jika bukan pertanyaan pertama) --}}
                    @if($current_question_index > 0)
                        <button wire:click="previousQuestion" class="flex items-center gap-2 text-sm text-slate-500 font-bold hover:text-indigo-600 transition-colors py-2 px-4 rounded-full hover:bg-indigo-50">
                            <span>←</span> Sebelumnya
                        </button>
                    @else
                        <div></div> {{-- Spacer kosong agar tombol batal tetap di kanan --}}
                    @endif

                    {{-- Tombol Batal --}}
                    <button wire:click="$set('is_testing', false)" class="text-xs text-slate-400 font-bold uppercase tracking-widest hover:text-rose-500 transition-colors py-2 px-4 rounded-full hover:bg-rose-50">
                        Batalkan Tes
                    </button>
                </div>
            </div>
        @else
            {{-- Fallback: Jika state testing aktif namun array kosong akibat kegagalan database --}}
            <div class="bg-rose-50 p-8 rounded-[2.5rem] border-2 border-rose-100 text-center font-bold text-rose-700">
                Gagal memproses soal kuis. Silakan muat ulang halaman atau periksa ketersediaan data pada database.
            </div>
        @endif

    {{-- STATE 3: TES SELESAI --}}
    @elseif ($is_completed)
        <div class="bg-emerald-50 p-8 sm:p-12 rounded-[2.5rem] border-2 border-emerald-200 text-center">
            <div class="w-20 h-20 bg-emerald-500 text-white rounded-[2rem] flex items-center justify-center text-4xl mx-auto mb-6 shadow-lg shadow-emerald-200">
                ✨
            </div>
            <h3 class="text-2xl font-black text-emerald-900 mb-2">Hebat! Tes Minat & Bakat Selesai</h3>
            <p class="text-emerald-700 font-medium">Data potensimu sudah terekam dengan baik. Silakan klik tombol "Simpan & Lanjut" di bawah untuk menuju ke tahap selanjutnya.</p>
        </div>
    @endif
</div>