@extends('layouts.front.index')
@section('body')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li class="active"><a href="">keranjang</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="shopping-cart section">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="check--all">
                    <label class="custom-control-label" for="check--all">Pilih semua</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table shopping-summery" id="cart--data">
                    <thead>
                        <tr class="main-hading">
                            <th>Pilih</th>
                            <th width="150px">Produk</th>
                            <th>Nama</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Total</th> 
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" align="center">
                                <small>Belum ada keranjang</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-4 col-md-7 col-12 ml-auto">
                            <div class="right">
                                <ul>
                                    <li>Subtotal<span class="cart--subtotal">Rp0</span></li>
                                    <li class="last">Yang harus dibayar<span class="cart--subtotal-pay">Rp0</span></li>
                                </ul>
                                <div class="button5">
                                    <a href="{{ url('checkout') }}" class="btn disabled" id="checkout--btn">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                <div class="single-slider">
                                    <img src="{{ asset('static') }}/images/modal1.jpg" alt="" id="product-detail-img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2 id="product-detail-name">{product}</h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-stock ml-0">
                                    <span id="product-detail-stock"></span>
                                </div>
                            </div>
                            <h3 id="product-detail-price">-</h3>
                            <div class="quickview-peragraph mb-3">
                                <p id="product-detail-description">-</p>
                            </div>
                            <div class="quantity">
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="qty-detail">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="qty-detail" class="input-number"  data-min="1" data-max="1000" value="1" id="product-detail-cart-qty">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="qty-detail">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <a href="#" class="btn" id="product-detail-add-to-cart">Simpan</a>
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
<script src="{{ asset('server/front/cart.js') }}"></script>
@endsection