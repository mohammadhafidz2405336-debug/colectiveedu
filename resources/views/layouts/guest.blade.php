<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Collective Edu') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Pola Grid Halus untuk konsistensi desain */
            .bg-grid-pattern {
                background-image: linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
                background-size: 40px 40px;
            }
        </style>
    </head>
    <body class="font-['Figtree'] text-slate-800 antialiased bg-slate-50 relative overflow-x-hidden min-h-screen bg-grid-pattern selection:bg-blue-600 selection:text-white">
        {{-- Background Effects (Blue & Indigo) --}}
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-300/30 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-indigo-300/30 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 relative z-10">
            <div>
                <a href="/" class="flex flex-col items-center gap-4 group no-underline">
                    <div class="p-3 bg-blue-50 border text-blue-600 border-blue-100 rounded-2xl shadow-lg shadow-blue-100/50 group-hover:-translate-y-1 transition-all duration-300">
                        {{-- Mengganti SVG dengan file PNG --}}
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                    <span class="text-3xl font-black tracking-tight text-slate-900">
                        Collective<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Edu</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-10 bg-white/90 backdrop-blur-xl shadow-2xl shadow-blue-900/10 rounded-[2rem] border border-white relative z-10">
                {{ $slot }}
            </div>
            
            {{-- Tagline Footer Form --}}
            <div class="mt-8 text-center relative z-10">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                    AI-Powered Campus Navigator
                </p>
            </div>
        </div>
    </body>
</html>