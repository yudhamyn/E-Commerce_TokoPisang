@extends('layouts.front.index')
@section('body')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li class="active"><a href="{{ url('cart') }}">Keranjang</a></li>
                        <li class="active"><a href=""><i class="ti-arrow-right"></i></a> Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="shop checkout section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-8 col-12">
                <div class="checkout-form">
                    <div id="alert-message" class="mb-3"></div>
                    <h2 class="mb-4">Pilih atau Tambahkan Alamat</h2>
                    <div class="row form">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label>Nama<span>*</span></label>
                                <input type="text" class="form-control" id="address--name" placeholder="Masukkan Nama Penerima">
                                <small class="text-danger error--address-name"></small>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label>Nomor HP<span>*</span></label>
                                <input type="text" class="form-control" id="address--phone" placeholder="Masukkan Nomor HP Penerima">
                                <small class="text-danger error--address-phone"></small>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <label>Alamat<span>*</span></label>
                                <textarea rows="2" class="form-control" id="address--address" placeholder="Masukkan Alamat Lengkap Penerima" style="resize: none;"></textarea>
                                <small class="text-danger error--address-address"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table shopping-summery" id="cart--data">
                            <thead>
                                <tr class="main-hading">
                                    <th width="150px">Produk</th>
                                    <th>Nama</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Total</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" align="center">
                                        <small>Belum ada keranjang</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="order-details">
                    <div class="single-widget">
                        <h2 class="mb-3">KURIR</h2>
                        <div class="content">
                            <div class="row m-0" id="courier--list"></div>
                            <small class="text-danger error--courier"></small>
                        </div>
                    </div>
                    <div class="single-widget">
                        <h2 class="mb-3">Pembayaran</h2>
                        <div class="content">
                            <div class="row m-0">
                                <div class="col-md-12 text-center">
                                    <span class="text-dark"><i class="fa fa-check-circle text-success"></i> pembayaran dilakukan pada saat penyerahan barang (COD)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-widget">
                        <h2>TOTAL KERANJANG</h2>
                        <div class="content">
                            <ul>
                                <li>Sub Total<span class="cart--subtotal-pay">Rp0</span></li>
                                <li>Ongkir<span class="">Rp{{ number_format(env('SHIPPING_PRICE',5000),0,',','.') }}</span></li>
                                <li class="last">Total<span class="cart--subtotal-pay">Rp0</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="single-widget get-button">
                        <div class="content">
                            <div class="button">
                                <button id="order--btn" disabled class="btn">Buat Pesanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    let shippingPrice = {{ env('SHIPPING_PRICE',5000) }};
</script>
<script src="{{ asset('server/front/checkout.js') }}"></script>
@endsection

@section('css')
<style>

    .card-courier {
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        overflow: hidden;
        transition: all .3s linear;
    }

    .card-courier.active {
        border-color: #3A5BA0;
        background: rgba(58, 91, 160, .15);
    }

    .card-courier img {
        width: 100%;
    }

</style>
@endsection