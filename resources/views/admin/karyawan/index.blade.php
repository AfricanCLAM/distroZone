<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Karyawan
            </h2>
            <a href="{{ route('admin.karyawan.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Karyawan
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Live Search -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6" x-data="liveSearch('{{ route('admin.karyawan.index') }}')">
            <div class="flex items-center space-x-3">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" x-model="searchQuery" @input.debounce.500ms="performSearch()"
                    placeholder="Cari berdasarkan NIK, Nama, atau No. Telp..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                <div x-show="loading" class="flex items-center text-sm text-gray-500">
                    <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Mencari...
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Ketik minimal 1 karakter untuk mencari</p>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden" id="karyawan-table-container">
            @include('admin.karyawan.partials.table', ['karyawans' => $karyawans])
        </div>
    </div>

        <script>
            function liveSearch(url) {
                return {
                    searchQuery: '',
                    loading: false,

                    async performSearch() {
                        this.loading = true;

                        try {
                            const params = new URLSearchParams();
                            if (this.searchQuery) {
                                params.append('search', this.searchQuery);
                            }

                            const response = await fetch(`${url}?${params.toString()}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'text/html'
                                }
                            });

                            if (response.ok) {
                                const html = await response.text();
                                document.getElementById('karyawan-table-container').innerHTML = html;
                            }
                        } catch (error) {
                            console.error('Search error:', error);
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        </script>
</x-app-layout>
