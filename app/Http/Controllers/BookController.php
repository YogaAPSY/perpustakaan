<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $data = Book::with(['author'])->get();

            if ($request->ajax()) {

                $data = Book::with(['author'])->get();
                return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('name', function ($data) {
                        return $data->name;
                    })
                    ->addColumn('author', function ($data) {
                        return $data->author->name;
                    })
                    ->addColumn('image', function ($data) {
                        return '
                    <img src="' . asset('assets/img/books/' . $data->image) . '" width="100px" height="100px">';
                    })
                    ->addColumn('created_at', function ($data) {
                        return $data->created_at;
                    })
                    ->addColumn('aksi', function ($data) {
                        return '<div class="btn-group">
                                <a class="btn btn-sm btn-primary btn-update" data-id="' . $data->id . '" href="#">Update</a>
                                <a class="btn btn-sm btn-danger btn-hapus" data-id="' . $data->id . '" href="#">Hapus</a>
                            </div>';
                    })
                    ->rawColumns(['aksi', 'image'])
                    ->toJson();
            }

            return view('books.index');
        } else {
            $data = Book::with(['author'])->paginate(12);
            return view('books.index', compact('data'));
        }
    }

    function author()
    {
        $author = Author::pluck('id', 'name');
        return response()->json($author);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store(Request $request)
    {
        $rules         =  [
            'nama'   => 'required',
            'author' => 'required',
            'description' => 'required',
            'image'  => 'required|file|max:1024|mimes:jpeg,jpg,png, Jpeg, Jpg, Png, JPEG, JPG, PNG',
        ];
        $messages      =  [
            'required' => ':attribute wajib diisi',
            'file'     => ':attribute harus berupa file image',
            'max'      => ':attribute file maksimal 1024 kb',
            'mimes'    => ':attribute file hanya format jpeg,jpg,png'
        ];
        $names         =  [
            'nama'     => 'Nama buku',
            'author'   => 'Author',
            'image'    => 'Gambar',
            'description' => 'Deskripsi'
        ];

        $request->validate($rules, $messages, $names);
        try {

            $image = $request->image;
            $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('image')->getClientOriginalExtension();
            $images = $image->move('assets/img/books/', $namaFileBaru);
            if (!$images) {
                return $response = [
                    'code'  => 0,
                    'msg'   => 'Gagal tambah data',
                    'info'  => $e
                ];
            }

            $book            = new Book;
            $book->name      = $request->nama;
            $book->description      = $request->description;
            $book->author_id = $request->author;
            $book->image     = $namaFileBaru;

            $book->save();

            $response = [
                'code'  => 1,
                'msg'   => 'Berhasil tambah data'
            ];
        } catch (Exception $e) {
            $response = [
                'code'  => 0,
                'msg'   => 'Gagal tambah data',
                'info'  => $e
            ];
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = [];
        if (auth()->user()->role == 'admin') {
            $data = Book::where('author_id', $id)->with(['author'])->get();

            if ($request->ajax()) {

                $data = Book::with(['author'])->get();
                return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('name', function ($data) {
                        return $data->name;
                    })
                    ->addColumn('author', function ($data) {
                        return $data->author->name;
                    })
                    ->addColumn('image', function ($data) {
                        return '
                    <img src="' . asset('assets/img/books/' . $data->image) . '" width="100px" height="100px">';
                    })
                    ->addColumn('created_at', function ($data) {
                        return $data->created_at;
                    })
                    ->addColumn('aksi', function ($data) {
                        return '<div class="btn-group">
                                <a class="btn btn-sm btn-primary btn-update" data-id="' . $data->id . '" href="#">Update</a>
                                <a class="btn btn-sm btn-danger btn-hapus" data-id="' . $data->id . '" href="#">Hapus</a>
                            </div>';
                    })
                    ->rawColumns(['aksi', 'image'])
                    ->toJson();
            }
        } else {
            $data = Book::where('author_id', $id)->with(['author'])->paginate(12);
        }
        $author = $data[0]->author->name;
        return view('books.index', compact('data', 'author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function shows($id)
    {
        $data = Book::find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules         =  [
            'nama'   => 'required',
            'author' => 'required',
            'description' => 'required',
            'image'  => 'required|file|max:1024|mimes:jpeg,jpg,png, Jpeg, Jpg, Png, JPEG, JPG, PNG',
        ];
        $messages      =  [
            'required' => ':attribute wajib diisi',
            'file'     => ':attribute harus berupa file image',
            'max'      => ':attribute file maksimal 1024 kb',
            'mimes'    => ':attribute file hanya format jpeg,jpg,png'
        ];
        $names         =  [
            'nama'     => 'Nama buku',
            'author'   => 'Author',
            'image'    => 'Gambar',
            'description' => 'Deskripsi'
        ];

        $request->validate($rules, $messages, $names);
        try {

            $image = $request->image;
            $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('image')->getClientOriginalExtension();
            $images = $image->move('assets/img/books/', $namaFileBaru);
            if (!$images) {
                return $response = [
                    'code'  => 0,
                    'msg'   => 'Gagal tambah data',
                    'info'  => $e
                ];
            }

            $book              = Book::find($id);
            $book->name        = $request->nama;
            $book->description = $request->description;
            $book->author_id   = $request->author;
            $book->image       = $namaFileBaru;

            $book->save();

            $response = [
                'code'  => 1,
                'msg'   => 'Berhasil update data'
            ];
        } catch (Exception $e) {
            $response = [
                'code'  => 0,
                'msg'   => 'Gagal update data',
                'info'  => $e
            ];
        }

        return response()->json($response);
    }

    public function updates(Request $request, $id)
    {
        $rules         =  [
            'nama'   => 'required',
            'author' => 'required',
            'description' => 'required',
            'image'  => 'file|max:1024|mimes:jpeg,jpg,png, Jpeg, Jpg, Png, JPEG, JPG, PNG',
        ];
        $messages      =  [
            'required' => ':attribute wajib diisi',
            'file'     => ':attribute harus berupa file image',
            'max'      => ':attribute file maksimal 1024 kb',
            'mimes'    => ':attribute file hanya format jpeg,jpg,png'
        ];
        $names         =  [
            'nama'     => 'Nama buku',
            'author'   => 'Author',
            'image'    => 'Gambar',
            'description' => 'Deskripsi'
        ];

        $request->validate($rules, $messages, $names);
        try {

            $book              = Book::find($id);
            $book->name        = $request->nama;
            $book->description = $request->description;
            $book->author_id   = $request->author;

            if ($request->has('image')) {
                if (file_exists('assets/img/books/' . $book->image)) {
                    unlink('assets/img/books/' . $book->image);
                };
                $image = $request->image;
                $namaFileBaru = date('Ymd') . rand(0, 9999) . Str::slug(request('name'), '-') . '.' . request('image')->getClientOriginalExtension();
                $images = $image->move('assets/img/books/', $namaFileBaru);
                if (!$images) {
                    return $response = [
                        'code'  => 0,
                        'msg'   => 'Gagal tambah data',
                        'info'  => $e
                    ];
                }
                $book->image       = $namaFileBaru;
            }

            $book->save();

            $response = [
                'code'  => 1,
                'msg'   => 'Berhasil update data'
            ];
        } catch (Exception $e) {
            $response = [
                'code'  => 0,
                'msg'   => 'Gagal update data',
                'info'  => $e
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!request()->ajax()) {
            return redirect('book');
        }
        try {

            $book = Book::find($id);

            $book->delete();

            $response = [
                'code'  => 1,
                'msg'   => 'Berhasil hapus data'
            ];
        } catch (Exception $e) {
            $response = [
                'code'  => 0,
                'msg'   => 'Gagal hapus data',
                'error' => $e
            ];
        }

        return response()->json($response);
    }
}
