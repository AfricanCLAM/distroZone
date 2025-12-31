<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DistroZone') }} — Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Configuration -->

    <style>
        /* Custom dot pattern for background */
        .bg-pattern {
            background-image: radial-gradient(#c95b13 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.1;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-ink min-h-screen flex flex-col relative overflow-x-hidden selection:bg-primary selection:text-white">

    <!-- Background Decoration -->
    <div class="absolute inset-0 bg-pattern pointer-events-none z-0"></div>
    <div
        class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-[100px] pointer-events-none z-0">
    </div>
    <div
        class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-primary/10 rounded-full blur-[80px] pointer-events-none z-0">
    </div>

    <div class="layout-container flex h-full grow flex-col justify-center items-center relative z-10 p-6">

        <!-- Main Retro Card -->
        <div
            class="w-full max-w-[480px] bg-white border-[3px] border-ink rounded-xl shadow-retro flex flex-col overflow-hidden transition-transform duration-300">

            <!-- Window Title Bar -->
            <div
                class="bg-ink text-[#f8f7f6] px-5 py-3 flex justify-between items-center border-b-[3px] border-ink select-none">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">terminal</span>
                    <span class="font-bold tracking-widest text-sm uppercase">
                        Secure Login V.1.0
                    </span>
                </div>
                <div class="flex gap-2">
                    <div class="w-3 h-3 rounded-full bg-primary border border-white/50"></div>
                    <div class="w-3 h-3 rounded-full bg-[#f8f7f6] border border-white/50"></div>
                    <div class="w-3 h-3 rounded-full bg-[#f8f7f6] border border-white/50"></div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8 flex flex-col gap-8 bg-[#fffdfa]">

                <!-- Session Status -->
                @if (session('status'))
                    <div class="bg-green-100 border-2 border-black rounded-lg p-3 text-sm font-medium shadow-retro">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Heading -->
                <div class="flex flex-col gap-2 text-center border-b-2 border-ink/10 pb-6 border-dashed">
                    <div
                        class="w-16 h-16 bg-primary text-white mx-auto rounded-lg border-2 border-ink shadow-retro mb-2 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[32px]">fingerprint</span>
                    </div>
                    <h1 class="text-ink text-4xl font-black tracking-[-0.05em] uppercase leading-none mt-2">
                        Masuk
                    </h1>
                    <p class="text-ink/70 text-sm font-medium max-w-xs mx-auto">
                        Silakan masukkan kredensial Anda untuk mengakses terminal sistem.
                    </p>
                </div>

                <!-- FORM -->
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                    @csrf

                    <!-- Username -->
                    <div class="flex flex-col gap-2 group">
                        <label class="text-ink text-sm font-bold uppercase tracking-wide flex justify-between">
                            <span>Username</span>
                        </label>
                        <div class="relative">
                            <input name="username" value="{{ old('username') }}" required autofocus
                                autocomplete="username" type="text" placeholder="ex: user_retro99"
                                class="w-full h-14 bg-background-light text-ink border-2 border-ink rounded-lg px-4 pl-12 font-medium placeholder:text-ink/40 focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#c95b13] transition-all duration-200" />
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-ink/50">
                                person
                            </span>
                        </div>
                        @error('username')
                            <p class="text-xs font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col gap-2 group">
                        <label class="text-ink text-sm font-bold uppercase tracking-wide">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" required autocomplete="current-password"
                                type="password" placeholder="••••••••"
                                class="w-full h-14 bg-background-light text-ink border-2 border-ink rounded-lg px-4 pl-12 font-medium placeholder:text-ink/40 focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#c95b13] transition-all duration-200" />
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-ink/50">
                                lock
                            </span>
                        </div>
                        @error('password')
                            <p class="text-xs font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Show Password -->
                    <label class="inline-flex items-center gap-2 cursor-pointer text-sm font-medium">
                        <input type="checkbox" onclick="togglePassword()"
                            class="rounded border-ink text-primary focus:ring-0">
                        Tampilkan Password
                    </label>

                    <!-- Submit -->
                    <button type="submit"
                        class="mt-4 flex w-full items-center justify-center rounded-lg h-14 px-5 bg-primary text-white border-2 border-ink shadow-retro hover:shadow-retro-hover hover:translate-x-[2px] hover:translate-y-[2px] active:shadow-retro-active active:translate-x-[5px] active:translate-y-[5px] transition-all duration-150 group">
                        <span class="text-lg font-black tracking-wider uppercase mr-2">
                            Masuk Sekarang
                        </span>
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">
                            arrow_forward
                        </span>
                    </button>
                </form>
            </div>

            <!-- Status Bar -->
            <div
                class="bg-[#f0ede9] border-t-[3px] border-ink px-4 py-1.5 flex justify-between items-center text-[10px] font-mono text-ink/60 uppercase">
                <span>Status: Online</span>
                <span>SECURE-CONN-256</span>
            </div>
        </div>

        <p class="mt-8 text-ink/40 text-xs font-mono">
            © {{ date('Y') }} DISTRO SYSTEM INC. ALL RIGHTS RESERVED.
        </p>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>
