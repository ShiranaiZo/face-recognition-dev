<?php

namespace App\Http\Controllers;

use App\Model\Databarang;
use App\Model\Riwayat;
use App\Exports\RiwayatExport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $result['jumlahdata_barang'] = Databarang::latest()->get()->count();
        $result['data_barang'] = Databarang::where('jumlah', '<=', 3)->get();
        $result['BK'] = Riwayat::latest()->take(10)->get();
        $result['BP'] = Riwayat::whereNull('tgl_akhir')->where('tujuan', 'PM')->get();

        return view('index', $result);
    }
}
