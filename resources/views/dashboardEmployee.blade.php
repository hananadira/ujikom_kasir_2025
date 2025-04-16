@extends('layouts.sidebar')
@section('content')

@php
    use Carbon\Carbon;
    use App\Models\Penjualan;

    // Ambil tanggal hari ini (Asia/Jakarta)
    $today = Carbon::now('Asia/Jakarta')->toDateString();

    // Hitung jumlah penjualan hari ini
    $todaySales = Penjualan::whereDate('created_at', $today)->count();

    // Ambil data penjualan terakhir hari ini (jika ada)
    $lastUpdateToday = Penjualan::whereDate('created_at', $today)->latest('created_at')->first();
@endphp

<!-- Breadcrumb -->
<nav class="mb-4 text-sm text-gray-600 flex items-center gap-2">
    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
        <svg class="w-6 h-6 text-gray-800 dark:text-gray" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
        </svg>                      
    </a> >
    <a href="{{ route('dashboardEmployee') }}" class="text-blue-600 hover:underline">Dashboard</a>
</nav>

<!-- Header -->
<div class="container px-4">
    <div class="flex justify-between items-center pb-4">
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Selamat Datang, Petugas!</h2>
        
        <!-- Grafik Penjualan -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-100 text-center py-3">
                <h2 class="text-gray-700 text-lg font-semibold">Total Penjualan Hari Ini</h2>
            </div>
            <div class="text-center py-10">
                <p class="text-3xl font-bold text-gray-900">{{ $todaySales }}</p>
                <p class="text-gray-600">Jumlah total penjualan yang terjadi hari ini.</p>
            </div>
            <div class="bg-gray-100 text-center py-3 text-gray-500 text-sm">
                Terakhir diperbarui: 
                {{ $lastUpdateToday ? $lastUpdateToday->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') : 'Belum ada penjualan hari ini' }}
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
@endsection
