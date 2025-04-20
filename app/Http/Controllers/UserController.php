<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        // Kirim data barang dan kategori ke view
        return view('user.index', [
            'activeMenu' => 'user',
        ]);
    }

    public function getData()
    {
        $users = UserModel::all();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                // Gunakan concatenation untuk menggabungkan URL yang benar
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->id . '/show') . '\')" 
                            class="btn btn-info btn-sm mr-2">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->id . '/edit') . '\')"
                             class="btn btn-warning btn-sm mr-2">Edit</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->id . '/confirm') . '\')"
                             class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        UserModel::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil ditambahkan!',
            'redirect' => url('/user')
        ]);
    }

    public function show(string $id)
    {
        // Mencari user berdasarkan ID
        $user = UserModel::find($id);

        // Menyiapkan breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        // Menyiapkan page untuk judul halaman
        $page = (object) [
            'title' => 'Detail User'
        ];

        // Menentukan menu aktif
        $activeMenu = 'user';

        // Mengembalikan view dengan data yang diperlukan
        return view('user.show', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'user' => $user, 
            'activeMenu' => $activeMenu]);
    }


    public function edit($id)
    {
        $user = UserModel::find($id);
        return view('user.edit', compact('user'));
    }
  
    public function update(Request $request, $id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan.'
            ]);
        }

        // Simpan data
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diperbarui.'
        ]);
    }

    public function confirm(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm', ['user' => $user]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
