@extends('layouts.front.index')
@section('body')
<section class="hero-slider">
    <div class="single-slider d-flex">
        <div class="container my-auto">
            <div class="row no-gutters">
                <div class="col-sm-12">
                    <div class="text-inner ">
                        <div class="row">
                            <div class="col-sm-7">
                            </div>
                            <div class="col-sm-5">
                                <div class="bg-white rounded shadow p-5 m-0">
                                    <h1><span>Selamat Datang di </span> {{ env('APP_NAME') }}</h1><br>
                                    <p class="m-0">Kami menyediakan berbagai macam jenis Pisang </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="product-area section" style="background: linear-gradient(to right, #ffc938, #fdf58a);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center ">
                <div class="bg-light py-2 rounded">
                    <h2>Produk Kami</h2>
                </div>
            </div>
        </div>
        <div class="row mb-3" id="product--list">
            <span class="col-md-12 d-block text-center">
                Loading...
            </span>
        </div>
        <div class="d-flex justify-content-center" id="paging-btn"></div>
    </div>
</div>

<div class="modal fade" id="productDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                                <p id="product-detail-weight">-</p>
                            </div>
                            <div class="quantity d-none" id="product-detail-qty">
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
                                    <div class="add-to-cart mt-3">
                                        <a href="#" class="btn d-none bg-dark rounded" id="product-detail-add-to-cart" style="background:#ffc938">Tambah ke keranjang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<style>

    .single-product {
        background: #fff;
        box-shadow: 0 0 8px rgba(0,0,0,.15);
        border-radius: 8px;
        overflow: hidden;
    }

</style>
@endsection
@section('js')
<script src="{{ asset('server/front/home.js') }}"></script>
@endsection