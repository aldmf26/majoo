<?php

use App\Http\Controllers\API\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::get('produk', [ProdukController::class, 'get']);
Route::get('produk/{id_lokasi}', [ProdukController::class, 'get']);

Route::get('komisi', [ProdukController::class, 'komisi']);

Route::get('komisi/{lokasi}/{tgl1}/{tgl2}', [ProdukController::class, 'komisi']);

Route::get('kom_majo_server/{tgl1}/{tgl2}', [ProdukController::class, 'kom_majo_server']);

Route::get('penjualn_server/{lokasi}/{tgl1}/{tgl2}', [ProdukController::class, 'penjualn_server']);

Route::get('komisiGaji/{lokasi}/{nama}/{tgl1}/{tgl2}', [ProdukController::class, 'komisiGaji']);

Route::get('add_karyawan/{nama}', [ProdukController::class, 'add_karyawan'])->middleware('api_key');

Route::get('laporan/{lokasi}/{tgl1}/{tgl2}', [ProdukController::class, 'laporan']);

