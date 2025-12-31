<nav x-data="{ mobileMenuOpen: false }"
    class="fixed top-0 left-0 w-full z-50 bg-background-dark border-b-[3px] border-black text-white mb-2">

    <div class="max-w-[1440px] mx-auto px-4 md:px-10 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center gap-2">
           <img src="{{ asset('favicon/android-chrome-512x512.png') }}" alt="Icon" height="30" width="30">
            <h1 class="text-2xl font-black tracking-tighter uppercase">
                DistroZone
            </h1>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.karyawan.index') }}"
                    class="nav-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">
                    Karyawan
                </a>
                <a href="{{ route('admin.kaos.index') }}"
                    class="nav-link {{ request()->routeIs('admin.kaos.*') ? 'active' : '' }}">
                    Kaos
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                    class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    Laporan
                </a>
            @elseif(Auth::user()->isKasirOnline())
                <a href="{{ route('kasir.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('kasir.transaksi.index') }}" class="nav-link">Transaksi</a>
                <a href="{{ route('kasir.history') }}" class="nav-link">Riwayat</a>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">

            <!-- User Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center gap-3 hover:bg-white/10 px-3 py-2 rounded-lg transition">
                    <div class="flex flex-col items-end text-right">
                        <span class="text-sm font-bold">{{ Auth::user()->nama }}</span>
                        <span class="text-xs text-white/60 uppercase">{{ Auth::user()->role }}</span>
                    </div>

                    <div class="size-9 rounded-full border-2 border-black overflow-hidden bg-primary flex items-center justify-center">
                        @if(Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="font-black text-white">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-3 w-56 bg-white text-background-dark
                           border-2 border-black rounded-lg shadow-retro z-50"
                    style="display: none;">
                    <div class="px-4 py-3 border-b-2 border-black/10">
                        <p class="text-sm font-bold">{{ Auth::user()->nama }}</p>
                        <p class="text-xs text-gray-500 uppercase">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 font-bold hover:bg-primary hover:text-white transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Button -->
            <button @click="mobileMenuOpen = true"
                class="md:hidden size-10 rounded-lg border-2 border-black flex items-center justify-center hover:bg-white/10 transition">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>

    <!-- MOBILE OVERLAY -->
    <div x-show="mobileMenuOpen"
        class="fixed inset-0 bg-black/40 z-40"
        @click="mobileMenuOpen = false"
        style="display: none;">
    </div>

    <!-- MOBILE SIDEBAR -->
    <aside x-show="mobileMenuOpen"
        class="fixed top-0 left-0 h-full w-72 bg-background-dark
               border-r-[3px] border-black z-50
               p-6 flex flex-col gap-6"
        style="display: none;">

        <div class="flex items-center gap-2 mb-4">
            <img src="{{ asset('favicon/android-chrome-512x512.png') }}" alt="Icon" height="30" width="30">
            <h2 class="font-black uppercase">Menu</h2>
        </div>

        <nav class="flex flex-col gap-4 font-bold uppercase text-sm ">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.karyawan.index') }}">Karyawan</a>
                <a href="{{ route('admin.kaos.index') }}">Kaos</a>
                <a href="{{ route('admin.laporan.index') }}">Laporan</a>
            @elseif(Auth::user()->isKasirOnline())
                <a href="{{ route('kasir.dashboard') }}">Dashboard</a>
                <a href="{{ route('kasir.transaksi.index') }}">Transaksi</a>
                <a href="{{ route('kasir.history') }}">Riwayat</a>
            @endif
        </nav>

        <div class="mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full bg-primary text-white py-3 font-black
                           border-2 border-black rounded-lg shadow-retro
                           hover:translate-x-[2px] hover:translate-y-[2px]
                           hover:shadow-none transition-all">
                    Logout
                </button>
            </form>
        </div>
    </aside>
</nav>

<style>
    .nav-link {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.2s;
    }
    .nav-link:hover,
    .nav-link.active {
        color: #c95b13;
    }
</style>
