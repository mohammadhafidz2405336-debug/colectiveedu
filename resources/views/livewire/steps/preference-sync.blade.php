<div class="animate-fade-in-up">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">Aspek 4: Preferensi Masa Depan</h2>
        <p class="text-slate-500 mt-2">Selaraskan keinginanmu dan harapan orang tua agar AI dapat merumuskan rekomendasi jembatan karier terbaik.</p>
    </div>

    <div class="space-y-6">
        
        {{-- BLOK PILIHAN SISWA --}}
        <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.263 15.918a9 9 0 1 1 15.474 0M12 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 0v6.75M12 22.5c4.142 0 7.5-1.12 7.5-2.5s-3.358-2.5-7.5-2.5-7.5 1.12-7.5 2.5 3.358 2.5 7.5 2.5Z" />
                    </svg>
                </span>
                Pilihan Jurusan/Karier Impianmu (Siswa)
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pilihan Utama (Prioritas 1)</label>
                    <input type="text" wire:model="student_preference" placeholder="Contoh: Teknik Informatika / Sastra Inggris" 
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pilihan Alternatif (Prioritas 2)</label>
                    <input type="text" wire:model="student_preference_secondary" placeholder="Contoh: Manajemen Bisnis / Desain Komunikasi Visual" 
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0 transition">
                </div>
            </div>
        </div>

        {{-- BLOK PILIHAN ORANG TUA --}}
        <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94-3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </span>
                Harapan / Pilihan Orang Tua
            </h3>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Jurusan/Karier yang Disarankan Orang Tua</label>
                <input type="text" wire:model="parent_preference" placeholder="Contoh: Akuntansi / Kedokteran / Menyerahkan sepenuhnya ke anak" 
                    class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0 transition">
            </div>
        </div>

        {{-- BLOK CATATAN TAMBAHAN --}}
        <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-sm space-y-4">
            <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </span>
                Catatan atau Alasan Tambahan
            </h3>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Kenapa kamu memilih jurusan tersebut? Beritahu tantangan atau ceritamu disini (Opsional)</label>
                <textarea wire:model="preference_notes" rows="3" placeholder="Contoh: Ingin mengambil Teknik Informatika karena suka coding sejak SMP, tapi orang tua menyarankan Akuntansi karena prospek kerja perusahaan dinilai lebih stabil." 
                    class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0 transition resize-none"></textarea>
            </div>
        </div>
    </div>
</div>