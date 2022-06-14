@extends('layouts.panel.index')
@section('body')
<div id="alert-message" class="mb-3"></div>
<div class="row">
    <div class="col-md-6">
        <h1 class="h3 mb-2 text-gray-800">Produk</h1>
    </div>
    <div class="col-md-6 text-right">
        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAdd">Tambah</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="product--data">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th width="20px">No</th>
                                <th width="150px">Produk</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
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

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                    <div class="alert--message mb-3"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="upload--image mb-2">
                                <div class="upload--image-preview">
                                    <img src="{{ asset('static/images/default.jpg') }}" alt="" width="100%" class="image--preview">
                                </div>
                                <div class="upload--image-btn">
                                    <button type="button" class="btn btn-sm btn-primary btn-block w-100" data-toggle="choose-image" data-target="#modalAdd [name=image]" data-result-target="#modalAdd .image--preview">Pilih Gambar</button>
                                    <input type="file" name="image" class="d-none" accept="image/jpg,image/png" hidden>
                                </div>
                            </div>
                            <small class="text-danger error--image"></small>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukkan nama produk">
                                <small class="text-danger error--name"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="description" rows="2" class="form-control" placeholder="Masukkan deskripsi produk"></textarea>
                                <small class="text-danger error--description"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input type="number" name="price" class="form-control" placeholder="Masukkan harga produk">
                                <small class="text-danger error--price"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Stok</label>
                                <input type="number" name="stock" class="form-control" placeholder="Masukkan stok produk">
                                <small class="text-danger error--stock"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                    <div class="alert--message mb-3"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="upload--image mb-2">
                                <div class="upload--image-preview">
                                    <img src="{{ asset('static/images/default.jpg') }}" alt="" width="100%" class="image--preview">
                                </div>
                                <div class="upload--image-btn">
                                    <button type="button" class="btn btn-sm btn-primary btn-block w-100" data-toggle="choose-image" data-target="#modalEdit [name=image]" data-result-target="#modalEdit .image--preview">Pilih Gambar</button>
                                    <input type="file" name="image" class="d-none" accept="image/jpg,image/png" hidden>
                                </div>
                            </div>
                            <small class="text-danger error--image"></small>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukkan nama produk">
                                <small class="text-danger error--name"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="description" rows="2" class="form-control" placeholder="Masukkan deskripsi produk"></textarea>
                                <small class="text-danger error--description"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input type="number" name="price" class="form-control" placeholder="Masukkan harga produk">
                                <small class="text-danger error--price"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Stok</label>
                                <input type="number" name="stock" class="form-control" placeholder="Masukkan stok produk">
                                <small class="text-danger error--stock"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
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
                    Apakah anda yakin ingin menghapus produk ini?
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tidak</button>
                <button class="btn btn-danger" type="submit">Ya</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

    $(document).on('click','[data-toggle="choose-image"]', function(e){
        e.preventDefault()
        let target = $(this).data('target'),
            resultImg = $(this).data('result-target');

        $(target).trigger('click')

        $(document).on('change',target, function(e){

            var reader = new FileReader();

            var files = e.target.files[0]

            reader.addEventListener("load", function(e) {

                let _resultData = e.target.result

                $(resultImg).attr('src',_resultData)

            });
            
            reader.readAsDataURL(files);

        })

    })

</script>
<script src="{{ asset('server/panel/products.js') }}"></script>
@endsection

@section('css')
<style>
    .upload--image {
        width: 100%;
        position: relative;
    }

    .upload--image .upload--image-preview {
        width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid #ddd;
        overflow: hidden;
        margin-bottom: 10px;
    }


</style>
@endsection