<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    use HasFactory;
    protected $table = 'tb_stok_produk';
    protected $fillable = [
        'kode_stok_produk', 'id_produk', 'stok_program',
        'harga', 'debit', 'kredit', 'ttl_stok', 'tgl', 'tgl_input', 'ket',
        'admin', 'jenis', 'status', 'id_lokasi'
    ];
}
