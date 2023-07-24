<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_produk', function (Blueprint $table) {
            $table->integerIncrements('id_produk');
            $table->integer('id_kategori');
            $table->integer('id_satuan');
            $table->string('sku')->nullable();
            $table->string('nm_produk');
            $table->float('harga_modal')->nullable();
            $table->float('harga');
            $table->integer('stok');
            $table->integer('terjual')->nullable();
            $table->text('foto')->nullable();
            $table->float('diskon')->nullable();
            $table->double('komisi');
            $table->enum('monitoring', ['y', 't']);
            $table->integer('id_lokasi')->nullable();
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
        Schema::dropIfExists('tb_produk');
    }
}
