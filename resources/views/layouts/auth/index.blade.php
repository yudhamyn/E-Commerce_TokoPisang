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
    <style>
        .container {
            height: 100vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            padding: 2rem 0;
            position: relative;
        }

        .container .auth--content {
            flex: 1;
        }

        .container .auth--box {
            border-radius: 20px;
        }
        body {
            background: url("{{ asset('static/images/bg.png') }}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
    </style>
    @yield('css')
    @include('layouts.variable')
</head>
<body>
    <div class="container">

        @yield('body')

    </div>

    <script src="{{ asset('static/panel') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('static/panel') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('static/panel') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="{{ asset('store') }}/jq-cookie.min.js"></script>
    <script src="{{ asset('store') }}/main.js"></script>
    @yield('js')
</body>

</html>