@extends('layouts.sidebar')
@section('content')
<div class="container px-4" id="cart-container">
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
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @foreach ($penjualans as $penjualan)
            @if($penjualan->stock > 0)
            <div class="product-item bg-white shadow-lg rounded-lg p-4 text-center" 
                 data-id="{{ $penjualan->id }}" 
                 data-price="{{ $penjualan->harga_produk }}" 
                 data-stock="{{ $penjualan->stock }}">
                <img src="{{ asset('storage/products/' . $penjualan->image) }}" class="w-full h-40 object-contain rounded-lg">
                <h2 class="text-lg font-semibold mt-2">{{ $penjualan->nama_produk }}</h2>
                <p class="text-gray-500">Stok: {{ $penjualan->stock }}</p>
                <p class="text-gray-900 font-bold">Rp. {{ number_format($penjualan->harga_produk, 0, ',', '.') }}</p>

                <!-- Tombol + - -->
                <div class="flex items-center justify-center mt-2">
                    <button class="decrement-btn px-3 py-1 bg-gray-200 rounded-l">-</button>
                    <input type="text" class="quantity-input w-10 text-center border" value="0" readonly>
                    <button class="increment-btn px-3 py-1 bg-gray-200 rounded-r">+</button>
                </div>

                <!-- Subtotal -->
                <p class="subtotal text-gray-600 mt-2">
                    Sub Total: <span class="font-bold">Rp. <span class="subtotal-value">0</span></span>
                </p>
            </div>
            @endif
        @endforeach
    </div>

    <!-- Form untuk semua produk yang dipilih -->
    <form id="checkout-form" action="{{ route('employee.penjualans.preview') }}" method="GET">
        <div id="cart-inputs"></div>
        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
            Selanjutnya
        </button>
    </form> 
</div>

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const cart = {};
    
    // Initialize product items
    $('.product-item').each(function() {
        const $item = $(this);
        const id = $item.data('id');
        const price = parseFloat($item.data('price'));
        const stock = parseInt($item.data('stock'));
        const $quantityInput = $item.find('.quantity-input');
        const $subtotalValue = $item.find('.subtotal-value');
        
        // Initialize cart item
        cart[id] = 0;
        
        // Increment button click
        $item.find('.increment-btn').click(function(e) {
            e.preventDefault();
            if (cart[id] < stock) {
                cart[id]++;
                $quantityInput.val(cart[id]);
                $subtotalValue.text((cart[id] * price).toLocaleString('id-ID'));
                updateCartInputs();
            }
        });
        
        // Decrement button click
        $item.find('.decrement-btn').click(function(e) {
            e.preventDefault();
            if (cart[id] > 0) {
                cart[id]--;
                $quantityInput.val(cart[id]);
                $subtotalValue.text((cart[id] * price).toLocaleString('id-ID'));
                updateCartInputs();
            }
        });
    });
    
    // Update hidden inputs in form
    function updateCartInputs() {
        $('#cart-inputs').empty();
        
        $.each(cart, function(id, qty) {
            if (qty > 0) {
                $('#cart-inputs').append(
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'products[' + id + ']',
                        value: qty
                    })
                );
            }
        });
    }
    $('#checkout-form').submit(function(e) {
    const hasItem = Object.values(cart).some(qty => qty > 0);
    if (!hasItem) {
        e.preventDefault();
        alert('Silakan pilih minimal 1 produk terlebih dahulu.');
    }
});

});
</script>
@endsection