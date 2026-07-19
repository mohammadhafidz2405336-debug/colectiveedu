<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-extrabold text-slate-900">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 mt-2">Daftar menggunakan NIP Anda untuk memulai.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="{{ __('Nama Lengkap') }}" class="text-slate-700 font-bold" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai ijazah" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="nip" value="{{ __('NIP') }}" class="text-slate-700 font-bold" />
            <x-text-input id="nip" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" type="text" name="nip" :value="old('nip')" required autocomplete="username" placeholder="Masukkan NIP Anda" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
            <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="text-slate-700 font-bold" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="{{ __('Konfirmasi Sandi') }}" class="text-slate-700 font-bold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi di atas" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-lg shadow-indigo-200 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                Daftar Sekarang
            </button>
        </div>

        <div class="mt-6 text-center text-sm text-slate-500">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800">Masuk di sini</a>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">Anda adalah siswa? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-900">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>