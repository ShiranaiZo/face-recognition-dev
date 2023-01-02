<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Riwayat extends Model
{
    use SoftDeletes;
    protected $guarded = [
        'id', 'created_at'
    ];

    public function barang(){
        return $this->belongsTo('\App\Model\Databarang', 'idbarang', 'id');
    }

    public function pegawai(){
        return $this->belongsTo('\App\Model\Daftar_pegawai', 'idpegawai', 'id');
    }
}
