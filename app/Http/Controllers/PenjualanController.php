<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Exports\ExportPenjualan;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // get all product
         $penjualans = Penjualan::with('items', 'products', 'member')->paginate(10);     

         // render view with product 
         return view('admin.penjualans.index', compact('penjualans'));
    }

    // di PenjualanController.php
    public function export()
    {
        // dd('export');
        return Excel::download(new ExportPenjualan, 'penjualan.xlsx');
    }

    public function unduhBukti($id)
    {
        $penjualan = Penjualan::with(['member', 'detailPenjualan.product'])->findOrFail($id);

        return Pdf::loadView('admin.penjualans.strukPDF', compact('penjualan'))
                ->setPaper('A5')
                ->download('bukti-penjualan-'.$penjualan->id.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }
}