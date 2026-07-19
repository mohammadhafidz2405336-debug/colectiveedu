<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-600">
            {{ __('Hapus Akun Permanen') }}
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            {{ __('Setelah akunmu dihapus, semua data dan hasil tes rekomendasi akan hilang selamanya. Pastikan kamu sudah yakin sebelum melakukan ini.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5 bg-red-500 text-white font-bold rounded-full shadow-md hover:bg-red-600 transition transform hover:-translate-y-0.5"
    >
        {{ __('Hapus Akun Saya') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white sm:rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-extrabold text-slate-900 mb-3">
                {{ __('Apakah kamu yakin?') }}
            </h2>

            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                {{ __('Tindakan ini tidak bisa dibatalkan. Silakan masukkan kata sandimu untuk mengonfirmasi penghapusan data secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500"
                    placeholder="{{ __('Masukkan Kata Sandi...') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2.5 text-slate-600 font-bold bg-white border-2 border-slate-200 rounded-full hover:border-slate-300 hover:bg-slate-50 transition">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-full shadow-md hover:bg-red-700 transition transform hover:-translate-y-0.5">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>