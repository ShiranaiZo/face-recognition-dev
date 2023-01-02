@extends('layout')

@section('title', 'Daftar Pegawai')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/extensions/sweetalert2/sweetalert2.min.css')}}">
@endsection

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
                    <a href="{{ url('admin/daftar-pegawai/create') }}" class="btn icon btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </div>

                <div class="float-end">
                    <button id="training_btn" class="btn icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Training Data" onclick="training()">
                        Training Data
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table" id="table_users">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto Pegawai</th>
                            <th>Qr Code</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($daftar_pegawai as $key_pegawai => $pegawai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($pegawai->fotopegawai) }}" alt="Can't load image." width="120px">
                            </td>
                            <td>{!! $pegawai->qrcode_p ? \QrCode::size(100)->generate($pegawai->qrcode_p) : '' !!}</td>
                            <td>{{ $pegawai->namapegawai }}</td>
                            <td>{{ $pegawai->jabatan }}</td>
                            <td>
                                <div class="buttons">
                                    <a href="{{ url('admin/daftar-pegawai/'.$pegawai->id.'/edit') }}" class="btn icon btn-primary tooltip-class" data-bs-placement="left" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button" class="btn icon btn-danger tooltip-class" data-bs-placement="right" title="Remove" data-bs-toggle="modal" data-bs-target="#modal_remove" onclick="modalRemove('{{ url('admin/daftar-pegawai/'.$pegawai->id) }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Modal Remove--}}
        <div class="modal fade text-left" id="modal_remove" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title white" id="myModalLabel120">Confirmation</h5>

                        <button type="button" class="close" data-bs-dismiss="modal"aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure want to remove this data?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">No</span>
                        </button>

                        <form action="" method="post" id="form_delete_user">
                            @method("DELETE")
                            @csrf

                            <button type="submit" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Yes</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- Modal Remove --}}
@endsection

@section('js')
    <script src="{{asset('assets/extensions/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/sweetalert2.js')}}"></script>>

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

        // Sweetalert
       function training(params) {
            $.ajax({
                url: "{{ url('face-recognition-training') }}",
                type: 'GET',
                beforeSend: function(){
                    $('#training_btn').html(`<span id="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...`).attr('disabled', true)
                },
                success: function(res) {
                    Swal.fire({
                        icon: "success",
                        title: "Success"
                    })
                },
                complete: function(){
                    $('#training_btn').html(`Training Data`).attr('disabled', false)
                }
            });
       }
    </script>
@endsection
