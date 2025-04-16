@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Penjualan</h1>

    <div class="bg-white p-6 rounded-xl shadow-md border grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Bagian kiri: Ringkasan Produk --}}
        <div class="border p-4 rounded-md">
            <table class="w-full text-left mb-4">
                <thead>
                    <tr class="text-gray-600 font-semibold">
                        <th>Nama Produk</th>
                        <th>QTY</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr>
                        <td>Produk 1</td> 
                        <td>1</td> 
                        <td>Rp. 100.000</td> 
                        <td>Rp. 100.00</td> 
                    </tr>
                </tbody>
            </table>

            <div class="text-right font-semibold text-lg">
                <p>Total Harga <span class="ml-4 font-bold text-black">Rp. 100.000</span></p> 
                <p>Total Bayar <span class="ml-4 font-bold text-black">Rp. 100.000</span></p> 
            </div>
        </div>

        {{-- Bagian kanan: Form Member --}}
        <form action="#" method="POST" class="flex flex-col justify-between">

           
            <input type="hidden" name="total_payment" value="100.000"> 

            <div>
                <label class="block text-sm font-medium mb-1">Nama Member (identitas)</label>
                <input type="text" name="nama_member" class="w-full border border-gray-300 rounded p-2 mb-4" placeholder="Masukkan nama member" required>

                <label class="block text-sm font-medium mb-1">Poin</label>
                <input type="text" name = "points" value="1000" class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded p-2 mb-2" readonly>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="use_point" name="use_point" class="border-gray-300">
                    <label for="use_point" class="text-sm text-gray-700">Gunakan poin</label>
                </div>
                <p class="text-sm text-red-500 mt-1">Poin tidak dapat digunakan pada pembelanjaan pertama.</p>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                    Selanjutnya
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
