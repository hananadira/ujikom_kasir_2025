@extends('layouts.sidebar')
@section('content')

<div class="container px-4 py-6">
     <!-- Breadcrumb -->
     <nav class="mb-6 flex items-center text-sm text-gray-600 space-x-2">
        <a href="{{ route('dashboardEmployee') }}" class="flex items-center text-blue-600 hover:underline hover:text-blue-800">
            <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
            </svg>
            Dashboard
        </a>
        <span>/</span>
        <a href="{{ route('employee.penjualans.index') }}" class="text-blue-600 hover:underline hover:text-blue-800">
            Penjualan
        </a>
    </nav>

    <div class="bg-white shadow-lg rounded-lg p-6" x-data="{ is_member: 'bukan_member' }">
        <h2 class="text-2xl font-bold mb-4">Produk yang dipilih</h2>
        
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Daftar Produk -->
            <div>
                @foreach($selectedProducts as $product)
                <input type="hidden" name="products[{{ $product['id'] }}]" value="{{ $product['qty'] }}">
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <p class="font-semibold">{{ $product['nama_produk'] }}</p>
                    <div class="flex justify-between text-gray-500">
                        <p>Rp {{ number_format($product['harga_produk'], 0, ',', '.') }} x {{ $product['qty'] }}</p>
                        <p class="font-semibold text-gray-700">Rp {{ number_format($product['sub_total'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
                
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <p>Total</p>
                        <p class="text-gray-900">Rp {{ number_format($total_payment, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Member dan Total Bayar -->
            <div>
                <form action="{{ route('employee.penjualan.storeStep1') }}" method="POST">
                    @csrf
                    @foreach($selectedProducts as $product)
                        <input type="hidden" name="products[{{ $product['id'] }}]" value="{{ $product['qty'] }}">
                    @endforeach
                
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Member Status</label>
                        <select name="is_member" x-model="is_member" class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="bukan_member">Bukan Member</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    
                    <div class="mb-4" x-show="is_member === 'member'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Member</label>
                        <input type="number" name="customer_phone" placeholder="Masukkan nomor telepon member" 
                               class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" 
                               :disabled="is_member !== 'member'">
                        @error('customer_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @php
                        $minimalBayar = $total_payment - ($point ?? 0);
                    @endphp
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Bayar (Uang dari Customer)</label>
                        <input type="number" name="total_bayar" min="{{ $minimalBayar }}" required
                               class="w-full border rounded-lg p-2" placeholder="Masukkan jumlah uang dari customer">
                        <input type="hidden" name="total_payment" value="{{ $total_payment }}">
                    </div>
                                   
                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Proses Penjualan
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
<!-- Tambahkan ini jika belum ada -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@endsection