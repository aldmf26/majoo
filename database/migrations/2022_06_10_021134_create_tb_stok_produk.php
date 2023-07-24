<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbStokProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_stok_produk', function (Blueprint $table) {
            $table->integerIncrements('id_stok_produk');
            $table->string('kode_stok_produk');
            $table->integer('id_produk');
            $table->integer('stok_program');
            $table->integer('harga');
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->date('tgl');
            $table->dateTime('tgl_input');
            $table->string('ket')->nullable();
            $table->integer('admin');
            $table->string('jenis');
            $table->string('status');
            $table->id_lokasi('id_lokasi');
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
        Schema::dropIfExists('tb_stok_produk');
    }
}
