@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
   <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-600 flex items-center gap-2">
        <a href="" class="flex items-center text-blue-600 hover:underline">
            <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
            </svg>
            Dashboard
        </a>
        <span class="text-gray-400">/</span>
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">Produk</a>
        <span class="text-gray-400">/</span>
        <span class="text-gray-500">Buat Produk</span>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center pb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Buat Produk</h2>
    </div>

    <!-- Card untuk Form -->
    <div class="bg-white shadow-sm rounded p-8 mt-10">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <!-- Nama Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama_produk') border-red-500 @enderror" value="{{ old('nama_produk') }}">
                    @error('nama_produk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Gambar Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Gambar Produk <span class="text-red-500">*</span></label>
                    <input type="file" name="image" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Harga Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_produk" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('harga_produk') border-red-500 @enderror" value="{{ old('harga_produk') }}">
                    @error('harga_produk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Stok Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('stock') border-red-500 @enderror" value="{{ old('stock') }}">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
