<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Product;
use Illuminate\Http\Request;

class EmployeePenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // get all product
         $penjualans = Penjualan::with('items', 'products', 'member')->paginate(10);     

         // render view with product 
         return view('employee.penjualan.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function card()
    {
        $penjualans = Product::with('items', 'detailPenjualans')->latest()->paginate(10);
        return view('employee.penjualan.card', compact('penjualans'));
    }

    // Menampilkan produk dengan stok lebih besar dari 0 untuk dipilih
    public function create(Request $request)
    {
        $penjualans = Product::with('items', 'detailPenjualans')->where('stock', '>', 0)->get();
        return view('employee.penjualan.card', compact('penjualans'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'integer|min:1',
        ]);

        $selectedProducts = [];
        $total_payment = 0;

        foreach ($request->products as $productId => $qty) {
            $product = Product::findOrFail($productId);
            if ($qty > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok untuk produk ' . $product->nama_produk);
            }

            $selectedProducts[] = [
                'id' => $product->id,
                'nama_produk' => $product->nama_produk,
                'harga_produk' => $product->harga_produk,
                'qty' => $qty,
                'sub_total' => $product->harga_produk * $qty,
            ];
            $total_payment += $product->harga_produk * $qty;
        }

        return view('employee.penjualan.create', compact('selectedProducts', 'total_payment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
