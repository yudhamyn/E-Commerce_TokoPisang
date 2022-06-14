<header class="header shop">
    {{-- <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="top-left">
                        <ul class="list-main">
                            <li><i class="ti-headphone-alt"></i> +060 (800) 801-582</li>
                            <li><i class="ti-email"></i> support@shophub.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-location-pin"></i> Store location</li>
                            <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li>
                            <li><i class="ti-user"></i> <a href="#">My account</a></li>
                            <li><i class="ti-power-off"></i><a href="login.html#">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="middle-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 col-3">
                    <div class="logo text-capitalize">
                        <a href="{{ url('') }}" style="font-size: 25px; font-weight: 600;">{{ env('APP_NAME') }}</a>
                    </div>
                </div>

                <div class="col-md-10 col-9 d-inline-flex">
                    @if(auth()->user())
                        <div class="right-bar ml-auto">
                            <div class="sinlge-bar" id="navbar--user-name">
                                <a href="" class="single-icon"><i class="fa fa-user-circle-o mr-1" aria-hidden="true"></i>
                                    <small>{name}</small></a>
                            </div>
                            <div class="sinlge-bar shopping d-none" id="navbar--user-cart">
                                <a href="{{ route('user.cart') }}" class="single-icon"><i class="ti-bag"></i> <span
                                        class="total-count cart--count">0</span></a>
                                <div class="shopping-item d-none">
                                    <div class="dropdown-cart-header">
                                        <span><span class="cart--count">0</span> produk</span>
                                        <a href="{{ url('cart') }}">Lihat Keranjang</a>
                                    </div>
                                    <ul class="shopping-list" id="cart--list">
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount" id="cart--subtotal">Rp0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="right-bar ml-auto">
                        <div class="sinlge-bar">
                            <a href="{{ route('auth.login') }}" class="btn btn-sm bg-white text-primary p-2 p-md-3 px-md-4">Masuk</a>
                        </div>
                        <div class="sinlge-bar">
                            <a href="{{ route('auth.register') }}" class="btn btn-sm bg-white text-dark border p-2 p-md-3 px-md-4">Daftar</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
