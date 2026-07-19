<div class="relative">
    {{-- Pesan Sukses (Flash Message) --}}
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-2 border-emerald-200 text-emerald-700 rounded-2xl font-bold flex justify-between items-center animate-fade-in-up">
            <span>✅ {{ session('success') }}</span>
            <button wire:click="$set('search', search)" class="text-emerald-500 hover:text-emerald-800">✕</button>
        </div>
    @endif

    {{-- BARIS PENCARIAN & FILTER --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="relative w-full sm:w-1/2">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">🔍</span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau NISN siswa..." 
                class="w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-indigo-600 focus:ring-0 text-slate-700 bg-slate-50 transition">
        </div>
        
        <div class="w-full sm:w-1/4">
            <select wire:model.live="kelasFilter" class="w-full py-3 border-2 border-slate-200 rounded-2xl focus:border-indigo-600 focus:ring-0 text-slate-700 bg-slate-50 transition cursor-pointer font-bold">
                <option value="">Semua Kelas</option>
                @foreach($daftarKelas as $kelas)
                    <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="overflow-x-auto rounded-2xl border border-slate-200">
        <table class="w-full text-left text-sm text-slate-600 whitespace-nowrap">
            <thead class="bg-slate-50 text-slate-700 font-bold uppercase text-[10px] tracking-widest border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Nama Siswa</th>
                    <th class="px-6 py-4 text-center">NISN (Username)</th>
                    <th class="px-6 py-4 text-center">L/P</th>
                    <th class="px-6 py-4 text-center">Kelas</th>
                    <th class="px-6 py-4 text-right">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($students as $siswa)
                    <tr class="hover:bg-slate-50 transition duration-150 group">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800">{{ $siswa->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-center font-mono text-slate-500">
                            {{ $siswa->nisn }}
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-slate-700">
                            @if($siswa->gender == 'Laki-laki') 
                                <span title="Laki-laki">L</span>
                            @elseif($siswa->gender == 'Perempuan') 
                                <span title="Perempuan">P</span>
                            @else 
                                - 
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-black uppercase tracking-wider border border-slate-200">
                                {{ $siswa->kelas ?? 'BELUM ADA' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="openEditModal({{ $siswa->id }})" class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition border border-blue-100 hover:border-blue-600">Edit</button>
                            <button wire:click="openResetModal({{ $siswa->id }})" class="px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition border border-amber-100 hover:border-amber-500">Reset PW</button>
                            <button wire:click="openDeleteModal({{ $siswa->id }})" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition border border-rose-100 hover:border-rose-600">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="text-4xl mb-2">🤷‍♂️</div>
                            <p class="font-bold">Tidak ada data siswa ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $students->links() }}
    </div>

    {{-- ============================== --}}
    {{-- MODAL SECTION (HIDDEN BY DEFAULT) --}}
    {{-- ============================== --}}

    {{-- 1. MODAL EDIT SISWA --}}
    @if($isEditModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-black text-slate-800">Edit Data Siswa</h3>
                <button wire:click="closeModals" class="text-slate-400 hover:text-rose-500 font-bold text-xl">✕</button>
            </div>
            <div class="p-8 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-500 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="editName" class="w-full rounded-xl border-slate-200 focus:border-indigo-600 bg-slate-50">
                    @error('editName') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-500 mb-1">NISN (Username)</label>
                    <input type="text" wire:model="editNisn" class="w-full rounded-xl border-slate-200 focus:border-indigo-600 bg-slate-50 font-mono">
                    @error('editNisn') <span class="text-rose-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-1">Jenis Kelamin</label>
                        <select wire:model="editGender" class="w-full rounded-xl border-slate-200 focus:border-indigo-600 bg-slate-50">
                            <option value="">Pilih...</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-500 mb-1">Kelas</label>
                        <input type="text" wire:model="editKelas" placeholder="Misal: 9A" class="w-full rounded-xl border-slate-200 focus:border-indigo-600 bg-slate-50 uppercase">
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button wire:click="closeModals" class="px-5 py-2.5 text-slate-500 font-bold hover:bg-slate-200 rounded-xl transition">Batal</button>
                <button wire:click="updateStudent" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-md shadow-indigo-200">Simpan Perubahan</button>
            </div>
        </div>
    </div>
    @endif

    {{-- 2. MODAL RESET PASSWORD --}}
    @if($isResetModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl p-8 text-center">
            <div class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">🔑</div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Reset Password?</h3>
            <p class="text-slate-500 mb-8">Password akun ini akan dikembalikan ke *default*, yaitu: <br><span class="font-mono font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded">password123</span></p>
            <div class="flex justify-center gap-3">
                <button wire:click="closeModals" class="px-6 py-3 text-slate-500 font-bold hover:bg-slate-100 rounded-xl transition w-full">Batal</button>
                <button wire:click="resetPassword" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition shadow-md shadow-amber-200 w-full">Ya, Reset</button>
            </div>
        </div>
    </div>
    @endif

    {{-- 3. MODAL KONFIRMASI HAPUS --}}
    @if($isDeleteModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm animate-fade-in">
        <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl p-8 text-center border-4 border-rose-100">
            <div class="w-20 h-20 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 animate-bounce">⚠️</div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Siswa Ini?</h3>
            <p class="text-slate-500 mb-8">Data ini akan dihapus secara permanen. Semua riwayat tes dan hasil AI yang terhubung dengan akun ini juga akan ikut terhapus.</p>
            <div class="flex justify-center gap-3">
                <button wire:click="closeModals" class="px-6 py-3 text-slate-500 font-bold hover:bg-slate-100 rounded-xl transition w-full">Batal</button>
                <button wire:click="deleteStudent" class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl transition shadow-md shadow-rose-200 w-full">Ya, Hapus!</button>
            </div>
        </div>
    </div>
    @endif

</div>