<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Karyawan: {{ $karyawan->nama }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- NIK -->
                <div class="mb-4">
                    <label for="NIK" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="NIK" id="NIK" value="{{ old('NIK', $karyawan->NIK) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('NIK') border-red-500 @enderror">
                    @error('NIK')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $karyawan->nama) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $karyawan->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telp -->
                <div class="mb-4">
                    <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $karyawan->no_telp) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('no_telp') border-red-500 @enderror">
                    @error('no_telp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" id="role" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('role') border-red-500 @enderror">
                        <option value="">Pilih Role</option>
                        <option value="kasir online" {{ old('role', $karyawan->role) === 'kasir online' ? 'selected' : '' }}>
                            Kasir Online
                        </option>
                        <option value="kasir offline" {{ old('role', $karyawan->role) === 'kasir offline' ? 'selected' : '' }}>
                            Kasir Offline
                        </option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (Optional) -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password baru (opsional)">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah password</p>
                </div>

                <!-- Shift Start -->
                <div class="mb-4">
                    <label for="shift_start" class="block text-sm font-medium text-gray-700 mb-2">Shift Mulai (opsional)</label>
                    <input type="time" name="shift_start" id="shift_start"
                        value="{{ old('shift_start', $karyawan->shift_start ? $karyawan->shift_start->format('H:i') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Shift End -->
                <div class="mb-4">
                    <label for="shift_end" class="block text-sm font-medium text-gray-700 mb-2">Shift Selesai (opsional)</label>
                    <input type="time" name="shift_end" id="shift_end"
                        value="{{ old('shift_end', $karyawan->shift_end ? $karyawan->shift_end->format('H:i') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Foto -->
                <div class="mb-6">
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto (opsional)</label>

                    @if($karyawan->foto)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="{{ $karyawan->nama }}"
                                class="h-32 w-32 object-cover rounded-lg border-2 border-gray-300">
                        </div>
                    @endif

                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="file" name="foto" id="foto" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                onchange="previewImage(event)">
                            <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG. Max: 2MB</p>
                        </div>
                        <div id="preview-container" class="hidden">
                            <img id="preview" class="h-24 w-24 object-cover rounded-lg border-2 border-gray-300">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.karyawan.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Update
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
