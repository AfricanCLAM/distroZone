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

        .flex {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="center bold">
        <div style="font-size: 14px;">DISTROZONE</div>
        <div style="font-size: 10px;">Jl. Raya Pegangsaan Timur No.29H</div>
    </div>

    <div class="separator"></div>

    <div style="margin: 5px 0;">
        <div>No: {{ $transaksi->no_transaksi }}</div>
        <div>Tanggal: {{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
        <div>Pembeli: {{ $transaksi->nama_pembeli }}</div>
        <div>No HP: {{ $transaksi->no_telp_pembeli }}</div>
        <div>Alamat: {{ $transaksi->alamat }}</div>
        <div>Wilayah: {{ $transaksi->wilayah }}</div>
        <div>Kasir: {{ $transaksi->kasir->nama ?? 'System' }}</div>
    </div>

    <div class="separator"></div>

    @foreach($items as $item)
        <div class="item">
            <div>{{ $item->kaos->merek }} - {{ $item->kaos->ukuran }}</div>
            <div>{{ $item->kaos->warna_kaos }}</div>
            <div class="flex">
                <span>{{ $item->qty }} x {{ number_format($item->harga, 0, ',', '.') }}</span>
                <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
    @endforeach

    <div class="separator"></div>

    <div class="total">
        <div class="flex">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="flex">
            <span>Ongkir ({{ $transaksi->total_berat }} kg):</span>
            <span>Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</span>
        </div>
        <div class="separator"></div>
        <div class="flex" style="font-size: 13px;">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($transaksi->pemasukan, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="separator"></div>

    <div class="center" style="margin-top: 10px;">
        <div>Metode: {{ $transaksi->metode_pembayaran }}</div>
        <div style="margin-top: 5px;">Thanks for shopping with us!</div>
        <div style="font-size: 10px; margin-top: 5px;">{{ now()->format('d/m/Y H:i:s') }}</div>
    </div>
</body>

</html>
