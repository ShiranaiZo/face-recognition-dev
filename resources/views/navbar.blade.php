<nav class="navbar navbar-expand navbar-light navbar-top">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0"></ul>

            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3 mt-2">
                            <h6 class="md-2 text-gray-600">{{ \Auth::user()->username }}</h6>
                        </div>

                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="{{asset('assets/images/faces/9.jpg')}}">
                            </div>
                        </div>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                    <li>
                        <h6 class="dropdown-header">Hi, {{ \Auth::user()->username }}</h6>
                    </li>
                    <li> <hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ url('admin/logout') }}"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
