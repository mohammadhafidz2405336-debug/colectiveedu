<x-app-layout>
    <!-- Inisialisasi data global untuk pencarian dan pagination 10 data per halaman -->
    <div x-data="{ 
        search: '', 
        page: 1, 
        perPage: 10,
        universities: [
            @foreach($universities as $kampus)
            {
                id: {{ $kampus->id }},
                name: {{ json_encode(strtolower($kampus->name)) }},
                shortName: {{ json_encode(strtolower($kampus->short_name ?? '')) }},
                programs: {{ json_encode($kampus->studyPrograms->pluck('name')->map(fn($item) => strtolower($item))->toArray()) }}
            },
            @endforeach
        ],
        get filteredList() {
            return this.universities.filter(k => 
                k.name.includes(this.search.toLowerCase()) || 
                k.shortName.includes(this.search.toLowerCase()) || 
                k.programs.some(p => p.includes(this.search.toLowerCase()))
            );
        },
        get paginatedList() {
            let start = (this.page - 1) * this.perPage;
            return this.filteredList.slice(start, start + this.perPage);
        },
        get totalPages() {
            return Math.ceil(this.filteredList.length / this.perPage) || 1;
        }
    }" class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Banner Header & Kolom Cari -->
            <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-3xl font-black tracking-tight text-slate-900">
                    Eksplorasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Kampus & Jurusan</span>
                </h2>
                <p class="text-slate-500 mt-2">Cari tahu daya tampung, jumlah peminat tahun lalu, dan tingkat keketatan persaingan (persentase) untuk jalur SNBP maupun SNBT sebagai referensimu.</p>
                
                <!-- Input Pencarian Langsung -->
                <div class="mt-6 relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input 
                        type="text" 
                        x-model="search" 
                        @input="page = 1"
                        placeholder="Ketik langsung nama kampus, singkatan, atau jurusan yang dicari (contoh: Kedokteran)..." 
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all outline-none text-sm font-medium text-slate-700 placeholder-slate-400"
                    >
                </div>
            </div>

            <!-- Keterangan Jika Hasil Cari Kosong -->
            <div x-show="filteredList.length === 0" class="bg-white p-12 rounded-2xl shadow-sm border border-slate-200 text-center text-slate-500 font-medium mb-8">
                Kampus atau jurusan yang kamu cari tidak ditemukan.
            </div>

            <!-- List Kampus -->
            @foreach($universities as $kampus)
                <div 
                    x-data="{ isOpen: false }"
                    x-show="paginatedList.some(k => k.id === {{ $kampus->id }})"
                    x-effect="if(search.length > 0) { isOpen = true }"
                    class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8 transition-all duration-300"
                >
                    
                    <!-- Header Kampus (Bisa Diklik) -->
                    <div @click="isOpen = !isOpen" class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-100 flex justify-between items-center cursor-pointer select-none hover:from-blue-100/40 transition-colors duration-200">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">
                                {{ $kampus->name }} 
                                @if($kampus->short_name) 
                                    <span class="text-blue-600">({{ $kampus->short_name }})</span> 
                                @endif
                            </h3>
                            <p class="text-sm text-slate-500 flex items-center gap-1 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $kampus->location ?? 'Lokasi tidak diketahui' }}
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $kampus->studyPrograms->count() }} Jurusan
                            </div>
                            <!-- Ikon Panah/Chevron Indikator Buka Tutup -->
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Tabel Jurusan -->
                    <div x-show="isOpen" x-transition.opacity.duration.200ms class="overflow-x-auto border-t border-slate-100">
                        <table class="w-full text-sm text-left text-slate-600">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold border-b">Program Studi</th>
                                    <!-- PERUBAHAN: Mengubah header menjadi Jenjang -->
                                    <th scope="col" class="px-6 py-4 font-bold border-b">Jenjang</th>
                                    <th scope="col" class="px-6 py-3 font-bold border-b text-center bg-emerald-50/50" colspan="3">Data SNBP (Rapor)</th>
                                    <th scope="col" class="px-6 py-3 font-bold border-b text-center bg-indigo-50/50" colspan="3">Data SNBT (Tes)</th>
                                </tr>
                                <tr>
                                    <th scope="col" class="px-6 py-2 border-b"></th>
                                    <th scope="col" class="px-6 py-2 border-b"></th>
                                    <!-- Sub Header SNBP -->
                                    <th scope="col" class="px-4 py-2 font-semibold border-b text-center bg-emerald-50/30 text-xs">Daya Tampung</th>
                                    <th scope="col" class="px-4 py-2 font-semibold border-b text-center bg-emerald-50/30 text-xs">Peminat</th>
                                    <th scope="col" class="px-4 py-2 font-semibold border-b text-center bg-emerald-50/30 text-xs">Keketatan</th>
                                    <!-- Sub Header SNBT -->
                                    <th scope="col" class="px-4 py-2 font-semibold border-b text-center bg-indigo-50/30 text-xs">Daya Tampung</th>
                                    <th scope="col" class="px-4 py-2 font-semibold border-b text-center bg-indigo-50/30 text-xs">Peminat</th>
                                    <th scope="col" class="px-4 py-2 font-semibold border-b text-center bg-indigo-50/30 text-xs">Keketatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kampus->studyPrograms as $jurusan)
                                    <!-- Filter baris jurusan berdasarkan keyword pencarian -->
                                    <tr 
                                        x-show="search === '' || {{ json_encode(strtolower($jurusan->name)) }}.includes(search.toLowerCase()) || {{ json_encode(strtolower($kampus->name)) }}.includes(search.toLowerCase()) || {{ json_encode(strtolower($kampus->short_name ?? '')) }}.includes(search.toLowerCase())"
                                        class="hover:bg-slate-50/80 border-b border-slate-100 transition-colors last:border-0"
                                    >
                                        <td class="px-6 py-4 font-medium text-slate-800">
                                            {{ $jurusan->name }}
                                            @if($jurusan->requires_portfolio)
                                                <span class="block mt-1"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">Wajib Portofolio</span></span>
                                            @endif
                                        </td>
                                        
                                        <!-- PERUBAHAN: Menampilkan Jenjang dengan warna badge yang dinamis -->
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                                {{ $jurusan->jenjang === 'S1' ? 'bg-indigo-100 text-indigo-700' : (in_array($jurusan->jenjang, ['D4', 'Sarjana Terapan']) ? 'bg-teal-100 text-teal-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ $jurusan->jenjang }}
                                            </span>
                                        </td>
                                        
                                        <!-- Data SNBP -->
                                        <td class="px-4 py-4 text-center">{{ $jurusan->snbp_capacity }}</td>
                                        <td class="px-4 py-4 text-center">{{ $jurusan->snbp_applicants }}</td>
                                        <td class="px-4 py-4 text-center font-bold text-emerald-600">{{ $jurusan->snbp_tightness }}%</td>

                                        <!-- Data SNBT -->
                                        <td class="px-4 py-4 text-center">{{ $jurusan->snbt_capacity }}</td>
                                        <td class="px-4 py-4 text-center">{{ $jurusan->snbt_applicants }}</td>
                                        <td class="px-4 py-4 text-center font-bold text-indigo-600">{{ $jurusan->snbt_tightness }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-8 text-center text-slate-400 font-medium">
                                            Belum ada data jurusan untuk kampus ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            <!-- Tombol Navigasi Halaman (Pagination) -->
            <div x-show="totalPages > 1" class="mt-8 flex items-center justify-between border border-slate-200 bg-white px-6 py-4 rounded-2xl shadow-sm">
                <!-- Tampilan Mobile -->
                <div class="flex flex-1 justify-between sm:hidden">
                    <button @click="if(page > 1) { page--; window.scrollTo({top: 0, behavior: 'smooth'}); }" :disabled="page === 1" class="relative inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-40 transition-opacity">Sebelumnya</button>
                    <button @click="if(page < totalPages) { page++; window.scrollTo({top: 0, behavior: 'smooth'}); }" :disabled="page === totalPages" class="relative ml-3 inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-40 transition-opacity">Selanjutnya</button>
                </div>
                <!-- Tampilan Desktop -->
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate-600">
                            Menampilkan 
                            <span class="font-bold text-slate-800" x-text="((page - 1) * perPage) + 1"></span> 
                            sampai 
                            <span class="font-bold text-slate-800" x-text="Math.min(page * perPage, filteredList.length)"></span> 
                            dari 
                            <span class="font-bold text-slate-800" x-text="filteredList.length"></span> 
                            kampus
                        </p>
                    </div>
                    <div>
                        <nav class="inline-flex items-center space-x-2" aria-label="Pagination">
                            <!-- Button Prev -->
                            <button @click="if(page > 1) { page--; window.scrollTo({top: 0, behavior: 'smooth'}); }" :disabled="page === 1" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition disabled:opacity-40">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
                            </button>
                            
                            <!-- Keterangan Halaman -->
                            <span class="px-4 py-2 text-sm font-bold bg-slate-50 text-slate-700 border border-slate-200 rounded-lg">
                                Halaman <span x-text="page"></span> dari <span x-text="totalPages"></span>
                            </span>

                            <!-- Button Next -->
                            <button @click="if(page < totalPages) { page++; window.scrollTo({top: 0, behavior: 'smooth'}); }" :disabled="page === totalPages" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition disabled:opacity-40">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>