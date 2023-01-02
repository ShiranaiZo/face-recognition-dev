@extends('layout')

@section('title', "Create | Daftar Pegawai")

@section('content')
    @if ($errors->any())
        <div class="card-body pt-0">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible show fade">
                    <i class="bi bi-file-excel"></i> {{ $error }}

                    <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah Daftar Pegawai</h4>
        </div>

        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ url('admin/daftar-pegawai') }}" id="form_create_user" enctype="multipart/form-data">
                    @method('POST')
                    @csrf

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nama Pegawai<span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-8 form-group">
                                <input type="text" id="namapegawai" class="form-control  @error('namapegawai') is-invalid @enderror" name="namapegawai" placeholder="Nama Pegawai" value="{{ old('namapegawai') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Jabatan <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-8 form-group">
                                <input type="text" id="jabatan" class="form-control  @error('jabatan') is-invalid @enderror" name="jabatan" placeholder="Jabatan" value="{{ old('jabatan') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Qr Code <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-2 form-group">
                                <div id="qr_code_wrap" style="width: 100px; height: 100px; background-color: #eee">
                                    {!! \QrCode::size(100)->generate($qr_code); !!}
                                    <input type="hidden" id="qrcode_p" class ="form-control  @error('qrcode_p') is-invalid @enderror" name="qrcode_p" placeholder="QR Code" value="{{ $qr_code }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Foto Pegawai <span class="text-danger">*</span></label>

                            </div>

                            <div class="col-md-4 form-group text-center">
                                <img id="preview_image" src="{{ asset('assets/images/faces/5.jpg') }}" alt="Can't load image." style="max-width: 100%; width: auto">

                                <input type="hidden" id="fotopegawai_camera" name="fotopegawai">
                            </div>

                            <div class="col-md-4 form-group">
                                <div class="form-check">
                                    <button type="button" class="btn btn-lg icon btn-info" id="btn_foto_pegawai_camera" onclick="rekamDataWajah()">
                                        <i class="bi bi-camera-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary me-1 mb-1 submit_create_user" id="submit_create_user" onclick='preventDoubleClick("form_create_user", "submit_create_user")'>Submit</button>

                            <a href="{{ url('admin/daftar-pegawai') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ambil Foto--}}
        <div class="modal fade text-left" id="modal_ambil_foto" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="myModalLabel120">Ambil Foto</h5>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div id="ambil_foto" class="buttons text-center">
                            <button type="button" class="btn icon btn-info tooltip-class" data-bs-placement="right" onclick="ambilFoto()">
                                <i class="bi bi-record-circle-fill"></i>
                            </button>
                        </div>

                        <div id="konfirmasi_foto" class="buttons text-center" style="display: none">
                            <button type="button" class="btn icon btn-warning tooltip-class" data-bs-placement="right" onclick="ulangiFoto()">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>

                            <button type="button" class="btn icon btn-success tooltip-class" data-bs-placement="right" onclick="lolosFoto()">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- Modal Ambil Foto --}}
@endsection

@section('js')
    <script src="{{asset("assets/extensions/webcamjs-master/webcam.min.js")}}"></script>

    <script>
        $(document).ready(function () {
            // show and hide password
            $('#show').click(function(){
                if($(this).is(':checked')){
                    $('#password').prop('type', 'text')
                }else{
                    $('#password').prop('type', 'password')
                }
            })

            $('input:radio[name="fileOrCamera"]').change(function(){
                if($('#file_foto').is(':checked')){
                    $('#btn_foto_pegawai_camera').attr('disabled', true)
                    $('#fotopegawai_camera').attr('disabled', true)

                    $('#fotopegawai_file').attr('disabled', false)
                }else{
                    $('#btn_foto_pegawai_camera').attr('disabled', false)
                    $('#fotopegawai_camera').attr('disabled', false)

                    $('#fotopegawai_file').attr('disabled', true)
                }

                $('#fotopegawai_camera').val('')
                $('#fotopegawai_file').val('')
                $('#preview_image').attr('src', "{{ asset('assets/images/faces/5.jpg') }}")
            });

		});

        // Function for prevent double click
        function preventDoubleClick(id_form, id_button){
            $('#'+id_button).attr('disabled', true)
            $('#'+id_form).submit()
        }

        $('#modal_ambil_foto').on('shown.bs.modal', function (e) {
            // Webcam
            Webcam.set({
                width: 640,
                height: 480,
                image_format: 'jpg',
                jpeg_quality: 90
            });

            Webcam.attach( '#webcam' );
        })

        $('#modal_ambil_foto').on('hidden.bs.modal', function (e) {
            Webcam.reset();

            // swap button sets
            $('#ambil_foto').show()
            $('#konfirmasi_foto').hide()
        })

        function ambilFoto(){
            // freeze camera so user can preview pic
			Webcam.freeze();

			// swap button sets
            $('#ambil_foto').hide()
            $('#konfirmasi_foto').show()
        }

        function ulangiFoto(){
            // cancel preview freeze and return to live camera feed
			Webcam.unfreeze();

			// swap buttons back
			$('#ambil_foto').show()
            $('#konfirmasi_foto').hide()
        }

        function lolosFoto() {
            // actually snap photo (from preview freeze) and display it
			Webcam.snap( function(data_uri) {
				// display results in page
                $("#fotopegawai_camera").val(data_uri);
                $('#preview_image').attr('src', data_uri)
                // document.getElementById('preview_image').innerHTML = '<img id="preview_image" width="200px" height="180px" src="'+data_uri+'"/>';
                // <img id="preview_image" src="{{ asset('assets/images/faces/5.jpg') }}" alt="No Image" width="200px" height="180px">

				// swap buttons back
				$('#ambil_foto').show()
                $('#konfirmasi_foto').hide()
                $('#modal_ambil_foto').modal('hide');
			} );
        }

        $(document).on("change", "#fotopegawai_file", function () {
            preview_image.src=URL.createObjectURL(event.target.files[0]);
        });

        function generateQRCode(uniqid) {
            $('#qr_code_wrap').html(`{!! \QrCode::size(100)->generate('PGW-'.`+uniqid+`); !!}`)
        }

        function rekamDataWajah() {
            $.ajax({
                    url: "{{ url('face-recognition-rekam') }}",
                    type: 'GET',
                    success: function(res) {
                        $("#fotopegawai_camera").val(res);
                        $('#preview_image').attr('src', "{{ asset('face_recognition/datasementara/') }}"+'/'+res+".30.jpg")
                    }
                });
        }
    </script>
@endsection
