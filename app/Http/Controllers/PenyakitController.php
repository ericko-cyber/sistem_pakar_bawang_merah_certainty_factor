<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penyakit;
use App\Models\Gejala; // Import model Gejala

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakit = DB::table('penyakit')->get();
        return view('layouts.diagnosa.detailpenyakit', compact('penyakit'));
    }

    public function show($id)
    {
        $penyakit = Penyakit::findOrFail($id); // Ambil data penyakit berdasarkan ID

        // Ambil ID gejala yang terkait dengan penyakit ini
        $gejala_ids = explode(',', $penyakit->gejala);

        // Ambil nama gejala berdasarkan ID
        $gejala_list = Gejala::whereIn('id', $gejala_ids)->pluck('nama_gejala');

        return view('layouts.diagnosa.rinciandetailpenyakit', compact('penyakit', 'gejala_list'));
    }
}
