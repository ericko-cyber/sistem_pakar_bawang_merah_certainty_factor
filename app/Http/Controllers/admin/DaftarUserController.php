<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class DaftarUserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        // Mengambil data user dari tabel accounts
        $user_list = DB::table('accounts')->get();
        return view('layouts.admin.daftaruser')->with('user_list', $user_list);
    }

    // Menghapus user
    public function destroy($id)
    {
        // Menggunakan query builder untuk mencari user di tabel accounts
        DB::table('accounts')->where('id', $id)->delete();

        return redirect()->route('daftaruser')->with('success', 'User berhasil dihapus!');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:accounts',
            'email' => 'required|string|email|max:100|unique:accounts',
            'alamat' => 'required|string|max:99',
            'telp' => 'required|string|max:99',
            'umur' => 'required|string|max:99',
            'password' => 'required|string|min:8',
        ]);

        // Buat user baru
        Account::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'alamat' => $data['alamat'],
            'telp' => $data['telp'],
            'umur' => $data['umur'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        return redirect()->route('daftaruser')->with('success', 'User berhasil ditambahkan!');
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        // Mencari user berdasarkan ID
        $user = DB::table('accounts')->where('id', $id)->first();
        if (!$user) {
            return redirect()->route('daftaruser')->with('error', 'User tidak ditemukan!');
        }

        return view('layouts.admin.edituser', compact('user'));
    }

    // Mengupdate data user
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50',
            'email'    => 'required|string|email|max:100',
            'alamat'   => 'required|string|max:99',
            'telp' => 'required|string|max:99',
            'umur' => 'required|string|max:99',
            // Menghapus confirmed jika tidak memerlukan konfirmasi password
            'password' => 'nullable|string|min:8',
        ]);

        // Mencari user berdasarkan ID
        $user = Account::findOrFail($id);
        $user->username = $data['username'];
        $user->email    = $data['email'];
        $user->alamat   = $data['alamat'];
        $user->telp   = $data['telp'];
        $user->umur   = $data['umur'];

        // Jika password diubah, update password
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('daftaruser')->with('success', 'User berhasil diperbarui!');
    }
}
