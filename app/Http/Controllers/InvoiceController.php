<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Tb_invoice;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $r)
    {
        if (!Session::get('nama')) {
            return redirect()->route('welcome');
        } else {
            $hari  = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $id_lokasi = Session::get('id_lokasi');

            $lokasi = $id_lokasi == '1' ? 'TAKEMORI' : 'SOONDOBU';
            if (empty($r->tgl1)) {
                $tgl1   = date('Y-m-') . '01';
                $tgl2   = date('Y-m-') . $hari . ' 23:00:00';
            } else {
                $tgl1   = $r->tgl1;
                $tgl2   = $r->tgl2 . ' 23:00:00';
            }
            $data = [
                'title' => 'Invoice Penjualan',
                'invoice' => DB::select("SELECT * FROM tb_invoice as a  where a.tgl_jam between '$tgl1' and '$tgl2' and a.lokasi = '$lokasi' and a.status ='0' order by a.id DESC "),
                'id_lokasi' => $id_lokasi
            ];
            // dd($data['produk']);
            return view('invoice.invoice', $data);
        }
    }

    public function Void_penjualan(Request $r)
    {
        $nota = $r->no_nota;
        $admin = Session::get('nama');

        $data_void = [
            'status' => '1',
            'nm_void' => $admin,
            'ket_void' => $r->ket_void
        ];
        Tb_invoice::where('no_nota', $nota)->update($data_void);


        $dt_pembelian = Pembelian::where('no_nota', $nota)->get();

        foreach ($dt_pembelian as $d) {

            $produk = Produk::where('id_produk', $d->id_produk)->first();

            $data_stok_produk = [
                'stok' => $produk->stok + $d->jumlah
            ];
            Produk::where('id_produk', $d->id_produk)->update($data_stok_produk);
        }

        $data_void_pembelian = [
            'void' => '1',
        ];
        Pembelian::where('no_nota', $nota)->update($data_void_pembelian);

        return redirect()->route('invoice')->with('sukses', 'Data berhasil di void');
    }

    public function invoiceSummary(Request $r)
    {
        $dt_a   = $r->tgl1;
        $dt_b = $r->tgl2;
        $id_lokasi = Session::get('id_lokasi');
        $lokasi = $id_lokasi == '1' ? 'TAKEMORI' : 'SOONDOBU';
        $data = array(
            'title'  => "Laporan Invoice",
            'invoice' => DB::select("SELECT * FROM tb_invoice as a  where a.tgl_jam between '$dt_a' and '$dt_b' and a.lokasi = '$lokasi' and a.status ='0' order by a.id DESC "),
            'tgl1' => $r->tgl1,
            'tgl2' => $r->tgl2,
        );

        return view('invoice.laporan',$data);
    }
}
