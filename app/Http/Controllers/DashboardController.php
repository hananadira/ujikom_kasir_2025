<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Penjualan::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

        $salesLabels = $sales->pluck('date')->toArray();
        $salesCounts = $sales->pluck('count')->toArray();

        // FIXED: pakai tabel products
        $produkTerjual = Penjualan::join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
                            ->join('products', 'detail_penjualans.product_id', '=', 'products.id')
                            ->selectRaw('products.nama_produk as nama_produk, SUM(detail_penjualans.qty) as total')
                            ->groupBy('products.nama_produk')
                            ->get();

        $productLabels = $produkTerjual->pluck('nama_produk')->toArray();
        $productTotals = $produkTerjual->pluck('total')->toArray();

        return view('dashboard', compact('salesLabels', 'salesCounts', 'productLabels', 'productTotals'));
    }




    // Fungsi lainnya dibiarkan kosong sesuai default Laravel Resource
    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
