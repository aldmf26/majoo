<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_invoice extends Model
{
    use HasFactory;
    protected $table = 'tb_invoice';
    protected $fillable = [
        'no_nota', 'total', 'bayar', 'kembali', 'cash', 'mandiri_kredit', 'mandiri_debit', 'bca_kredit', 'bca_debit', 'dp', 'kd_dp', 'diskon', 'tgl_jam', 'tgl_input', 'id_customer', 'admin', 'no_meja', 'lokasi', 'status', 'nm_void', 'ket_void', 'invoice'
    ];
}
