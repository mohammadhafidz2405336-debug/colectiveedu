<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-slate-900">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 mt-2">Daftar untuk memulai analisis kampus impianmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Input Nama Lengkap --}}
        <div>
            <x-input-label for="name" value="{{ __('Nama Lengkap') }}" class="text-slate-700 font-bold" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Input Username (Manual Input) --}}
        <div>
            <x-input-label for="username" value="{{ __('Username') }}" class="text-slate-700 font-bold" />
            <div class="mt-1 relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                {{-- Dibuat agar bisa diisi manual oleh siswa --}}
                <x-text-input id="username" class="block w-full pl-10 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Buat username (tanpa spasi)" />
            </div>
            <p class="mt-2 text-xs text-slate-500 font-medium">
                Username harus unik. Jika sudah digunakan, sistem akan meminta Anda menggantinya.
            </p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        {{-- Input Jenis Kelamin --}}
        <div class="mt-4">
            <x-input-label for="gender" value="{{ __('Jenis Kelamin') }}" class="text-slate-700 font-bold" />
            <select id="gender" name="gender" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-slate-700 transition-colors" required>
                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        {{-- Input Kelas (Disesuaikan untuk persiapan PTN) --}}
        <div class="mt-4">
            <x-input-label for="kelas" value="{{ __('Kelas / Status') }}" class="text-slate-700 font-bold" />
            <select id="kelas" name="kelas" required class="block mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-slate-700 transition-colors">
                <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>-- Pilih Kelas --</option>
                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                <option value="Alumni" {{ old('kelas') == 'Alumni' ? 'selected' : '' }}>Alumni / Gap Year</option>
            </select>
        </div>

        {{-- Input Kata Sandi --}}
        <div>
            <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="text-slate-700 font-bold" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Input Konfirmasi Kata Sandi --}}
        <div>
            <x-input-label for="password_confirmation" value="{{ __('Konfirmasi Sandi') }}" class="text-slate-700 font-bold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi di atas" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Tombol Daftar --}}
        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-lg shadow-blue-200 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                Daftar Sekarang
            </button>
        </div>

        {{-- Link Login --}}
        <div class="mt-6 text-center text-sm font-medium text-slate-500">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors">Masuk di sini</a>
        </div>

        {{-- Link Guru/Konselor --}}
        <div class="mt-6 pt-4 border-t border-slate-200/60 text-center">
            <p class="text-sm font-medium text-slate-500">Anda adalah Konselor/Guru BK? 
                <a href="{{ route('register.guru') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>