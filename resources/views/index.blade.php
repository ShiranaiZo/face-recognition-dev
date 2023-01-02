@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admin</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                        <div class="stats-icon blue mb-3 bi bi-box2">
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                        <h6 class="text-muted font-semibold">Jumlah Barang Keseluruhan</h6>
                        <h6 class="font-extrabold mb-0">{{ $jumlahdata_barang }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Stok Barang Minim</h4>
            </div>
            <div class="card-body">
                <table class="table" id="data_barang">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data_barang as $key => $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $barang->kodebarang }}</td>
                                <td>{{ $barang->namabarang }}</td>
                                <td>{{ $barang->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Barang Keluar</h4>
            </div>

            <div class="card-body">
                <table class="table" id="BK">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tujuan</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($BK as $key => $keluar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ @$keluar->pegawai->namapegawai }}</td>
                                <td>
                                    <h6>{{ @$keluar->barang->namabarang }}</h6>
                                    <p>{{ @$keluar->barang->kodebarang }}<p>
                                </td>
                                <td>{{ $keluar->jumlah }}</td>
                                <td>{{ ucfirst(config('custom.tujuan.'.$keluar->tujuan)) }}</td>
                                <td>{{ ddmmyyyy($keluar->tgl_awal) }}</td>
                                <td>{{ ddmmyyyy($keluar->tgl_akhir) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Barang yang Dipinjam</h4>
            </div>

            <div class="card-body">
                <table class="table" id="BP">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tujuan</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($BP as $key => $pinjam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ @$pinjam->pegawai->namapegawai }}</td>
                                <td>
                                    <h6>{{ @$pinjam->barang->namabarang }}</h6>
                                    <p>{{ @$pinjam->barang->kodebarang }}<p>
                                </td>
                                <td>{{ $pinjam->jumlah }}</td>
                                <td>{{ ucfirst(config('custom.tujuan.'.$pinjam->tujuan)) }}</td>
                                <td>{{ ddmmyyyy($pinjam->tgl_awal) }}</td>
                                <td>{{ ddmmyyyy($pinjam->tgl_akhir) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
                <script>
                    $(document).ready(function () {
                    // Init Datatable
                    $("#data_barang").DataTable();
                    $("#BK").DataTable();
                    $("#BP").DataTable();
                    });

                </script>
@endsection
