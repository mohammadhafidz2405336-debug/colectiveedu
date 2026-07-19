<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-black text-slate-900">Selamat Datang Kembali!</h2>
        <p class="text-sm text-slate-500 mt-2">Silakan masuk untuk melanjutkan analisis kampus impianmu.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Input Username --}}
        <div>
            <x-input-label for="username" value="{{ __('username') }}" class="text-slate-700 font-bold" />
            <x-text-input id="username" class="block mt-1 w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Masukkan username kamu" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        {{-- Input Password dengan Fitur Show/Hide --}}
        <div>
            <div class="flex justify-between items-center mt-1">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="text-slate-700 font-bold" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            
            {{-- Wrapper untuk menempatkan Ikon di dalam Input --}}
            <div class="relative mt-1">
                <x-text-input id="password" 
                    class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors pr-12" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    placeholder="••••••••" />
                
                {{-- Tombol Toggle Password --}}
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.976 9.976 0 012.146-3.574M9.933 4.817A10.017 10.017 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-4.22-4.22l-4.56-4.56m4.56 4.56a4.839 4.839 0 01-1.033 1.033M12 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm font-medium text-slate-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-lg shadow-blue-200 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                Masuk ke Sistem
            </button>
        </div>

        <div class="mt-6 text-center text-sm font-medium text-slate-500">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors">Daftar sekarang</a>
        </div>
    </form>

    {{-- Script untuk Toggle Visibility --}}
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>