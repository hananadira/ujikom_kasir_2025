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

    public function items() {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function member() {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
