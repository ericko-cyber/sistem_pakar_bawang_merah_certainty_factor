<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\RiwayatDiagnosa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DiagnosaController extends Controller
{
    public function index()
    {
        $gejala_list = Gejala::all();
        return view('layouts.diagnosa.diagnosalay', ['gejala_list' => $gejala_list]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'gejala' => 'required|array|min:3',
            'gejala.*' => 'required|integer|exists:gejala,id',
            'cf_user' => 'required|array|min:3',
            'cf_user.*' => 'in:0,0.2,0.4,0.6,0.8,1.0',
        ]);

        $selectedGejala = $request->input('gejala');
        $cfUserInputs = $request->input('cf_user');

        Log::info('Auth::id(): ' . Auth::id());
        Log::info('Data Gejala yang Dipilih: ', $selectedGejala);
        Log::info('Selected Gejala: ' . implode(',', $selectedGejala));
        Log::info('Nilai CF User: ' . implode(',', $cfUserInputs));

        $penyakits = Penyakit::with(['gejala', 'rules'])->get();
        $hasil = [];

        foreach ($penyakits as $penyakit) {
            $cf_values = [];

            Log::info("Penyakit ID: {$penyakit->id}");

            foreach ($penyakit->rules as $rule) {
                $index = array_search($rule->id_gejala, $selectedGejala);
                if ($index !== false) {
                    $cf_user = floatval($cfUserInputs[$index]);
                    $cf_pakar = floatval($rule->cf_pakar);
                    $cf_he = $cf_user * $cf_pakar;
                    $cf_values[] = $cf_he;

                    Log::info("Gejala {$rule->id_gejala}: CF_Pakar={$cf_pakar}, CF_User={$cf_user}, CF(he)={$cf_he}");
                }
            }

            if (empty($cf_values)) {
                Log::info("Tidak ada CF(he) untuk penyakit ID: {$penyakit->id}");
                continue;
            }

            $cf_combine = $cf_values[0];
            for ($i = 1; $i < count($cf_values); $i++) {
                $cf_combine = $cf_combine + ($cf_values[$i] * (1 - $cf_combine));
            }

            Log::info("Penyakit ID: {$penyakit->id}, CF Combined: {$cf_combine}");

            if ($cf_combine > 0) {
                $hasil[] = [
                    'penyakit' => $penyakit,
                    'nilai' => $cf_combine
                ];
            }
        }

        usort($hasil, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

        if (empty($hasil)) {
            return redirect()->back()->with('error', 'Tidak ditemukan penyakit yang cocok.');
        }

        $terbesar = $hasil[0];
        Log::info("Hasil Diagnosa: Penyakit ID {$terbesar['penyakit']->id} dengan nilai CF {$terbesar['nilai']}");

        $riwayat = RiwayatDiagnosa::create([
            'id_user' => Auth::user()->id,
            'id_penyakit' => $terbesar['penyakit']->id,
            'nilai' => ($terbesar['nilai'] * 100) . '%',
            'tanggal' => now(),
        ]);

        if (!$riwayat) {
            return redirect()->back()->with('error', 'Gagal menyimpan riwayat diagnosa.');
        }

        return redirect()->route('history.detail', $riwayat->id_riwayat);
    }

    public function hasil($id)
    {
        $riwayat = RiwayatDiagnosa::with(['user', 'penyakit'])->findOrFail($id);
        return view('layouts.diagnosa.hasildiagnosa', compact('riwayat'));
    }
}
