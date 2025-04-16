<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailPenjualan extends Model
{
    protected $fillable = [
        'penjualan_id',
        'product_id',
        'qty',
        'price',
        'sub_total',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
