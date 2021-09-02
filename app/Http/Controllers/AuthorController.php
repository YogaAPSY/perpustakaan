<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Author::all();

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('aksi', function ($data) {
                    if (auth()->user()->role == 'admin') {
                        $aksi = '<div class="btn-group">
                                <a class="btn btn-sm btn-primary btn-update" data-id="' . $data->id . '" href="#">Update</a>
                                <a class="btn btn-sm btn-success btn-detail" href="' . url('book/' . $data->id) . '">List Buku</a>
                                 <a class="btn btn-sm btn-danger btn-hapus" data-id="' . $data->id . '" href="#">Hapus</a>
                            </div>';
                    } else {
                        $aksi = '<div class="btn-group">
                                <a class="btn btn-sm btn-success btn-detail" href="' . url('book/' . $data->id) . '">List Buku</a>
                            </div>';
                    }
                    return $aksi;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }

        return view('authors.index');
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
            'nama'     => 'required',
        ];
        $messages      =  [
            'required' => ':attribute wajib diisi',
        ];
        $names         =  [
            'author'     => 'Nama author',
        ];

        $request->validate($rules, $messages, $names);
        try {
            $author           = new Author;
            $author->name     = $request->nama;
            $author->save();

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
    public function show($id)
    {
        $data = Author::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'nama'     => 'required',
        ];
        $messages      =  [
            'required' => ':attribute wajib diisi',
        ];
        $names         =  [
            'author'     => 'Nama author',
        ];

        $request->validate($rules, $messages, $names);
        try {
            $author           = Author::find($id);
            $author->name     = $request->nama;
            $author->save();

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
            return redirect('author');
        }
        try {

            $author = Author::find($id);

            $author->delete();

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
