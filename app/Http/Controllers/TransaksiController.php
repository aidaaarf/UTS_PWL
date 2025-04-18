<?php

namespace App\Http\Controllers;

use App\Models\TransaksiModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TransaksiModel::with(['barang', 'user'])->get();
        return view('transaksi.index', compact('data'))->with('activeMenu', 'transaksi');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('transaksi.create', compact('barang', 'user'))->with('activeMenu', 'transaksi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'user_id' => 'required|exists:user,id',
            'keterangan' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1'
        ]);

        TransaksiModel::create($request->all());
        return redirect('/transaksi')->with('success', 'Data transaksi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiModel $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = TransaksiModel::findOrFail($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('transaksi.edit', compact('data', 'barang', 'user'))->with('activeMenu', 'transaksi');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'user_id' => 'required|exists:user,id',
            'keterangan' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1'
        ]);
    
        TransaksiModel::where('id', $id)->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
        ]);
    
        return redirect('/transaksi')->with('success', 'Data transaksi berhasil diupdate');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TransaksiModel::destroy($id);
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
