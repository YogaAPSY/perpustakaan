<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();

            return datatables($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('informasi', function ($data) {
                    return $data->email . '<br>
                    <small><ul>

                    <li>Tanggal Gabung: ' . $data->created_at . '</li>
                    </ul></small>';
                })
                ->addColumn('role', function ($data) {
                    return $data->role;
                })
                // ->addColumn('status', function ($data) {
                //     $checked = ($data->status) ? 'checked' : '';
                //     return '<div class="custom-control custom-switch">
                //                 <input data-id="' . $data->id . '" type="checkbox" ' . $checked . ' class="switch-status custom-control-input" id="status' . $data->id . '">
                //                 <label class="custom-control-label" for="status' . $data->id . '"></label>
                //             </div>';
                // })
                ->addColumn('aksi', function ($data) {
                    return '<div class="btn-group">
                                <a class="btn btn-sm btn-primary btn-update" data-id="' . $data->id . '" href="#">Update</a>
                                <a class="btn btn-sm btn-danger btn-hapus" data-id="' . $data->id . '" href="#">Hapus</a>
                            </div>';
                })
                ->rawColumns(['aksi', 'status', 'informasi'])
                ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'role'     => 'required',
            'email'    => 'required|email|unique:users',
        ];
        $messages      =  [
            'required' => ':ttribute wajib diisi',
            'email'    => ':attribute harus dalam format email'
        ];
        $names         =  [
            'nama'     => 'Nama user',
            'email'    => 'Email',
            'role'     => 'Role'
        ];

        $request->validate($rules, $messages, $names);
        try {
            $user           = new User;
            $user->name     = $request->nama;
            $user->email    = $request->email;
            $user->password = bcrypt("qwerty123");
            $user->role     = $request->role;
            $user->status   = 1;
            $user->save();

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
        $data = User::find($id);
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
            'role'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
        ];
        $messages      =  [
            'required' => ':attribute wajib diisi',
            'email'    => ':attribute harus dalam format email'
        ];
        $names         =  [
            'nama'     => 'Nama user',
            'email'    => 'Email',
            'role'     => 'Role'
        ];

        $request->validate($rules, $messages, $names);
        try {
            $user           = User::find($id);
            $user->name     = $request->nama;
            $user->email    = $request->email;
            $user->password = bcrypt("qwerty123");
            $user->role     = $request->role;
            $user->status   = 1;
            $user->save();

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
            return redirect('user');
        }
        try {

            $user = User::find($id);

            if ($user->role != 'admin') {
                $user->delete();

                $response = [
                    'code'  => 1,
                    'msg'   => 'Berhasil hapus data'
                ];
            } else {
                $response = [
                    'code'  => 0,
                    'msg'   => 'Tidak dapat menghapus admin',
                    'error' => ''
                ];
            }
        } catch (Exception $e) {
            $response = [
                'code'  => 0,
                'msg'   => 'Gagal hapus data',
                'error' => $e
            ];
        }

        return response()->json($response);
    }

    function update_status($id)
    {
        if (!request()->ajax()) {
            return redirect('user');
        }
        try {
            $user = User::find($id);
            $status = ($user->status) ? '0' : '1';
            $user->status = $status;
            $user->save();
            $response = [
                'code'  => 1,
                'msg'   => 'Berhasil update status'
            ];
        } catch (Exception $e) {
            $response = [
                'code'  => 0,
                'msg'   => 'Gagal update status',
                'error' => $e
            ];
        }
        return response()->json($response);
    }
}
