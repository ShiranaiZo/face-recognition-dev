<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Databarang extends Model
{
    use SoftDeletes;
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $table = '_data_barang';

    public function riwayat(){
        return $this->hasMany('\App\Model\Riwayat', 'idbarang', 'id');
    }
}
