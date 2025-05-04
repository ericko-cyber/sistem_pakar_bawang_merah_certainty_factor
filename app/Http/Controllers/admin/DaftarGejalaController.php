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
        ]);

        Gejala::create([
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
        ]);

        return redirect()->back()->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_gejala' => 'required|max:10',
            'nama_gejala' => 'required|string|max:255',
        ]);

        $gejala = Gejala::findOrFail($id);
        $gejala->update([
            'kode_gejala' => $request->kode_gejala,
            'nama_gejala' => $request->nama_gejala,
        ]);

        return redirect()->route('daftargejala')->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('gejala')->where('id', $id)->delete();

        return redirect()->route('daftargejala')->with('success', 'Gejala berhasil dihapus.');
    }
}
