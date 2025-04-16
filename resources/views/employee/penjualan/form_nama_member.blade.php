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
                    @foreach ($selectedProducts as $product)
                    <tr>
                        <td>{{ $product['nama_produk'] }}</td>
                        <td>{{ $product['qty'] }}</td>
                        <td>Rp. {{ number_format($product['harga_produk'], 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($product['sub_total'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right font-semibold text-lg">
                <p>Total Harga <span class="ml-4 font-bold text-black">Rp. {{ number_format($total_payment, 0, ',', '.') }}</span></p>
                <p>Total Bayar <span class="ml-4 font-bold text-black">Rp. {{ number_format($total_payment, 0, ',', '.') }}</span></p>
            </div>
        </div>

        {{-- Bagian kanan: Form Member --}}
        <form action="{{ route('employee.penjualan.storeStep2') }}" method="POST" class="flex flex-col justify-between">
            @csrf

           
            <input type="hidden" name="total_payment" value="{{ $total_payment }}">

            <div>
                <label class="block text-sm font-medium mb-1">Nama Member (identitas)</label>
                <input type="text" name="nama_member" class="w-full border border-gray-300 rounded p-2 mb-4" 
                    placeholder="Masukkan nama member" value="{{ old('nama_member', $nama_member ?? '') }}" required>
                
                <label class="block text-sm font-medium mb-1">Poin</label>
                <input type="text" name="points_display" value="{{ $memberPoints ?? session('earned_points') }}" 
                    class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded p-2 mb-2" readonly>
                
                {{-- Checkbox untuk penggunaan poin --}}
                @if(session('is_member') == 'member' && session('member_id'))
                    @php
                        $member = \App\Models\Member::find(session('member_id'));
                    @endphp
            
                    @if($member && $member->points > 0)
                        <div class="my-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="use_point" value="1" class="form-checkbox text-blue-500">
                                <span class="ml-2">Gunakan {{ $member->points }} poin untuk potongan belanja</span>
                            </label>
                        </div>
                    @elseif($member && $member->points == 0)
                        <p class="text-sm text-gray-500 mt-2">Anda tidak memiliki poin yang cukup untuk digunakan.</p>
                    @endif
                @endif
                
                {{-- Informasi tentang poin tidak dapat digunakan pada pembelian pertama --}}
                @if(session('is_member') == 'member' && session('member_id'))
                    @php
                        $penjualanCount = $member ? $member->penjualan()->count() : 0;
                    @endphp
            
                    @if($penjualanCount == 0)
                        <p class="text-sm text-red-500 mt-2">Poin tidak dapat digunakan pada pembelanjaan pertama.</p>
                    @endif
                @endif
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