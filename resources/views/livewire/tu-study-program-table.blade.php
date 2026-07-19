<div>
    {{-- Notifikasi --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 font-bold">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 font-bold">{{ session('error') }}</div>
    @endif

    {{-- Header & Upload Form --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 bg-slate-50 p-6 rounded-2xl border border-slate-200">
        <div class="w-full md:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Cari nama jurusan..." class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500">
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            {{-- Tombol Export / Download Template --}}
            <button wire:click="exportExcel" type="button" class="px-5 py-2 bg-blue-600 text-white rounded-xl font-bold shadow-sm hover:bg-blue-700 transition whitespace-nowrap">
                📤 Download Data / Template
            </button>

            {{-- Form Import --}}
            <form wire:submit.prevent="importExcel" class="flex items-center gap-3 w-full md:w-auto">
                <input type="file" wire:model="file" class="block w-full md:w-48 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" required>
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white rounded-xl font-bold shadow-sm hover:bg-emerald-700 transition whitespace-nowrap">
                    📥 Import Excel
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data Jurusan --}}
    <div class="overflow-x-auto border border-slate-200 rounded-2xl">
        <table class="w-full text-left text-sm text-slate-700 whitespace-nowrap">
            <thead class="bg-slate-800 text-white font-bold">
                <tr>
                    <th class="px-4 py-3">Nama Jurusan</th>
                    <th class="px-4 py-3 text-center">Rumpun</th>
                    <th class="px-4 py-3 text-center">Daya Tampung<br><span class="text-xs font-normal text-slate-300">(SNBP / SNBT)</span></th>
                    <th class="px-4 py-3 text-center">Peminat Lanjut<br><span class="text-xs font-normal text-slate-300">(SNBP / SNBT)</span></th>
                    <th class="px-4 py-3 text-center">Portofolio</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($programs as $program)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-bold text-slate-800">{{ $program->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-md text-xs font-bold 
                                {{ $program->cluster == 'SAINTEK' ? 'bg-blue-100 text-blue-700' : ($program->cluster == 'SOSHUM' ? 'bg-orange-100 text-orange-700' : 'bg-purple-100 text-purple-700') }}">
                                {{ $program->cluster }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center font-mono">{{ $program->snbp_capacity }} / {{ $program->snbt_capacity }}</td>
                        <td class="px-4 py-3 text-center font-mono text-slate-500">{{ $program->snbp_applicants }} / {{ $program->snbt_applicants }}</td>
                        <td class="px-4 py-3 text-center">
                            {!! $program->requires_portfolio ? '<span class="text-amber-500 font-bold">Ya</span>' : '<span class="text-slate-400">Tidak</span>' !!}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="delete({{ $program->id }})" class="text-red-500 hover:text-red-700 font-bold transition" onclick="return confirm('Hapus jurusan ini?')">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada jurusan. Silakan upload file Excel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $programs->links() }}</div>
</div>