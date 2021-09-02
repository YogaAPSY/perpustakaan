@extends('layouts/app')

@section('title','Data Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @if(auth()->user()->role == 'admin')
                <a href="#" class="btn btn-primary btn-tambah"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data Buku</a>
                @else
                <div class="alert alert-primary" role="alert">
                    @if(isset($author))
                    <h1>List Buku {{$author}}</h1>
                    @else
                    <h1>List Buku</h1>
                    @endif
                </div>
                @endif
            </div>
            <div class="card-body">
                @if(auth()->user()->role == 'admin')
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableBook" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Buku</th>
                                <th>Author</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Created At</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                @else
                <div class="row">
                    @if(isset($data))
                    @foreach ($data as $d)

                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="card m-1">
                            <img src="{{ asset('assets/img/books/'.$d->image) }}" class="card-img-top" alt="no image">
                            <div class="card-body">
                                <h5 class="card-title">{{$d->name}}</h5>
                                <p class="card-text">{{$d->description}}</p>
                                Author : <a href="{{ url('book/'. $d->author_id)}}" class="btn btn-primary">{{$d->author->name}}</a>
                            </div>

                        </div>
                    </div>

                    @endforeach
                    @else

                    @endif

                </div>

                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBook" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <input type="hidden" id="book_id">
            <form id="formBook">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama"> <i class="fa fa-user" aria-hidden="true"></i> Nama Buku</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                        <div class="invalid-feedback error-nama"></div>
                    </div>
                    <div class="form-group">
                        <label for="image"> <i class="fa fa-user" aria-hidden="true"></i>Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="image">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <div class="invalid-feedback error-image"></div>
                    </div>

                    <div class="form-group">
                        <label for="description"> <i class="fas fa-sign"></i> Deskripsi</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>
                    <div class="form-group">
                        <label for="author"> <i class="fas fa-truck"></i> Author </label>
                        <select name="author" id="author" class="form-control select2" style="width:100%;">

                        </select>
                        <div class="invalid-feedback error-author"></div>
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
<script src="{{ asset('assets/js/book.js') }}"></script>
@endsection
