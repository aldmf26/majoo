<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function getAllQuery($tgl1, $tgl2, $kategori = null, $orchad = null)
    {
        if (empty($kategori)) {
            $query = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0
            GROUP BY a.id_produk");
        } elseif (empty($orchad)) {
            $query = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = '$kategori' AND b.id_kategori NOT IN (6,11)
            GROUP BY a.id_produk");
        } else {
            $query = DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = '$kategori' AND b.id_kategori = $orchad
            GROUP BY a.id_produk");
        }
        return $query;
    }
    public function index(Request $r)
    {

        $tgl1 = $r->tgl1 ?? date('Y-m-01');
        $tgl2 = $r->tgl2 ?? date('Y-m-t');

        $jenis = $r->jenis;
        if (empty($jenis)) {
            $all = $this->getAllQuery($tgl1, $tgl2);
        }
        if ($jenis == 'tkm') {
            $all = $this->getAllQuery($tgl1, $tgl2, 'TAKEMORI');
        } elseif ($jenis == 'sdb') {
            $all = $this->getAllQuery($tgl1, $tgl2, 'SOONDOBU');
        } else {
            $takemori = $this->getAllQuery($tgl1, $tgl2, 'TAKEMORI', $jenis);
            $soondobu = $this->getAllQuery($tgl1, $tgl2, 'SOONDOBU', $jenis);
        }

        $data = [
            'title' => "Laporan Penjualan",
            'all' => $all ?? '',
            'soondobu' => $soondobu ?? '',
            'takemori' => $takemori ?? '',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'jenis' => $jenis,
        ];
        return view('laporan.laporan', $data);
    }

    public function laporanExcel(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $lokasi = $r->lokasi;
        $jenis = $r->jenis;

        if (empty($jenis)) {
            $all = $this->getAllQuery($tgl1, $tgl2);
        }
        if ($jenis == 'tkm') {
            $all = $this->getAllQuery($tgl1, $tgl2, 'TAKEMORI');
        } elseif ($jenis == 'sdb') {
            $all = $this->getAllQuery($tgl1, $tgl2, 'SOONDOBU');
        } else {
            $takemori = $this->getAllQuery($tgl1, $tgl2, 'TAKEMORI', $jenis);
            $soondobu = $this->getAllQuery($tgl1, $tgl2, 'SOONDOBU', $jenis);
        }

        $data = [
            'title' => "Laporan Penjualan",
            'penjualan' => $all,
            'soondobu' => $soondobu ?? '',
            'takemori' => $takemori ?? '',
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'jenis' => $jenis,
            'sort'      => date('d-M-y', strtotime($tgl1)) . " ~ " . date('d-M-y', strtotime($tgl2))
        ];
        return view('laporan.excel', $data);
    }
}
