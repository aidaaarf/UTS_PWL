<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->authenticated($request, Auth::user());
        }

        return response()->json(['message' => 'Username atau password salah.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return response()->json(['redirect_to' => route('admin.dashboard')]);
        } elseif ($user->role === 'pegawai') {
            return response()->json(['redirect_to' => route('pegawai.dashboard')]);
        }

        return response()->json(['redirect_to' => '/']);
    }
}
