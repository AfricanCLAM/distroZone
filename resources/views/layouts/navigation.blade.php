<nav class="bg-white border-b border-gray-200 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route(Auth::user()->isAdmin() ? 'admin.dashboard' : (Auth::user()->isKasirOnline() ? 'kasir.dashboard' : 'customer.catalog')) }}"
                        class="text-2xl font-bold text-indigo-600">
                        DISTROZONE
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex">
                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('admin.karyawan.index')" :active="request()->routeIs('admin.karyawan.*')">
                            Karyawan
                        </x-nav-link>
                        <x-nav-link :href="route('admin.kaos.index')" :active="request()->routeIs('admin.kaos.*')">
                            Kaos
                        </x-nav-link>
                        <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">
                            Laporan
                        </x-nav-link>
                    @elseif(Auth::user()->isKasirOnline())
                        <x-nav-link :href="route('kasir.transaksi.index')"
                            :active="request()->routeIs('kasir.transaksi.*')">
                            Transaksi Pending
                        </x-nav-link>
                        <x-nav-link :href="route('kasir.history')" :active="request()->routeIs('kasir.history')">
                            Riwayat Saya
                        </x-nav-link>
                    @elseif(Auth::user()->isKasirOffline())
                        <x-nav-link :href="route('kasir-offline.dashboard')"
                            :active="request()->routeIs('kasir-offline.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('kasir-offline.history')"
                            :active="request()->routeIs('kasir-offline.history')">
                            Riwayat Saya
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Desktop User Dropdown -->
            <div class="hidden md:flex md:items-center md:ml-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition space-x-3">
                        <!-- User Photo -->
                        @if(Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->nama }}"
                                class="h-8 w-8 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center border-2 border-gray-200">
                                <span
                                    class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</span>
                            </div>
                        @endif

                        <div class="text-left">
                            <div class="font-semibold">{{ Auth::user()->nama }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->role }}</div>
                        </div>

                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50"
                        style="display: none;">

                        <div class="px-4 py-3 border-b">
                            <p class="text-xs text-gray-500">Logged in as</p>
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->nama }} -
                                {{ ucwords(Auth::user()->role) }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 z-50 md:hidden">

        <!-- Overlay -->
        <div x-show="mobileMenuOpen" x-transition.opacity class="fixed inset-0 bg-black/45"
            @click="mobileMenuOpen = false">
        </div>

        <!-- Sidebar -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition transform duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl">
            <div class="h-full flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200">
                    <span class="text-xl font-bold text-indigo-600">DISTROZONE</span>
                    <button @click="mobileMenuOpen = false"
                        class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- User Info -->
                <div class="px-4 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center space-x-3">
                        @if(Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->nama }}"
                                class="h-12 w-12 rounded-full object-cover border-2 border-indigo-200">
                        @else
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-500 flex items-center justify-center border-2 border-indigo-200">
                                <span
                                    class="text-white font-semibold text-lg">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</span>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->NIK }}</p>
                            <p class="text-xs text-indigo-600 font-medium mt-1">{{ ucwords(Auth::user()->role) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="flex-1 overflow-y-auto py-4">
                    <nav class="px-2 space-y-1">
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>

                            <a href="{{ route('admin.karyawan.index') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.karyawan.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Karyawan
                            </a>

                            <a href="{{ route('admin.kaos.index') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.kaos.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Kaos
                            </a>

                            <a href="{{ route('admin.laporan.index') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Laporan
                            </a>
                        @elseif(Auth::user()->isKasirOnline())
                            <a href="{{ route('kasir.transaksi.index') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('kasir.transaksi.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Transaksi Pending
                            </a>

                            <a href="{{ route('kasir.history') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('kasir.history') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Riwayat Saya
                            </a>
                        @elseif(Auth::user()->isKasirOffline())
                            <a href="{{ route('kasir-offline.dashboard') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('kasir-offline.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>

                            <a href="{{ route('kasir-offline.history') }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('kasir-offline.history') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}"
                                @click="mobileMenuOpen = false">
                                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Riwayat Saya
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Logout Button -->
                <div class="border-t border-gray-200 p-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
