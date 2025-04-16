@extends('layouts.sidebar')
@section('content')

<div class="container px-4 py-6">
   <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-600 flex items-center gap-2">
        <a href="#" class="flex items-center text-blue-600 hover:underline">
            <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
            </svg>
            Dashboard
        </a>
        <span class="text-gray-400">/</span>
        <a href="#" class="text-blue-600 hover:underline">Penjualan</a>
        <span class="text-gray-400">/</span>
        <span class="text-gray-500">Buat Penjualan</span>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Buat Penjualan</h2>
    </div>


    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Produk yang dipilih</h2>
        
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Daftar Produk -->
            <div>
                <input type="hidden" name="products['1']" value="1"> 
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <p class="font-semibold">produk 1</p> 
                    <div class="flex justify-between text-gray-500">
                        <p>Rp 100.000 x 1</p> 
                        <p class="font-semibold text-gray-700">Rp 100.000</p> 
                    </div>
                </div>
                
                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between font-bold text-lg">
                        <p>Total</p>
                        <p class="text-gray-900">Rp 100.000</p> 
                    </div>
                </div>
            </div>
            
            <!-- Form Member dan Total Bayar -->
            <div>
                <form action="#" method="POST">
                        <input type="hidden" name="products['1']" value="1"> 

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Member Status</label>
                        <select name="is_member" class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="bukan_member">Bukan Member</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Member</label>
                        <input type="number" name="customer_phone" placeholder="Masukkan nomor telepon member"  
                               class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Bayar</label>
                        <input type="text" value="Rp 100.000" 
                               class="w-full border rounded-lg p-2 bg-gray-100" readonly>
                        <input type="hidden" name="total_payment" value="Rp 100.000"> 
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

@endsection