@extends('layouts.auth.index')
@section('body')
<div class="row justify-content-center auth--content">

    <div class="col-xl-6 col-lg-6 col-md-12">
        <h4 class="text-center font-weight-bold"><a href="{{ url('') }}" class="text-decoration-none">{{ env('APP_NAME') }}</a></h4>
        <div class="card o-hidden border-0 shadow-lg my-5 auth--box">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Silahkan Masuk </h1>
                            </div>
                            <div id="alert-message"></div>
                            <form class="user" id="login--form">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" aria-describedby="emailHelp"
                                        placeholder="Masukkan email" id="login--email">
                                    <small class="text-danger error--email"></small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" placeholder="Masukkan password" id="login--password">
                                    <small class="text-danger error--password"></small>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="rememberMe">
                                        <label class="custom-control-label" for="rememberMe">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                Belum punya akun? <a class="small text-success" href="{{ route('auth.register') }}">Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
@section('js')
<script src="{{ asset('server/auth/login.js') }}"></script>
@endsection