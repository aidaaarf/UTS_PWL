<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kategori.index', [
            'activeMenu' => 'kategori'
        ]);
    }

    public function list()
    {
        return response()->json([
            'data' => KategoriModel::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kategori,kode',
            'nama' => 'required'
        ]);

        KategoriModel::create($request->all());

        return response()->json(['message' => 'Data kategori berhasil ditambahkan']);
    }


    /**
     * Display the specified resource.
     */
    public function show(KategoriModel $kategori)
    {
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriModel $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:kategori,kode,' . $id,
            'nama' => 'required'
        ]);

        $kategori = KategoriModel::findOrFail($id);
        $kategori->update($request->all());

        return response()->json(['message' => 'Data kategori berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Data kategori berhasil dihapus']);
    }
}
