<section>
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            {{ __('Informasi Akun') }}
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            {{ __("Perbarui nama lengkap, jenis kelamin, dan kelas akunmu.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Menampilkan Username / ID (Readonly - Tidak bisa diubah user) --}}
        <div>
            <x-input-label for="username" :value="__('ID Pengguna')" class="text-slate-700 font-bold" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full rounded-xl border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed" :value="old('username', $user->username)" readonly />
            <p class="text-xs text-slate-500 mt-1">ID Pengguna dibuat otomatis oleh sistem dan tidak dapat diubah.</p>
        </div>

        {{-- Input Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-bold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Input Jenis Kelamin --}}
        <div>
            <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-slate-700 font-bold" />
            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- Input Kelas --}}
        <div>
            <x-input-label for="kelas" :value="__('Kelas')" class="text-slate-700 font-bold" />
            <select id="kelas" name="kelas" required class="mt-1 block w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-slate-700">
                <option value="" disabled {{ old('kelas', $user->kelas) ? '' : 'selected' }}>-- Pilih Kelas --</option>
                <option value="10" {{ old('kelas', $user->kelas) == '10' ? 'selected' : '' }}>10</option>
                <option value="11" {{ old('kelas', $user->kelas) == '11' ? 'selected' : '' }}>11</option>
                <option value="12" {{ old('kelas', $user->kelas) == '12' ? 'selected' : '' }}>12</option>
                <!-- Tambahkan opsi kelas lainnya jika perlu -->
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('kelas')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-full shadow-md hover:bg-indigo-700 transition transform hover:-translate-y-0.5">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-semibold bg-green-50 px-3 py-1 rounded-full">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>