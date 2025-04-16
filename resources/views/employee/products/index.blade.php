@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
    <div class="max-w-full bg-white overflow-x-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6 flex items-center text-sm text-gray-600 space-x-2">
            <a href="#" class="flex items-center text-blue-600 hover:underline hover:text-blue-800">
                <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
                </svg>
                Dashboard
            </a>
            <span>/</span>
            <a href="#" class="text-blue-600 hover:underline hover:text-blue-800">
                Produk
            </a>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center pb-6 mb-4">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Daftar Produk</h2>
        </div>

        
      
        
        <!-- Card Container -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- Header Table -->
            <div class="flex justify-end pb-4">
               {{--  --}}
            </div>
        
            <!-- Table -->
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3">Harga Produk</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($products as $product)
                        <tr class="bg-white border-b">
                            <td class="px-4 py-3">{{ $no++ }}</td>
                            <td class="px-4 py-3 text-center">
                                <img src="{{ asset('storage/products/'.$product->image) }}" class="rounded" style="width: 100px">
                            </td>
                            <td class="px-4 py-3">{{ $product->nama_produk }}</td>
                            <td class="px-4 py-3">{{ "Rp " . number_format($product->harga_produk,2,',','.') }}</td>
                            <td class="px-4 py-3">{{ $product->stock }}</td>
                            <td class="px-4 py-3 flex justify-center space-x-2">
                               {{--  --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Update Stock -->
            <div id="updateStockModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-xl font-bold mb-4">Update Stok</h2>

                    <!-- Form Update Stock -->
                    <form id="updateStockForm" method="POST">
                        @csrf
                        @method('PATCH') 
                        <input type="hidden" id="productId" name="product_id">

                       <!-- Tampilkan Nama Produk (tidak bisa diubah) -->
                        <label class="block mb-2">Nama Produk</label>
                        <input type="text" id="namaProdukInput" class="border rounded w-full p-2 bg-gray-100" value="" readonly disabled>


                        <label class="block mb-2">Jumlah Stok:</label>
                        <input type="number" id="stockInput" name="stock" class="border rounded w-full p-2" placeholder="Masukkan jumlah stok">

                        <div class="mt-4 flex justify-end gap-2">
                            <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                        </div>
                    </form>
                </div>
            </div>

        
            <!-- Pagination -->
            <div class="mt-4">
                {{-- {{ $products->links() }} --}}
            </div>
        </div>
        
    </div>
</div>
            <!-- JavaScript -->
            <script>
               function openModal(productId, stock, nama_produk) {
                let modal = document.getElementById("updateStockModal");
                let form = document.getElementById("updateStockForm");

                // Set data produk ke dalam modal
                document.getElementById("productId").value = productId;
                document.getElementById("stockInput").value = stock;
                document.getElementById("namaProdukInput").value = nama_produk;

                // Set action form ke endpoint update stock
                form.action = `/admin/products/${productId}/updateStock`;

                // Tampilkan modal
                modal.classList.remove("hidden");
            }

            window.closeModal = function () {
            let modal = document.getElementById("updateStockModal");
            modal.classList.add("hidden");
}


            </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
