<?php

namespace App\Http\Controllers;

use App\Models\TransaksiModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('transaksi.index', [
            'activeMenu' => 'transaksi',
        ]);
    }

    public function getData()
    {
        $transactions = TransaksiModel::with('user', 'barang')->where(
                        'user_id', Auth::user()->id)->get();

        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) {
                $btn = '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->id . '/show') . '\')" 
                                    class="btn btn-info btn-sm mr-2">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->id . '/edit') . '\')" 
                                    class="btn btn-warning btn-sm mr-2">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->id . '/confirm') . '\')" 
                                    class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->addColumn('username', function ($transaksi) {
                return $transaksi->user->nama ?? 'N/A'; // Menampilkan nama user
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $barang = BarangModel::all();
        return view('transaksi.create', compact('barang'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|in:masuk,keluar',
        ]);

        // Ambil data barang
        $barang = BarangModel::findOrFail($request->barang_id);

        // Cek stok cukup jika keluar
        if ($request->keterangan === 'keluar' && $barang->stok < $request->jumlah) {
            return response()->json([
                'status' => false,
                'message' => 'Stok barang tidak mencukupi untuk transaksi keluar.',
            ]);
        }

        // Update stok sesuai keterangan
        if ($request->keterangan === 'masuk') {
            $barang->stok += $request->jumlah;
        } else {
            $barang->stok -= $request->jumlah;
        }

        // Simpan perubahan stok
        $barang->save();

        // Simpan transaksi
        TransaksiModel::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil ditambahkan!',
        ]);
    }

    public function show(string $id)
    {
        $transaksi = TransaksiModel::with(['barang', 'user'])->find($id);

        // Menyiapkan breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];

        // Menyiapkan page untuk judul halaman
        $page = (object) [
            'title' => 'Detail Transaksi'
        ];

        // Menentukan menu aktif
        $activeMenu = 'transaksi';

        return view('transaksi.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'transaksi' => $transaksi,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = TransaksiModel::find($id);

        if (!$transaksi) {
            return redirect('/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        $barang = BarangModel::all();
        $user = Auth::user();

        return view('transaksi.edit', compact(
            'transaksi',
            'barang',
            'user'
        ))->with(
            'activeMenu',
            'transaksi'
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'keterangan' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1'
        ]);

        $data = TransaksiModel::find($id);

        if (!$data) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ]);
            }
            return redirect('/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        // Ambil barang lama dan kembalikan stok sebelumnya
        $barangLama = BarangModel::find($data->barang_id);
        if ($data->keterangan === 'masuk') {
            $barangLama->stok -= $data->jumlah;
        } else {
            $barangLama->stok += $data->jumlah;
        }
        $barangLama->save();

        // Ambil barang baru (bisa sama atau beda dari sebelumnya)
        $barangBaru = BarangModel::find($request->barang_id);

        // Validasi stok cukup untuk keluar
        if ($request->keterangan === 'keluar' && $barangBaru->stok < $request->jumlah) {
            return response()->json([
                'status' => false,
                'message' => 'Stok barang tidak mencukupi.'
            ]);
        }

        // Update stok sesuai transaksi baru
        if ($request->keterangan === 'masuk') {
            $barangBaru->stok += $request->jumlah;
        } else {
            $barangBaru->stok -= $request->jumlah;
        }
        $barangBaru->save();

        // Update data transaksi
        $data->update([
            'barang_id' => $request->barang_id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'user_id' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Data transaksi berhasil diupdate'
            ]);
        }

        return redirect('/transaksi')->with('success', 'Data transaksi berhasil diupdate');
    }


    public function confirm(string $id)
    {
        $transaksi = TransaksiModel::find($id);
        return view('transaksi.confirm', ['transaksi' => $transaksi]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $transaksi = TransaksiModel::find($id);
            if ($transaksi) {
                $transaksi->delete();
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
