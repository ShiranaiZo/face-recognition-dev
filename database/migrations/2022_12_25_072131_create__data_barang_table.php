<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_data_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kodebarang')->nullable();
            $table->string('namabarang')->nullable();
            $table->string('qrcode_b')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('jenis')->nullable();
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
        Schema::dropIfExists('_data_barang');
    }
}
