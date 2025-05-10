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

    // PenyakitController.php
    public function show($id)
    {
        // Ambil data penyakit berdasarkan ID dan muat relasi gejalas
        $penyakit = Penyakit::with('gejala')->findOrFail($id);

        // Mengirim data penyakit ke view
        return view('layouts.diagnosa.rinciandetailpenyakit', compact('penyakit'));
    }
}
