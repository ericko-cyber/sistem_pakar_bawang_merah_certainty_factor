<?php

namespace App\Http\Controllers\admin;

use App\Models\Penyakit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DaftarPenyakitController extends Controller
{
    //

    public function update(Request $request, $id)
    {
        $penyakit = Penyakit::findOrFail($id);

        $request->validate([
            'kode_penyakit' => 'required|string|max:10|unique:penyakit,kode_penyakit,' . $penyakit->id,
            'nama_penyakit' => 'required|string|max:100',
            'subjudul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'penanganan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update field
        $penyakit->kode_penyakit = $request->kode_penyakit;
        $penyakit->nama_penyakit = $request->nama_penyakit;
        $penyakit->subjudul = $request->subjudul;
        $penyakit->deskripsi = $request->deskripsi;
        $penyakit->penanganan = $request->penanganan;

        // Kalau upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            $gambarPath = public_path('assets/images/' . $penyakit->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('assets/images'), $namaGambar);

            $penyakit->gambar = $namaGambar;
        }

        $penyakit->save();

        return redirect()->back()->with('success', 'Data penyakit berhasil diperbarui!');
    }


    public function daftarpenyakit()
    {
        return view('layouts.admin.daftarpenyakit');
    }
    public function index()
    {
        $penyakit_list = DB::table('penyakit')->get();
        return view('layouts.admin.daftarpenyakit')->with('penyakit_list', $penyakit_list);
    }
    public function destroy($id)
    {
        $penyakit = Penyakit::findOrFail($id);

        // Hapus gambar dari folder jika ada
        $gambarPath = public_path('assets/images/' . $penyakit->gambar);
        if (file_exists($gambarPath)) {
            unlink($gambarPath); // Hapus file dari server
        }

        // Hapus data dari database
        $penyakit->delete();

        return redirect()->back()->with('success', 'Data penyakit berhasil dihapus beserta gambarnya.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|string|max:10|unique:penyakit',
            'nama_penyakit' => 'required|string|max:100',
            'subjudul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'penanganan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar
        $gambar = $request->file('gambar');
        $namaGambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('assets/images'), $namaGambar);

        // Simpan data ke database
        Penyakit::create([
            'kode_penyakit' => $request->kode_penyakit,
            'nama_penyakit' => $request->nama_penyakit,
            'subjudul' => $request->subjudul,
            'deskripsi' => $request->deskripsi,
            'penanganan' => $request->penanganan,
            'gambar' => $namaGambar,
        ]);

        return redirect()->back()->with('success', 'Data penyakit berhasil ditambahkan!');
    }
}
