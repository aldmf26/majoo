<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'tb_produk';
    protected $fillable = [
        'id_kategori', 'id_satuan', 'sku', 'nm_produk',
        'harga_modal', 'harga', 'stok', 'terjual',
        'foto', 'diskon', 'komisi', 'monitoring', 'id_lokasi'
    ];
}
