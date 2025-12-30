<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>DistroZone - Gaya Jalanan Masa Kini</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="{{ asset('js/alpine.js') }}"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;700;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#c95b13",
                        "background-light": "#f8f7f6",
                        "background-dark": "#211711",
                        "cream-accent": "#f3ece7",
                        "retro-border": "#1b130e",
                        "retro-cream": "#f3ece7",
                        "retro-surface": "#f3ece7",
                    },
                    fontFamily: {
                        "display": ["Work Sans", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                    boxShadow: {
                        'retro': '4px 4px 0px 0px rgba(33, 23, 17, 1)',
                        'retro-lg': '6px 6px 0px 0px rgba(33, 23, 17, 1)',
                        'retro-sm': '2px 2px 0px 0px rgba(33, 23, 17, 1)',
                    }
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Work Sans', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-background-light text-background-dark overflow-x-hidden font-display">
    <!-- Fixed Top Navigation Bar -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-background-dark border-b-2 border-black text-white">
        <div class="max-w-[1440px] mx-auto px-4 md:px-10 py-4 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('favicon/android-chrome-512x512.png') }}" alt="Icon" height="40" width="40">
                <h1 class="text-2xl font-black tracking-tighter uppercase"><a href="{{ route('welcome') }}">Distrozone</a></h1>
            </div>
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a class="text-sm font-bold uppercase tracking-wide hover:text-primary transition-colors"
                    href="{{ route('welcome') }}">Beranda</a>
                <a class="text-sm font-bold uppercase tracking-wide hover:text-primary transition-colors"
                    href="{{ route('customer.catalog') }}">Katalog</a>
            </div>
            <!-- Actions -->
            <div class="flex items-center gap-4">
                <button
                    class="relative flex items-center justify-center size-10 rounded-lg hover:bg-white/10 transition-colors group">
                    <a href="{{ route('customer.cart') }}"
                        class="material-symbols-outlined group-hover:text-primary transition-colors">shopping_cart</a>
                    @php
                        $cart = Session::get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px]
                                   px-1 flex items-center justify-center
                                   text-[10px] font-bold
                                   bg-primary text-white
                                   rounded-full border border-background-dark">{{ $cartCount }}</span>
                    @endif
                </button>
                @auth
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('kasir.dashboard') }}">
                        <span
                            class="h-14 px-8 py-3 bg-cream-accent text-background-dark font-bold uppercase tracking-wider rounded-lg border-2 border-black shadow-retro hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none transition-all duration-150">
                            Dashboard
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        <span
                            class="h-14 px-8 py-3 bg-cream-accent text-background-dark font-bold uppercase tracking-wider rounded-lg border-2 border-black shadow-retro hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none transition-all duration-150">
                            Login
                        </span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Main Content Wrapper to offset fixed header -->
    <main class="pt-[72px] min-h-screen flex flex-col">
        @yield('content')

        <!-- Footer -->
        <footer class="bg-background-dark text-white py-12 px-4 md:px-10 mt-auto">
            <div class="max-w-[1440px] mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

                <!-- Brand -->
                <div class="flex flex-col gap-4">
                    <h2 class="text-2xl font-black uppercase tracking-tighter">DistroZone</h2>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                        Platform streetwear modern dengan jiwa retro. Kami menghadirkan kualitas terbaik untuk gaya
                        jalanan Anda sejak 2024.
                    </p>
                    <div class="flex gap-3 mt-2">
                        <a
                            class="size-8 rounded bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                            <span class="text-xs font-bold">IG</span>
                        </a>
                        <a
                            class="size-8 rounded bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                            <span class="text-xs font-bold">TW</span>
                        </a>
                        <a
                            class="size-8 rounded bg-white/10 flex items-center justify-center hover:bg-primary transition-colors">
                            <span class="text-xs font-bold">YT</span>
                        </a>
                    </div>
                </div>

                <!-- Contact -->
                <div class="flex flex-col gap-4">
                    <h3 class="text-lg font-bold uppercase tracking-wide text-primary">Hubungi Kami</h3>
                    <div class="flex flex-col gap-3 text-sm font-medium text-gray-300">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-sm mt-0.5">location_on</span>
                            <span>Jln. Raya Pegangsaan Timur No.29H Jakarta</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">call</span>
                            <span>+62 812 3456 7890</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">mail</span>
                            <span>distroZone@gmail.com</span>
                        </div>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="flex flex-col gap-4 lg:col-span-2">
                    <h3 class="text-lg font-bold uppercase tracking-wide text-primary">Lokasi Kami</h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4902598182916!2d106.84173890000001!3d-6.1988655999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f46b2987e043%3A0xdffad804774872d1!2sJl.%20Pegangsaan%20Timur%20No.29%2C%20RT.1%2FRW.1%2C%20Pegangsaan%2C%20Kec.%20Menteng%2C%20Kota%20Jakarta%20Pusat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2010310!5e0!3m2!1sid!2sid!4v1767062750394!5m2!1sid!2sid"
                        class="w-full h-[250px] rounded-lg border-0" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="max-w-[1440px] mx-auto mt-12 pt-8 border-t border-white/10
                flex flex-col md:flex-row justify-between items-center gap-4
                text-xs text-gray-500 font-medium">
                <p>© 2025 DistroZone. All rights reserved.</p>
                <div class="flex gap-6">
                    <a class="hover:text-white" href="#">Syarat & Ketentuan</a>
                    <a class="hover:text-white" href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </footer>
    </main>
</body>
