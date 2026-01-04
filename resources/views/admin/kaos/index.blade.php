<x-app-layout>
    <!-- Page Heading & Actions -->
    <div
        class="flex flex-col md:flex-row md:items-end justify-between gap-6 px-5 my-6 py-8  pb-8 border-b-2 border-dashed border-retro-border/20">
        <div class="flex flex-col gap-2">
            <h1 class="text-retro-border text-4xl md:text-5xl font-black leading-none tracking-tighter uppercase">
                Daftar <span class="text-primary">Kaos</span>
            </h1>
            <p class="text-[#6b584a] font-medium">
                Kelola data Kaos
            </p>
        </div>

        <a href="{{ route('admin.kaos.create') }}"
            class="flex min-w-[220px] items-center justify-center gap-2 h-14 px-6
                   bg-primary text-white font-black uppercase tracking-wide
                   border-2 border-retro-border rounded-lg
                   shadow-retro hover:translate-y-[-2px]
                   hover:shadow-[6px_6px_0px_0px_#1b130e]
                   active:translate-y-[2px] active:shadow-retro-sm transition-all">
            <span class="material-symbols-outlined">add_circle</span>
            Tambah Kaos
        </a>
    </div>

    <div class="mx-auto max-w-[1440px] px-4 sm:px-8 py-8 space-y-6">

        <!-- LIVE SEARCH (RETRO) -->
        <div x-data="liveSearch('{{ route('admin.kaos.index') }}')"
            class="rounded-xl border-2 border-retro-border
                   bg-white shadow-retro p-4">

            <div class="flex flex-wrap items-center gap-3">
                <span class="material-symbols-outlined text-[22px]">
                    search
                </span>

                <input type="text" x-model="searchQuery" @input.debounce.500ms="performSearch()"
                    placeholder="Cari berdasarkan Merek, Tipe, atau Warna..."
                    class="flex-1 min-w-[220px]
                           rounded border-2 border-retro-border
                           bg-white px-4 py-2
                           font-semibold
                           focus:outline-none
                           focus:bg-[#fffdf5]">

                <div x-show="loading" class="flex items-center gap-2 text-sm font-bold">
                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    Mencari...
                </div>
            </div>

            <p class="mt-2 text-xs font-bold text-[#6b584a]">
                Ketik minimal 1 karakter untuk mencari
            </p>
        </div>

        <!-- TABLE WRAPPER (RETRO FRAME) -->
        <div id="kaos-table-container"
            class="rounded-xl border-2 border-retro-border
                   bg-white shadow-retro
                   overflow-hidden">

            @include('admin.kaos.partials.table', ['kaos' => $kaos])

        </div>
    </div>

    <script>
        function liveSearch(url) {
            return {
                searchQuery: '',
                loading: false,
                async performSearch() {
                    this.loading = true
                    try {
                        const params = new URLSearchParams()
                        if (this.searchQuery) {
                            params.append('search', this.searchQuery)
                        }

                        const response = await fetch(`${url}?${params.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            }
                        })

                        if (response.ok) {
                            document.getElementById('kaos-table-container')
                                .innerHTML = await response.text()
                        }
                    } finally {
                        this.loading = false
                    }
                }
            }
        }
    </script>
</x-app-layout>
