<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\StokProduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // produk
    public function index(Request $r)
    {
        if(!Session::get('nama')) {
            return redirect()->route('welcome');
        } else {
            $id_lokasi = Session::get('id_lokasi');
            // dd($id_lokasi);
            $data = [
                'title' => 'Produk',
                'produk' => Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where('tb_produk.id_lokasi', $id_lokasi)->orderBy('tb_produk.id_produk', 'DESC')->get(),
                'kategori' => Kategori::all(),
                'satuan' => Satuan::all(),
                'id_lokasi' => $id_lokasi
            ];
            // dd($data['produk']);
            return view('produk.produk',$data);
        }
        
    }

    public function tambah(Request $r)
    {
        if ($r->hasFile('image')) {
            $r->file('image')->move('assets/uploads/produk/', $r->file('image')->getClientOriginalName());
            $foto = $r->file('image')->getClientOriginalName();
        } else {
            $foto = 'not-available.png';
        }

        $data = [
            'nm_produk' => $r->nm_produk,
            'id_kategori' => $r->id_kategori,
            'id_satuan' => $r->id_satuan,
            'stok' => $r->stok,
            'harga' => $r->harga,
            'harga_modal' => $r->harga_modal,
            'komisi' => $r->komisi,
            'id_lokasi' => $r->id_lokasi,
            'foto' => $foto,
        ];

        $sku = Produk::create($data);
         
      
        Produk::where('id_produk', $sku->id)->update(['sku' => 'TS'.$sku->id]);
        return redirect()->route('produk')->with('sukses', 'Berhasil tambah produk');
    }

    public function edit(Request $r)
    {
        if ($r->hasFile('image')) {
            $r->file('image')->move('assets/uploads/', $r->file('image')->getClientOriginalName());
            $foto = $r->file('image')->getClientOriginalName();
        } else {
            $foto = '';
        }

        $data = [
            'nm_produk' => $r->nm_produk,
            'id_kategori' => $r->id_kategori,
            'id_satuan' => $r->id_satuan,
            'stok' => $r->stok,
            'harga' => $r->harga,
            'harga_modal' => $r->harga_modal,
            'komisi' => $r->komisi,
            'id_lokasi' => $r->id_lokasi,
            'foto' => $foto,
        ];

        Produk::where('id_produk', $r->id_produk)->update($data);
        return redirect()->route('produk')->with('sukses', 'Berhasil ubah produk');
    }

    public function hapus(Request $r)
    {
        Produk::where('id_produk', $r->id_produk)->delete();
        return redirect()->route('produk')->with('error', 'Berhasil hapus produk');
    }
    // -----------------------------------

    // stok produk
    public function stokProduk(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $hari  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        if(empty($r->tgl1)){
            $tgl1   = date('Y-m-').'01';
            $tgl2   = date('Y-m-').$hari;
        }else{
            $tgl1   = $r->tgl1;
            $tgl2   = $r->tgl2;
        } 

        $data = [
            'title' => 'Stok Produk',
            'stokProduk' => DB::select("SELECT a.*, SUM(a.debit) as debit, SUM(a.kredit) as kredit FROM tb_stok_produk as a
            WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND a.id_lokasi = '$id_lokasi'
            GROUP BY a.kode_stok_produk
            ORDER BY a.id_stok_produk DESC")
        ];

        return view('stokProduk.stokProduk',$data);
    }

    public function buatStokProduk(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $data = [
            'title'  => "Create Stok Masuk",
            'kategori' => Kategori::all(),
            'produk' => DB::select("SELECT a.*,b.*,c.* FROM tb_produk as a
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE a.id_lokasi = '$id_lokasi'
            ORDER BY a.nm_produk ASC"),
        ];
        return view('stokProduk.buat',$data);
    }

    public function inputProdukMasuk(Request $r)
    {
        $id_produk = $r->id_stok_produk;
        $kode_stok_produk = 'INV'.date('ymd') . strtoupper(Str::random(3));
        $id_user = User::where('nama', strtolower(Session::get('nama')))->first();
        $admin = $id_user->id_user;
        $id_lokasi = Session::get('id_lokasi');
        foreach ($id_produk as $id) {
            $get_produk = Produk::where('id_produk', $id)->first();
            $data = [
                'kode_stok_produk' => $kode_stok_produk,
                'id_produk' => $get_produk->id_produk,
                'stok_program' => $get_produk->stok,
                'ttl_stok' => $get_produk->stok,
                'debit' => 0,
                'kredit' => 0,
                'harga' => $get_produk->harga,
                'admin' => $admin,
                'jenis' => 'Masuk',
                'status' => 'Draft',
                'tgl_input' => date('Y-m-d H:i:s'),
                'tgl' => date('Y-m-d'),
                'ket' => 'stok masuk',
                'id_lokasi' => $id_lokasi,
            ];
            StokProduk::create($data);
        }
        return redirect()->route('detailStokProduk', ['kode' => $kode_stok_produk]);
    }

    public function tambahProdukMasuk(Request $r)
    {
        $id_produk = $r->id_produk_stok;
        $kode_stok_produk = $r->kode_stok_produk;

        foreach ($id_produk as $id) {
            $get_produk = $this->db->get_where('tb_produk', array(
                'id_produk' => $id
            ))->row();
            $cek = $this->db->get_where('tb_stok_produk', [
                'kode_stok_produk' => $kode_stok_produk,
                'id_produk' => $id
            ])->num_rows();
            if ($cek > 0) {
                continue;
            } else {
                $data = [
                    'kode_stok_produk' => $kode_stok_produk,
                    'id_produk' => $get_produk->id_produk,
                    'stok_program' => $get_produk->stok,
                    'ttl_stok' => $get_produk->stok,
                    'debit' => 0,
                    'kredit' => 0,
                    'harga' => $get_produk->harga,
                    'admin' => Session::user()->id,
                    'jenis' => 'Masuk',
                    'status' => 'Draft',
                    'tgl_input' => date('Y-m-d H:i:s'),
                    'tgl' => date('Y-m-d'),
                    'ket' => 'stok masuk'
                ];
                StokProduk::create($data);
            }
        }
        return redirect()->route('detailStokProduk', ['kode' => $kode_stok_produk]);
    }

    public function detailStokProduk(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $kode_stok_produk = $r->kode;
        $data = [
            'title' => "Detail Produk Masuk",
            'cek_status' => StokProduk::where('kode_stok_produk', $kode_stok_produk)->groupBy('kode_stok_produk')->first(),
            'stok' => DB::select("SELECT a.*,b.*,c.*,d.* FROM tb_stok_produk as d
            LEFT JOIN tb_produk as a ON d.id_produk = a.id_produk
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE d.kode_stok_produk = '$kode_stok_produk' AND d.jenis = 'Masuk'
            GROUP BY d.id_produk"),
            'kode_stok_produk' => $kode_stok_produk,
            'produk' => DB::select("SELECT a.*,b.*,c.* FROM tb_produk as a
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE a.id_lokasi = '$id_lokasi'
            ORDER BY a.nm_produk ASC"),
            'kategori' => Kategori::all()
        ];
        
        return view('stokProduk.detail', $data);
    }

    public function printStokMasuk(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $kode_stok_produk = $r->kode_stok_produk;

        $data = [
            'title' => "Detail Produk Masuk",
            'cek_status' => StokProduk::where('kode_stok_produk', $kode_stok_produk)->groupBy('kode_stok_produk')->first(),
            'stok' => DB::select("SELECT a.*,b.*,c.*,d.* FROM tb_stok_produk as d
            LEFT JOIN tb_produk as a ON d.id_produk = a.id_produk
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE d.kode_stok_produk = '$kode_stok_produk' AND d.jenis = 'Masuk'
            GROUP BY d.id_produk"),
            'kode_stok_produk' => $kode_stok_produk,
            'produk' => DB::select("SELECT a.*,b.*,c.* FROM tb_produk as a
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE a.id_lokasi = '$id_lokasi'
            ORDER BY a.nm_produk ASC"),
            'kategori' => Kategori::all(),
            'kode_stok_produk' => $kode_stok_produk
        ];

        return view('stokProduk.print',$data);
    }

    public function editStokMasuk(Request $r)
    {
        if($r->action == 'selesai') {
            $id_stok_produk = $r->id_stok_produk;
            $id_produk = $r->id_produk;
            $debit = $r->debit;
            for ($x = 0; $x < sizeof($id_stok_produk); $x++) { 
                
                $dt_produk = Produk::select('stok')->where('id_produk', $id_produk[$x])->first();
                $ttl_stok = $debit[$x] + $dt_produk->stok;

                $data = [
                    'debit' => $debit[$x],
                    'status' => 'Selesai',
                    'tgl_input' => date('Y-m-d H:i:s'),
                    'tgl' => date('Y-m-d'),
                    'ttl_stok' => $ttl_stok
                ];
                
                StokProduk::where('id_stok_produk', $id_stok_produk[$x])->update($data);
                $data_produk = [
                    'stok' => $ttl_stok
                ];
               
                Produk::where('id_produk', $id_produk[$x])->update($data_produk);

                
            }
            return redirect()->route('stokProduk')->with('sukses', 'Berhasil tambah produk');
        }
        if($r->action == 'edit') {
            return 'edit';
        }
    }
    // -----------------------------------
}
