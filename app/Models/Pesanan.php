<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'nama_customer',
        'catatan', // ⬅️ wajib
        'no_meja',
        'jumlah_item',
        'total_bayar',
        'uang_bayar',
        'uang_kembalian',
        'waktu',
    ];



    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

}
