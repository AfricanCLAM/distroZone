<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kaos Baru
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.kaos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Merek -->
                    <div>
                        <label for="merek" class="block text-sm font-medium text-gray-700 mb-2">Merek / Brand</label>
                        <input type="text" name="merek" id="merek" value="{{ old('merek') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('merek') border-red-500 @enderror"
                            placeholder="Contoh: Nike, Adidas, Local Brand">
                        @error('merek')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipe -->
                    <div>
                        <label for="tipe" class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                        <select name="tipe" id="tipe" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('tipe') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="Lengan Panjang" {{ old('tipe') === 'Lengan Panjang' ? 'selected' : '' }}>Lengan
                                Panjang</option>
                            <option value="Lengan Pendek" {{ old('tipe') === 'Lengan Pendek' ? 'selected' : '' }}>Lengan
                                Pendek</option>
                        </select>
                        @error('tipe')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Warna -->
                    <div>
                        <label for="warna_kaos" class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <input type="text" name="warna_kaos" id="warna_kaos" value="{{ old('warna_kaos') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('warna_kaos') border-red-500 @enderror"
                            placeholder="Contoh: Hitam, Putih, Merah">
                        @error('warna_kaos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ukuran -->
                    <div>
                        <label for="ukuran" class="block text-sm font-medium text-gray-700 mb-2">Ukuran</label>
                        <select name="ukuran" id="ukuran" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('ukuran') border-red-500 @enderror">
                            <option value="">Pilih Ukuran</option>
                            @foreach(['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'] as $size)
                                <option value="{{ $size }}" {{ old('ukuran') === $size ? 'selected' : '' }}>{{ $size }}
                                </option>
                            @endforeach
                        </select>
                        @error('ukuran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Pokok -->
                    <div>
                        <label for="harga_pokok" class="block text-sm font-medium text-gray-700 mb-2">Harga Pokok
                            (Modal)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="harga_pokok" id="harga_pokok" value="{{ old('harga_pokok') }}"
                                required min="0"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('harga_pokok') border-red-500 @enderror"
                                placeholder="50000">
                        </div>
                        @error('harga_pokok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">Harga Jual</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}"
                                required min="0"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('harga_jual') border-red-500 @enderror"
                                placeholder="75000">
                        </div>
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok_kaos" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                        <input type="number" name="stok_kaos" id="stok_kaos" value="{{ old('stok_kaos', 0) }}" required
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('stok_kaos') border-red-500 @enderror"
                            placeholder="100">
                        @error('stok_kaos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Foto -->
                <div class="mt-6">
                    <label for="foto_kaos" class="block text-sm font-medium text-gray-700 mb-2">Foto Produk
                        (opsional)</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="foto_kaos" id="foto_kaos" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                onchange="previewImage(event)">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Max: 2MB</p>
                        </div>
                        <div id="preview-container" class="hidden">
                            <img id="preview" class="h-24 w-24 object-cover rounded-lg border-2 border-gray-300">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('admin.kaos.index') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(event) {
                const preview = document.getElementById('preview');
                const previewContainer = document.getElementById('preview-container');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
</x-app-layout>
