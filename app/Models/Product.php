<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'stock',
        'image',
    ];

    public function detailPenjualans() {
        return $this->hasMany(DetailPenjualan::class, 'id');
    }

    public function items() {
        return $this->hasMany(DetailPenjualan::class, 'id');
    }

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function penjualans()
    {
        return $this->belongsToMany(Penjualan::class, 'detail_penjualans', 'product_id', 'penjualan_id')
                    ->withPivot('qty', 'harga', 'subtotal');
    }

    

}
