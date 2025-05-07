<?php

namespace App\Http\Controllers\admin;

use App\Models\Gejala;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarGejalaController extends Controller
{
    public function index()
    {
        $gejala_list = DB::table('gejala')->get();
        return view('layouts.admin.daftargejala')->with('gejala_list', $gejala_list);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|unique:gejala,kode_gejala|max:10',
            'nama_gejala' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',

        ]);
        // Upload gambar
        $gambar = $request->file('gambar');
        $namaGambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('assets/images'), $namaGambar);


        Gejala::create([
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
            'gambar' => $namaGambar
        ]);

        return redirect()->back()->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_gejala' => 'required|max:10',
            'nama_gejala' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $gejala = Gejala::findOrFail($id);

        // Update data teks terlebih dahulu
        $gejala->kode_gejala = $request->kode_gejala;
        $gejala->nama_gejala = $request->nama_gejala;

        // Jika ada gambar baru, upload dan ganti gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($gejala->gambar) {
                $gambarPath = public_path('assets/images/' . $gejala->gambar);
                if (file_exists($gambarPath)) {
                    unlink($gambarPath);
                }
            }

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('assets/images'), $namaGambar);

            // Simpan nama gambar baru
            $gejala->gambar = $namaGambar;
        }

        // Simpan perubahan ke database
        $gejala->save();

        return redirect()->route('daftargejala')->with('success', 'Gejala berhasil diperbarui.');
    }


    public function destroy($id)
    {
        DB::table('gejala')->where('id', $id)->delete();

        return redirect()->route('daftargejala')->with('success', 'Gejala berhasil dihapus.');
    }
}
