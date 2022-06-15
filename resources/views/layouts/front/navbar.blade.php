<header class="header shop">
    <div class="middle-inner" style="background:linear-gradient(to right,#ffc938,#fce18a);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 col-3">
                    <div class="logo text-capitalize m-0 text-dark">
                        <a href="{{ url('') }}" style="font-size: 25px; font-weight: 600;">{{ env('APP_NAME') }}</a>
                    </div>
                </div>

                <div class="col-md-10 col-9 d-inline-flex">
                    @if(auth()->user())
                        <div class="right-bar ml-auto text-dark">
                        <div class="sinlge-bar">
                            <marquee>
                            <h6 class="text-dark px-5">Pengiriman Only Karawang</h6>
                            </marquee>
                        </div>
                            <div class="sinlge-bar" id="navbar--user-name">
                                <a href="" class="single-icon"><i class="fa fa-user-circle-o mr-1" aria-hidden="true"></i>
                                    <small></small></a>
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
                            <marquee>
                            <h6 class="text-dark px-5">Pengiriman Only Karawang</h6>
                            </marquee>
                        </div>
                        <div class="sinlge-bar">
                            <a href="{{ route('auth.login') }}" class="btn btn-sm rounded bg-white text-primary shadow">Mulai Belanja</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
