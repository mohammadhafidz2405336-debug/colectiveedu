<div>
    {{-- Header & Pencarian --}}
    <div class="flex justify-between items-center mb-6">
        <div class="w-1/3">
            <input type="text" wire:model.live="search" placeholder="Cari nama kampus atau lokasi..." class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <button wire:click="create" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold shadow-sm hover:bg-blue-700 transition">
            + Tambah Kampus
        </button>
    </div>

    {{-- Pesan Sukses --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="overflow-x-auto border border-slate-200 rounded-2xl">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-600 font-bold border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Nama Perguruan Tinggi</th>
                    <th class="px-6 py-4">Singkatan</th>
                    <th class="px-6 py-4">Lokasi</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($universities as $university)
                    <tr class="hover:bg-slate-50 transition duration-150 group">
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ $university->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-bold">
                                {{ $university->short_name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $university->location ?? '-' }}
                        </td>
                        {{-- PERUBAHAN PADA KOLOM AKSI: Penambahan Tombol Jurusan --}}
                        <td class="px-6 py-4 text-right space-x-2 flex justify-end gap-2 items-center">
                            <a href="{{ route('tu.kampus.jurusan', $university->id) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-lg font-bold transition text-xs flex items-center shadow-sm">
                                🎓 Daftar Jurusan
                            </a>
                            <button wire:click="edit({{ $university->id }})" class="text-amber-500 hover:text-amber-700 font-bold transition text-sm">Edit</button>
                            <button wire:click="openDeleteModal({{ $university->id }})" class="text-red-500 hover:text-red-700 font-bold transition text-sm">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data kampus yang ditambahkan atau tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $universities->links() }}
    </div>

    {{-- Modal Tambah / Edit --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-[2rem] p-8 w-full max-w-lg shadow-xl">
                <h3 class="text-xl font-black text-slate-800 mb-6">{{ $isEditMode ? 'Edit Data Kampus' : 'Tambah Kampus Baru' }}</h3>
                
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nama Perguruan Tinggi</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: UNIVERSITAS INDONESIA">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Singkatan Kampus</label>
                        <input type="text" wire:model="short_name" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: UI">
                        @error('short_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Lokasi (Kota, Provinsi)</label>
                        <input type="text" wire:model="location" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Depok, Jawa Barat">
                        @error('location') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" wire:click="closeModal" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Hapus --}}
    @if($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-[2rem] p-8 w-full max-w-md shadow-xl text-center">
                <div class="w-20 h-20 bg-red-100 text-red-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">⚠️</div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Hapus Kampus Ini?</h3>
                <p class="text-slate-500 mb-6">Tindakan ini tidak bisa dibatalkan. Menghapus kampus ini juga akan menghapus seluruh data program studi yang terkait dengannya.</p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeModal" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button wire:click="delete" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition">Ya, Hapus</button>
                </div>
            </div>
        </div>
    @endif
</div>