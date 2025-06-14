<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gejala;

class GejalaController extends Controller
{
    public function index()
    {
        $gejala_list = DB::table('gejala')
            ->orderBy('kode_gejala')  // Mengurutkan berdasarkan kolom 'kode_gejala'
            ->get();
        return view('layouts.diagnosa.diagnosalay')->with('gejala_list', $gejala_list);
    }



    public function fetch(Request $request)
    {
        $select = $request->input('select');
        $value = $request->input('value');
        $dependent = $request->input('dependent');

        $data = DB::table('gejala')
            ->where($select, $value)
            ->groupBy($dependent)
            ->get();

        $output = '<option value="">Pilih ' . ucfirst($dependent) . '</option>';

        foreach ($data as $row) {
            $output .= '<option value="' . $row->$dependent . '">' . $row->$dependent . '</option>';
        }

        return response()->json(['options' => $output]);
    }

    public function show($id)
    {
        $penyakit = Gejala::findOrFail($id); // Hanya ambil satu penyakit berdasarkan ID
        return view('layouts.diagnosa.rinciandetailpenyakit', compact('penyakit'));
    }
}
