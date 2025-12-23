="bg-gray-50">
<tr>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ongkir</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grand Total</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Struk</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($transaksis as $transaksi)
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                #{{ str_pad($transaksi->no_transaksi, 6, '0', STR_PAD_LEFT) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $transaksi->validated_at->format('d/m/Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $transaksi->kasir->nama ?? 'N/A' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ $transaksi->nama_pembeli }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                Rp {{ number_format($transaksi->pemasukan, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                         {{ $transaksi->metode_pembayaran === 'Bank Transfer' ? 'bg-blue-100 text-blue-800' :
            ($transaksi->metode_pembayaran === 'Cash' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                    {{ $transaksi->metode_pembayaran }}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                @if($transaksi->struk)
                    <a href="{{ route('kasir.transaksi.download-struk', $transaksi->id) }}"                class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Unduh
                    </a>
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="px-6 py-8 text-center">
                <div class="flex flex-col items-center">
                    <svg class="h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500">Tidak ada transaksi ditemukan.</p>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="px-6 py-4 bg-gray-50">
    {{ $transaksis->links() }}
</div>
</div>
</div>
</x-app-layout>
````

Step 9: Update PDF Struk View
File: resources/views/pdf/struk.blade.php
blade
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk Pembayaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', monospace;
        }

        body {
            width: 80mm;
            padding: 5mm;
            font-size: 11px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .item {
            margin: 3px 0;
        }

        .total {
            margin-top: 5px;
            font-weight: bold;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="center bold">
        <div style="font-size: 14px;">DISTROZONE</div>
        <div style="font-size: 10px;">Jl. Contoh No. 123, Sidoarjo</div>
        <div style="font-size: 10px;">Telp: 081234567890</div>
    </div>

    <div class="separator"></div>

    <!-- Transaction Info -->
    <div style="margin: 5px 0;">
        <div>No Transaksi: {{ str_pad($transaksi->no_transaksi, 6, '0', STR_PAD_LEFT) }}</div>
        <div>Tanggal: {{ $transaksi->validated_at->format('d/m/Y H:i') }}</div>
        <div>Kasir: {{ $transaksi->kasir->nama }}</div>
    </div>

    <div class="separator"></div>

    <!-- Customer Info -->
    <div style="margin: 5px 0; font-size: 10px;">
        <div>Pembeli: {{ $transaksi->nama_pembeli }}</div>
        <div>No HP: {{ $transaksi->no_telp_pembeli }}</div>
        <div>Alamat: {{ Str::limit($transaksi->alamat, 40) }}</div>
        <div>Wilayah: {{ $transaksi->wilayah }}</div>
    </div>

    <div class="separator"></div>

    <!-- Items -->
    @foreach($items as $item)
        <div class="item">
            <div class="bold">{{ $item->kaos->merek }} - {{ $item->kaos->ukuran }}</div>
            <div style="font-size: 10px;">{{ $item->kaos->warna_kaos }}</div>
            <div class="flex-between">
                <span>{{ $item->qty }} x Rp {{ number_format($item->kaos->harga_jual, 0, ',', '.') }}</span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    @endforeach

    <div class="separator"></div>

    <!-- Totals -->
    <div class="total">
        <div class="flex-between">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="flex-between">
            <span>Ongkir:</span>
            <span>Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
        </div>
        <div class="separator"></div>
        <div class="flex-between" style="font-size: 13px;">
            <span>GRAND TOTAL:</span>
            <span>Rp {{ number_format($transaksi->pemasukan, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="separator"></div>

    <!-- Payment Method -->
    <div class="center" style="font-size: 10px;">
        <div>Pembayaran: {{ $transaksi->metode_pembayaran }}</div>
    </div>

    <div class="separator"></div>

    <!-- Footer -->
    <div class="center" style="margin-top: 10px;">
        <div class="bold">Terima Kasih!</div>
        <div style="font-size: 10px; margin-top: 5px;">{{ now()->format('d/m/Y H:i:s') }}</div>
        <div style="font-size: 9px; margin-top: 3px;">distrozone.com</div>
    </div>
</body>

</html>
