<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;

Route::get('admin', 'LoginController@checkLogin');
Route::get('', function () {
    return view('face_recognitions.index');
});
Route::post('admin/login', 'LoginController@login');
Route::get('admin/logout', 'LoginController@logout');

Route::get('admin/login', function () {
    return view('login');
})->name('login');

Route::get('face-recognition-scan/{id}', 'FaceRecognitionController@scanWajah');
Route::get('scan-qrcode/{qrcode}', 'DaftarPegawaiController@scanQRCode');
Route::get('daftar-pegawai/{id}', 'DaftarPegawaiController@showAjax');
Route::get('scan-qrcode-barang/{qrcode}/{tujuan}/{idpegawai}', 'DataBarangController@scanQRCode');
Route::patch('riwayat/update', 'RiwayatController@update');
Route::resource('riwayat', 'RiwayatController');

Route::group(['middleware' => ['auth']], function() {
    Route::get('admin/dashboard', 'DashboardController@index');

	//super admin
    // Route::group(['middleware' => ['roles:1']], function() {
		// *****************CRUD Users********************
			Route::resource('admin/users', 'UserController');
			Route::resource('admin/daftar-pegawai', 'DaftarPegawaiController');
			Route::resource('admin/data-barang', 'DatabarangController');
			Route::get('admin/riwayat/cetak-pdf/{filter?}', 'RiwayatController@index');
			Route::get('admin/riwayat/cetak-excel/{filter?}', 'RiwayatController@index');
			Route::get('admin/riwayat/{filter?}', 'RiwayatController@index');

            // Face Recognition
            Route::get('face-recognition-rekam', 'FaceRecognitionController@rekamDataWajah');
            Route::get('face-recognition-training', 'FaceRecognitionController@trainingData');
	// });
});
