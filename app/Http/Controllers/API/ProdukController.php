<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function get($id_lokasi = 1)
    {
        if (isset($id_lokasi)) {
            $produk = Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where('tb_produk.id_lokasi', $id_lokasi)->orderBy('tb_produk.id_produk', 'DESC')->get();

            return response()->json(['msg' => 'Data retrieved', 'data' => $produk], 200);
        } else {
            $produk = Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->orderBy('tb_produk.id_produk', 'DESC')->get();

            return response()->json(['msg' => 'Data retrieved', 'data' => $produk], 200);
        }
    }

    public function komisi($lokasi, $tgl1, $tgl2)
    {

        if ($tgl1 == '' || $tgl2 == '') {
            $month = date('m');
            $year = date('Y');

            $last_date = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $tgl1 = $year . '-' . $month . '-01';
            $tgl2 = $year . '-' . $month . '-' . $last_date;
        } else {
            $tgl1 = $tgl1;
            $tgl2 = $tgl2;
        }
        
        $komisi = DB::select("SELECT SUM(b.harga) as komisi_penjualan,a.id, b.no_nota, c.nm_karyawan, sum(a.komisi) AS dt_komisi, b.lokasi, d.id_kategori, e.nm_kategori,
        if(d.id_kategori = '6' , e.nm_kategori, b.lokasi) AS lokasi2
        FROM komisi AS a
        LEFT JOIN tb_pembelian AS b ON b.id_pembelian = a.id_pembelian
        LEFT JOIN tb_karyawan AS c ON c.kd_karyawan = a.id_kry
        
        LEFT JOIN tb_produk AS d ON d.id_produk = b.id_produk
        
        
        LEFT JOIN tb_kategori AS e ON e.id_kategori = d.id_kategori
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND d.id_kategori != '6' AND b.lokasi = '$lokasi'
        GROUP BY a.id_kry");

        $komisi_resto = DB::selectOne("SELECT SUM(b.harga) as beban_penjualan,SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori != 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $komisi_orchard = DB::selectOne("SELECT SUM(a.komisi) as beban_komisi, b.*, c.*, a.* FROM `komisi` as a
        LEFT JOIN tb_pembelian as b ON a.id_pembelian = b.id_pembelian
        LEFT JOIN tb_produk as c ON b.id_produk = c.id_produk
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2'
        AND c.id_kategori = 6
        AND a.id_kry != 418
        AND a.id_kry != 419
        GROUP BY a.id_kry");

        $dt_rules = DB::table('tb_rules')->get();
        $rules_active = DB::table('tb_rules')->where('status', 1)->first();
        $total_penjualan = DB::selectOne("SELECT SUM(a.total) as ttl_penjualan, a.* FROM `tb_invoice` as a
        WHERE a.tgl_jam BETWEEN '$tgl1' AND '$tgl2' AND status = 0");
        $data = [
            'msg' => 'Data Sukses',
            'komisi' => $komisi,
            'dt_rules' => $dt_rules,
            'rules_active' => $rules_active,
            'total_penjualan' => $total_penjualan,
            'komisi_resto' => $komisi_resto,
            'komisi_orchard' => $komisi_orchard,
            200
        ];
        return response()->json($data);
    }
    
    public function komisiGaji($lokasi, $nama, $tgl1, $tgl2)
    {
        $lokasi = $lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU';
        $komisi = DB::select("SELECT SUM(b.harga) as komisi_penjualan,a.id, b.no_nota, c.nm_karyawan, sum(a.komisi) AS dt_komisi, b.lokasi, d.id_kategori, e.nm_kategori,
        if(d.id_kategori = '6' , e.nm_kategori, b.lokasi) AS lokasi2
        FROM komisi AS a
        LEFT JOIN tb_pembelian AS b ON b.id_pembelian = a.id_pembelian
        LEFT JOIN tb_karyawan AS c ON c.kd_karyawan = a.id_kry
        
        LEFT JOIN tb_produk AS d ON d.id_produk = b.id_produk
        
        
        LEFT JOIN tb_kategori AS e ON e.id_kategori = d.id_kategori
        WHERE a.tgl BETWEEN '$tgl1' AND '$tgl2' AND d.id_kategori != '6' AND b.lokasi = '$lokasi' AND c.nm_karyawan = '$nama'
        GROUP BY a.id_kry");
        $data = [
            'msg' => 'Data Sukses',
            'komisi' => $komisi,
            200
        ];
        return response()->json($data);
    }
    public function kom_majo_server($tgl1, $tgl2)
    {
        $komisi = DB::select("SELECT b.komisi, sum(a.total) as total, sum(a.total * (b.komisi/100)) as komisi_bagi, a.lokasi
    FROM tb_pembelian as a 
    left join tb_produk as b on b.id_produk = a.id_produk
    WHERE b.komisi != '0' and a.tanggal between '$tgl1' and '$tgl2' 
    group by b.komisi , a.lokasi;");
        $data = [
            'msg' => 'Data Sukses',
            'komisi' => $komisi,
            200
        ];
        return response()->json($data);
    }
    public function penjualn_server($lokasi,$tgl1, $tgl2)
    {
        $komisi = DB::select("SELECT b.nm_produk, sum(a.jumlah) as jumlah, b.komisi, sum(a.total) as total, a.lokasi 
        FROM tb_pembelian as a 
        left join tb_produk as b on b.id_produk = a.id_produk 
        where a.tanggal BETWEEN '$tgl1' and '$tgl2' and b.komisi != '0' and a.lokasi = '$lokasi'
        group by a.id_produk;");
        $data = [
            'msg' => 'Data Sukses',
            'komisi' => $komisi,
            200
        ];
        return response()->json($data);
    }
    
    public function laporan($lokasi, $tgl1, $tgl2)
    {
        $data = [
            'msg' => 'Data Sukses',
            'laporan' => DB::select("SELECT a.*, SUM(a.jumlah) as jlh, SUM(a.total) as total, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
            LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
            LEFT JOIN tb_kategori as c ON b.id_kategori = c.id_kategori
            LEFT JOIN tb_satuan as d ON b.id_satuan = d.id_satuan
            WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.void = 0 AND a.lokasi = '$lokasi' AND b.id_kategori != 6
            GROUP BY a.id_produk"),
            200
        ];
        return response()->json($data);
    }
    
    public function add_karyawan($nama)
    {
        $data = [
            'nm_karyawan' => $nama,
            'posisi' => 'WAITRESS',
            'pangkat' => 'SERVER',
            'tgl_join' => date('Y-m-d'),
          ];
        Karyawan::create($data);
    }

}
