<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id_carts';
    protected $fillable = ['jumlah','id_menu'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
