<x-app-layout>

    <!-- Page Heading & Actions -->
    <div
        class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-5 my-6 py-8  pb-8 border-b-2 border-dashed border-retro-border/20">
        <div class="flex flex-col gap-2">
            <h1
                class="text-retro-border text-4xl md:text-5xl font-black leading-none tracking-tighter uppercase">
                Daftar <span class="text-primary">Kasir</span>
            </h1>
            <p class="text-[#6b584a] font-medium">
                Kelola data kasir online & offline
            </p>
        </div>

        <a href="{{ route('admin.karyawan.create') }}"
            class="flex min-w-[220px] items-center justify-center gap-2 h-14 px-6
                   bg-primary text-white font-black uppercase tracking-wide
                   border-2 border-retro-border rounded-lg
                   shadow-retro hover:translate-y-[-2px]
                   hover:shadow-[6px_6px_0px_0px_#1b130e]
                   active:translate-y-[2px] active:shadow-retro-sm transition-all">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Kasir
        </a>
    </div>

    <!-- Search -->
    <div class="px-6 mt-6" x-data="liveSearch('{{ route('admin.karyawan.index') }}')">
        <label class="flex flex-col h-12 w-full max-w-3xl">
            <div
                class="flex w-full items-stretch rounded-lg h-full shadow-retro-sm
                       border-2 border-retro-border bg-white overflow-hidden
                       focus-within:ring-2 ring-primary ring-offset-2">
                <div class="flex items-center justify-center pl-4 text-[#6b584a]">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input
                    type="text"
                    x-model="searchQuery"
                    @input.debounce.500ms="performSearch"
                    placeholder="Cari nama, username, atau NIK kasir..."
                    class="flex-1 bg-transparent px-4 text-base font-medium
                           text-retro-border placeholder:text-[#998b80] focus:outline-none">
            </div>
        </label>
    </div>

    <!-- Table -->
    <div class="px-6 py-6" id="karyawan-table-container">
        @include('admin.karyawan.partials.table', ['karyawan' => $karyawan])
    </div>

    <script>
        function liveSearch(url) {
            return {
                searchQuery: '',
                async performSearch() {
                    const params = new URLSearchParams()
                    if (this.searchQuery) params.append('search', this.searchQuery)

                    const res = await fetch(`${url}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })

                    if (res.ok) {
                        document.getElementById('karyawan-table-container').innerHTML = await res.text()
                    }
                }
            }
        }
    </script>

</x-app-layout>
