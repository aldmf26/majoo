<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Data Karyawan',
            'karyawan' => Karyawan::where('posisi', 'WAITRESS')->orderBy('kd_karyawan', 'DESC')->get(),
        ];
        return view('karyawan.karyawan',$data);
    }

    public function tambah(Request $r)
    {
        $data = [
            'nm_karyawan' => $r->nm_karyawan,
            'posisi' => 'WAITRESS',
            'pangkat' => 'SERVER',
            'tgl_join' => date('Y-m-d'),
          ];
        Karyawan::create($data);
        return redirect()->route('karyawan')->with('sukses', 'Berhasil tambah karyawan');
    }

    public function hapus(Request $r)
    {
        Karyawan::where('kd_karyawan', $r->kd_karyawan)->delete();
        return redirect()->route('karyawan')->with('error', 'Berhasil hapus karyawan');
    }
}
