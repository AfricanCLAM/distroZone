<x-app-layout>
    <main class="flex-grow w-full px-4 py-8 my-6 md:py-12">
        <div class="mx-auto max-w-4xl">

            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <a href="{{ route('admin.karyawan.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-bold uppercase tracking-widest text-gray-500 hover:text-primary mb-2">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        Kembali
                    </a>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tighter uppercase relative inline-block">
                        Tambah Karyawan
                        <span class="absolute -bottom-2 left-0 h-1 w-full bg-primary"></span>
                    </h1>
                </div>
                <p class="hidden md:block text-sm font-medium text-gray-600 max-w-xs text-right">
                    Lengkapi formulir untuk menambahkan karyawan baru ke sistem.
                </p>
            </div>

            <!-- Form Card -->
            <div class="retro-card bg-[#f3ece7] p-6 md:p-10 rounded-xl">
                <form action="{{ route('admin.karyawan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- INFORMASI PRIBADI -->
                    <div class="mb-10">
                        <div class="flex items-center gap-2 mb-6 border-b-2 border-black/20 pb-2">
                            <span class="material-symbols-outlined text-primary">badge</span>
                            <h3 class="text-xl font-bold uppercase">Informasi Pribadi</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- NIK -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">NIK</label>
                                <input type="text" name="NIK" value="{{ old('NIK') }}"
                                       class="retro-input w-full h-12 rounded-lg px-4 @error('NIK') border-red-500 @enderror"
                                       required>
                                @error('NIK')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                       class="retro-input w-full h-12 rounded-lg px-4 @error('nama') border-red-500 @enderror"
                                       required>
                                @error('nama')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}"
                                       class="retro-input w-full h-12 rounded-lg px-4 @error('username') border-red-500 @enderror"
                                       required>
                                @error('username')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telp -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">No. Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                                       class="retro-input w-full h-12 rounded-lg px-4 @error('no_telp') border-red-500 @enderror"
                                       required>
                                @error('no_telp')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold uppercase mb-2">Alamat</label>
                                <textarea name="alamat" rows="3"
                                          class="retro-input w-full rounded-lg px-4 py-3 @error('alamat') border-red-500 @enderror"
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- AKUN & SHIFT -->
                    <div class="mb-10">
                        <div class="flex items-center gap-2 mb-6 border-b-2 border-black/20 pb-2">
                            <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                            <h3 class="text-xl font-bold uppercase">Akun & Shift</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Role</label>
                                <select name="role" id="role"
                                        class="retro-input w-full h-12 rounded-lg px-4 @error('role') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="kasir online" {{ old('role') === 'kasir online' ? 'selected' : '' }}>
                                        Kasir Online
                                    </option>
                                    <option value="kasir offline" {{ old('role') === 'kasir offline' ? 'selected' : '' }}>
                                        Kasir Offline
                                    </option>
                                </select>
                                @error('role')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shift -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Shift</label>
                                <select name="shift" id="shift"
                                        class="retro-input w-full h-12 rounded-lg px-4 @error('shift') border-red-500 @enderror"
                                        required>
                                    <option value="">Pilih Shift</option>
                                    <option value="offline_siang" data-role="kasir offline">Offline Siang</option>
                                    <option value="offline_sore" data-role="kasir offline">Offline Sore</option>
                                    <option value="online" data-role="kasir online">Online</option>
                                </select>
                                @error('shift')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shift Start -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Shift Mulai</label>
                                <input type="time" id="shift_start" name="shift_start"
                                       class="retro-input w-full h-12 rounded-lg px-4 bg-gray-200 cursor-not-allowed"
                                       readonly>
                            </div>

                            <!-- Shift End -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Shift Selesai</label>
                                <input type="time" id="shift_end" name="shift_end"
                                       class="retro-input w-full h-12 rounded-lg px-4 bg-gray-200 cursor-not-allowed"
                                       readonly>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Password</label>
                                <input type="password" name="password"
                                       class="retro-input w-full h-12 rounded-lg px-4 @error('password') border-red-500 @enderror"
                                       required>
                                @error('password')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div>
                                <label class="block text-sm font-bold uppercase mb-2">Foto (Opsional)</label>
                                <input type="file" name="foto"
                                       class="retro-input w-full h-12 rounded-lg px-4 bg-white">
                            </div>

                        </div>
                    </div>

                    <!-- ACTION -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 border-t-2 border-black/10 pt-8">
                        <a href="{{ route('admin.karyawan.index') }}"
                           class="px-8 h-12 flex items-center justify-center border-2 border-black font-bold uppercase rounded-lg">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-10 h-12 retro-card bg-primary text-white font-bold uppercase flex items-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <!-- SHIFT SCRIPT (UNCHANGED) -->
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
                shiftSelect.disabled = false;
                shiftSelect.value = '';

                [...shiftSelect.options].forEach(option => {
                    if (!option.value) return;
                    option.hidden = option.dataset.role !== role;
                });

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
            shiftSelect.addEventListener('change', () => applyShiftTime(shiftSelect.value));

            updateShiftByRole();
        });
    </script>
</x-app-layout>
