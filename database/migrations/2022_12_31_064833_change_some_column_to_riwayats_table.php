<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSomeColumnToRiwayatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->unsignedBigInteger('idpegawai')->nullable()->change();
            $table->string('kodebarang')->nullable()->change();
            $table->string('tujuan')->nullable()->change();
            $table->date('tgl_awal')->nullable()->change();
            $table->date('tgl_akhir')->nullable()->change();
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
            //
        });
    }
}
