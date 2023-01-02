<?php

namespace App\Http\Controllers;

use App\Model\Databarang;
use App\Model\Riwayat;
use Illuminate\Http\Request;

class DatabarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results['data_barang'] = Databarang::latest()->get();
        return view('data_barang.index', $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results['qr_code_b'] = 'BRG-'.uniqid();
        return view('data_barang.create', $results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kodebarang'=>'required',
            'namabarang'=>'required',
            'jumlah'=>'required',
        ]);

        $data = $request->except('_method', '_token');
        $data_barang = Databarang::create($data);

        return redirect('admin/data-barang')->with('success', 'Data Barang Tersimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Databarang  $databarang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Databarang  $databarang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result['data_barang'] = Databarang::find($id);

        return view('data_barang.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Databarang  $databarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kodebarang'=>'required',
            'namabarang'=>'required',
            'jumlah'=>'required',
        ]);

        $data = $request->except('_method', '_token');

        if (!$request->get('jenis')) {
            $data['jenis'] = null;
        }

        $data_barang = Databarang::find($id)->update($data);
        return redirect('admin/data-barang')->with('success', 'Data Barang Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Databarang  $databarang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Databarang::find($id)->delete();

        return redirect('admin/data-barang')->with('success', 'Barang Dihapus!');
    }

    public function scanQRCode($qrcode, $tujuan, $idpegawai)
    {
        $results['pesan'] = '';
        $results['riwayat'] = array();
        $results['data'] = Databarang::where('qrcode_b', $qrcode)->first();

        if ($tujuan == 'PN') {
            if ($results['data']){
                if ($results['data']->jenis == null) {
                    $results['pesan'] = "Barang tidak sekali pakai, silahkan ke peminjaman";
                }
            }else{
                $results['pesan'] = "Barang tidak di temukan, pastikan QR Code anda benar";
            }
        }elseif ($tujuan == 'PM'){
            if ($results['data']){
                if ($results['data']->jenis == 'on') {
                    $results['pesan'] = "Barang sekali pakai, silahkan ke penggunaan";
                }
            }else{
                $results['pesan'] = "Barang tidak di temukan, pastikan QR Code anda benar";
            }
        }else {
            if ($results['data']){
                $results['riwayat'] = Riwayat::where('idpegawai', $idpegawai)->where('idbarang', $results['data']->id)->whereNull('tgl_akhir')->where('tujuan', "PM")->with('barang', 'pegawai')->get();

                if (count($results['riwayat']) <= 0) {
                    $results['pesan'] = "Anda belum meminjam barang ini";
                }
            }else{
                $results['pesan'] = "Barang tidak di temukan, pastikan QR Code anda benar";
            }
        }

        return response()->json($results);
    }
}
