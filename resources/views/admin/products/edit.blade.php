@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
    <!-- Breadcrumb -->
    <nav class="mb-4 text-sm text-gray-600 flex items-center gap-2">
        <a href="#" class="text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-gray-800 dark:text-gray" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
            </svg>                      
        </a> >
        <a href="#" class="text-blue-600 hover:underline">Produk</a>
    </nav>

    <!-- Header -->
    <div class="flex justify-between items-center pb-4">
        <h2 class="text-3xl font-bold text-gray-900">Edit Produk</h2>
    </div>

    <!-- Card untuk Form -->
    <div class="bg-white shadow-sm rounded p-8 mt-10">
        <form action="{{ route('admin.products.update', $products->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH') 
            <div class="grid grid-cols-2 gap-4">
                <!-- Nama Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama_produk') border-red-500 @enderror" value="{{ old('nama_produk', $products->nama_produk) }}">
                    @error('nama_produk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Gambar Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Gambar Produk</label>
                    <input type="file" name="image" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Preview Gambar -->
                    @if($products->image)
                        <img src="{{ asset('storage/products/'.$products->image) }}" class="mt-2 h-24 rounded shadow-md">
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Harga Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Harga <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_produk" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('harga_produk') border-red-500 @enderror" value="{{ old('harga_produk', $products->harga_produk) }}">
                    @error('harga_produk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Stok Produk -->
                <div>
                    <label class="text-gray-700 font-semibold">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" class="w-full border rounded-md p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('stock') border-red-500 @enderror" value="{{ old('stock', $products->stock) }}">
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
