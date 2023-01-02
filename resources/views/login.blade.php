<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="{{asset('assets/css/main/app.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/pages/auth.css')}}">
        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.svg')}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/png">
    </head>

    <body>
        <div id="auth">
            <div class="row h-100">
                <div class="col-lg-5 col-12">
                    <div id="auth-left">
                        <div class="auth-logo">
                            <a href=""><img width="50%" height="50%" src="{{asset('assets/images/logo/logo.jpg')}}" alt="Logo"></a>
                        </div>

                        <h1 class="auth-title">Log in.</h1>

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

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <i class="bi bi-file-excel"></i> {{session('error')}}
                                <button type="button" class="btn-close btn-close-session" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ url('admin/login') }}" method="POST">
                            @method('POST')
                            @csrf

                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}">

                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>

                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Password" name="password" autocomplete="off">

                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>

                            {{-- <div class="form-check form-check-lg d-flex align-items-end">
                                <input class="form-check-input me-2" type="checkbox" id="flexCheckDefault" name="remember">

                                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                    Keep me logged in
                                </label>
                            </div> --}}

                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Log in</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right">

                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>

    <script>
        // Set time out session success
        @if(session('error') || $errors->any())
        setTimeout(() => {
                $('.btn-close-session').trigger('click')
            }, 5000);
        @endif
    </script>
</html>
