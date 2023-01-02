<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title')</title>

        <link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
        <link rel="stylesheet" href="{{asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css')}}">

        <link rel="stylesheet" href="{{asset('assets/css/main/app.css')}}">

        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.svg')}}" type="image/x-icon">
        <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/png">

        <link rel="stylesheet" href="{{asset('assets/css/pages/datatables.css')}}">

        @yield('css')
    </head>

    <body>
        <nav class="navbar navbar-light mb-4" style="background-color: white;">
            <div class="container d-block">
                <a class="navbar-brand-icon ms-4">
                    <img width="10%" src="{{asset('assets/images/logo/logo.jpg')}}" alt="Logo" srcset="">
                </a>
            </div>
        </nav>


        <div class="container">
            @yield('content')
        </div>

                        {{-- <div class="d-flex justify-content-center align-items-center">
                            <div class="logo mt-3 ms-5">
                                <a href="index.html"><img width="10%" src="{{asset('assets/images/logo/logo.jpg')}}" alt="Logo" srcset=""></a>
                            </div>

                            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">

                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0 d-none" type="checkbox" id="toggle-dark">
                                    <label class="form-check-label"></label>
                                </div>
                            </div>
                            <div class="sidebar-toggler  x">
                                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                            </div>
                        </div>

                    <div class="sidebar-menu">
                    </div> --}}

            <div id="main" class='layout-navbar mx-0'>
                {{-- <header class='mb-3'>

                </header> --}}

                <div id="main-content">
                    {{-- <div class="page-heading">
                        @yield('content')
                    </div> --}}

                    <footer>
                        <div class="footer clearfix mb-0 text-muted">
                            <div class="float-start">
                                <p>2021 &copy; Mazer</p>
                            </div>

                            <div class="float-end">
                                <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> by <a href="https://ahmadsaugi.com" target="_blank">Saugi</a></p>
                            </div>

                            <div class="float-end mx-2">
                                <p>|</p>
                            </div>

                            <div class="float-end">
                                <p>Modified with <span class="text-info">@kptikbmnsurabaya 2022</p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>


            <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
            <script src="{{asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
            <script src="{{asset("assets/extensions/inputmask/jquery.inputmask.min.js")}}"></script>
        {{-- <script src="{{asset("assets/extensions/inputmask/jquery.inputmask.min.js")}}"></script> --}}
        <script src="{{asset("assets/extensions/datatable/datatables.min.js")}}"></script>
        <script src="{{asset("assets/extensions/helpers/helpers.js")}}"></script>

        <script src="{{asset('assets/js/bootstrap.js')}}"></script>
        <script src="{{asset('assets/js/app.js')}}"></script>

        <script src="{{asset('assets/js/pages/form-element-select.js')}}"></script>
        <script src="{{asset("assets/js/pages/datatables.js")}}"></script>

        <script>
            // Set time out session success
            @if(session('success') || session('error'))
                setTimeout(() => {
                    $('.btn-close-session').trigger('click')
                }, 5000);
            @endif

            // Function for prevent double click
            function preventDoubleClick(id_form, id_button){
                $('#'+id_button).attr('disabled', true)
                $('#'+id_form).submit()
            }
        </script>

        @yield('js')
    </body>
</html>
