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
                                <h1 class="h4 text-gray-900 mb-4">Silahkan Daftar </h1>
                            </div>
                            <div id="alert-message"></div>
                            <form class="user" id="register--form">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" autocomplete="new-field" placeholder="Nama" id="register--name">
                                    <small class="text-danger error--name"></small>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" autocomplete="new-field" placeholder="Email" id="register--email">
                                    <small class="text-danger error--email"></small>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" autocomplete="new-field" placeholder="No Telp" id="register--phone">
                                    <small class="text-danger error--phone"></small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" autocomplete="new-field" placeholder="Password" id="register--password">
                                    <small class="text-danger error--password"></small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" autocomplete="new-field" placeholder="Konfirmasi Password" id="register--password-confirmation">
                                    <small class="text-danger error--password-confirmation"></small>
                                </div>
                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    Register
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                Sudah punya akun? <a class="small text-success" href="{{ route('auth.login') }}">Masuk</a>
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
<script src="{{ asset('server/auth/register.js') }}"></script>
@endsection