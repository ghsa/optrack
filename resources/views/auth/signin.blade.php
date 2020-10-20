<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{env('APP_NAME')}} - Login</title>

    <!-- Custom fonts for this template-->
    <link href="/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/dashboard/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-login-image">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

                {!! Form::open(['route' => 'auth.signin', 'method' => 'post']) !!}
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Efetuar Login</h1>
                                    </div>
                                    @include('dashboard.messages')
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email" placeholder="Email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="passowrd" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Lembrar</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        Login
                                    </button>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>


            @if(request()->signup)
            <div class="col-xl-6 col-lg-6 col-md-6">
                {!! Form::open(['route' => 'customer.auth.signup', 'method' => 'post']) !!}
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Cadastre-se</h1>
                                    </div>
                                    @include('dashboard.messages')
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="name" class="form-control form-control-user" id="name" placeholder="Nome" name="name">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" placeholder="Email" name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="passowrd" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="cpf" class="form-control form-control-user" id="cpf" placeholder="CPF" name="cpf">
                                        </div>
                                        <div class="form-group">
                                            <input type="phone" class="form-control form-control-user" id="phone" placeholder="Telefone" name="phone">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Efetuar Cadastro
                                        </button>
                                        <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/dashboard/js/sb-admin-2.min.js"></script>

</body>

</html>
