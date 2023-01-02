<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Model\Daftar_pegawai;

class DaftarPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results['daftar_pegawai'] = Daftar_pegawai::latest()->get();

        return view('daftar_pegawai.index', $results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results['qr_code'] = 'PGW-'.uniqid();
        return view('daftar_pegawai.create', $results);
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
            'namapegawai'=>'required',
            'jabatan'=>'required',
            'fotopegawai'=>'required',
        ]);


        $data = $request->except('_method', '_token', 'fotopegawai');
        if($request->get('fotopegawai')){
            if (!File::exists(public_path("attachments"))) {
                File::makeDirectory(public_path("attachments"));
            }

            if(!File::exists(public_path("attachments/images"))){
                File::makeDirectory(public_path("attachments/images"));
            }

            if(!File::exists(public_path("attachments/images/foto_pegawai"))){
                File::makeDirectory(public_path("attachments/images/foto_pegawai"));
            }

            $file = "attachments/images/foto_pegawai/".$request->get('fotopegawai').".jpg";

            // if ($request->get('fileOrCamera') == 1) {
            //     $img_real = $request->file('fotopegawai');
            //     $image_type = $img_real->getClientOriginalExtension();

            //     $fileName = uniqid() . '.' . $image_type;

            //     $file = $folderPath . $fileName;

            //     $img_real->move($folderPath,$fileName);
            // }else{
            //     $img = $request->get('fotopegawai');

            //     $image_parts = explode(";base64,", $img);
            //     $img_real = base64_decode($image_parts[1]);

            //     $image_type_aux = explode("image/", $image_parts[0]);

            //     $image_type = $image_type_aux[1];
            //     $fileName = uniqid() . '.' . $image_type;

            //     $file = $folderPath . $fileName;

            //     \File::put(public_path().'/'.$folderPath.'/'.$fileName, $img_real);
            // }


            $data['fotopegawai'] = $file;
        }

        $daftar_pegawai = Daftar_pegawai::create($data);

        if (!File::exists(public_path("face_recognition/dataset"))) {
            File::makeDirectory(public_path("face_recognition/dataset"));
        }

        if (!File::exists(public_path("face_recognition/dataset/$daftar_pegawai->id"))) {
            File::makeDirectory(public_path("face_recognition/dataset/$daftar_pegawai->id"));
        }

        for ($i=0; $i <= 30; $i++) {
            $folderFilePathSebelum = "face_recognition/datasementara/".$request->get('fotopegawai').".".$i.".jpg";

            if ($i < 30){
                $folderFilePathTujuan = "face_recognition/dataset/".$daftar_pegawai->id."/User.".$daftar_pegawai->id.'.'.$i.".jpg";
            }else{
                $folderFilePathTujuan = $file;
            }

            rename($folderFilePathSebelum, $folderFilePathTujuan);
        }

        return redirect('admin/daftar-pegawai')->with('success', 'Daftar Pegawai Tersimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result['daftar_pegawai'] = Daftar_pegawai::find($id);


        return view('daftar_pegawai.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'namapegawai'=>'required',
            'jabatan'=>'required',
        ]);

        $data = $request->except('_method', '_token', 'fotopegawai');

        // if($request->get('fotopegawai')){
            // $file = "attachments/images/foto_pegawai/".$request->get('fotopegawai').".jpg";

            // if ($request->get('fileOrCamera') == 1) {
            //     $img_real = $request->file('fotopegawai');
            //     $image_type = $img_real->getClientOriginalExtension();

            //     $fileName = uniqid() . '.' . $image_type;

            //     $file = $folderPath . $fileName;

            //     $img_real->move($folderPath,$fileName);
            // }else{
            //     $img = $request->get('fotopegawai');

            //     $image_parts = explode(";base64,", $img);
            //     $img_real = base64_decode($image_parts[1]);

            //     $image_type_aux = explode("image/", $image_parts[0]);

            //     $image_type = $image_type_aux[1];
            //     $fileName = uniqid() . '.' . 'jpg';

            //     $file = $folderPath . $fileName;

            //     \File::put(public_path().'/'.$folderPath.'/'.$fileName, $img_real);
            // }


        //     $data['fotopegawai'] = $file;
        // }

        $daftar_pegawai = Daftar_pegawai::find($id);

        if (!File::exists(public_path("face_recognition/dataset"))) {
            File::makeDirectory(public_path("face_recognition/dataset"));
        }

        if (!File::exists(public_path("face_recognition/dataset/$daftar_pegawai->id"))) {
            File::makeDirectory(public_path("face_recognition/dataset/$daftar_pegawai->id"));
        }

        if ($request->get('fotopegawai')) {
            for ($i=0; $i <= 30; $i++) {
                $folderFilePathSebelum = "face_recognition/datasementara/".$request->get('fotopegawai').".".$i.".jpg";

                if ($i < 30){
                    $folderFilePathTujuan = "face_recognition/dataset/".$daftar_pegawai->id."/User.".$daftar_pegawai->id.'.'.$i.".jpg";
                }else{
                    $folderFilePathTujuan = $daftar_pegawai->fotopegawai;
                }

                rename($folderFilePathSebelum, $folderFilePathTujuan);
            }
        }

        $daftar_pegawai->update($data);

        return redirect('admin/daftar-pegawai')->with('success', 'Daftar Pegawai Terubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = Daftar_pegawai::find($id)->delete();

        return redirect('admin/daftar-pegawai')->with('success', 'Pegawai Dihapus!');
    }

    public function scanQRCode($qrcode)
    {
        $pegawai = Daftar_pegawai::where('qrcode_p', $qrcode)->first();

        return response()->json($pegawai);
    }

    public function showAjax($id)
    {
        $pegawai = Daftar_pegawai::find($id);

        return response()->json($pegawai);
    }

}
