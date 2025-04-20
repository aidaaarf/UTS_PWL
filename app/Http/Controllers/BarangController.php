<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        // Kirim data barang dan kategori ke view
        return view('barang.index', [
            'activeMenu' => 'barang',
        ]);
    }

    public function getData()
    {
        $barangs = BarangModel::with('kategori')->get();

        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori ? $barang->kategori->nama : '-';
            })
            ->addColumn('aksi', function ($barang) {
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->id . '/show') . '\')" 
                                    class="btn btn-info btn-sm mr-2">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->id . '/edit') . '\')" 
                                    class="btn btn-warning btn-sm mr-2">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->id . '/confirm') . '\')" 
                                    class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        // Mengambil semua data kategori
        $data_kategori = KategoriModel::all();

        // Mengirimkan data kategori ke view 'barang.create'
        return view('barang.create', compact('data_kategori'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:barang,kode',
            'nama' => 'required',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada inputan!',
                'msgField' => $validator->errors()
            ]);
        }

        BarangModel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Barang berhasil ditambahkan!',
            'redirect' => url('/barang')
        ]);
    }

    // Di controller BarangController
    public function show(string $id)
    {
        // Mencari barang berdasarkan ID
        $barang = BarangModel::find($id);

        // Menyiapkan breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        // Menyiapkan page untuk judul halaman
        $page = (object) [
            'title' => 'Detail Barang'
        ];

        // Menentukan menu aktif
        $activeMenu = 'barang';

        // Mengembalikan view dengan data yang diperlukan
        return view('barang.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori tidak ditemukan.'
            ]);
        }

        $barang->kode = $request->kode;
        $barang->nama = $request->nama;
        $barang->stok = $request->stok;
        $barang->kategori_id = $request->kategori_id;
        $barang->save();

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil diperbarui.'
        ]);
    }

    public function confirm(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm', ['barang' => $barang]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
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
