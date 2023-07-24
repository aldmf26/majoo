<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_karyawan', function (Blueprint $table) {
            $table->integerIncrements('kd_karyawan');
            $table->string('id_karyawan')->nullable();
            $table->string('nm_karyawan')->nullable();
            $table->string('posisi')->nullable();
            $table->string('pangkat')->nullable();
            $table->double('gaji_e')->nullable();
            $table->double('gaji_m')->nullable();
            $table->double('gaji_sp')->nullable();
            $table->double('gaji_off')->nullable();
            $table->double('bonus')->nullable();
            $table->double('bonus_posisi')->nullable();
            $table->date('tgl_join');
            $table->date('tkmr')->nullable();
            $table->date('sdb')->nullable();
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
        Schema::dropIfExists('tb_karyawan');
    }
}
