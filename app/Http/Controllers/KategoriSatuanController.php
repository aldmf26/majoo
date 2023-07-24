<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;

class KategoriSatuanController extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Kategori & Satuan',
            'kategori' => Kategori::all(),
            'satuan' => Satuan::all()
        ];
        return view('kategoriSatuan.kategoriSatuan',$data);
    }

    // KATEGORI
    public function tambahKategori(Request $r)
    {
        Kategori::create(['nm_kategori' => $r->nm_kategori]);
        return redirect()->route('kategoriSatuan')->with('sukses', 'Berhasil tambah kategori');
    }

    public function editKategori(Request $r)
    {
        Kategori::where('id_kategori', $r->id_kategori)->update(['nm_kategori' => $r->nm_kategori]);
        return redirect()->route('kategoriSatuan')->with('sukses', 'Berhasil ubah kategori');
    }

    public function hapusKategori(Request $r)
    {
        Kategori::where('id_kategori', $r->id_kategori)->delete();
        return redirect()->route('kategoriSatuan')->with('error', 'Berhasil hapus kategori');
    }

    // SATUAN
    public function tambahSatuan(Request $r)
    {
        Satuan::create(['satuan' => $r->satuan]);
        return redirect()->route('kategoriSatuan')->with('sukses', 'Berhasil tambah satuan');
    }

    public function editSatuan(Request $r)
    {
        Satuan::where('id_satuan', $r->id_satuan)->update(['satuan' => $r->satuan]);
        return redirect()->route('kategoriSatuan')->with('sukses', 'Berhasil ubah satuan');
    }

    public function hapusSatuan(Request $r)
    {
        Satuan::where('id_satuan', $r->id_satuan)->delete();
        return redirect()->route('kategoriSatuan')->with('error', 'Berhasil hapus satuan');
    }
}
