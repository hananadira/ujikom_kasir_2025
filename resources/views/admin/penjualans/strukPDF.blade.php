<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { padding: 6px 8px; }
        th { background: #eee; text-align: left; }
        .right { text-align: right; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .footer { margin-top: 20px; font-size: 11px; color: #666; text-align: center; }
    </style>
</head>
<body>

    <h3>FlexyLite</h3>
    <p>
        Member Status : {{ $penjualan->is_member ? 'Member' : 'Bukan Member' }}<br>
        No. HP : {{ $penjualan->member->nomor_telepon ?? $penjualan->customer_phone ?? '-' }}<br>
        Bergabung Sejak : {{ $penjualan->created_at->format('d F Y') ?? '-' }}<br>
        Poin Member : {{ $penjualan->member->points ?? 0 }}
    </p>

    <table border="0">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th class="center">QTY</th>
                <th class="right">Harga</th>
                <th class="right">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($penjualan->detailPenjualan) && is_iterable($penjualan->detailPenjualan))
                        @foreach($penjualan->detailPenjualan as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->product->nama_produk }}</td>
                                <td class="py-2 text-center">{{ $item->qty }}</td>
                                <td class="py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="py-2 text-right">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center py-2 text-gray-500">Tidak ada produk</td>
                        </tr>
                    @endif
        </tbody>
    </table>

    <table>
        <tr>
            <td width="50%">Total Harga</td>
            <td class="right bold">Rp. {{ number_format($penjualan->total_payment, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Poin Digunakan: {{ $penjualan->point_used }}</td>
            <td class="right">Harga Setelah Poin: Rp. {{ number_format($penjualan->total_payment - $penjualan->point_used, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Kembalian</td>
            <td class="right bold">Rp. {{ number_format($penjualan->change, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        {{ $penjualan->created_at }} | {{ $penjualan->user->name ?? 'Tidak diketahui' }}<br><br>
        <strong>Terima kasih atas pembelian Anda!</strong>
    </div>

</body>
</html>
