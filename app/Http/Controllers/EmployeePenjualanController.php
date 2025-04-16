<?php

namespace App\Http\Controllers;

use App\Exports\ExportPenjualan;
use App\Models\User;
use App\Models\Member;
use App\Models\Product;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class EmployeePenjualanController extends Controller
{
    // Menampilkan daftar penjualan
    public function index()
    {
        $penjualans = Penjualan::with('member', 'detailPenjualan.product')->paginate(10);
        return view('employee.penjualan.index', compact('penjualans'));
    }

    // Menampilkan produk untuk dipilih pada halaman 'card'
    public function card()
    {
        $penjualans = Product::with('items', 'detailPenjualans')->latest()->paginate(10);
        return view('employee.penjualan.card', compact('penjualans'));
    }

    // Menampilkan produk dengan stok lebih besar dari 0 untuk dipilih
    public function create(Request $request)
    {
        $penjualans = Product::with('items', 'detailPenjualans');
        return view('employee.penjualan.card', compact('penjualans'));
    }

    // Menampilkan preview dari produk yang dipilih
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

    // Proses step 1 checkout
    public function storeStep1(Request $request)
    {
        $request->validate([
            'is_member' => 'required|in:member,bukan_member',
            'total_payment' => 'required|numeric|min:0',
            'total_bayar' => 'required|numeric|min:' . ($request->total_payment ?? 0),
            'products' => 'required|array'
        ]);

        Session::put('is_member', $request->is_member);
        Session::put('total_payment', $request->total_payment);
        Session::put('products', $request->products);
        Session::put('total_bayar', $request->total_bayar);

        if ($request->is_member === 'member') {
            $request->validate(['customer_phone' => 'required|string']);
            Session::put('customer_phone', $request->customer_phone);

            $member = Member::where('nomor_telepon', $request->customer_phone)->first();
            if ($member) {
                Session::put('nama_member', $member->nama_member);
                Session::put('member_id', $member->id);
                Session::put('existing_member', true); // Flag bahwa ini member yang sudah ada
            } else {
                Session::put('existing_member', false);
            }

            return redirect()->route('employee.penjualan.step2'); // SELALU ke step2
        }

        // BUKAN MEMBER → Langsung simpan
        return $this->simpanPenjualan($request);
    }

    // Menampilkan form untuk input nama member
    public function step2()
    {
        $products = Session::get('products');
        $total_payment = Session::get('total_payment');
        $customerPhone = Session::get('customer_phone');
        $existingMember = Session::get('existing_member');

        if (!$products || !$total_payment) {
            return redirect()->route('employee.penjualans.card')->with('error', 'Data tidak ditemukan.');
        }

        $selectedProducts = [];
        foreach ($products as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $selectedProducts[] = [
                    'id' => $product->id,
                    'nama_produk' => $product->nama_produk,
                    'harga_produk' => $product->harga_produk,
                    'qty' => $qty,
                    'sub_total' => $product->harga_produk * $qty,
                ];
            }
        }

        $nama_member = '';
        $memberPoints = 0;
        $point = intval($total_payment * 0.10); // earned points (standar)

        if ($existingMember && Session::has('member_id')) {
            $member = Member::find(Session::get('member_id'));
            if ($member) {
                $nama_member = $member->nama_member;
                $memberPoints = $member->points;
                $point = $memberPoints; // Tampilkan yang bisa dipakai
            }
        }

        return view('employee.penjualan.form_nama_member', compact('selectedProducts', 'total_payment', 'nama_member', 'point', 'memberPoints'));
    }

    // Proses step 2 checkout dan penyimpanan data
    public function storeStep2(Request $request)
    {
        $request->validate(['nama_member' => 'required|string|max:255']);

        $customerPhone = Session::get('customer_phone');
        $products = Session::get('products');
        $total_payment = Session::get('total_payment');

        if (!$products || !$total_payment) {
            return back()->with('error', 'Data produk atau total pembayaran tidak tersedia.');
        }

        $member = Member::firstOrCreate(
            ['nomor_telepon' => $customerPhone],
            ['nama_member' => $request->nama_member, 'points' => 0]
        );

        Session::put('nama_member', $member->nama_member);
        Session::put('member_id', $member->id);

        // Untuk member baru, set poin yang diperoleh pada transaksi ini
        $earnedPoints = intval($total_payment / 100);  // 10% dari total pembayaran
        Session::put('earned_points', $earnedPoints);

        // Tentukan jika poin digunakan
        Session::put('point_used', $request->has('use_point'));

        return $this->simpanPenjualan($request);
    }


    // Menampilkan detail penjualan
    public function detail($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.product', 'member', 'user'])->findOrFail($id);

        // Set semua data ke session
        session([
            'invoice_number' => $penjualan->invoice_number,
            'customer_phone' => $penjualan->customer_phone,
            'is_member' => $penjualan->is_member,
            'points' => $penjualan->member->poin ?? 0,
            'selected_products' => $penjualan->detailPenjualan,
            'total_payment' => $penjualan->total_payment,
            'point_used' => $penjualan->point_used,
            'change' => $penjualan->change,
        ]);

        return view('employee.penjualan.detail', compact('penjualan'));
    }

    // Menyimpan penjualan
    public function simpanPenjualan(Request $request)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::create([
                'invoice_number' => '',
                'user_id' => Auth::id(),
                'member_id' => Session::get('is_member') === 'member' ? Session::get('member_id') : null,
                'customer_phone' => Session::get('is_member') === 'member' ? Session::get('customer_phone') : null,
                'is_member' => Session::get('is_member'),
                'total_payment' => Session::get('total_payment'),
                'point_used' => 0,
                'change' => 0,
            ]);
    
            $products = Session::get('products');
            foreach ($products as $productId => $qty) {
                $product = Product::findOrFail($productId);
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'product_id' => $productId,
                    'qty' => $qty,
                    'price' => $product->harga_produk,
                    'sub_total' => $qty * $product->harga_produk,
                ]);
    
                $product->decrement('stock', $qty);
            }
    
            // PENGOLAHAN POINT
            if ($penjualan->is_member && $penjualan->member_id) {
                $member = Member::find($penjualan->member_id);
                if ($member) {
                    $usePoint = Session::get('point_used');
                    $totalPenjualanMember = Penjualan::where('member_id', $member->id)->count();
    
                    if ($totalPenjualanMember > 1) {
                        if ($usePoint && $member->points > 0) {
                            $pointUsed = min($member->points, $penjualan->total_payment / 100);
                            $penjualan->total_payment = max(0, $penjualan->total_payment - $pointUsed);
                            $penjualan->point_used = $pointUsed;
                            $member->points -= $pointUsed;
                        }
                    }
    
                    // Hitung poin yang diperoleh dari total pembayaran
                    $earned = intval($penjualan->total_payment / 100);
                    $member->points += $earned;
                    $member->save();
    
                    // $totalBayar = Session::get('total_bayar');
                    // $penjualan->change = $totalBayar - $penjualan->total_payment;
                    // $penjualan->save();                    
                }
            }

              // Hitung kembali kembalian
                $totalBayar = Session::get('total_bayar');
                $penjualan->change = $totalBayar - $penjualan->total_payment;
                
                $penjualan->invoice_number = 'INV-' . str_pad($penjualan->id, 6, '0', STR_PAD_LEFT);
                $penjualan->save();

            
    
            // Bersihkan session
            Session::forget([
                'is_member', 'customer_phone', 'total_payment', 'products',
                'nama_member', 'member_id', 'point_used', 'total_bayar'
            ]);
    
            DB::commit();
            return redirect()->route('employee.penjualan.detail', $penjualan->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan penjualan: ' . $e->getMessage());
        }
    }    

    // Mengunduh bukti penjualan dalam format PDF
    public function unduhBukti($id)
    {
        $penjualan = Penjualan::with(['member', 'detailPenjualan.product'])->findOrFail($id);

        return Pdf::loadView('admin.penjualans.strukPDF', compact('penjualan'))
                ->setPaper('A5')
                ->download('bukti-penjualan-'.$penjualan->id.'.pdf');
    }

    // Mengekspor data penjualan ke dalam format Excel
    public function export()
    {
        return Excel::download(new ExportPenjualan, 'penjualan.xlsx');
    }
}