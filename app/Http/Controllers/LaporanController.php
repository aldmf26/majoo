<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $r)
    {
        if (empty($r->tgl1)) {
            $last = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $tgl1 = date('Y-m-01');            
            $tgl2 = date('Y-m-').$last;
        }else {
           $tgl1 = $r->tgl1;
           $tgl2 = $r->tgl2;
        }

        $jenis = $r->jenis;
        if($jenis == 'tkm') {
            $all = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'TAKEMORI' AND b.id_kategori != 6
            GROUP BY a.id_produk");
            $jenis = 'tkm';
            $takemori = '';
            $soondobu = '';
        } elseif($jenis == 'sdb') {
            $jenis = 'sdb';
            $takemori = '';
            $soondobu = '';
            $all = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'SOONDOBU' AND b.id_kategori != 6
            GROUP BY a.id_produk");
        } elseif($jenis == 'orc') {
            $jenis = 'orc';
            $takemori = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'TAKEMORI' AND b.id_kategori = 6
            GROUP BY a.id_produk");

            $soondobu = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'SOONDOBU' AND b.id_kategori = 6
            GROUP BY a.id_produk");
            $all = '';
        } else {
            $jenis = '';
            $all = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0
            GROUP BY a.id_produk");
            $takemori = '';
            $soondobu = '';
        }
        

        $data = [
            'title' => "Laporan Penjualan",
            'all' => $all,
            'soondobu' => $soondobu,
            'takemori' => $takemori,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'jenis' => $jenis,
        ];
        return view('laporan.laporan',$data);
    }

    public function laporanExcel(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $lokasi = $r->lokasi;
        $jenis = $r->jenis;

        if($jenis == 'tkm') {
            $all = DB::select("SELECT a.*, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'TAKEMORI' AND b.id_kategori != 6
            GROUP BY a.id_produk");
            $jenis = 'tkm';
            $takemori = '';
            $soondobu = '';
        } elseif($jenis == 'sdb') {
            $jenis = 'sdb';
            $takemori = '';
            $soondobu = '';
            $all = DB::select("SELECT a.*, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'SOONDOBU' AND b.id_kategori != 6
            GROUP BY a.id_produk");
        } elseif($jenis == 'orc') {
            $jenis = 'orc';
            $takemori = DB::select("SELECT a.*, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'TAKEMORI' AND b.id_kategori = 6
            GROUP BY a.id_produk");

            $soondobu = DB::select("SELECT a.*, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = 'SOONDOBU' AND b.id_kategori = 6
            GROUP BY a.id_produk");
            $all = '';
        } else {
            $jenis = '';
            $all = DB::select("SELECT a.*, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0
            GROUP BY a.id_produk");
            $takemori = '';
            $soondobu = '';
        }

        $data = [
            'title' => "Laporan Penjualan",
            'penjualan' => $all,
            'soondobu' => $soondobu,
            'takemori' => $takemori,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'jenis' => $jenis,
            'sort'      => date('d-M-y', strtotime($tgl1))." ~ ".date('d-M-y', strtotime($tgl2))
        ];
        return view('laporan.excel',$data);
    }
}
