@extends('layouts/app')

@section('title','Data Author')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @if(auth()->user()->role == 'admin')
                <a href="#" class="btn btn-primary btn-tambah"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data Author</a>
                @else
                <div class="alert alert-primary" role="alert">
                    <h1>List Author</h1>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableAuthor" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Author</th>
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

<div class="modal fade" id="modalAuthor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <input type="hidden" id="author_id">
            <form id="formAuthor">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Author</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama"> <i class="fa fa-user" aria-hidden="true"></i> Nama Author</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                        <div class="invalid-feedback error-nama"></div>
                    </div>
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
<script src="{{ asset('assets/js/author.js') }}"></script>
@endsection
