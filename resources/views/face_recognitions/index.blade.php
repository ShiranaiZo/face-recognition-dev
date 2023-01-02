@extends('layoutfrontend')

@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/extensions/sweetalert2/sweetalert2.min.css')}}">

    <style>
        .scroll-vertical{
            display: block;
            overflow-y: scroll;
            height: 190px;
        }
    </style>
@endsection

@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Face Recognition</h3>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            <i class="bi bi-check-circle"></i> {{session('success')}}
            <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            <i class="bi bi-file-excel"></i> {{session('error')}}
            <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <div class="card align-items-center d-none" id="scan_qrcode">
            <div class="card-header">
                <h4 class="card-title">Silahkan login dengan scan QR Code anda terlebih dahulu</h4>
            </div>

            <div class="card-body">
                <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#modal_scan_qrcode"><i class="bi bi-qr-code-scan"></i></button>
            </div>
        </div>

        <div class="card align-items-center d-none" id="scan_wajah">
            <div class="card-header">

                <h4 class="card-title">Scan Qr Code Berhasil! Silahkan scan terlebih dahulu</h4>
            </div>

            <div class="card-body">
                <button id="scan" type="button" class="btn btn-primary btn-lg" onclick="scanWajah()" data-id=""><i class="bi bi-webcam-fill"></i></button>

                <a href="{{ \Request::url() }}"><button id="back" type="button" class="btn btn-danger btn-lg"><i class="bi bi-x-lg"></i></button></a>
            </div>
        </div>


        <div class="card align-items-center d-none" id="wrap_tujuan">
            <div class="card-header">
                <h4 class="card-title">Halo, <span class="text-nama-pegawai"></span>. Apa yang kamu inginkan?</h4>
            </div>

            <div class="card-body">
                @foreach (config("custom.tujuan") as $key_tujuan => $tujuan)
                    <button type="button" class="btn btn-outline-secondary" onclick="tujuanBTN('{{$key_tujuan}}')" data-bs-toggle="modal" data-bs-target="#modal_tujuan">{{ ucfirst($tujuan) }}</button>
                @endforeach

                <button type="button" class="btn btn-danger ms-2" onclick="logout()">Logout</button>
            </div>
        </div>
    </section>

    {{-- Modal Scan QR Code--}}
        <div class="modal fade text-left" id="modal_scan_qrcode" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="myModalLabel120">Scan QR Code</h5>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <video id="scan_qrcode_pegawai" width="100%"></video>
                    </div>
                </div>
            </div>
        </div>
    {{-- Modal Scan QR Code --}}

    {{-- Modal Tujuan--}}
        <div class="modal fade text-left" id="modal_tujuan" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title judul-tujuan" id="myModalLabel120"></h5>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <form action="{{ url('riwayat') }}" method="post" id="form_tujuan">
                        @csrf
                        <input type="hidden" name="_method" id="method_form_tujuan">
                        {{-- <input type="hidden" name="_token" id="token_form_tujuan"> --}}

                        <!-- list Input Hidden -->
                        <div id="list_input_hidden">
                            <input type="hidden" name="tujuan" id="tujuan" value="">
                            <input type="hidden" name="idpegawai" id="idpegawai" value="">

                            <div id="input_hidden_per_item">

                            </div>
                        </div>
                        <!-- /Input Hidden -->

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <video id="scan_qrcode_barang" width="100%"></video>
                                </div>

                                <div class="col-6" class="table-scroll-vertical">
                                    <table style="width: 100%" class="table">
                                        <thead style="display: block">
                                            <tr>
                                                <th style="width: 150px">Barang</th>
                                                <th style="width: 155px" class="text-center">Jumlah</th>
                                                <th style="width: 40px" class="text-left">#</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbody_daftar_barang" class="scroll-vertical">
                                            {{-- <tr>
                                                <td>Sapu</td>
                                                <td class="text-end">
                                                    <div class="input-group">
                                                        <button type="button" onclick="countPlusMinus(-1, '#jumlah', 1)" class="btn btn-light input-group-text">
                                                            <i class="bi bi-dash-lg"></i>
                                                        </button>

                                                        <input type="text" class="form-control text-center mask" placeholder="0" name="jumlah" value="1" id="jumlah">

                                                        <button type="button" onclick="countPlusMinus(1, '#jumlah', 1)" class="btn btn-light input-group-text">
                                                            <i class="bi bi-plus-lg"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button id="remove" type="button" class="btn btn-danger"><i class="bi bi-x-lg"></i></button>
                                                </td>

                                                <!-- Input Hidden -->
                                                <input type="hidden" name="idbarang[]" id="idbarang">
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                    {{-- <video id="scan_qrcode_pegawai" width="100%"></video> --}}
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Cancel</span>
                            </button>

                            <button type="submit" class="btn btn-secondary ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    {{-- Modal Tujuan --}}
@endsection

@section('js')
    <script src="{{asset('assets/extensions/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/sweetalert2.js')}}"></script>>
    <script src="{{asset('assets/extensions/html5-qrcode/html5-qrcode.min.js')}}"></script>
    <script src="{{asset('assets/extensions/instascan/instascan.min.js')}}"></script>

    <script>
        let config_tujuan = {!! json_encode(config('custom.tujuan')); !!};

        function tujuanBTN(key_tujuan) {
            $('.judul-tujuan').html(ucfirst(config_tujuan[key_tujuan]))

            $('#tujuan').val(key_tujuan)

            if (key_tujuan == 'PM' || key_tujuan == 'PN') {
                $('#form_tujuan').attr('action', "{{ url('riwayat') }}")
                $('#method_form_tujuan').val('POST')
            }else{
                $('#form_tujuan').attr('action', "{{ url('riwayat/update') }}")
                $('#method_form_tujuan').val('PATCH')
            }
        }

        // Function for increment and decrement button
        function countPlusMinus(crement, id, min = null, max = null){
            let value = $(id).inputmask('unmaskedvalue')
                value = parseInt(value)
                value = isNaN(value) ? 0 : value
                value += crement

            if(value <= min){
                value = parseInt(min)
            }

            if (value >= max) {
                value = parseInt(max)
            }

            $(id).val(value)
        }

        function logout() {
            sessionStorage.removeItem('id');

            setTimeout(function() {
                window.location.href = "{{url('')}}";
            }, 1000);
        }

        $(document).ready(function () {

            let id = JSON.parse(sessionStorage.getItem("id"));

            if (id) {
                $.ajax({
                    url: "{{ url('daftar-pegawai') }}/"+id,
                    type: 'GET',
                    success: function(res) {
                        $('.text-nama-pegawai').text(res.namapegawai)
                    }
                });

                $('#scan_qrcode').addClass('d-none')
                $('#scan_wajah').addClass('d-none')
                $('#wrap_tujuan').removeClass('d-none')

                $('#idpegawai').val(id)
            }else{
                $('#scan_qrcode').removeClass('d-none')
                $('#scan_wajah').addClass('d-none')
                $('#wrap_tujuan').addClass('d-none')
            }
		});

        function scanWajah() {
            let id = $('#scan').data('id')

            $.ajax({
                    url: "{{ url('face-recognition-scan') }}/"+id,
                    type: 'GET',
                    success: function(res) {
                        if (res == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Scan Berhasil."
                            }).then(function() {
                                sessionStorage.setItem("id", id);

                                window.location.href = "{{url('')}}";
                            });
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Wajah tidak di kenali, hubungi Admin untuk training data."
                            })
                        }
                    }
                });
        }

        // Scan QR Code Pegawai
            let scanner_pegawai = new Instascan.Scanner({ video: document.getElementById('scan_qrcode_pegawai') });

            $('#modal_scan_qrcode').on('shown.bs.modal', function (e) {
                Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner_pegawai.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
                }).catch(function (e) {
                console.error(e);
                });
            })

            $('#modal_scan_qrcode').on('hidden.bs.modal', function (e) {
                scanner_pegawai.stop();
            })

            scanner_pegawai.addListener('scan', function (content) {
                $('#modal_scan_qrcode').modal('hide');

                $.ajax({
                    url: "{{ url('scan-qrcode') }}/"+content,
                    type: 'GET',
                    beforeSend: function(){
                        $('#modal_scan_qrcode .model-content').html(`<span id="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...`).attr('disabled', true)
                    },
                    success: function(res) {
                        $('#scan').data('id', res.id)

                        if (jQuery.isEmptyObject(res)){
                            Swal.fire({
                                icon: "error",
                                title: "QR Code Anda Bukan Pegawai."
                            })
                        }else{
                            Swal.fire({
                                icon: "success",
                                title: "Scan QR Code Berhasil."
                            })

                            $('#scan_qrcode').addClass('d-none')
                            $('#scan_wajah').removeClass('d-none')
                            $('#wrap_tujuan').addClass('d-none')
                        }
                    }
                });
            });
        // Scan QR Code Pegawai

        // Scan QR Code Barang
            let scanner_barang = new Instascan.Scanner({ video: document.getElementById('scan_qrcode_barang') });

            $('#modal_tujuan').on('shown.bs.modal', function (e) {
                Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner_barang.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
                }).catch(function (e) {
                console.error(e);
                });
            })

            $('#modal_tujuan').on('hidden.bs.modal', function (e) {
                scanner_barang.stop();
                $('#tbody_daftar_barang').html('')
                $('#input_hidden_per_item').html('')
            })

            scanner_barang.addListener('scan', function (content) {
                let tujuan = $('#tujuan').val()
                let idpegawai = $('#idpegawai').val()

                $.ajax({
                    url: "{{ url('scan-qrcode-barang') }}/"+content+'/'+tujuan+'/'+idpegawai,
                    type: 'GET',
                    success: function(res) {
                        let html = ""
                        let input_hidden = ""
                        let data = res.data

                        // Jika Tujuan Pengambilan atau Penggunaan
                        if (tujuan == 'PM' || tujuan == 'PN') {
                            if (res.pesan == ''){
                                if ($("tr").hasClass(`item-${data.id}`)) {
                                    let jumlah = $(`#jumlah_${data.id}`).val()
                                        jumlah = parseInt(jumlah)
                                        jumlah += 1

                                    $(`#jumlah_${data.id}`).val(jumlah)
                                }else{
                                    html += `
                                                <tr class="item-${data.id}">
                                                    <td style="width:150px">
                                                        <h6>${data.namabarang}</h6>
                                                        <p>${data.kodebarang} (Stock: ${data.jumlah})</p>
                                                    </td>
                                                    <td class="text-end" style="width:155px">
                                                        <div class="input-group">
                                                            <button type="button" onclick="countPlusMinus(-1, '#jumlah_${data.id}', 1, ${data.jumlah})" class="btn btn-light input-group-text">
                                                                <i class="bi bi-dash-lg"></i>
                                                            </button>

                                                            <input type="text" class="form-control text-center mask" placeholder="0" name="jumlah[${data.id}]" value="1" id="jumlah_${data.id}">

                                                            <button type="button" onclick="countPlusMinus(1, '#jumlah_${data.id}', 1, ${data.jumlah})" class="btn btn-light input-group-text">
                                                                <i class="bi bi-plus-lg"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td style="width:40px">
                                                        <button onclick="removeElement('.item-${data.id}')" type="button" class="btn btn-danger"><i class="bi bi-x-lg"></i></button>
                                                    </td>
                                                </tr>
                                            `

                                    input_hidden += `
                                                        <div class="item-${data.id}">
                                                            <input type="hidden" value="${data.id}" name="idbarang[${data.id}]">
                                                            <input type="hidden" value="${data.kodebarang}" name="kodebarang[${data.id}]">
                                                        </div>
                                                    `
                                }

                                setTimeout(function() {
                                    $('#jumlah_'+data.id).inputmask({"alias": "decimal", "groupSeparator": ",", "digits": 0 , "autoGroup": true, "clearMaskOnLostFocus": false, "allowMinus": false, max: data.jumlah, min:1 });
                                }, 1000);

                            }else{
                                html += `
                                            <tr class="alert-barang">
                                                <td colspan="3">
                                                    <div class="alert alert-danger alert-dismissible show fade">
                                                        <i class="bi bi-file-excel"></i> ${res.pesan}

                                                        <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close" onclick="removeElement('.alert-barang')"></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `

                                setTimeout(function() {
                                    $('.alert-barang').remove();
                                }, 5000);
                            }
                        }else{
                            if (res.pesan == ''){
                                $.each(res.riwayat, function(key_riwayat, riwayat){
                                    if ($("tr").hasClass(`item-${riwayat.id}`)) {
                                        html = `
                                                <tr class="alert-barang">
                                                    <td colspan="3">
                                                        <div class="alert alert-danger alert-dismissible show fade">
                                                            <i class="bi bi-file-excel"></i> Barang sudah ada di tabel ini

                                                            <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close" onclick="removeElement('.alert-barang')"></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `

                                        setTimeout(function() {
                                            $('.alert-barang').remove();
                                        }, 5000);
                                    }else{
                                        html += `
                                                    <tr class="item-${riwayat.id}">
                                                        <td style="width:150px">
                                                            <h6>${riwayat?.barang?.namabarang}</h6>
                                                            <p>${riwayat.kodebarang}</p>
                                                        </td>
                                                        <td class="text-end" style="width:155px">
                                                            <div class="input-group">
                                                                <button type="button" class="btn btn-light input-group-text" disabled>
                                                                    <i class="bi bi-dash-lg"></i>
                                                                </button>

                                                                <input type="text" class="form-control text-center mask" placeholder="0" name="jumlah[${riwayat.id}]" value="${riwayat.jumlah}" id="jumlah_${riwayat.id}" readonly>

                                                                <button type="button" class="btn btn-light input-group-text" disabled>
                                                                    <i class="bi bi-plus-lg"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td style="width:40px">
                                                            <input type="checkbox" class="form-check-input form-check-primary" checked name="checkbox_riwayat[${riwayat.id}]" id="check_${riwayat.id}">
                                                        </td>
                                                    </tr>
                                                `

                                        input_hidden += `
                                                            <div class="item-${riwayat.id}">
                                                                <input type="hidden" value="${data.id}" name="idbarang[${riwayat.id}]">
                                                                <input type="hidden" value="${riwayat.id}" name="idriwayat[${riwayat.id}]">
                                                            </div>
                                                        `
                                    }
                                });
                            }else{
                                html += `
                                            <tr class="alert-barang">
                                                <td colspan="3">
                                                    <div class="alert alert-danger alert-dismissible show fade">
                                                        <i class="bi bi-file-excel"></i> ${res.pesan}

                                                        <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close" onclick="removeElement('.alert-barang')"></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `

                                setTimeout(function() {
                                    $('.alert-barang').remove();
                                }, 5000);
                            }
                        }

                        $('#tbody_daftar_barang').prepend(html)
                        $('#input_hidden_per_item').append(input_hidden)
                    }
                });
            });
        // Scan QR Code Barang

        function removeElement(element) {
            $(element).remove()
        }
    </script>

@endsection
