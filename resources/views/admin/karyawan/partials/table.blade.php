<div class="flex flex-col overflow-hidden rounded-xl border-2 border-retro-border bg-white shadow-retro">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px] border-collapse">
            <thead>
                <tr class="bg-retro-cream border-b-2 border-retro-border">
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Info Kasir</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Username</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">NIK</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y-2 divide-dashed divide-retro-border/20">
                @forelse ($karyawan as $user)
                    <tr class="hover:bg-[#fffdf5] transition-colors">
                        <!-- ID -->
                        <td class="px-6 py-4">
                            <span
                                class="inline-block rounded bg-[#f3ece7] px-2 py-1 text-xs font-bold border border-retro-border/30">
                                {{ $user->kID }}
                            </span>
                        </td>

                        <!-- Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}"
                                        class="size-10 rounded-full border-2 border-retro-border object-cover">
                                @else
                                    <div
                                        class="size-10 rounded-full bg-primary text-white
                                               border-2 border-retro-border
                                               flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                                    </div>
                                @endif
                                <span
                                class="font-sm">
                                {{ $user->nama }}
                            </span>
                            </div>
                        </td>

                        <!-- Username -->
                        <td class="px-6 py-4 font-medium">
                            {{ $user->username }}
                        </td>

                        <!-- Role -->
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1
                                text-xs font-bold uppercase border-2 border-retro-border
                                shadow-[2px_2px_0px_0px_#1b130e]
                                {{ str_contains($user->role, 'online') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucwords($user->role) }}
                            </span>
                        </td>

                         <!-- NIK -->
                        <td class="px-6 py-4 font-medium">
                            {{ $user->NIK }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.karyawan.edit', $user->id) }}"
                                    class="flex size-9 items-center justify-center
                                           border-2 border-retro-border rounded
                                           hover:bg-yellow-100 shadow-retro-sm
                                           active:translate-y-[1px] transition-all">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>

                                <form action="{{ route('admin.karyawan.destroy', $user->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus kasir ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="flex size-9 items-center justify-center
                                               border-2 border-retro-border rounded
                                               text-red-600 hover:bg-red-50
                                               shadow-retro-sm active:translate-y-[1px] transition-all">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-[#6b584a] font-medium">
                            Tidak ada data kasir ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div
        class="border-t-2 border-retro-border bg-retro-cream px-6 py-4 flex justify-between items-center">
        <span class="text-sm font-bold text-[#6b584a]">
            Menampilkan {{ $karyawan->count() }} dari {{ $karyawan->total() }} data
        </span>
        {{ $karyawan->links() }}
    </div>
</div>
