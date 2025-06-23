<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated user details
        $account = Auth::user();
        
        // Return the profile view with the authenticated user details
        return view('layouts.profile', ['account' => $account]);
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'passupdate' => 'required|string|min:8',
        ]);
        
        $user = auth()->user();
        $user->password = Hash::make($request->passupdate);
        $user->save();
        
        return back()->with('success', 'Password berhasil diperbarui.');
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'umur' => 'nullable|date',
            'telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);
        
        $user = auth()->user();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->umur = $request->umur;
        $user->telp = $request->telp;
        $user->alamat = $request->alamat;
        $user->save();
        
        return back()->with('success', 'Profile berhasil diperbarui.');
    }
}