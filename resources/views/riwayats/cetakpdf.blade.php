<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cetak Riwayat</title>
    <style>
        @page {
          margin: 56.69px;
        }

        body{
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        #table_riwayat {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 14px;
        }

        #table_riwayat td, #table_riwayat th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #table_riwayat tr:nth-child(even){background-color: #f2f2f2;}

        #table_riwayat tr:hover {background-color: #ddd;}

        #table_riwayat th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #525659;
          color: white;
        }

        .summarylist {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            font-size: 11px;
            width: 250px;
        }

        .summarylist th{
            padding-top: 6px;
            padding-bottom: 6px;
            text-align: right;
        }
    </style>
</head>

<body style="background-color:#ffffff;">
    <main>
        <table style="border-collapse: collapse;width:100%;margin-bottom: 100px">
            <tr>
                <td style="width: 40%">
                    <img src="{{public_path('assets/images/logo/logo.jpg')}}" alt="gambar tidak di temukan" width="40%">
                </td>

                <td style="width: 20%;text-align: center">
                    <h1>Riwayat</h1>
                </td>

                <td style="width: 40%;text-align: right">
                    <span>Report Printed on: {{ ddmmyyyy_now() }}</span>
                </td>
            </tr>
        </table>

        <table id="table_riwayat">
            <thead>
                <tr>
                    <th style="text-align: center">No</th>
                    <th style="text-align: center">Nama Pegawai</th>
                    <th style="text-align: center">Nama Barang</th>
                    <th style="text-align: center">Jumlah</th>
                    <th style="text-align: center">Tujuan</th>
                    <th style="text-align: center">Tanggal Awal</th>
                    <th style="text-align: center">Tanggal Akhir</th>
                </tr>
            </thead>

            <tbody>
                @if (!$riwayats->isEmpty())
                    @foreach ($riwayats as $key => $riwayat)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ @$riwayat->pegawai->namapegawai }}</td>
                            <td>
                                <h3>{{ @$riwayat->barang->namabarang }}</h3>
                                <p>{{ @$riwayat->barang->kodebarang }}<p>
                            </td>
                            <td>{{ $riwayat->jumlah }}</td>
                            <td>{{ ucfirst(config('custom.tujuan.'.$riwayat->tujuan)) }}</td>
                            <td>{{ ddmmyyyy($riwayat->tgl_awal) }}</td>
                            <td>{{ ddmmyyyy($riwayat->tgl_akhir) }}</td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align: center">No data available in table</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </main>
</body>
</html>
