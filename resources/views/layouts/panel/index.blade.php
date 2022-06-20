<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ env('APP_DESCRIPTION','') }}">
    <meta name="author" content="{{ env('APP_AUTHOR','') }}">
    <title>@yield('title',$title?? env('APP_NAME'))</title>
    <link href="{{ asset('static/panel') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('static/panel') }}/css/app.min.css" rel="stylesheet">
    <link href="{{ asset('static/panel') }}/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/panel/DataTables/datatables.min.css') }}">
    @yield('css')
    @include('layouts.variable')
</head>
<body id="page-top">
    <div id="wrapper">

        @include('layouts.panel.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('layouts.panel.navbar')
            
                <div class="container-fluid">

                    @yield('body')

                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Copyright {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Siap untuk keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin keluar?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-danger" href="{{ url('logout') }}">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('static/panel') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('static/panel') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('static/panel') }}/vendor/chart.js/Chart.min.js"></script>
    <script src="{{ asset('static/panel/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('static/panel') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="{{ asset('static/panel') }}/js/app.min.js"></script>
    <script src="{{ asset('store') }}/jq-cookie.min.js"></script>
    <script src="{{ asset('store') }}/main.js"></script>
    <script src="{{ asset('server') }}/panel/userSigned.js"></script>
    @yield('js')
</body>

</html>