<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penyakit; // Pastikan model Penyakit ada

class PenyakitController extends Controller
{
    public function index()
    {
        $penyakit = DB::table('penyakit')->get(); 
        return view('layouts.diagnosa.detailpenyakit', compact('penyakit'));
    }

    public function show($id)
    {
        $penyakit = Penyakit::findOrFail($id); // Hanya ambil satu penyakit berdasarkan ID
        return view('layouts.diagnosa.rinciandetailpenyakit', compact('penyakit'));
    }
}
