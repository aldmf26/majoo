<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->integerIncrements('id_barang');
            $table->integer('id_satuan');
            $table->string('kode_barang')->nullable();
            $table->string('nm_barang');
            $table->float('harga');
            $table->integer('stok');
            $table->integerIncrements('foto')->nullable();
            $table->date('tgl_beli');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_barang');
    }
}
