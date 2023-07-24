<?php

namespace App\Http\Controllers;

use App\Models\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomisiController extends Controller
{
    public function komisiTarget(Request $r)
    {
        if (empty($r->tgl1)) {
            $month = date('m');
            $year = date('Y');

            $last_date = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $tgl1 = $year . '-' . $month . '-01';
            $tgl2 = $year . '-' . $month . '-' . $last_date;
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $komisi = DB::select("SELECT SUM(a.komisi) as dt_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_karyawan as c ON a.id_kry = c.kd_karyawan
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id_kry");

        $data = [
            'title'  => "Daftar Komisi Penjualan",
            'komisi' => $komisi,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2
        ];

        return view('listPenjualan.komisiTarget', $data);
    }

    public function komisiPenjualan(Request $r)
    {
        if (empty($r->tgl1)) {
            $month = date('m');
            $year = date('Y');

            $last_date = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $tgl1 = $year . '-' . $month . '-01';
            $tgl2 = $year . '-' . $month . '-' . $last_date;
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $komisi = DB::select("SELECT SUM(a.komisi) as dt_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_karyawan as c ON a.id_kry = c.kd_karyawan
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id_kry");

        $komisi_orchard = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori = 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $komisi_resto = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori != 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $data = [
            'title'  => "Daftar Komisi Penjualan",
            'komisi' => $komisi,
            'komisi_orchard' => $komisi_orchard,
            'komisi_resto' => $komisi_resto,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'dt_rules' => DB::table('tb_rules')->get(),
            'rules_active' => DB::table('tb_rules')->where('status', 1)->first(),
            'total_penjualan' => DB::selectOne("SELECT SUM(a.total) as ttl_penjualan, a.* FROM `tb_invoice` as a
            WHERE a.tgl_jam BETWEEN '$tgl1' AND '$tgl2' AND status = 0"),
        ];

        return view('listPenjualan.komisiPenjualan', $data);
    }

    public function resto(Request $r)
    {
        if (empty($r->tgl1)) {
            $month = date('m');
            $year = date('Y');

            $last_date = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $tgl1 = $year . '-' . $month . '-01';
            $tgl2 = $year . '-' . $month . '-' . $last_date;
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $lokasi = $r->lokasi;
        $komisi = DB::select("SELECT SUM(b.harga) as komisi_penjualan,a.id, b.no_nota, c.nm_karyawan, sum(a.komisi) AS dt_komisi, b.lokasi, d.id_kategori, e.nm_kategori,
        if(d.id_kategori = '6' , e.nm_kategori, b.lokasi) AS lokasi2
        FROM komisi AS a
        LEFT JOIN tb_pembelian AS b ON b.id_pembelian = a.id_pembelian
        LEFT JOIN tb_karyawan AS c ON c.kd_karyawan = a.id_kry
        
        LEFT JOIN tb_produk AS d ON d.id_produk = b.id_produk
        
        
        LEFT JOIN tb_kategori AS e ON e.id_kategori = d.id_kategori
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND d.id_kategori != '6' AND b.lokasi = '$lokasi'
        GROUP BY a.id_kry");

        $komisi_orchard = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori = 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $komisi_resto = DB::selectOne("SELECT SUM(b.harga) as beban_penjualan,SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori != 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $data = [
            'title'  => "Daftar Komisi Penjualan",
            'komisi' => $komisi,
            'komisi_orchard' => $komisi_orchard,
            'komisi_resto' => $komisi_resto,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'lokasi' => $lokasi,
            'dt_rules' => DB::table('tb_rules')->get(),
            'rules_active' => DB::table('tb_rules')->where('status', 1)->first(),
            'total_penjualan' => DB::selectOne("SELECT SUM(a.total) as ttl_penjualan, a.* FROM `tb_invoice` as a
            WHERE a.tgl_jam BETWEEN '$tgl1' AND '$tgl2' AND status = 0"),
        ];

        return view('listPenjualan.komisiResto', ['lokasi' => $lokasi, 'tgl1' => $tgl1, 'tgl2' => $tgl2], $data);
    }

    public function orchard(Request $r)
    {
        if (empty($r->tgl1)) {
            $month = date('m');
            $year = date('Y');

            $last_date = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $tgl1 = $year . '-' . $month . '-01';
            $tgl2 = $year . '-' . $month . '-' . $last_date;
        } else {
            $tgl1 = $r->tgl1;
            $tgl2 = $r->tgl2;
        }

        $lokasi = $r->lokasi;

        $komisi = DB::select("SELECT a.id, b.no_nota, c.nm_karyawan, sum(a.komisi) AS dt_komisi, b.lokasi, d.id_kategori, e.nm_kategori,
        if(d.id_kategori = '6' , e.nm_kategori, b.lokasi) AS lokasi2
        FROM komisi AS a
        LEFT JOIN tb_pembelian AS b ON b.id_pembelian = a.id_pembelian
        LEFT JOIN tb_karyawan AS c ON c.kd_karyawan = a.id_kry
        
        LEFT JOIN tb_produk AS d ON d.id_produk = b.id_produk
        
        
        LEFT JOIN tb_kategori AS e ON e.id_kategori = d.id_kategori
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND d.id_kategori = '6'
        GROUP BY a.id_kry");

        $komisi_orchard = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori = 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $komisi_resto = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori != 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $data = [
            'title'  => "Daftar Komisi Penjualan",
            'komisi' => $komisi,
            'komisi_orchard' => $komisi_orchard,
            'komisi_resto' => $komisi_resto,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'lokasi' => $lokasi,
            'dt_rules' => DB::table('tb_rules')->get(),
            'rules_active' => DB::table('tb_rules')->where('status', 1)->first(),
            'total_penjualan' => DB::selectOne("SELECT SUM(a.total) as ttl_penjualan, a.* FROM `tb_invoice` as a
            WHERE a.tgl_jam BETWEEN '$tgl1' AND '$tgl2' AND status = 0"),
        ];

        return view('listPenjualan.komisiOrchard', $data);
    }

    public function edit_rules_komisi(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;

        $id_rules = $r->id_rules;
        $jenis = $r->jenis;
        $jumlah = $r->jumlah;
        $persen = $r->persen;

        $jenis_tambah = $r->jenis_tambah;
        $jumlah_tambah = $r->jumlah_tambah;
        $persen_tambah = $r->persen_tambah;

        if ($jenis_tambah && $jumlah_tambah && $persen_tambah) {
            $data_tambah = [
                'jenis' => $jenis_tambah,
                'jumlah' => $jumlah_tambah,
                'persen' => $persen_tambah
            ];
            Rules::create($data_tambah);
        }

        if ($id_rules) {
            for ($count = 0; $count < count($id_rules); $count++) {
                $data_update = [
                    'jenis' => $jenis[$count],
                    'jumlah' => $jumlah[$count],
                    'persen' => $persen[$count],
                ];

                Rules::where('id_rules', $id_rules[$count])->update($data_update);
            }
        }

        if ($r->komisi) {
            $data_uncheck = [
                'status' => 0
            ];
            Rules::where('id_rules', '!=', $r->komisi)->update($data_uncheck);


            $data_check = [
                'status' => 1
            ];
            Rules::where('id_rules', $r->komisi)->update($data_check);

            return redirect()->route('komisiPenjualan', ['tgl1' => $tgl1, 'tgl2' => $tgl2])->with('sukses', 'Rules berhasil diubah');
        } else {
            return redirect()->route('komisiPenjualan', ['tgl1' => $tgl1, 'tgl2' => $tgl2])->with('error', 'Pilih rules terlebih dahulu');
        }
    }


    public function excel_komisi_penjualan(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;

        $komisi = DB::select("SELECT SUM(a.komisi) as dt_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_karyawan as c ON a.id_kry = c.kd_karyawan
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.id_kry");

        $komisi_orchard = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori = 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $komisi_resto = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori != 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $data = [
            'title'  => "Daftar Komisi Penjualan",
            'komisi' => $komisi,
            'komisi_orchard' => $komisi_orchard,
            'komisi_resto' => $komisi_resto,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'rules_active' => DB::table('tb_rules')->where('status', 1)->first(),
            'total_penjualan' => DB::selectOne("SELECT SUM(a.total) as ttl_penjualan, a.* FROM `tb_invoice` as a
            WHERE a.tgl_jam BETWEEN '$tgl1' AND '$tgl2' AND status = 0"),
        ];

        return view('listPenjualan.excel',$data);
    }
}
