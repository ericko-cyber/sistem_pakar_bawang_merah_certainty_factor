<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\Rule;

class RulesController extends Controller
{

    public function update(Request $request, $id)
    {

        $request->validate([
            'id_gejala' => 'required|exists:gejala,id',
            'cf_pakar' => 'required|numeric|min:0|max:1',
        ]);

        $rule = Rule::findOrFail($id);
        $rule->id_gejala = $request->id_gejala;
        $rule->cf_pakar = $request->cf_pakar;
        $rule->save();

        return redirect()->route('rules')->with('success', 'Rule berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rule = Rule::findOrFail($id);
        $rule->delete();

        return redirect()->route('rules')->with('success', 'Rule berhasil dihapus.');
    }

    public function index()
    {
        // Ambil semua penyakit beserta relasi rules dan gejalanya
        $penyakit_list = Penyakit::with('rules.gejala')->get();

        // Ambil semua gejala untuk dropdown pilihan
        $gejala_list = Gejala::all();

        // Tidak perlu rules_list lagi karena rules sudah diambil dari relasi
        return view('layouts.admin.rules', compact('penyakit_list', 'gejala_list'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakit,id',
            'gejala_id' => 'required|exists:gejala,id',
            'cf_pakar' => 'required|numeric|min:0|max:1',
        ]);

        Rule::create([
            'id_penyakit' => $request->penyakit_id,
            'id_gejala' => $request->gejala_id,
            'cf_pakar' => $request->cf_pakar,
        ]);

        return redirect()->back()->with('success', 'Gejala berhasil ditambahkan ke penyakit.');
    }
}
