@extends('layout')

@section('title', "Create | Users")

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
            <h4 class="card-title">Add User</h4>
        </div>

        <div class="card-content">
            <div class="card-body">
                <form method="POST" action="{{ url('admin/users') }}" id="form_create_user">
                    @method('POST')
                    @csrf

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Username <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-8 form-group">
                                <input type="text" id="username" class="form-control  @error('username') is-invalid @enderror" name="username" placeholder="Username" value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Password <span class="text-danger">*</span></label>
                            </div>

                            <div class="col-md-8 form-group">
                                <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror" name="password" placeholder="Password" value="{{ old('password') }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-8 offset-md-4 form-group">
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="show" class="form-check-input">
                                        <label for="show">Show</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary me-1 mb-1 submit_create_user" id="submit_create_user" onclick='preventDoubleClick("form_create_user", "submit_create_user")'>Submit</button>

                            <a href="{{ url('admin/users') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
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
            // show and hide password
            $('#show').click(function(){
                if($(this).is(':checked')){
                    $('#password').prop('type', 'text')
                }else{
                    $('#password').prop('type', 'password')
                }
            })
		});

        // Function for prevent double click
        function preventDoubleClick(id_form, id_button){
            $('#'+id_button).attr('disabled', true)
            $('#'+id_form).submit()
        }
    </script>
@endsection
