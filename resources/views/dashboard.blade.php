@extends('layouts.sidebar')
@section('content')
<div class="container px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6 flex items-center text-sm text-gray-600 space-x-2">
            <a href="{{ route('dashboard') }}" class="flex items-center text-blue-600 hover:underline hover:text-blue-800">
                <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
                </svg>
                Dashboard
            </a>
        </nav>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Selamat Datang, Administrator!</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Grafik Penjualan (Bar Chart) -->
            <div class="md:col-span-2 p-4 border rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2 text-center">Jumlah Penjualan</h3>
                <canvas id="salesChart"></canvas>
            </div>

            <!-- Persentase Penjualan Produk (Pie Chart) -->
            <div class="p-4 border rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2 text-center">Persentase Penjualan Produk</h3>
                <canvas id="productChart"></canvas>
                <div id="legend" class="flex flex-wrap justify-center mt-4"></div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const barLabels = {!! json_encode($salesLabels) !!};
        const barData = {!! json_encode($salesCounts) !!};

        const pieLabels = {!! json_encode($productLabels) !!};
        const pieData = {!! json_encode($productTotals) !!};

        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: barData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const productCtx = document.getElementById('productChart').getContext('2d');
        const productChart = new Chart(productCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                        '#FF9F40', '#B2FF66', '#66FFB2', '#FF66D9', '#66D9FF'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        const legendContainer = document.getElementById('legend');
        pieLabels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center mr-4 mb-2';
            legendItem.innerHTML = `
                <span class="w-4 h-4 inline-block mr-2" style="background-color: ${productChart.data.datasets[0].backgroundColor[index]}"></span>
                ${label}
            `;
            legendContainer.appendChild(legendItem);
        });
    });
</script>
@endsection
