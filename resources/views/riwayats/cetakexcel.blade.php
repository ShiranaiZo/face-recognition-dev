<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center">Riwayat</th>
        </tr>
    </thead>
</table>

<table id="table_riwayat">
    <thead>
        <tr>
            <th style="text-align: center;width: 50px">No</th>
            <th style="text-align: center;width: 200px">Nama Pegawai</th>
            <th style="text-align: center;width: 200px">Nama Barang</th>
            <th style="text-align: center;width: 50px">Jumlah</th>
            <th style="text-align: center;width: 100px">Tujuan</th>
            <th style="text-align: center;width: 100px">Tanggal Awal</th>
            <th style="text-align: center;width: 100px">Tanggal Akhir</th>
        </tr>
    </thead>

    <tbody>
        @if (!$riwayats->isEmpty())
            @foreach ($riwayats as $key => $riwayat)
                <tr>
                    <td style="text-align: center;width: 50px">{{ $loop->iteration }}</td>
                    <td style="width: 200px">{{ @$riwayat->pegawai->namapegawai }}</td>
                    <td style="width: 200px;margin: 0 ">
                        <h3 style="margin: 0 ">{{ @$riwayat->barang->namabarang }}</h3>
                        <p style="margin: 0 ">{{ @$riwayat->barang->kodebarang }}<p>
                    </td>
                    <td style="width: 50px">{{ $riwayat->jumlah }}</td>
                    <td style="width: 100px">{{ ucfirst(config('custom.tujuan.'.$riwayat->tujuan)) }}</td>
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
