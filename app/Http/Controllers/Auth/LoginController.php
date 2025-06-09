<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/home'); // Ganti dengan redirect ke /dashboard jika diperlukan
        }
        return view('layouts.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validasi inputan login
        $credentials = $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string',
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // dapatkan user yang sedang login

            // Cek role dan redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'user') {
                return redirect()->intended('/home');
            }

            // Fallback redirect kalau role tidak dikenali
            return redirect('/login')->withErrors(['username' => 'Role tidak dikenali.']);
        }

        // Gagal login
        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ])->withInput();
    }


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
