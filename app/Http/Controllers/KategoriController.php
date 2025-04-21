<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{

    public function index()
    {
        // dd($data);
        return view('kategori.index', [
            'activeMenu' => 'kategori'
        ]);
    }

    public function getData()
    {
        $kategories = KategoriModel::all();

        return DataTables::of($kategories)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->id . '/show') . '\')" 
                                class="btn btn-info btn-sm mr-2">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->id . '/edit') . '\')" 
                                class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->id . '/confirm') . '\')" 
                                class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('kategori.create');
    }


    public function store(Request $request)
    {
        // validasi dulu
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:kategori,kode',
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada inputan!',
                'msgField' => $validator->errors()
            ]);
        }
       // masukkan di database
        KategoriModel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Kategori berhasil ditambahkan!',
            'redirect' => url('/')
        ]);
    }


    public function show(string $id)
    {
        // Mencari kategori berdasarkan ID
        $kategori = KategoriModel::find($id);

        // Jika kategori tidak ditemukan, redirect ke halaman kategori dengan pesan error
        if (!$kategori) {
            return redirect()->route('kategori.index')->with(
                'error', 'Kategori tidak ditemukan');
        }

        // Menyiapkan breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        // Menyiapkan page untuk judul halaman
        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        // Menentukan menu aktif
        $activeMenu = 'kategori';

        // Mengembalikan view dengan data yang diperlukan
        return view('kategori.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.edit', ['kategori' => $kategori]);
    }


    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori tidak ditemukan.'
            ]);
        }

        $kategori->kode = $request->kode;
        $kategori->nama = $request->nama;
        $kategori->save();

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil diperbarui.'
        ]);
    }


    public function confirm(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm', ['kategori' => $kategori]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::with('barang')->find($id);
    
            if (!$kategori) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
    
            if ($kategori->barang->count() > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kategori tidak dapat dihapus karena sudah digunakan di data barang.'
                ]);
            }
    
            $kategori->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
    
        return redirect('/');
    }
    
}
