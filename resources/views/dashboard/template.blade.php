<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{env('APP_NAME')}}</title>
    <link href="/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/dashboard/css/sb-admin-2.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        @include('dashboard.menu')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @auth()
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    {{env('APP_NAME')}}

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="{{route('dashboard.auth.signout')}}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                @endauth
                <div class="container-fluid" id='app'>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="/js/app.js"></script>
    <script src="/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/dashboard/js/sb-admin-2.min.js"></script>
    <script src="/js/masks/jquery.mask.min.js"></script>
    <script src="/js/masks/price.js"></script>
    <script src="/js/masks/mascaras.js"></script>
    <!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
