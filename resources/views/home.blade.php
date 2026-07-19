<x-app-layout>
    {{-- Hero Section --}}
    <section class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center px-6 pt-10">
        <div class="text-left relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 text-blue-700 font-bold text-xs mb-6 border border-blue-100 uppercase tracking-widest shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                AI-Powered PTN Navigator
            </div>
            <h1 class="text-5xl md:text-6xl md:leading-[1.15] font-black text-slate-900 mb-6 tracking-tight">
                Petakan Potensimu, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 italic">Tembus Kampus Impian.</span>
            </h1>
            <p class="text-lg text-slate-600 mb-8 max-w-lg leading-relaxed font-medium">
                Sistem analisis akademik dan rekomendasi Program Studi Perguruan Tinggi Negeri (PTN) berbasis <b>Kecerdasan Buatan</b>. Strategi cerdas untuk SNBP dan SNBT.
            </p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('assessment') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-bold hover:shadow-[0_0_30px_rgba(37,99,235,0.3)] hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 group">
                    Mulai Analisis PTN
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="#edukasi" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 hover:text-blue-600 transition-colors duration-300 flex items-center gap-2">
                    Pelajari Jalur
                </a>
            </div>
        </div>
        
        <div class="hidden lg:block relative z-10">
            {{-- Menggunakan ilustrasi berwarna biru (blue) dari Popsy yang lebih cocok untuk mahasiswa --}}
            <img src="https://illustrations.popsy.co/blue/student-going-to-school.svg" alt="University Education Illustration" class="w-full h-auto drop-shadow-[0_20px_20px_rgba(37,99,235,0.15)] hover:scale-105 transition-transform duration-700 ease-out">
        </div>
    </section>

    {{-- Edukasi Section --}}
    <section id="edukasi" class="py-24 px-6 mt-10 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">Pahami Jalur Seleksi PTN</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Ketahui perbedaan setiap jalur masuk Perguruan Tinggi Negeri agar kamu bisa menyusun strategi yang tepat bersama Collective Edu.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Card SNBP --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">SNBP</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Seleksi Nasional Berdasarkan Prestasi. Menggunakan nilai rapor semester 1-5 dan portofolio akademik/non-akademik.</p>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Tanpa Tes</span>
                </div>

                {{-- Card SNBT --}}
                <div class="bg-gradient-to-br from-blue-900 to-indigo-900 p-8 rounded-[2rem] shadow-xl border border-indigo-800 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white mb-6 border border-white/20 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">SNBT</h3>
                        <p class="text-blue-100/80 text-sm leading-relaxed mb-4">Seleksi Nasional Berdasarkan Tes. Berfokus pada penalaran matematika, literasi bahasa, dan potensi kognitif (UTBK).</p>
                        <span class="text-xs font-bold text-white bg-white/20 backdrop-blur-md px-3 py-1 rounded-full">Tes Tulis (UTBK)</span>
                    </div>
                </div>

                {{-- Card Mandiri --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Seleksi Mandiri</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Jalur masuk yang diselenggarakan secara independen oleh masing-masing PTN dengan kebijakan tes atau nilai UTBK.</p>
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Kebijakan PTN</span>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>