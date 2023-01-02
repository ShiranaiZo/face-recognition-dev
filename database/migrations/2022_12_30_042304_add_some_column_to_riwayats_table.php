<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToRiwayatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->unsignedBigInteger('idbarang')->after('idpegawai');
            $table->integer('jumlah')->after('tujuan');
            $table->integer('batch')->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn(['jumlah', 'idbarang', 'batch']);
        });
    }
}
