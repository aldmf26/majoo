<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class PenjualanController extends Controller
{
    public function index(Request $r)
    {
        $agent = new Agent();
        $id_lokasi = Session::get('id_lokasi');
        $id_user = User::where('nama', strtolower(Session::get('nama')))->first();

        $data = [
            'title' => 'Penjulan',
            'kategori' => Kategori::all(),
            'produk' => Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where('tb_produk.id_lokasi', $id_lokasi)->orderBy('tb_produk.id_produk', 'ASC')->get(),
            'id_lokasi' => $id_lokasi,
        ];

        if ($id_user->role_id != 1) {
            if ($agent->is('Windows')) {
                return view('404', $data);
            } else {
                return view('penjualan.penjualan', $data);
            }
        }

        return view('penjualan.penjualan', $data);
    }

    public function edit_pembayaran(Request $r)
    {
        dd($r->all());
    }

    public function tabelProduk(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        if ($r->search == null) {
            $produk = Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where('tb_produk.id_lokasi', $id_lokasi)->orderBy('tb_produk.id_produk', 'ASC')->get();
        } else {
            $produk = Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where('tb_produk.id_lokasi', $id_lokasi)->where('tb_produk.nm_produk', 'LIKE', '%' . $r->search . '%')->orderBy('tb_produk.id_produk', 'ASC')->get();
        }

        $data = [
            'title' => 'produk',
            'produk' => $produk,
        ];
        return view('penjualan.pr', $data);
    }

    public function searchProduk(Request $r)
    {
        $id_lokasi = Session::get('id_lokasi');
        $produk = Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where('tb_produk.id_lokasi', $id_lokasi)->where('tb_produk.nm_produk', 'LIKE', '%' . $r->search . '%')->orderBy('tb_produk.id_produk', 'ASC')->get();
        $data = [
            'title' => 'produk',
            'produk' => $produk,
        ];
        return view('penjualan.pr', $data);
    }

    public function get_cart(Request $r)
    {
        if (empty(Cart::content())) {
            echo '<div class="card">
            <div class="card-body">
                <h3 class="text-center">Keranjang Belanja</h3>
                <hr>
                <center><br><br>
                    <img width="100" src="' . asset('assets') . 'uploads/icon/cart.png" alt=""><br><br>
                    <h5>keranjang belanja kosong!</h5>
                </center><br>
    
            </div>
        </div>';
        } else {
            echo ' <div class="card">';

            echo '<div class="card-body">
                <h3 class="text-center">Product</h3>
                <hr>';
            $subtotal_produk = 0;
            $jumlah = 0;
            foreach (Cart::content() as $k) {
                if ($k->options->type == 'barang') {
                    echo '<div class="row">';


                    $subtotal_produk += $k->price * $k->qty;
                    $jumlah += $k->qty;
                    echo '<div class="col-sm-12 col-md-12">';
                    foreach ($k->options->nm_karyawan as $key => $nm_karyawan) {
                        foreach ($nm_karyawan as $c) {
                            echo  '<span class="badge badge-secondary">' . $c . '</span> ';
                        }
                    }
                    echo '<p>' . $k->name . '</p>               
                    </div>
                    <div class="col-sm-6 col-md-6">
                    <p>' . $k->qty . ' x <strong>Rp.' . number_format($k->price) . '</strong> </p>
                    </div>
                    <div class="col-sm-6 col-md-6 text-center text-lg">
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                        <a class="min_cart mr-2" id="' . $k->rowId . '" qty="' . $k->qty . '" href="javascript:void(0)" style="margin-top: 50px;"><i class="fa fa-minus"></i></a>
                        </div>
                        <div class="col-sm-4 col-md-4">
                        <a class="delete_cart mr-2" id="' . $k->rowId . '" href="javascript:void(0)" style="margin-top: 50px;"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="col-sm-4 col-md-4">
                        <a class="plus_cart mr-2" id="' . $k->rowId . '" qty="' . $k->qty . '" id_produk="' . $k->id . '" href="javascript:void(0)" style="margin-top: 50px;"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>            
                    </div>
                    <div class="col-md-6">
                    <strong>Rp. ' . number_format($k->qty * $k->price, 0) . '</strong>
                    </div>
                    <div class="col-md-12 mb-4">
                    <hr>
                    </div>';
                }
            }
            echo '<div class="container">
            <strong>Subtotal ' . $jumlah . ' produk</strong> <strong style="float: right;">Rp. ' . number_format($subtotal_produk) . '</strong>
            
            </div';
            echo '<div class="row">';


            echo '<div class="container">
                        <hr>
                        <strong style="font-size: 20px;">Total</strong> <strong style="float: right; font-size: 22px;">Rp. ' . number_format($subtotal_produk) . '</strong>
                        <hr>
                    </div>
                    
                </div>
                <a type="button" data-toggle="modal" data-target="#myModalp" class="btn btn-costume btn-block text-light" font-weight: bold;">LANJUTKAN KE PEMBAYARAN</a>
                </div>
                </div>';
        }
    }

    public function get_karyawan(Request $r)
    {
        $karyawan = Karyawan::where('posisi', '!=', 'KITCHEN')->get();
        echo '<div class="row">';
        foreach ($karyawan as $k) {
            echo '<div class="col-lg-2 col-4">
                            <label class="btn btn-default buying-selling">
                            <div class="checkbox-group required">
                                <input type="checkbox" name="kd_karyawan[]" id value="' . $k->kd_karyawan . '" autocomplete="off" class="cart_id_karyawan option1">
                            </div>	
                                <span class="radio-dot"></span>
                                <span class="buying-selling-word">' . $k->nm_karyawan . '</span>
                            </label>
                            </div>';
        }
        echo   '</div>';
    }

    public function get_modal(Request $r)
    {
        $data = [
            'k' => Produk::join('tb_kategori', 'tb_produk.id_kategori', 'tb_kategori.id_kategori')->join('tb_satuan', 'tb_produk.id_satuan', 'tb_satuan.id_satuan')->where([['tb_produk.id_lokasi', Session::get('id_lokasi')], ['id_produk', $r->id_produk]])->first(),
        ];
        return view('penjualan.modal', $data);
    }

    public function cart(Request $r)
    {
        $id = $r->id;
        $jumlah = $r->jumlah;
        $satuan = $r->satuan;
        $catatan = $r->catatan;
        $id_karyawan = $r->kd_karyawan;
        $qty = 0;
        foreach (Cart::content() as $cart) {
            if ($cart->options->type == 'barang') {
                if ($id == $cart->id) {
                    $qty = $cart->qty + $jumlah;
                }
            }
        }
        $detail = Produk::where('id_produk', $id)->first();

        if (empty($id_karyawan)) {
            echo "null";
        } else {
            if ($jumlah > ($detail->stok)) {
                echo 'kosong';
            } elseif ($qty > ($detail->stok)) {
                echo 'kosong';
            } else {
                foreach ($id_karyawan as $id_kr) {

                    $kry = Karyawan::where('kd_karyawan', $id_kr)->first();
                    $karyawan[] = preg_replace("/[^a-zA-Z0-9]/", " ", $kry->nm_karyawan);
                }
                $harga = $detail->harga;
                $data = array(
                    'id' => $id,
                    'qty'     => $r->jumlah,
                    'price'   => $harga,
                    'name'    => preg_replace("/[^a-zA-Z0-9]/", " ", $detail->nm_produk),
                    'options' => [
                        'picture' => $detail->foto,
                        'satuan'  => $satuan,
                        'catatan' => $catatan,
                        'id_karyawan'   => $id_karyawan,
                        'nm_karyawan'   => [$karyawan],
                        'type'    => 'barang',

                    ],

                );

                Cart::add($data);
            }
        }
    }

    public function delete_cart(Request $r)
    {
        $rowId = $r->rowid;
        Cart::remove($rowId);
    }

    public function min_cart(Request $r)
    {
        $rowId = $r->rowid;
        $qty = $r->qty - 1;
        Cart::update($rowId, ['qty' => $qty]);
    }

    public function plus_cart(Request $r)
    {


        $id_produk = $r->id_produk;
        $produk = Produk::where('id_produk', $id_produk)->first();

        $stok_produk = $produk->stok  - 1;
        if ($stok_produk < $r->qty) {
            echo '<div style="background-color: #FFA07A;" class="alert" role="alert">Stok tidak ckup!  <div class="ml-5 btn btn-sm"><i class="fas fa-times-circle fa-2x"></i></div></div>';
        } else {
            $rowId = $r->rowid;
            $qty = $r->qty + 1;
            Cart::update($rowId, ['qty' => $qty]);
        }
    }

    public function payment(Request $r)
    {
        $now = date('Y-m-d');

        $data = [
            'title' => 'Payment Order Produk',
            'cart' => Cart::content(),
            'nota' => DB::select("SELECT count(no_nota) as maxKode FROM tb_invoice where tb_invoice.tgl_jam = '$now' group by tb_invoice.tgl_jam"),
            'pembayaran' => DB::table('klasifikasi_pembayaran')->get()
        ];

        return view('penjualan.payment', $data);
    }

    public function checkout(Request $r)
    {
        $id_user = User::where('nama', strtolower(Session::get('nama')))->first();
        $admin = $id_user->id_user;
        $q = DB::select("SELECT MAX(RIGHT(no_invoice,4)) AS kd_max FROM tb_kd_invoice WHERE DATE(tanggal)=CURDATE()");
        $kd = "";
        if ($q) {
            foreach ($q as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        $no_invoice = date('ymd') . $kd;

        $hasil = DB::table('tb_kd_invoice')->insert(['no_invoice' => $no_invoice]);
        $i_invoice = $hasil;

        $no_nota = 'TS' . $no_invoice;
        $id_lokasi = Session::get('id_lokasi');
        $lokasi = $id_lokasi == 1 ? 'TAKEMORI' : 'SOONDOBU';


        $cek_nota = DB::table('tb_invoice')->where('lokasi', $lokasi)->first();
        date_default_timezone_set('Asia/Makassar');
        $awal  = strtotime($cek_nota->tgl_input ?? date('Y-m-d'));
        $akhir = strtotime(date('Y-m-d H:i:s'));
        $diff  = $akhir - $awal;
        $menit = floor($diff / 60);

        if ($menit < 1) {
            Cart::destroy();
            return redirect()->route('detail_invoice', ['invoice' => $cek_nota->no_nota]);
        } else {
            $total = $r->total;
            $cash = $r->cash ?? 0;
            $mandiri_debit = $r->mandiri_debit ?? 0;
            $mandiri_kredit = $r->mandiri_kredit ?? 0;
            $bca_kredit = $r->bca_kredit ?? 0;
            $bca_debit = $r->bca_debit ?? 0;
            $no_meja = $r->no_meja;
            $invoice = $r->invoice;
            $ttlBayarHanyar = 0;
            foreach ($r->pembayaran as  $d) {
                $ttlBayarHanyar += $d;
            }


            // $bayar = $cash + $mandiri_debit + $mandiri_kredit + $bca_debit + $bca_kredit;
            $bayar = $ttlBayarHanyar;
            $cart = Cart::content();


            if ($cart) {

                if ($total <= $bayar) {

                    // $total = 0;
                    foreach ($cart as $c) {
                        if ($c->price > 0) {
                            $subharga = $c->qty * $c->price;
                        } else {
                            $subharga = 0;
                        }

                        $nm_karyawan = '';
                        $length = count($c->options->nm_karyawan[0]);
                        $number = 1;
                        foreach ($c->options->nm_karyawan as $key => $karyawan) {
                            foreach ($karyawan as $kar) {
                                $nm_karyawan .= $kar;
                                if ($number !== $length) {
                                    $nm_karyawan .= ', ';
                                }
                                $number++;
                            }
                        }


                        $d_produk = Produk::where('id_produk', $c->id)->where('id_lokasi', $id_lokasi)->first();
                        $data = [
                            'id_karyawan'  => $c->options->id_karyawan[0],
                            'id_produk' => $c->id,
                            'nm_karyawan' => $nm_karyawan,
                            'no_nota' => $no_nota,
                            'jumlah' => $c->qty,
                            'harga' => $c->price,
                            'total' => $c->price * $c->qty,
                            'tanggal' => date('Y-m-d'),
                            'tgl_input' => date('Y-m-d H:i:s'),
                            'admin' => $admin,
                            'lokasi' => $lokasi,
                            'no_meja' => $no_meja,
                            'jml_komisi' => $d_produk->komisi
                        ];
                        $dataInsert = Pembelian::create($data);
                        $id_pembelian = $dataInsert->id;



                        $stok_baru = [
                            'stok' => $d_produk->stok - $c->qty
                        ];


                        Produk::where('id_produk', $c->id)->update($stok_baru);
                        if ($subharga > 0) {
                            // $komisi1 = $subharga * $produk['komisi'] /100;
                            if ($d_produk->komisi > 0) {
                                $komisi1 = $subharga * $d_produk->komisi / 100;
                                $komisi = $komisi1 / count($c->options->id_karyawan);
                                foreach ($c->options->id_karyawan as $id_karyawan) {
                                    $data_komisi = [
                                        'id_pembelian' => $id_pembelian,
                                        'id_kry'  => $id_karyawan,
                                        'komisi' => $komisi,
                                        'tgl' => date('Y-m-d')
                                    ];
                                    DB::table('komisi')->insert($data_komisi);
                                }
                            }
                        }
                    }
                    $data_invoice = [
                        'no_nota' => $no_nota,
                        'total' => $total,
                        'cash' => $cash,
                        'mandiri_kredit' => $mandiri_kredit,
                        'mandiri_debit' => $mandiri_debit,
                        'bca_kredit' => $bca_kredit,
                        'bca_debit' => $bca_debit,
                        'bayar' => $bayar,
                        'kembali' => $bayar -  $total,
                        'tgl_jam' => date('Y-m-d'),
                        'tgl_input' => date('Y-m-d H:i:s'),
                        'admin' => $admin,
                        'no_meja' => $no_meja,
                        'invoice' => $invoice,
                        'lokasi' => $lokasi
                    ];
                    for ($i = 0; $i < count($r->pembayaran); $i++) {
                        if ($r->pembayaran[$i] != 0) {
                            DB::table('pembayaran')->insert([
                                'id_akun_pembayaran' => $r->id_akun[$i],
                                'no_nota' => $no_nota,
                                'nominal' => $r->pembayaran[$i],
                                'pengirim' => $r->pengirim[$i],
                                'tgl' => date('Y-m-d'),
                            ]);
                        }
                    }
                    DB::table('tb_invoice')->insert($data_invoice);


                    Cart::destroy();
                    return redirect()->route('detail_invoice', ['invoice' => $no_nota]);
                } else {
                    return redirect()->route('payment')->with('error', 'Mohon maaf, jumlah bayar kurang dari jumlah tagihan / data pembayaran gagal dikirim. Harap lakukan pembayaran lagi');
                }
            } else {
                return redirect()->route('detail_invoice', ['invoice' => $cek_nota->no_nota]);
            }
        }
    }

    public function nota(Request $r)
    {
        $no_nota = $r->invoice;
        $invoice = DB::selectOne("SELECT a.*, b.* FROM tb_invoice as a
        LEFT JOIN users as b ON a.admin = b.id_user
        WHERE a.no_nota = '$no_nota'");

        $produk = DB::select("SELECT a.harga as harga, a.nm_karyawan as nm_karyawan, a.jumlah as jumlah, c.nm_produk as nm_produk, c.harga as harga_asli, c.diskon as diskon FROM tb_pembelian as a
        LEFT JOIN tb_invoice as b ON a.no_nota = b.no_nota
        LEFT JOIN tb_produk as c ON a.id_produk = c.id_produk
        WHERE a.no_nota = '$no_nota'");
        $data = [
            'title'  => "Nota",
            'invoice' => $invoice,
            'produk' => $produk,
            'pembayaran' => DB::select("SELECT * FROM `pembayaran` as a 
            LEFT JOIN akun_pembayaran as b ON a.id_akun_pembayaran = b.id_akun_pembayaran
            LEFT JOIN klasifikasi_pembayaran as c ON c.id_klasifikasi_pembayaran = b.id_klasifikasi
            WHERE a.no_nota = '$no_nota';")
        ];

        return view('penjualan.nota', $data);
    }

    public function detail_invoice(Request $r)
    {
        $no_nota = $r->invoice;
        $invoice = DB::table('tb_invoice')->where('no_nota', $no_nota)->first();

        $produk = DB::select("SELECT a.harga as harga, a.jumlah as jumlah, c.nm_produk FROM `tb_pembelian` as a
        LEFT JOIN tb_invoice as b on a.no_nota = b.no_nota
        LEFT JOIN tb_produk as c on a.id_produk = c.id_produk
        WHERE a.no_nota = '$no_nota'");


        $data = [
            'title'  => "Detail Invoice",
            'invoice' => $invoice,
            'produk' => $produk,
            'no_nota' => $no_nota,
            'pembayaran' => DB::table('klasifikasi_pembayaran')->get()
        ];

        return view('penjualan.detail_invoice', $data);
    }
}
