<?php
namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportPenjualan implements FromCollection, WithHeadings, WithMapping
{
public function collection()
{
return Penjualan::with(['member', 'detailPenjualan.product'])
->get();
}

public function headings(): array
{
return [
"Nama Pelanggan",
"No HP Pelanggan",
"Poin Pelanggan",
"Produk",
"Total Harga",
"Total Bayar",
"Total Diskon Poin",
"Total Kembalian",
"Tanggal Pembelian"
];
}

 public function map($penjualan): array
 {
$produk_list = $penjualan->detailPenjualan->map(function ($detail) {
 return $detail->product->nama_produk . ' (' . $detail->qty . ' : Rp. ' . number_format($detail->sub_total, 0, ',', '.') . ' )';
})->implode(', ');

// Harga sebelum potongan diskon/poin
$total_harga_asli = $penjualan->detailPenjualan->sum(function ($detail) {
 return $detail->sub_total;
});

// Harga setelah potongan diskon/poin
$total_bayar = $penjualan->total_payment ?? 0;

return [
 $penjualan->member->nama_member ?? 'Bukan Member',
 $penjualan->member->nomor_telepon ?? $penjualan->customer_phone ?? '-',
 $penjualan->member->points ?? '-',
 $produk_list,
 'Rp. ' . number_format($total_harga_asli, 0, ',', '.'), // Total harga sebelum potongan
 'Rp. ' . number_format($total_bayar, 0, ',', '.'), // Total harga setelah potongan
 'Rp. ' . number_format($penjualan->point_used, 0, ',', '.'),
 'Rp. ' . number_format($penjualan->change ?? 0, 0, ',', '.'),
 date('d-m-Y', strtotime($penjualan->created_at))
];
}


}