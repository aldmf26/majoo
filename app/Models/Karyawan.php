<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'tb_karyawan';
    protected $fillable = [
        'id_karyawan', 'nm_karyawan', 'posisi', 'pangkat',
        'gaji_e', 'gaji_m', 'gaji_sp', 'gaji_off',
        'bonus', 'bonus_posisi', 'tgl_join', 'tkmr', 'sdb'
    ];
}
