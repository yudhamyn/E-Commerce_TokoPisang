@extends('layouts.panel.index')
@section('body')
<div id="alert-message" class="mb-3"></div>
<div class="row">
    <div class="col-md-6">
        <h1 class="h3 mb-2 text-gray-800">Manajemen User</h1>
    </div>
    <div class="col-md-6 text-right">
        <button class="btn btn-sm btn-dark" data-toggle="modal" data-target="#modalAdd">Tambah</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="user--data">
                        <thead class="bg-warning text-white">
                            <tr>
                                <th width="20px">No</th>
                                <th width="150px">Nama</th>
                                <th>No HP</th>
                                <th>Email</th>
                                <th>Role</th>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                    <div class="alert--message mb-3"></div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <div>
                            <select name="role" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        <small class="text-danger error--role"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Pengguna</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama pengguna">
                        <small class="text-danger error--name"></small>
                    </div>
                    <div class="form-group">
                        <label for="">No HP</label>
                        <input type="text" name="phone" class="form-control" placeholder="Masukkan no hp">
                        <small class="text-danger error--phone"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email">
                        <small class="text-danger error--email"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                        <small class="text-danger error--password"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi password">
                        <small class="text-danger error--password-confirmation"></small>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengguna</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                    <div class="alert--message mb-3"></div>
                    <div class="form-group">
                        <label for="">Role</label>
                        <div>
                            <select name="role" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        <small class="text-danger error--role"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Pengguna</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama pengguna">
                        <small class="text-danger error--name"></small>
                    </div>
                    <div class="form-group">
                        <label for="">No HP</label>
                        <input type="text" name="phone" class="form-control" placeholder="Masukkan no hp">
                        <small class="text-danger error--phone"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email">
                        <small class="text-danger error--email"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                        <small class="text-danger error--password"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi password">
                        <small class="text-danger error--password-confirmation"></small>
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
                    Apakah anda yakin ingin menghapus pengguna ini?
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
<script src="{{ asset('server/panel/user.js') }}"></script>
@endsection