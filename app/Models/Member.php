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
}
