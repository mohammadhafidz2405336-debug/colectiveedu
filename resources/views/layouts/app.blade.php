<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Update Title Fallback -->
        <title>{{ config('app.name', 'Collective Edu') }}</title>

        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <script src="https://kit.fontawesome.com/f7091fe396.js" crossorigin="anonymous"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob { animation: blob 7s infinite; }
            .animation-delay-2000 { animation-delay: 2s; }
            
            /* Pola Grid Halus untuk kesan teknologi/data-driven */
            .bg-grid-pattern {
                background-image: linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
                background-size: 40px 40px;
            }
        </style>
    </head>
    <body class="font-['Figtree'] antialiased bg-slate-50 text-slate-800 selection:bg-blue-600 selection:text-white bg-grid-pattern">
        <div class="min-h-screen flex flex-col relative overflow-hidden">
            
            {{-- Background Effects --}}
            <div class="absolute top-0 right-0 -z-10 w-full h-full pointer-events-none overflow-hidden">
                {{-- Penyesuaian warna blob menjadi blue & indigo --}}
                <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-blue-300/20 rounded-full blur-[120px] animate-blob"></div>
                <div class="absolute bottom-[10%] left-[-5%] w-[400px] h-[400px] bg-indigo-300/20 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>
            </div>

            @include('layouts.navigation')

            @isset($header)
                <header class="pt-28 pb-6 px-6 relative z-10">
                    <div class="max-w-7xl mx-auto">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-grow {{ isset($header) ? '' : 'pt-24' }} relative z-10">
                {{ $slot }}
            </main>

            <footer class="bg-white/80 backdrop-blur-md py-12 px-6 border-t border-slate-200 mt-20 relative z-10">
                <div class="max-w-7xl mx-auto text-center flex flex-col items-center">
                    {{-- Logo Collective Edu --}}
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-blue-50 border text-blue-600 border-blue-100 rounded-xl shadow-md shadow-blue-50 group-hover:-translate-y-1 transition-all duration-300">
                            {{-- Ganti SVG dengan tag IMG --}}
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Kampus" class="w-6 h-6 object-contain">
                        </div>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">
                            Collective<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Edu</span>
                        </span>
                    </div>
                    
                    {{-- Copyright & Tagline baru --}}
                    <p class="text-slate-500 text-sm font-medium">
                        &copy; {{ date('Y') }} Collective Edu System.
                    </p>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">
                        AI-Powered Campus Navigator
                    </p>
                </div>
            </footer>
        </div>

        @livewireScripts
    </body>
</html>