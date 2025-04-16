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

    public function items()
    {
        return $this->hasMany(detailPenjualan::class);
    }

    public function detailPenjualans()
    {
        return $this->hasMany(detailPenjualan::class);
    }

    

}
