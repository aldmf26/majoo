<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;
    protected $table = 'tb_opname';
    protected $fillable = [
        'kode_opname', 'id_produk', 'stok_program', 'stok_aktual',
        'harga', 'catatan', 'status', 'tgl', 'id_lokasi'
    ];
}
