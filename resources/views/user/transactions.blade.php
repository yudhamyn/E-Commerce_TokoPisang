@extends('layouts.panel.index')
@section('body')
<div id="alert-message" class="mb-3"></div>
<h1 class="h3 mb-2 text-gray-800">Transaksi</h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="transaction--data">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th width="20px">No</th>
                                <th width="200px">No Pesanan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTransactionDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Transaksi <span id="purchase--order" class="font-weight-bold">{purchase-order}</span> <span class="transaction--status">{status}</span> <small id="transaction--created">{date}</small></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row"> 
                <div class="col-lg-8 col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-2 font-weight-bold text-dark">Alamat Penerima</h5>
                            <div class="row mb-3">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-2">
                                        <div class="row">
                                            <div class="col-md-2 col-3 text-dark">
                                                <b>Nama</b>
                                            </div>
                                            <div class="col-1 text-right">
                                                :
                                            </div>
                                            <div class="col-8 col-md-9">
                                                <div class="text-muted" id="address--name">{name}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-2">
                                        <div class="row">
                                            <div class="col-md-2 col-3 text-dark">
                                                <b>No HP</b>
                                            </div>
                                            <div class="col-1 text-right">
                                                :
                                            </div>
                                            <div class="col-8 col-md-9">
                                                <div class="text-muted" id="address--phone">{phone}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-md-2 col-3 text-dark">
                                                <b>Alamat</b>
                                            </div>
                                            <div class="col-1 text-right">
                                                :
                                            </div>
                                            <div class="col-8 col-md-9">
                                                <div class="text-muted" id="address--address">{address}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="bg-warning text-white">
                                        <tr class="main-hading">
                                            <th width="150px">Produk</th>
                                            <th>Nama</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Total</th> 
                                        </tr>
                                    </thead>
                                </table>
                                <div style="max-height: 300px;overflow-y:auto">
                                    <table class="table" id="detail-product--data">
                                        <tbody class="bg-light">
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
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <h5 class="mb-2 font-weight-bold text-dark">KURIR</h5>
                                <div class="content">
                                    <div class="row" id="courier--list"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h4 class="mb-2 font-weight-bold text-dark">Pembayaran</h4>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-1 d-flex align-items-center">
                                            <i class="fa fa-check-circle text-success"></i>
                                        </div>
                                        <div class="col-11">
                                            <span class="text-dark"> pembayaran dilakukan pada saat penyerahan barang (COD)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h5 class="mb-0 font-weight-bold text-dark">Total</h5>
                                <div class="content">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between text-dark">Sub Total<span class="text-muted transaction--subtotal">Rp0</span></li>
                                        <li class="list-group-item d-flex justify-content-between text-dark">Ongkir<span class="text-muted transaction--shipping-price">Rp0</span></li>
                                        <li class="list-group-item border-top border-secondary d-flex justify-content-between text-dark"><span class="title--subtotal-pay">Yang harus dibayar</span><span class="transaction--subtotal-pay">Rp0</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="modalCancelation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger p-3">
                    Apakah anda yakin ingin membatalkan pesanan ini?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <button class="btn btn-danger" type="submit">Ya</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReceived" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning p-3">
                    <div>
                        Apakah anda yakin ingin menerima barang? <br>
                        <small>Pastikan anda telah memeriksa semua kelengkapan barang anda.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <button class="btn btn-warning" type="submit">Ya</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalFinish" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning p-3">
                    Apakah anda yakin ingin menyelesaikan pesanan ini?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <button class="btn btn-success" type="submit">Ya</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('server/user/transaction.js') }}"></script>
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