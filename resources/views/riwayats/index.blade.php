@extends('layout')

@section('title', 'Riwayat')

@section('content')
    <section class="section">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <i class="bi bi-check-circle"></i> {{session('success')}}
                <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <div class="btn-group dropdown dropdown-icon-wrapper me-1 mb-1">
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-printer-fill dropdown-icon"></i> Cetak
                        </button>

                        <div class="dropdown-menu">
                            <a href="{{ url('admin/riwayat/cetak-pdf').(request()->filter ? '/'.request()->filter : '') }}" class="dropdown-item" target="_blank">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
                            </a>

                            <a href="{{ url('admin/riwayat/cetak-excel').(request()->filter ? '/'.request()->filter : '') }}" class="dropdown-item" target="_blank">
                                <i class="bi bi-file-earmark-excel-fill"></i> Cetak Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="float-end">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Filter</label>

                        <select class="form-select" id="inputGroupSelect01" onchange="filter(this.value)">
                            <option {{request()->filter ? '' : 'selected'}} value="">Semua</option>

                            @foreach (config('custom.tujuan') as $key_tujuan => $tujuan)
                                @if ($key_tujuan == 'K')
                                    @continue
                                @endif

                                <option {{request()->filter == $key_tujuan ? 'selected' : ''}} value="{{$key_tujuan}}">{{ucfirst($tujuan)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table" id="table_users">
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
                        @foreach ($riwayats as $key => $riwayat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ @$riwayat->pegawai->namapegawai }}</td>
                                <td>
                                    <h6>{{ @$riwayat->barang->namabarang }}</h6>
                                    <p>{{ @$riwayat->barang->kodebarang }}<p>
                                </td>
                                <td>{{ @$riwayat->jumlah }}</td>
                                <td>{{ ucfirst(config('custom.tujuan.'.$riwayat->tujuan)) }}</td>
                                <td>{{ ddmmyyyy($riwayat->tgl_awal) }}</td>
                                <td>{{ ddmmyyyy($riwayat->tgl_akhir) }}</td>

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
            $("#table_users").DataTable();
		});

        // Init Tooltip
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('#table_users .tooltip-class'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);

        // Modal Remove
        function modalRemove(url) {
            $('#form_delete_user').attr("action", url)
        }

        // Trigger Ketika filter
        function filter(filter) {
            if(filter == ''){
                window.location.href = "{{url('admin/riwayat')}}";
            }
            else{
                window.location.href = "{{url('admin/riwayat')}}/"+filter;
            }
        }
    </script>
@endsection

