<?php

namespace App\Http\Controllers;

use App\Model\Riwayat;
use App\Model\Databarang;
use Illuminate\Http\Request;
use App\Exports\RiwayatExport;

use Excel;
use PDF;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null)
    {
        $results['riwayats'] = Riwayat::latest();

        if ($filter) {
            $results['riwayats'] = $results['riwayats']->where('tujuan', $filter)->get();
        }else{
            $results['riwayats'] = $results['riwayats']->get();
        }
        // dd($request->path(), 'admin/riwayat/cetak-pdf'.($filter ? '/'.$filter : ''));
        if ($request->path() == 'admin/riwayat/cetak-pdf'.($filter ? '/'.$filter : '')) {
            $pdf = PDF::loadview('riwayats.cetakpdf', $results)
                  ->setPaper('legal', 'landscape');

            return $pdf->stream('riwayat'.($filter ? '_'.$filter : '').'_'.ddmmyyyy_now().'.pdf');
        }else if($request->path() == 'admin/riwayat/cetak-excel'.($filter ? '/'.$filter : '')){
            return Excel::download(new RiwayatExport($results), 'riwayat'.($filter ? '_'.$filter : '').'_'.ddmmyyyy_now().'.xlsx');
        }else{
            return view('riwayats.index', $results);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_method', '_token');

        if ($request->get('idbarang')) {
            foreach ($data['idbarang'] as $key_idbarang => $idbarang) {
                $riwayat = Riwayat::create([
                    'idpegawai' => $data['idpegawai'],
                    'idbarang' => $idbarang,
                    'kodebarang' => $data['kodebarang'][$key_idbarang],
                    'tujuan' => $data['tujuan'],
                    'jumlah' => $data['jumlah'][$key_idbarang],
                    'tgl_awal' => yyyymmdd_now()
                ]);

                $barang = Databarang::find($idbarang);

                $barang->update([
                    'jumlah' => $barang->jumlah - $data['jumlah'][$key_idbarang]
                ]);
            }

            return redirect('')->with('success', ucfirst(config('custom.tujuan.'.$data['tujuan'])).' berhasil');
        }else{
            return redirect('')->with('error',  ucfirst(config('custom.tujuan.'.$data['tujuan'])).' tidak berhasil');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function show(Riwayat $riwayat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function edit(Riwayat $riwayat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_method', '_token');

        if ($request->get('checkbox_riwayat')) {
            foreach ($request->get('checkbox_riwayat') as $key_checkbox_riwayat => $checkbox_riwayat) {
                $riwayat = Riwayat::find($data['idriwayat'][$key_checkbox_riwayat])->update([
                    'tgl_akhir' => yyyymmdd_now()
                ]);

                $barang = Databarang::find($data['idbarang'][$key_checkbox_riwayat]);

                $barang->update([
                    'jumlah' => $barang->jumlah + $data['jumlah'][$key_checkbox_riwayat]
                ]);
            }

            return redirect('')->with('success', 'Pengembalian barang berhasil');
        }else{
            return redirect('')->with('error', 'Tidak ada barang yang di kembalikan');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Riwayat $riwayat)
    {
        //
    }
}
