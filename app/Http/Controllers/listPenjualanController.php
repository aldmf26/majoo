<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class listPenjualanController extends Controller
{
    public function index(Request $r)
    {
        if (empty($r->tgl1)) {
            // $bulan = date('m');
            // $year = date('Y');
            $lokasi = Session::get('id_lokasi') == 1 ? 'TAKEMORI' : 'SOONDOBU';
            $date = date('Y-m-d');
            $data = [
                'title'  => "list penjualan",
                'list' => Pembelian::join('tb_produk', 'tb_pembelian.id_produk', 'tb_produk.id_produk')
                    ->join('users', 'tb_pembelian.admin', 'users.id_user')
                    ->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')
                    ->orderBy('tb_pembelian.id_pembelian', 'DESC')
                    ->where([['tb_pembelian.lokasi', $lokasi], ['tb_pembelian.tanggal', $date], ['void', 0]])->get(),

            ];
        } else {
            $lokasi = Session::get('id_lokasi') == 1 ? 'TAKEMORI' : 'SOONDOBU';
            $dt_a   = $r->tgl1;
            $dt_b   = $r->tgl2;
            $data = array(
                'title'  => "list penjualan",
                'list' => Pembelian::join('tb_produk', 'tb_pembelian.id_produk', 'tb_produk.id_produk')
                    ->join('users', 'tb_pembelian.admin', 'users.id_user')
                    ->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')
                    ->orderBy('tb_pembelian.id_pembelian', 'DESC')
                    ->whereBetween('tb_pembelian.tanggal', [$dt_a, $dt_b])
                    ->where([['tb_pembelian.lokasi', $lokasi], ['void', 0]])->get(),
            );
        }
        return view('listPenjualan.penjualan', $data);
    }

    public function summary_penjualan_produk(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $lokasi = Session::get('id_lokasi') == 1 ? 'TAKEMORI' : 'SOONDOBU';
        $penjualan = DB::select("SELECT a.*, SUM(a.total) as total, SUM(a.jumlah) as jumlah, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
        LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
        LEFT JOIN tb_kategori as c on b.id_kategori = c.id_kategori
        LEFT JOIN tb_satuan as d on b.id_satuan = d.id_satuan
        WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.lokasi = '$lokasi' AND void = 0
        GROUP BY a.id_produk;");

        $data = [
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'penjualan' => $penjualan,
            'void' => 0,
            'sort' => date('d-M-y', strtotime($tgl1)) . " ~ " . date('d-M-y', strtotime($tgl2)),
            'lokasi' => $lokasi
        ];

        return view('listPenjualan.summary', $data);
    }

    public function excel_penjualan_produk(Request $r)
    {
        $tgl1 = $r->tgl1;
        $tgl2 = $r->tgl2;
        $lokasi = Session::get('id_lokasi') == 1 ? 'TAKEMORI' : 'SOONDOBU';

        $penjualan = DB::select("SELECT a.*, SUM(a.total) as total, SUM(a.jumlah) as jumlah, AVG(a.harga) as rt_harga, b.*,c.*,d.* FROM `tb_pembelian` as a
        LEFT JOIN tb_produk as b ON a.id_produk = b.id_produk
        LEFT JOIN tb_kategori as c on b.id_kategori = c.id_kategori
        LEFT JOIN tb_satuan as d on b.id_satuan = d.id_satuan
        WHERE a.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.lokasi = '$lokasi' AND void = 0
        GROUP BY a.id_produk;");


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);

        $sheet
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'KATEGORI')
            ->setCellValue('C1', 'NAMA PRODUK')
            ->setCellValue('D1', 'HARGA SATUAN')
            ->setCellValue('E1', 'QTY')
            ->setCellValue('F1', 'SATUAN')
            ->setCellValue('G1', 'TOTAL');

        $kolom = 2;
        $no = 1;
        $ttl = 0;
        foreach ($penjualan as $k) {
            $ttl += $k->total;
            $sheet
                ->setCellValue('A' . $kolom, $no++)
                ->setCellValue('B' . $kolom, $k->nm_kategori)
                ->setCellValue('C' . $kolom, $k->nm_produk)
                ->setCellValue('D' . $kolom, $k->rt_harga)
                ->setCellValue('E' . $kolom, $k->jumlah)
                ->setCellValue('F' . $kolom, $k->satuan)
                ->setCellValue('G' . $kolom, $k->total);
            $kolom++;
        }
        $batas1 = count($penjualan) + 1;
        $sheet->setCellValue('G' . $kolom, $ttl);
        $sheet->setCellValue('F' . $kolom, 'TOTAL');

        $writer = new Xlsx($spreadsheet);
        $style = [
            'borders' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ];

        $batas = count($penjualan) + 2;
        $sheet->getStyle('A1:G' . $batas)->applyFromArray($style);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="List Penjualan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
