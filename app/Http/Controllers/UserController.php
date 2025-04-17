<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserModel::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,pegawai',
            'username' => 'required|unique:users,username',
            'nama' => 'required',
            'password' => 'required|min:6'
        ]);

        UserModel::create([
            'role' => $request->role,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserModel $userModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
        {
            $user = UserModel::findOrFail($id);
    
            $request->validate([
                'role' => 'required|in:admin,pegawai',
                'username' => 'required|unique:users,username,' . $user->id,
                'nama' => 'required',
            ]);
    
            $user->update([
                'role' => $request->role,
                'username' => $request->username,
                'nama' => $request->nama,
            ]);
    
            // Kalau user input password baru
            if ($request->password) {
                $user->update(['password' => Hash::make($request->password)]);
            }
    
            return redirect()->route('user.index')->with('success', 'User berhasil diupdate.');
        }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        UserModel::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
