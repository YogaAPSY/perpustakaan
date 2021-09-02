@extends('layouts/app')

@section('title','Data User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary btn-tambah"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableUser">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Informasi</th>
                                <th>Role</th>
                                <!-- <th>Status</th> -->
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

<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <input type="hidden" id="user_id">
            <form id="formUser">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama"> <i class="fa fa-user" aria-hidden="true"></i> Nama User</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                        <div class="invalid-feedback error-nama"></div>
                    </div>
                    <div class="form-group">
                        <label for="email"> <i class="fa fa-envelope" aria-hidden="true"></i> Email</label>
                        <input type="text" name="email" id="email" class="form-control">
                        <div class="invalid-feedback error-email"></div>
                        <small style="color:green">Password Default : qwerty123</small>
                    </div>
                    <div class="form-group">
                        <label for="role"> <i class="fa fa-envelope" aria-hidden="true"></i> Role</label>
                        <select name="role" id="role" class="form-control">
                            <!-- <option value="" selected="true" disabled="disabled"></option> -->
                            <option value="user" selected="true">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="invalid-feedback error-role"></div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="alamat"> <i class="fas fa-sign"></i> Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control"></textarea>
                        <div class="invalid-feedback error-alamat"></div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="no_hp"> <i class="fa fa-phone" aria-hidden="true"></i> No. Telpon</label>
                        <input type="number" name="no_hp" id="no_hp" class="form-control">
                        <div class="invalid-feedback error-no_hp"></div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/user.js') }}"></script>
@endsection
