@extends('layouts.sidebar')

@section('content')
<div class="container px-4 py-6">
    <div class="flex justify-between items-start mb-6">
        <div class="flex gap-2">
            <form action="{{ route('employee.penjualans.pdf', $penjualan->id) }}" method="GET" target="_blank">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">UNDUH</button>
            </form>
            <a href="{{ route('employee.penjualans.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
        </div>
        <div class="text-right text-sm text-gray-700">
            <p>Invoice – <strong>#{{ $penjualan->invoice_number }}</strong></p>
            <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
    </div>    

    <div class="mb-4 text-sm text-gray-800">
        <p><strong>{{ $penjualan->customer_phone }}</strong></p>
        @if($penjualan->is_member)
            <p>MEMBER SEJAK : {{ optional($penjualan->member)->created_at ?? '-' }}</p>
            <p>MEMBER POIN : {{ optional($penjualan->member)->points ?? '-' }}</p>
        @endif
    </div>

    <table class="w-full text-sm text-gray-700 mb-4">
        <thead>
            <tr class="border-b border-gray-300">
                <th class="text-left py-2">Produk</th>
                <th class="text-left py-2">Harga</th>
                <th class="text-left py-2">Quantity</th>
                <th class="text-left py-2">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->detailPenjualan as $item)
                <tr class="border-b border-gray-200">
                    <td class="py-2">{{ $item->product->nama_produk }}</td>
                    <td class="py-2">Rp. {{ number_format($item->product->harga_produk, 0, ',', '.') }}</td>
                    <td class="py-2">{{ optional($item)->qty }}</td>
                    <td class="py-2">Rp. {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="grid grid-cols-3 text-center text-sm bg-gray-100 rounded-t-md overflow-hidden">
        <div class="p-4">
            <p class="text-gray-500">POIN DIGUNAKAN</p>
            <p class="text-lg font-semibold">{{ $penjualan->point_used ?? 0 }}</p>
        </div>
        <div class="p-4">
            <p class="text-gray-500">KASIR</p>
            <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
        </div>
        <div class="p-4 bg-gray-800 text-white">
            <p class="text-sm">TOTAL</p>
            <p class="text-2xl font-bold">Rp. {{ number_format($penjualan->total_payment, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-gray-100 text-center p-4 rounded-b-md">
        <p class="text-gray-600">KEMBALIAN</p>
        <p class="text-lg font-bold">Rp. {{ number_format($penjualan->change ?? 0, 0, ',', '.') }}</p>
    </div>    
</div>
@endsection