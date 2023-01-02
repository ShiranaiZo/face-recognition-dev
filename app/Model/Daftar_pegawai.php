<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Daftar_pegawai extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    protected $table = 'daftar_pegawai';

    public function riwayat(){
        return $this->hasMany('\App\Model\Riwayat', 'idbarang', 'id');
    }
}
