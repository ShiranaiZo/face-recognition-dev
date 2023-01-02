<?php

namespace App\Exports;

use App\Model\Riwayat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RiwayatExport implements FromView
{
    protected $results;

    public function __construct($results){
        $this->results = $results;
    }

    public function view(): View
    {
        $results = $this->results;

        return view('riwayats.cetakexcel', $results);
    }
}
