<div class="flex flex-col overflow-hidden rounded-xl border-2 border-retro-border bg-white shadow-retro">

    <div class="overflow-x-auto">
        <table class="w-full min-w-[1000px] border-collapse">
            <thead>
                <tr class="bg-retro-cream border-b-2 border-retro-border">
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Foto</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Merek</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Tipe</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Warna</th>
                    <th class="px-6 py-4 text-left text-sm font-black uppercase">Ukuran</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Harga</th>
                    <th class="px-6 py-4 text-center text-sm font-black uppercase">Stok</th>
                    <th class="px-6 py-4 text-right text-sm font-black uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y-2 divide-dashed divide-retro-border/20">
                @forelse ($kaos as $item)
                    <tr class="hover:bg-[#fffdf5] transition-colors">

                        <!-- FOTO -->
                        <td class="px-6 py-4">
                            @if ($item->foto_kaos)
                                <img src="{{ asset('storage/' . $item->foto_kaos) }}"
                                     alt="{{ $item->merek }}"
                                     class="size-16 rounded border-2 border-retro-border object-cover">
                            @else
                                <div
                                    class="size-16 flex items-center justify-center
                                           rounded border-2 border-retro-border
                                           bg-[#f3ece7] text-xs font-bold text-[#6b584a]">
                                    NO IMG
                                </div>
                            @endif
                        </td>

                        <!-- MEREK -->
                        <td class="px-6 py-4 font-bold">
                            {{ $item->merek }}
                        </td>

                        <!-- TIPE -->
                        <td class="px-6 py-4">
                            {{ $item->tipe }}
                        </td>

                        <!-- WARNA -->
                        <td class="px-6 py-4">
                            {{ $item->warna_kaos }}
                        </td>

                        <!-- UKURAN -->
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex rounded px-3 py-1 text-xs font-bold
                                       border-2 border-retro-border bg-[#f3ece7]">
                                {{ $item->ukuran }}
                            </span>
                        </td>

                        <!-- HARGA -->
                        <td class="px-6 py-4 text-right font-bold">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </td>

                        <!-- STOK -->
                        <td class="px-6 py-4 text-center">
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1
                                text-xs font-bold uppercase border-2 border-retro-border
                                {{ $item->stok_kaos > 10
                                    ? 'bg-green-100 text-green-800'
                                    : ($item->stok_kaos > 0
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-red-100 text-red-800') }}">
                                {{ $item->stok_kaos }} pcs
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">

                                <!-- EDIT -->
                                <a href="{{ route('admin.kaos.edit', $item->id_kaos) }}"
                                   class="flex size-9 items-center justify-center
                                          border-2 border-retro-border rounded
                                          hover:bg-yellow-100 shadow-retro-sm
                                          active:translate-y-[1px] transition-all">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('admin.kaos.destroy', $item->id_kaos) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kaos ini?')">
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
                        <td colspan="8"
                            class="px-6 py-12 text-center text-[#6b584a] font-bold">
                            Tidak ada data kaos ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div
        class="border-t-2 border-retro-border bg-retro-cream px-6 py-4 flex justify-between items-center">
        <span class="text-sm font-bold text-[#6b584a]">
            Menampilkan {{ $kaos->count() }} dari {{ $kaos->total() }} data
        </span>
        {{ $kaos->links() }}
    </div>

</div>
