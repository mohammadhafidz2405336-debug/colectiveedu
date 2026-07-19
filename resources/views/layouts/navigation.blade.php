<nav x-data="{ open: false }" class="fixed top-0 w-full z-[100] backdrop-blur-xl bg-white/80 border-b border-slate-200/60 transition-all duration-300">
    @php
        // Default rute jika belum login diarahkan ke halaman utama
        $dashboardRoute = url('/'); 
        
        // Pengecekan HANYA dilakukan jika ada user yang login
        if(Auth::check()) {
            $dashboardRoute = route('dashboard');
            if(Auth::user()->role === 'guru_bk') $dashboardRoute = route('bk.dashboard');
            if(Auth::user()->role === 'admin_tu') $dashboardRoute = route('tu.dashboard');
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ $dashboardRoute }}" class="flex items-center gap-3 group no-underline">
                        <div class="p-2 bg-blue-50 border text-blue-600 border-blue-100 rounded-xl shadow-md shadow-blue-50 group-hover:-translate-y-1 transition-all duration-300">
                            {{-- Ganti SVG dengan tag IMG --}}
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Kampus" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-2xl font-black tracking-tight text-slate-900 hidden sm:block">
                            Collective<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Edu</span>
                        </span>
                    </a>
                </div>

                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$dashboardRoute" :active="request()->url() === $dashboardRoute" class="font-bold text-slate-500 hover:text-blue-600 transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(!in_array(Auth::user()->role, ['guru_bk', 'admin_tu']))
                        <x-nav-link :href="route('assessment')" :active="request()->routeIs('assessment')" class="font-bold text-slate-500 hover:text-blue-600 transition-colors">
                            {{ __('Analisis PTN') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('recommendation.history')" :active="request()->routeIs('recommendation.history')" class="font-bold text-slate-500 hover:text-blue-600 transition-colors">
                            {{ __('Riwayat Analisis') }}
                        </x-nav-link>
                        <x-nav-link :href="route('kampus.index')" :active="request()->routeIs('kampus.index')" class="font-bold text-slate-500 hover:text-blue-600 transition-colors">
                            {{ __('Info Kampus') }}
                        </x-nav-link>
                    @endif
                </div>
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-slate-200/80 text-sm leading-4 font-bold rounded-full text-slate-600 bg-white/50 hover:text-blue-700 hover:bg-blue-50 hover:border-blue-200 focus:outline-none transition ease-in-out duration-300 shadow-sm hover:shadow-md">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="font-medium hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                {{ __('Profil Pengguna') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                    {{ __('Keluar Akun') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-6 text-sm font-bold">
                        <a href="{{ route('login') }}" class="text-slate-500 hover:text-blue-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2.5 rounded-full hover:shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:-translate-y-0.5 transition-all duration-300">Daftar</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:bg-blue-50 focus:text-blue-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur-xl border-b border-slate-200 absolute w-full shadow-2xl">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="$dashboardRoute" :active="request()->url() === $dashboardRoute" class="font-bold text-slate-700">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if(!in_array(Auth::user()->role, ['guru_bk', 'admin_tu']))
                    <x-responsive-nav-link :href="route('assessment')" :active="request()->routeIs('assessment')" class="font-bold text-slate-700">
                        {{ __('Analisis PTN') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('recommendation.history')" :active="request()->routeIs('recommendation.history')" class="font-bold text-slate-700">
                        {{ __('Riwayat Analisis') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('kampus.index')" :active="request()->routeIs('kampus.index')" class="font-bold text-slate-700">
                        {{ __('Info Kampus') }}
                    </x-responsive-nav-link>
                @endif
            </div>

            <div class="pt-4 pb-1 border-t border-slate-200/60">
                <div class="px-4">
                    <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-blue-600">
                        {{-- Menggunakan username alih-alih NISN karena sudah kita ubah sebelumnya --}}
                        {{ !in_array(Auth::user()->role, ['guru_bk', 'admin_tu']) ? 'ID: ' . (Auth::user()->username ?? '-') : ucwords(str_replace('_', ' ', Auth::user()->role)) }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="font-medium text-slate-600">
                        {{ __('Profil Pengguna') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="font-medium text-red-600">
                            {{ __('Keluar Akun') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-slate-200/60 px-4 flex flex-col gap-3">
                <a href="{{ route('login') }}" class="text-center font-bold text-slate-600 py-2 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-2 rounded-xl hover:shadow-lg transition-all">Daftar</a>
            </div>
        @endauth
    </div>
</nav>