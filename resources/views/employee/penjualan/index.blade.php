@extends('layouts.sidebar')
@section('content')

<div class="container px-4">
    <div class="max-w-full bg-white overflow-x-auto">

        <!-- Breadcrumb -->
        <nav class="mb-4 text-sm text-gray-600 flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                </svg>                      
            </a> >
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">Penjualan</a>
        </nav>

        <!-- Header -->
        <div class="flex justify-between items-center pb-4">
            <h2 class="text-3xl font-bold text-gray-900">Penjualan</h2>
        </div>
        
        <!-- Alerts -->
        @if(Session::get('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">{{ Session::get('success') }}</div>
        @endif
        @if(Session::get('deleted'))
            <div class="p-4 mb-4 text-yellow-800 bg-yellow-100 rounded-lg">{{ Session::get('deleted') }}</div>
        @endif
        @if(Session::get('gagal'))
            <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg">{{ Session::get('gagal') }}</div>
        @endif
        
        <!-- Card Container -->
        <div class="bg-white shadow-md rounded-lg p-4">

            <!-- Button Tambah & Export -->
            <div class="flex justify-end gap-2 pb-4">
                <a href="{{ route('employee.penjualans.card') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Tambah Penjualan
                </a>
                <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Eksport Penjualan (.xlsx)
                </a>
            </div>

            <!-- Table -->
            <table id="example" class="table table-striped w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Harga</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($penjualans as $penjualan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $penjualan->member ? $penjualan->member->nama_member : 'Bukan Member' }}</td>
                            <td>{{ $penjualan->created_at }}</td>
                            <td>{{ $penjualan->total_payment }}</td>
                            <td>{{ $penjualan->user->name ?? 'Tidak diketahui' }}</td>
                            <td class="flex gap-2 justify-center">
                                <button onclick="openModal({{ $penjualan->id }})" class="bg-yellow-400 text-white px-3 py-1 rounded-lg hover:bg-yellow-500">
                                    LIHAT
                                </button>                                
                                <form action="#" method="GET" target="_blank">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">UNDUH BUKTI</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $penjualans->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
@foreach ($penjualans as $penjualan)
    <div id="viewModal-{{ $penjualan->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[500px]">
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-xl font-bold">Detail Penjualan</h2>
                <button onclick="closeModal({{ $penjualan->id }})" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <div class="text-gray-600 text-sm mb-4">
                <div class="flex justify-between">
                    <p>Member Status: {{ optional($penjualan->member)->nama_member ?? 'Bukan Member' }}</p>
                    <p>Bergabung Sejak: {{ optional($penjualan->member)->created_at ?? '-' }}</p>
                </div>
                <div class="flex justify-between">
                    <p>No. HP: {{ optional($penjualan->member)->nomor_telepon ?? '-' }}</p>
                    <p>Poin Member: {{ optional($penjualan->member)->points ?? '-' }}</p>
                </div>
            </div>

            <table class="w-full text-sm text-left text-gray-700">
                <thead class="border-b font-bold">
                    <tr>
                        <th class="py-2">Nama Produk</th>
                        <th class="py-2 text-center">Qty</th>
                        <th class="py-2 text-right">Harga</th>
                        <th class="py-2 text-right">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($penjualan->detailPenjualan) && is_iterable($penjualan->detailPenjualan))
                        @foreach($penjualan->detailPenjualan as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->product->nama_produk }}</td>
                                <td class="py-2 text-center">{{ $item->qty }}</td>
                                <td class="py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="py-2 text-right">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center py-2 text-gray-500">Tidak ada produk</td>
                        </tr>
                    @endif
                </tbody>                
            </table>

            <div class="flex justify-between items-center font-bold text-lg mt-4">
                <p>Total</p>
                <p class="text-gray-800">Rp {{ number_format($penjualan->total_payment, 0, ',', '.') }}</p>
            </div>

            <p class="text-sm text-gray-600 mt-4">Dibuat pada: {{ $penjualan->created_at }}</p>
            <p class="text-sm text-gray-600">Dibuat oleh: {{ $penjualan->user->name ?? 'Tidak diketahui' }}</p>

            <div class="mt-6 text-right">
                <button onclick="closeModal({{ $penjualan->id }})" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endforeach

<!-- JavaScript -->
<script>
    function openModal(id) {
        document.getElementById(`viewModal-${id}`).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(`viewModal-${id}`).classList.add("hidden");
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>

@endsection
