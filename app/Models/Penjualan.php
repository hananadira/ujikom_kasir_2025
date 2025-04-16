<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'member_id',
        'customer_phone',
        'is_member',
        'total_payment',
        'point_used',
        'change',
    ];

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function items() {
        return $this->hasMany(Penjualan::class, 'invoice_number', 'id');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'detail_penjualans', 'penjualan_id', 'product_id')
                    ->withPivot('qty'); // kolom tambahan di tabel pivot
    }


    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
