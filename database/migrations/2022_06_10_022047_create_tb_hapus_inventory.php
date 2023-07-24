<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHapusInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_hapus_inventory', function (Blueprint $table) {
            $table->integerIncrements('id_hapus');
            $table->string('id_satuan');
            $table->string('barang');
            $table->double('debit');
            $table->double('kredit');
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
        Schema::dropIfExists('tb_hapus_inventory');
    }
}
