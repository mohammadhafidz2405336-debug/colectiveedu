<div class="animate-fade-in-up">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">Aspek 3: Prestasi & Pengalaman</h2>
        <p class="text-slate-500 mt-2">Punya sertifikat juara atau pengalaman organisasi? Masukkan di sini agar AI tahu kelebihanmu di luar kelas.</p>
    </div>

    <div class="space-y-6">
        
        {{-- TAMBAHKAN CHECKBOX OPSI TIDAK ADA PRESTASI DI SINI --}}
        <label class="flex items-center gap-3 p-4 bg-white border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-indigo-600 transition-colors {{ $has_no_achievements ? 'border-indigo-600 bg-indigo-50' : '' }}">
            <input type="checkbox" wire:model.live="has_no_achievements" class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <span class="font-bold text-slate-700">Saya belum memiliki sertifikat prestasi atau pengalaman organisasi</span>
        </label>

        {{-- Sembunyikan form jika checkbox dicentang menggunakan @if --}}
        @if(!$has_no_achievements)
        
        {{-- PRESTASI 1 --}}
        <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-sm transition-all duration-300">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600 text-sm">1</span>
                Prestasi Paling Berkesan (Utama)
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kompetisi/Kegiatan</label>
                    <input type="text" wire:model="achievements.primary.name" placeholder="Contoh: Juara 1 Lomba Desain Poster" 
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0 transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tingkat</label>
                        <select wire:model="achievements.primary.level" class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0">
                            <option value="">Pilih Tingkat...</option>
                            <option value="Sekolah">Sekolah</option>
                            <option value="Kecamatan/Kabupaten">Kabupaten</option>
                            <option value="Provinsi">Provinsi</option>
                            <option value="Nasional">Nasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis</label>
                        <select wire:model="achievements.primary.type" class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0">
                            <option value="">Pilih Jenis...</option>
                            <option value="Akademik">Akademik (Sains/Sastra)</option>
                            <option value="Non-Akademik">Non-Akademik (Olahraga/Seni)</option>
                            <option value="Organisasi">Organisasi (OSIS/Pramuka)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRESTASI 2 --}}
        <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-sm transition-all duration-300">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600 text-sm">2</span>
                Prestasi Pendukung Lainnya (Opsional)
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kompetisi/Kegiatan</label>
                    <input type="text" wire:model="achievements.secondary.name" placeholder="Contoh: Anggota Aktif Ekstrakurikuler Robotik" 
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0 transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tingkat</label>
                        <select wire:model="achievements.secondary.level" class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0">
                            <option value="">Pilih Tingkat...</option>
                            <option value="Sekolah">Sekolah</option>
                            <option value="Kecamatan/Kabupaten">Kabupaten</option>
                            <option value="Provinsi">Provinsi</option>
                            <option value="Nasional">Nasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis</label>
                        <select wire:model="achievements.secondary.type" class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-0">
                            <option value="">Pilih Jenis...</option>
                            <option value="Akademik">Akademik (Sains/Sastra)</option>
                            <option value="Non-Akademik">Non-Akademik (Olahraga/Seni)</option>
                            <option value="Organisasi">Organisasi (OSIS/Pramuka)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="p-6 bg-slate-50 border border-dashed border-slate-300 rounded-3xl">
            <p class="text-center text-slate-500 text-sm italic">
                Tips: Prestasi di bidang Futsal atau Anime (seperti desain/fanart) juga sangat berguna untuk menentukan minat bakatmu!
            </p>
        </div>
    </div>
</div>