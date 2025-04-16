<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'incoice_number',
        'user_id',
        'member_id',
        'customer_phone',
        'is_member',
        'total_payment',
        'point_used',
        'change',
    ];
}
