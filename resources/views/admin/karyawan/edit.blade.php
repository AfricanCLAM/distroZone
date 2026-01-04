<<x-app-layout>
    <!-- Page Heading -->
    <div class="flex flex-col gap-2 mb-8 border-b-2 px-8 py-8 my-6 border-dashed border-retro-border/20 pb-6">
        <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight text-retro-border">
            Edit <span class="text-primary">Karyawan</span>
        </h1>
        <p class="text-[#6b584a] font-medium">
            Perbarui data karyawan: <span class="font-bold">{{ $karyawan->nama }}</span>
        </p>
    </div>

    <!-- Form Card -->
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl border-2 border-retro-border shadow-retro p-6 md:p-8">
            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- NIK -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">NIK</label>
                        <input type="text" name="NIK" value="{{ old('NIK', $karyawan->NIK) }}" required
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border retro-input
                                   @error('NIK') border-red-500 @enderror">
                        @error('NIK')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username', $karyawan->username) }}" required
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border retro-input
                                   @error('username') border-red-500 @enderror">
                        @error('username')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div class="md:col-span-2">
                        <label class="block font-bold text-sm uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}" required
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border retro-input
                                   @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block font-bold text-sm uppercase mb-2">Alamat</label>
                        <textarea name="alamat" rows="3" required
                            class="w-full px-4 py-3 rounded-lg border-2 border-retro-border retro-input
                                   @error('alamat') border-red-500 @enderror">{{ old('alamat', $karyawan->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Telp -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">No. Telepon</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp', $karyawan->no_telp) }}" required
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border retro-input
                                   @error('no_telp') border-red-500 @enderror">
                        @error('no_telp')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">Role</label>
                        <select name="role" required
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border bg-white retro-input
                                   @error('role') border-red-500 @enderror">
                            <option value="">Pilih Role</option>
                            <option value="kasir online" {{ old('role', $karyawan->role) === 'kasir online' ? 'selected' : '' }}>
                                Kasir Online
                            </option>
                            <option value="kasir offline" {{ old('role', $karyawan->role) === 'kasir offline' ? 'selected' : '' }}>
                                Kasir Offline
                            </option>
                        </select>
                        @error('role')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="md:col-span-2">
                        <label class="block font-bold text-sm uppercase mb-2">
                            Password Baru <span class="normal-case text-xs text-[#6b584a]">(opsional)</span>
                        </label>
                        <input type="password" name="password"
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border retro-input
                                   @error('password') border-red-500 @enderror"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shift -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">Shift</label>
                        <select name="shift"
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border bg-white retro-input">
                            <option value="">Pilih Shift</option>
                            <option value="offline_siang">Kasir Offline Siang (10:00 - 15:00)</option>
                            <option value="offline_sore">Kasir Offline Sore (15:00 - 20:00)</option>
                            <option value="online">Kasir Online (10:00 - 17:00)</option>
                        </select>
                    </div>

                    <!-- Shift Start -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">Shift Mulai</label>
                        <input type="time" readonly
                            value="{{ old('shift_start', optional($karyawan->shift_start)->format('H:i')) }}"
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border bg-gray-100 cursor-not-allowed">
                    </div>

                    <!-- Shift End -->
                    <div>
                        <label class="block font-bold text-sm uppercase mb-2">Shift Selesai</label>
                        <input type="time" readonly
                            value="{{ old('shift_end', optional($karyawan->shift_end)->format('H:i')) }}"
                            class="w-full h-12 px-4 rounded-lg border-2 border-retro-border bg-gray-100 cursor-not-allowed">
                    </div>

                    <!-- Foto -->
                    <div class="md:col-span-2">
                        <label class="block font-bold text-sm uppercase mb-2">Foto Karyawan</label>

                        @if ($karyawan->foto)
                            <div class="flex items-center gap-4 mb-3">
                                <img src="{{ asset('storage/' . $karyawan->foto) }}"
                                     class="h-24 w-24 object-cover rounded-lg border-2 border-retro-border shadow-retro-sm">
                                <span class="text-sm text-[#6b584a] font-medium">Foto saat ini</span>
                            </div>
                        @endif

                        <input type="file" name="foto" accept="image/*"
                            class="w-full px-4 py-3 rounded-lg border-2 border-retro-border bg-white retro-input">
                        <p class="text-xs text-[#6b584a] mt-1">
                            Kosongkan jika tidak ingin mengubah foto (JPG / PNG, max 2MB)
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('admin.karyawan.index') }}"
                        class="h-12 px-6 flex items-center justify-center rounded-lg border-2 border-retro-border bg-white font-bold shadow-retro-sm hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                        class="h-12 px-6 rounded-lg bg-primary text-white font-black uppercase border-2 border-retro-border shadow-retro hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#1b130e] active:translate-y-[2px] active:shadow-retro-sm transition-all">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleSelect = document.getElementById('role');
            const shiftSelect = document.getElementById('shift');
            const shiftStart = document.getElementById('shift_start');
            const shiftEnd = document.getElementById('shift_end');

            const shifts = {
                offline_siang: { start: '10:00', end: '15:00' },
                offline_sore: { start: '15:00', end: '20:00' },
                online: { start: '10:00', end: '17:00' }
            };

            function updateShiftByRole() {
                const role = roleSelect.value;

                // Reset
                shiftSelect.disabled = false;
                shiftSelect.value = '';

                [...shiftSelect.options].forEach(option => {
                    if (!option.value) return;

                    option.hidden = option.dataset.role !== role;
                });

                // Kasir online: force & lock
                if (role === 'kasir online') {
                    shiftSelect.value = 'online';
                    shiftSelect.disabled = true;
                    applyShiftTime('online');
                } else {
                    clearShiftTime();
                }
            }

            function applyShiftTime(shift) {
                if (!shifts[shift]) return;
                shiftStart.value = shifts[shift].start;
                shiftEnd.value = shifts[shift].end;
            }

            function clearShiftTime() {
                shiftStart.value = '';
                shiftEnd.value = '';
            }

            roleSelect.addEventListener('change', updateShiftByRole);

            shiftSelect.addEventListener('change', function () {
                applyShiftTime(this.value);
            });

            // Handle old() values on page load
            updateShiftByRole();
        });
    </script>

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
