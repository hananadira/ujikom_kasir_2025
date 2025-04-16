<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
       'nama_member',
       'nomor_telepon',
        'points',
    ];

    public function penjualan() {
        return $this->hasMany(Penjualan::class, 'member_id');
    }

    public function products() {
        return $this->belongsToMany(DetailPenjualan::class, 'member_id');
    }
}
