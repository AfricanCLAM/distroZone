<x-app-layout>
    <main class="flex-grow w-full px-4 py-8 my-6 md:py-12">
        <div class="mx-auto max-w-4xl">

            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <a href="{{ route('admin.kaos.index') }}"
                        class="inline-flex items-center gap-1 text-sm font-bold uppercase tracking-widest
                          text-gray-500 hover:text-primary mb-2">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        Kembali
                    </a>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase relative inline-block">
                        Edit Kaos
                        <span class="absolute -bottom-2 left-0 h-1 w-full bg-primary"></span>
                    </h1>
                </div>

                <p class="hidden md:block text-sm font-medium text-gray-600 max-w-xs text-right">
                    Perbarui informasi produk kaos yang sudah ada.
                </p>
            </div>

            <!-- Form Card -->
            <div class="retro-card bg-[#f3ece7] p-6 md:p-10 rounded-xl">
                <form action="{{ route('admin.kaos.update', $kaos->id_kaos) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- INFORMASI KAOS -->
                    <div class="mb-10">
                        <div class="flex items-center gap-2 mb-6 border-b-2 border-black/20 pb-2">
                            <span class="material-symbols-outlined text-primary">checkroom</span>
                            <h3 class="text-xl font-bold uppercase">Informasi Kaos</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Merek -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Merek / Brand</label>
                                <input type="text" name="merek" value="{{ old('merek', $kaos->merek) }}"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                          @error('merek') border-red-500 @enderror"
                                    required>
                                @error('merek')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipe -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Tipe</label>
                                <select name="tipe"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                           @error('tipe') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="Lengan Pendek"
                                        {{ old('tipe', $kaos->tipe) == 'Lengan Pendek' ? 'selected' : '' }}>
                                        Lengan Pendek
                                    </option>
                                    <option value="Lengan Panjang"
                                        {{ old('tipe', $kaos->tipe) == 'Lengan Panjang' ? 'selected' : '' }}>
                                        Lengan Panjang
                                    </option>
                                </select>
                                @error('tipe')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Warna -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Warna</label>
                                <input type="text" name="warna_kaos"
                                    value="{{ old('warna_kaos', $kaos->warna_kaos) }}"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                          @error('warna_kaos') border-red-500 @enderror"
                                    required>
                                @error('warna_kaos')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ukuran -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Ukuran</label>
                                <select name="ukuran"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                           @error('ukuran') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Ukuran</option>
                                    @foreach (['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'] as $size)
                                        <option value="{{ $size }}"
                                            {{ old('ukuran', $kaos->ukuran) === $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ukuran')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- HARGA & STOK -->
                    <div class="mb-10">
                        <div class="flex items-center gap-2 mb-6 border-b-2 border-black/20 pb-2">
                            <span class="material-symbols-outlined text-primary">payments</span>
                            <h3 class="text-xl font-bold uppercase">Harga & Stok</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Harga Pokok -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Harga Pokok</label>
                                <input type="number" name="harga_pokok"
                                    value="{{ old('harga_pokok', $kaos->harga_pokok) }}"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                          @error('harga_pokok') border-red-500 @enderror"
                                    required>
                                @error('harga_pokok')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Jual -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Harga Jual</label>
                                <input type="number" name="harga_jual"
                                    value="{{ old('harga_jual', $kaos->harga_jual) }}"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                          @error('harga_jual') border-red-500 @enderror"
                                    required>
                                @error('harga_jual')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Stok</label>
                                <input type="number" name="stok_kaos" value="{{ old('stok_kaos', $kaos->stok_kaos) }}"
                                    class="retro-input w-full h-12 rounded-lg px-4
                                          @error('stok_kaos') border-red-500 @enderror"
                                    required>
                                @error('stok_kaos')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Foto Kaos</label>

                                @if ($kaos->foto_kaos)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $kaos->foto_kaos) }}"
                                            class="h-24 w-24 rounded-lg border-2 border-retro-border object-cover">
                                        <p class="text-xs text-gray-600 mt-1">
                                            Kosongkan jika tidak ingin mengganti foto
                                        </p>
                                    </div>
                                @endif

                                <input type="file" name="foto_kaos"
                                    class="retro-input w-full h-12 rounded-lg px-4 bg-white">
                            </div>

                        </div>
                    </div>

                    <!-- ACTION -->
                    <div
                        class="flex flex-col-reverse sm:flex-row justify-end gap-4
                            border-t-2 border-black/10 pt-8">
                        <a href="{{ route('admin.kaos.index') }}"
                            class="px-8 h-12 flex items-center justify-center
                              border-2 border-black font-bold uppercase rounded-lg">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-10 h-12 retro-card bg-primary text-white
                                   font-bold uppercase flex items-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>


    @push('scripts')
        <script>
            function previewImage(event) {
                const preview = document.getElementById('preview');
                const previewContainer = document.getElementById('preview-container');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
</x-app-layout>
