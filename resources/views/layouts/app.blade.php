<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DistroZone') }} - @yield('title', 'Dashboard')</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="{{ asset('js/alpine.js') }}"></script>

    <!-- Retro Utilities -->
    <style>
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f3ece7;
            border-left: 2px solid #211711;
        }

        ::-webkit-scrollbar-thumb {
            background: #c95b13;
            border: 2px solid #211711;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0460b;
        }

        .retro-card {
            border: 2px solid #211711;
            box-shadow: 4px 4px 0px 0px #211711;
        }

        .retro-input:focus {
            outline: none;
            box-shadow: 4px 4px 0px 0px #c95b13;
            border-color: #c95b13;
        }

        /* Custom Utilities for Retro Feel */
        .retro-card {
            border: 2px solid #1b130e;
            box-shadow: 4px 4px 0px 0px #1b130e;
        }

        .retro-input {
            border: 2px solid #1b130e;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .retro-input:focus {
            outline: none;
            border-color: #c95b13;
            box-shadow: 2px 2px 0px 0px #c95b13;
        }

        .retro-btn-primary {
            background-color: #c95b13;
            color: white;
            border: 2px solid #1b130e;
            box-shadow: 4px 4px 0px 0px #1b130e;
            transition: all 0.15s ease;
        }

        .retro-btn-primary:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #1b130e;
        }

        .retro-btn-primary:active {
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        .retro-btn-secondary {
            background-color: #3e2c22;
            color: #f3ece7;
            border: 2px solid #1b130e;
            box-shadow: 4px 4px 0px 0px #9ca3af;
            /* Subtle shadow for dark button */
        }

        .retro-btn-secondary:hover {
            background-color: #2a1e17;
        }
    </style>
</head>

<body class="bg-background-light text-retro-border font-display overflow-hidden h-screen flex flex-col">

    <!-- Top Navigation -->
    @include('layouts.navigation')

    <!-- Page Wrapper -->
    <div class="flex-1 overflow-y-auto">
        <main class="max-w-[1440px] mx-auto px-6 py-8">

            <!-- Flash Messages -->
            @if (session('success') || session('error'))
                <div x-data="{ open: true }" x-show="open" x-transition.opacity
                    class="fixed inset-0 z-50 flex items-center justify-center">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/50" @click="open = false">
                    </div>

                    <!-- Modal -->
                    <div x-transition class="relative retro-card bg-retro-cream w-full max-w-md bg-paper px-6 py-6 mx-4">

                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-black uppercase tracking-wide">
                                {{ session('success') ? 'Berhasil' : 'Terjadi Kesalahan' }}
                            </h3>
                            <button @click="open = false" class="border-2 border-retro-border px-2 py-1
                                    hover:bg-retro-cream shadow-retro-sm
                                    active:translate-y-[1px] transition">
                                ✕
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="px-4 py-3 font-bold border-2 border-retro-border
                                {{ session('success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ session('success') ?? session('error') }}
                        </div>

                        <!-- Footer -->
                        <div class="mt-5 flex justify-end">
                            <button @click="open = false" class="h-10 px-5 bg-primary text-white font-black uppercase
                                    border-2 border-retro-border
                                    shadow-retro hover:translate-y-[-1px]
                                    active:translate-y-[1px] active:shadow-retro-sm transition">
                                Oke
                            </button>
                        </div>
                    </div>
                </div>
            @endif


            {{ $slot }}

        </main>
    </div>

</body>

</html>
