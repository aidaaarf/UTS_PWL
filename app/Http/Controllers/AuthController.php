<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LogActivityModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',   
            'password' => 'required|min:6',
        ]);

        // Cek login menggunakan username dan password
        if (Auth::attempt([
            'username' => $request->username, 
            'password' => $request->password])) {
            $request->session()->regenerate();

            // Log activity: login
            LogActivityModel::create([
                'user_id' => Auth::user()->id,
                'action' => 'Login'
            ]);

            return redirect()->route('dashboard.index');
        }

        // Jika login gagal, kembali dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }


    // Menangani logout
    public function logout(Request $request)
    {
        LogActivityModel::create([
            'user_id' => Auth::user()->id,
            'action' => 'Logout'
        ]);
        Auth::logout();

        return redirect()->route('login');
    }
}
