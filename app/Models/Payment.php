<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'total_bayar',
        'metode',
        'kembalian',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
