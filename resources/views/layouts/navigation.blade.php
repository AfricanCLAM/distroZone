<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route(Auth::user()->isAdmin() ? 'admin.dashboard' : (Auth::user()->isKasirOnline() ? 'kasir.dashboard' : 'customer.catalog')) }}" class="text-2xl font-bold text-indigo-600">
                        DISTROZONE
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
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
                        <x-nav-link :href="route('admin.shift.index')" :active="request()->routeIs('admin.shift.*')">
                            Shift
                        </x-nav-link>
                    @elseif(Auth::user()->isKasirOnline())
                        <x-nav-link :href="route('kasir.transaksi.index')" :active="request()->routeIs('kasir.transaksi.*')">
                            Transaksi Pending
                        </x-nav-link>
                        <x-nav-link :href="route('kasir.history')" :active="request()->routeIs('kasir.history')">
                            Riwayat Saya
                        </x-nav-link>
                    @elseif(Auth::user()->isKasirOffline())
                        <x-nav-link :href="route('kasir-offline.dashboard')" :active="request()->routeIs('kasir-offline.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('kasir-offline.history')" :active="request()->routeIs('kasir-offline.history')">
                            Riwayat Saya
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition">
                        <span>{{ Auth::user()->nama }}</span>
                        <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                         style="display: none;">

                        <div class="px-4 py-2 border-b">
                            <p class="text-xs text-gray-500">Role</p>
                            <p class="text-sm font-semibold text-gray-800">{{ ucwords(Auth::user()->role) }}</p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
