<?php

namespace App\Http\Controllers;

// import model product 
use App\Models\Product;
use Illuminate\View\View;
// import return view
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $products = Product::paginate(10);

        // render view with product 
        
        $search = $request->query('search');
        
        $prodproucts = Product::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('harga_produk', 'like', "%{$search}%")
                ->orWhere('stock', 'like', "%{$search}%");
            });
        })
        ->paginate(10);


        return view('admin.products.index', compact('products', 'search'));
    }

    public function indexEmployee(Request $request) : View
    {
        // get all product
        $products = Product::paginate(10);

        // render view with product 
        
        $search = $request->query('search');
        
        $prodproucts = Product::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('harga_produk', 'like', "%{$search}%")
                ->orWhere('stock', 'like', "%{$search}%");
            });
        })
        ->paginate(10);


        return view('employee.products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload image ke storage/app/public/products
        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('products', $imageName, 'public');


        // Generate image URL yang benar
        $imageUrl = $imageName;

        // Create product
        Product::create([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'stock' => $request->stock,
            'image' => $imageUrl
        ]);

        // Redirect ke index 
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //get product by ID
        // $product = Product::findOrFail($id);

        //render view with product
        // return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
        // gat product by ID 
        $products = Product::findOrFail($id);

        // render view with product 
        return view('admin.products.edit', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

       if ($request->isMethod('patch')) {
         // Validasi input
         $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->storeAs('products', $imageName, 'public');

            // Update produk dengan gambar baru
            $product->update([
                'nama_produk' => $request->nama_produk,
                'harga_produk' => $request->harga_produk,
                'stock' => $request->stock,
                'image' => $imageName
            ]);
        } else {
            // Update tanpa ubah gambar
            $product->update([
                'nama_produk' => $request->nama_produk,
                'harga_produk' => $request->harga_produk,
                'stock' => $request->stock,
            ]);
        }
       }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Stok berhasil diperbarui!');
    }


    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get product by ID
        $product = Product::findOrFail($id);
    
        // Delete image if exists
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }
    
        // Delete product
        $product->delete();
    
        // Redirect to product index page
        return redirect()->route('admin.products.index')->with('deleted', 'Product berhasil dihapus!');
    }    
}
