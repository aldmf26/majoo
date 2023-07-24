<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriSatuanController;
use App\Http\Controllers\KomisiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\listPenjualanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OpnameController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Void_controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['title' => 'Majoo']);
})->name('welcome');

// auth welcome 
Route::get('/auth', [AuthController::class, 'index'])->name('auth');

// login
Route::post('/login', [LoginController::class, 'prosesLogin'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
Route::post('/tambahProduk', [ProdukController::class, 'tambah'])->name('tambahProduk');
Route::post('/editProduk', [ProdukController::class, 'edit'])->name('editProduk');
Route::get('/hapusProduk', [ProdukController::class, 'hapus'])->name('hapusProduk');

// opname
Route::get('/opname', [OpnameController::class, 'index'])->name('opname');
Route::get('/buatOpname', [OpnameController::class, 'buatOpname'])->name('buatOpname');
Route::post('/inputOpname', [OpnameController::class, 'inputOpname'])->name('inputOpname');
Route::get('/detailOpname', [OpnameController::class, 'detailOpname'])->name('detailOpname');
Route::get('/detailStokProduk', [OpnameController::class, 'detailStokProduk'])->name('detailStokProduk');
Route::post('/editStokAktual', [OpnameController::class, 'editStokAktual'])->name('editStokAktual');
Route::get('/deleteOpname', [OpnameController::class, 'deleteOpname'])->name('deleteOpname');
Route::get('/printOpname', [OpnameController::class, 'printOpname'])->name('printOpname');
Route::get('/formulirOpname', [OpnameController::class, 'formulirOpname'])->name('formulirOpname');
Route::post('/tambahOpname', [OpnameController::class, 'tambahOpname'])->name('tambahOpname');

// stok produk
Route::get('/stokProduk', [ProdukController::class, 'stokProduk'])->name('stokProduk');
Route::get('/buatStokProduk', [ProdukController::class, 'buatStokProduk'])->name('buatStokProduk');
Route::post('/inputProdukMasuk', [ProdukController::class, 'inputProdukMasuk'])->name('inputProdukMasuk');
Route::get('/detailStokProduk', [ProdukController::class, 'detailStokProduk'])->name('detailStokProduk');
Route::post('/editStokMasuk', [ProdukController::class, 'editStokMasuk'])->name('editStokMasuk');
Route::get('/deleteStok', [ProdukController::class, 'deleteStok'])->name('deleteStok');
Route::get('/printStokMasuk', [ProdukController::class, 'printStokMasuk'])->name('printStokMasuk');
Route::post('/tambahProdukMasuk', [ProdukController::class, 'tambahProdukMasuk'])->name('tambahProdukMasuk');

// penjualan
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
Route::get('/listPenjualan', [PenjualanController::class, 'listPenjualan'])->name('listPenjualan');
Route::get('/payment', [PenjualanController::class, 'payment'])->name('payment');
Route::get('/get_karyawan', [PenjualanController::class, 'get_karyawan'])->name('get_karyawan');
Route::get('/get_cart', [PenjualanController::class, 'get_cart'])->name('get_cart');
Route::get('/cart', [PenjualanController::class, 'cart'])->name('cart');
Route::get('/get_modal', [PenjualanController::class, 'get_modal'])->name('get_modal');
Route::get('/delete_cart', [PenjualanController::class, 'delete_cart'])->name('delete_cart');
Route::get('/min_cart', [PenjualanController::class, 'min_cart'])->name('min_cart');
Route::get('/plus_cart', [PenjualanController::class, 'plus_cart'])->name('plus_cart');
Route::post('/checkout', [PenjualanController::class, 'checkout'])->name('checkout');
Route::get('/detail_invoice', [PenjualanController::class, 'detail_invoice'])->name('detail_invoice');
Route::post('/edit_pembayaran', [PenjualanController::class, 'edit_pembayaran'])->name('edit_pembayaran');
Route::get('/nota', [PenjualanController::class, 'nota'])->name('nota');
Route::get('/tabelProduk', [PenjualanController::class, 'tabelProduk'])->name('tabelProduk');


Route::get('/listPenjualan', [listPenjualanController::class, 'index'])->name('listPenjualan');
Route::get('/summary_penjualan_produk', [listPenjualanController::class, 'summary_penjualan_produk'])->name('summary_penjualan_produk');
Route::get('/deletePenjualan', [listPenjualanController::class, 'deletePenjualan'])->name('deletePenjualan');
Route::get('/excel_penjualan_produk', [listPenjualanController::class, 'excel_penjualan_produk'])->name('excel_penjualan_produk');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::post('/laporanExcel', [LaporanController::class, 'laporanExcel'])->name('laporanExcel');


Route::get('/komisiTarget', [KomisiController::class, 'komisiTarget'])->name('komisiTarget');
Route::get('/komisiPenjualan', [KomisiController::class, 'komisiPenjualan'])->name('komisiPenjualan');
Route::get('/excel_komisi_penjualan', [KomisiController::class, 'excel_komisi_penjualan'])->name('excel_komisi_penjualan');
Route::get('/resto', [KomisiController::class, 'resto'])->name('resto');
Route::post('/edit_rules_komisi', [KomisiController::class, 'edit_rules_komisi'])->name('edit_rules_komisi');
Route::get('/drop_rules', [KomisiController::class, 'drop_rules'])->name('drop_rules');
Route::get('/summary_komisi_penjualan', [KomisiController::class, 'summary_komisi_penjualan'])->name('summary_komisi_penjualan');
Route::get('/orchard', [KomisiController::class, 'orchard'])->name('orchard');

// kategori & satuan
Route::get('/kategoriSatuan', [KategoriSatuanController::class, 'index'])->name('kategoriSatuan');
Route::post('/tambahKategori', [KategoriSatuanController::class, 'tambahKategori'])->name('tambahKategori');
Route::post('/editKategori', [KategoriSatuanController::class, 'editKategori'])->name('editKategori');
Route::get('/hapusKategori', [KategoriSatuanController::class, 'hapusKategori'])->name('hapusKategori');
Route::post('/tambahSatuan', [KategoriSatuanController::class, 'tambahSatuan'])->name('tambahSatuan');
Route::post('/editSatuan', [KategoriSatuanController::class, 'editSatuan'])->name('editSatuan');
Route::get('/hapusSatuan', [KategoriSatuanController::class, 'hapusSatuan'])->name('hapusSatuan');
// -------------------------------

// user
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::post('/tambahUser', [UserController::class, 'tambah'])->name('tambahUser');
Route::post('/editUser', [UserController::class, 'edit'])->name('editUser');
Route::post('/updatePermission', [UserController::class, 'updatePermission'])->name('updatePermission');
Route::get('/hapusUser', [UserController::class, 'hapus'])->name('hapusUser');
Route::get('/get_permission', [UserController::class, 'get_permission'])->name('get_permission');


// ---------------------------------------------

// waitres
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
Route::post('/tambahKaryawan', [KaryawanController::class, 'tambah'])->name('tambahKaryawan');
Route::post('/editKaryawan', [KaryawanController::class, 'edit'])->name('editKaryawan');
Route::get('/hapusKaryawan', [KaryawanController::class, 'hapus'])->name('hapusKaryawan');


// invoice
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice');
Route::get('/invoiceSummary', [InvoiceController::class, 'invoiceSummary'])->name('invoiceSummary');
Route::post('/void_penjualan', [InvoiceController::class, 'void_penjualan'])->name('void_penjualan');
Route::get('/dataVoid', [Void_controller::class, 'index'])->name('dataVoid');

// ---------------------------------------------
