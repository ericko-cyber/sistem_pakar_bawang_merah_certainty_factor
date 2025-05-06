<?php

namespace App\Http\Controllers\admin;

use App\Models\Penyakit;
use App\Models\Gejala;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DaftarPenyakitController extends Controller
{
    public function index()
    {
        $penyakit_list = DB::table('penyakit')->get();
        $gejala = Gejala::all(); // Ambil semua gejala
        return view('layouts.admin.daftarpenyakit', compact('penyakit_list', 'gejala'));
    }

    public function store(Request $request)
    {
        // Validasi form
        $request->validate([
            'kode_penyakit' => 'required|string|max:10|unique:penyakit',
            'nama_penyakit' => 'required|string|max:100',
            'subjudul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'penanganan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gejala' => 'required|array', // Memastikan gejala yang dipilih adalah array
            'gejala.*' => 'exists:gejala,id', // Memastikan ID gejala ada di tabel gejala
        ]);

        // Upload gambar
        $gambar = $request->file('gambar');
        $namaGambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('assets/images'), $namaGambar);

        // Mengambil ID gejala yang dipilih dan mengubahnya menjadi string
        $gejalaIds = implode(',', $request->gejala);

        // Simpan data penyakit ke database
        Penyakit::create([
            'kode_penyakit' => $request->kode_penyakit,
            'nama_penyakit' => $request->nama_penyakit,
            'subjudul' => $request->subjudul,
            'deskripsi' => $request->deskripsi,
            'penanganan' => $request->penanganan,
            'gambar' => $namaGambar,
            'gejala' => $gejalaIds, // Simpan ID gejala dalam bentuk string
        ]);

        return redirect()->back()->with('success', 'Data penyakit berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        // HAPUS ini: dd($request->all());  // <-- Hapus baris ini
        
        $penyakit = Penyakit::findOrFail($id);
    
        $request->validate([
            'kode_penyakit' => 'required|string|max:10|unique:penyakit,kode_penyakit,' . $penyakit->id,
            'nama_penyakit' => 'required|string|max:100',
            'subjudul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'penanganan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gejala' => 'required|array', // Validasi gejala yang dipilih
            'gejala.*' => 'exists:gejala,id',
        ]);

        // Menyimpan log dengan memeriksa apakah gejala ada
        Log::info('Gejala yang diterima: ', ['gejala' => $request->gejala]); // Menyimpan data dalam array

        // Update data penyakit
        $penyakit->kode_penyakit = $request->kode_penyakit;
        $penyakit->nama_penyakit = $request->nama_penyakit;
        $penyakit->subjudul = $request->subjudul;
        $penyakit->deskripsi = $request->deskripsi;
        $penyakit->penanganan = $request->penanganan;

        // Jika ada gambar baru, upload dan ganti gambar
        if ($request->hasFile('gambar')) {
            $gambarPath = public_path('assets/images/' . $penyakit->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath); // Hapus gambar lama
            }

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('assets/images'), $namaGambar);

            $penyakit->gambar = $namaGambar;
        }

        // Menyinkronkan gejala yang dipilih
        if ($request->has('gejala')) {
            $penyakit->gejala = implode(',', $request->gejala); // Simpan ID yang dipilih dalam format string
            Log::info('Gejala yang dipilih disimpan: ', ['gejala' => $penyakit->gejala]); // Menampilkan gejala yang disimpan
        } else {
            $penyakit->gejala = ''; // Jika tidak ada gejala yang dipilih
        }

        // Simpan perubahan penyakit
        $penyakit->save();

        return redirect()->back()->with('success', 'Data penyakit berhasil diperbarui!');
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
}