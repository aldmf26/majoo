<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Opname;
use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OpnameController extends Controller
{
    public function index(Request $r)
    {
        if (!Session::get('nama')) {
            return redirect()->route('welcome');
        } else {
            $hari  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $id_lokasi = Session::get('id_lokasi');
            if (empty($r->tgl1)) {
                $tgl1   = date('Y-m-') . '01';
                $tgl2   = date('Y-m-') . $hari . ' 23:00:00';
            } else {
                $tgl1   = $r->tgl1;
                $tgl2   = $r->tgl2 . ' 23:00:00';
            }
            $data = [
                'title' => 'Opname Produk',
                'opname' => DB::select("Select * FROM tb_opname as a left join tb_produk as b on a.id_produk = b.id_produk where a.tgl >= '$tgl1' AND a.tgl <= '$tgl2' and b.id_lokasi = '$id_lokasi'  GROUP BY kode_opname ORDER BY a.id_opname DESC"),

                'id_lokasi' => $id_lokasi
            ];
            // dd($data['produk']);
            return view('opname.opname', $data);
        }
    }

    public function buatOpname(Request $r)
    {
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
        return view('opname.buat', $data);
    }

    public function inputOpname(Request $r)
    {
        $id_produk = $r->id_produk_opname;
        $kode_opname = date('ymd') . strtoupper(Str::random(3));
        foreach ($id_produk as $id) {

            $get_produk = Produk::where('id_produk', $id)->first();

            $data = [
                'kode_opname' => $kode_opname,
                'id_produk' => $get_produk->id_produk,
                'stok_program' => $get_produk->stok,
                'stok_aktual' => $get_produk->stok,
                'harga' => $get_produk->harga,
                'catatan' => '',
                'status' => 'Draft',
                'tgl' => date('Y-m-d H:i:s')
            ];
            Opname::create($data);
        }
        return redirect()->route('detailOpname', ['kode_opname' => $kode_opname]);
    }

    public function detailOpname(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $kode_opname = $r->kode_opname;
        $data = [
            'title'  => "Detail Opname Produk",
            'cek_status' => Opname::where('kode_opname', $kode_opname)->groupBy('kode_opname')->first(),
            'opname' => DB::select("SELECT * FROM tb_opname as o
            left join tb_produk as p on p.id_produk = o.id_produk
            left join tb_kategori as k on k.id_kategori = p.id_kategori
            left join tb_satuan as s on s.id_satuan = p.id_satuan
            where o.kode_opname = '$kode_opname'"),
            'kode_opname' => $kode_opname,
            'produk' => DB::select("SELECT a.*,b.*,c.* FROM tb_produk as a
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE a.id_lokasi = '$id_lokasi'
            ORDER BY a.nm_produk ASC"),
            'kategori' => Kategori::all()
        ];
        return view('opname.detail', $data);
    }

    public function editStokAktual(Request $r)
    {
        if ($r->action == 'selesai') {

            $id_opname = $r->id_opname;
            $id_produk = $r->id_produk;
            $stok_aktual = $r->stok_aktual;
            $catatan = $r->catatan;


            for ($x = 0; $x < sizeof($id_opname); $x++) {
                $data = [
                    'stok_aktual' => $stok_aktual[$x],
                    'catatan' => $catatan[$x],
                    'status' => 'Selesai',
                    'tgl' => date('Y-m-d H:i:s')
                ];

                Opname::where('id_opname', $id_opname[$x])->update($data);
            }

            for ($x = 0; $x < sizeof($id_produk); $x++) {
                $data_produk = [
                    'stok' => $stok_aktual[$x]
                ];

                Produk::where('id_produk', $id_produk[$x])->update($data_produk);
            }
            return redirect()->route('opname')->with('sukses', 'Opname Produk Selesai');
        }

        if ($r->action == 'edit') {
            $id_opname = $r->id_opname;
            $id_produk = $r->id_produk;
            $stok_aktual = $r->stok_aktual;
            $catatan = $r->catatan;
            $kode_opname = $r->kode_opname;


            for ($x = 0; $x < sizeof($id_opname); $x++) {
                $data = [
                    'stok_aktual' => $stok_aktual[$x],
                    'catatan' => $catatan[$x]
                ];
                Opname::where('id_opname', $id_opname[$x])->update($data);
            }
            return redirect()->route('detailOpname', ['kode_opname' => $kode_opname])->with('sukses', 'Data Berhasil Di Opname');
        }
    }

    public function tambahOpname(Request $r)
    {
        $id_produk = $r->id_produk_opname;
        $kode_opname = $r->kode_opname;

        foreach ($id_produk as $id) {
            $get_produk = Produk::where('id_produk', $id)->first();
            $cek = Opname::where([['kode_opname', $kode_opname], ['id_produk', $id]])->first();

            if ($cek) {
                continue;
            } else {
                $data = [
                    'kode_opname' => $kode_opname,
                    'id_produk' => $get_produk->id_produk,
                    'stok_program' => $get_produk->stok,
                    'stok_aktual' => $get_produk->stok,
                    'harga' => $get_produk->harga,
                    'catatan' => '',
                    'status' => 'Draft',
                    'tgl' => date('Y-m-d H:i:s')
                ];
                Opname::create($data);
            }
        }
        return redirect()->route('detailOpname', ['kode_opname' => $kode_opname]);
    }

    public function deleteOpname(Request $r)
    {
        $kode_opname = $r->kode_opname;

        Opname::where('kode_opname', $kode_opname);
        return redirect()->route('opname')->with('error', 'Berhasil hapus data');
    }

    public function printOpname(Request $r)
    {
        $kode_opname = $r->kode_opname;
        $data = [
            'opname' => Opname::where('kode_opname', $kode_opname)->groupBy('kode_opname')->first(),
            'detail_opname' => Opname::join('tb_produk', 'tb_opname.id_produk', 'tb_produk.id_produk')
            ->join('tb_kategori','tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan','tb_produk.id_satuan', 'tb_satuan.id_satuan')
            ->where('tb_opname.kode_opname', $kode_opname)->get(),
            'kode_opname' => $kode_opname
        ];
        return view('opname.print',$data);
    }

    public function formulirOpname(Request $r)
    {
        $kode_opname = $r->kode_opname;
        $id_lokasi = Session::get('id_lokasi');
        $data = array(
            'title'  => "Detail Opname Produk",
            'cek_status' => Opname::where('kode_opname', $kode_opname)->groupBy('kode_opname')->first(),
            // 'produk'   => $this->db->join('tb_kategori', 'tb_produk.id_kategori = tb_kategori.id_kategori', 'left')->get('tb_produk')->result(),
            // 'kategori'    => $this->db->get('tb_kategori')->result(),
            'opname' => Opname::join('tb_produk', 'tb_opname.id_produk', 'tb_produk.id_produk')
            ->join('tb_kategori','tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan','tb_produk.id_satuan', 'tb_satuan.id_satuan')
            ->where('tb_opname.kode_opname', $kode_opname)->get(),
            'kode_opname' => $kode_opname,
            'produk' => DB::select("SELECT a.*,b.*,c.* FROM tb_produk as a
            LEFT JOIN tb_kategori as b ON a.id_kategori = b.id_kategori
            LEFT JOIN tb_satuan as c ON a.id_satuan = c.id_satuan
            WHERE a.id_lokasi = '$id_lokasi'
            ORDER BY a.nm_produk ASC"),
            'kategori' => Kategori::all()
        );
        
        return view('opname.formulir', $data);
    }
}
