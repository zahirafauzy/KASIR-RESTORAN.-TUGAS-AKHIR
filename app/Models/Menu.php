<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'nama_menu',
        'id_kategori', 
        'harga_menu', 
        'stok_menu', 
        'image_menu'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}

