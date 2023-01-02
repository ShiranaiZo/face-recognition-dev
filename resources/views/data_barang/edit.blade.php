@extends('layout')

@section('title', "Edit | Barang")

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
            <h4 class="card-title">Edit Barang</h4>
        </div>

        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ url('admin/data-barang/'.$data_barang->id) }}" id="form_update_user">
                    @method('PATCH')
                    @csrf

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Kode Barang <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-8 form-group">
                                <input type="text" id="kodebarang" class="form-control  @error('kodebarang') is-invalid @enderror" name="kodebarang" placeholder="Kode Barang" value="{{ old('kodebarang') ? old('kodebarang') : $data_barang->kodebarang }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-8 form-group">
                                <input type="text" id="namabarang" class="form-control  @error('namabarang') is-invalid @enderror" name="namabarang" placeholder="Nama Barang" value="{{ old('namabarang') ? old('namabarang') : $data_barang->namabarang }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Qr Code <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-2 form-group">
                                <div id="qr_code_wrap" style="width: 100px; height: 100px; background-color: #eee">
                                    {!! \QrCode::size(100)->generate($data_barang->qrcode_b); !!}
                                    <input type="hidden" id="qrcode_b" class ="form-control  @error('qrcode_b') is-invalid @enderror" name="qrcode_b" placeholder="QR Code" value="{{ $data_barang->qrcode_b }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Jumlah <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-3 form-group">
                                {{-- <input type="text" id="jumlah" class="form-control  @error('jumlah') is-invalid @enderror" name="jumlah" placeholder="Jumlah" value="{{ old('jumlah') ? old('jumlah') : $data_barang->jumlah }}"> --}}

                                <div class="input-group">
                                    <button type="button" onclick="countPlusMinus(-1, '#jumlah', 1)" class="btn btn-light input-group-text">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>

                                    <input type="text" class="form-control text-center mask" placeholder="0" name="jumlah" value="{{ $data_barang->jumlah }}" id="jumlah">

                                    <button type="button" onclick="countPlusMinus(1, '#jumlah', 1)" class="btn btn-light input-group-text">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Jenis <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8 form-group">
                                            <input type="checkbox" id="jenis" name="jenis" class="form-check-input" {{ $data_barang->jenis =="on" ? "checked" : "" }}>
                                            <label for="jenis">Sekali pakai</label>
                            </div>
                        </div>

                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary me-1 mb-1 submit_update_user" id="submit_update_user" onclick='preventDoubleClick("form_update_user", "submit_update_user")'>Submit</button>

                            <a href="{{ url('admin/data-barang') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.mask').inputmask({"alias": "decimal", "groupSeparator": ",", "digits": 0 , "autoGroup": true, "clearMaskOnLostFocus": false, "allowMinus": false, max: 999999999, min:1 });

            // show and hide password
            $('#show').click(function(){
                if($(this).is(':checked')){
                    $('#password').prop('type', 'text')
                }else{
                    $('#password').prop('type', 'password')
                }
            })
		});

        // Function for increment and decrement button
        function countPlusMinus(crement, id, limit = null){
            let value = $(id).inputmask('unmaskedvalue')
                value = parseInt(value)
                value = isNaN(value) ? 0 : value
                value += crement

            if(value <= limit){
                value = limit
            }

            $(id).val(value)
        }
    </script>
@endsection
