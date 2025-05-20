<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RiwayatDiagnosa;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login
        $user_id = auth()->user()->id;

        // Ambil data riwayat hanya milik user yang login
        $history_list = DB::table('riwayat')
            ->where('id_user', $user_id)
            ->get();

        // Ambil daftar penyakit
        $penyakit_list = DB::table('penyakit')->pluck('nama_penyakit', 'id');

        // Kirim data ke view
        return view('layouts.diagnosa.history', [
            'history_list' => $history_list,
            'penyakit_list' => $penyakit_list,
        ]);
    }

    public function detail($id)
    {
        $role = auth()->user()->role;
        $riwayat = RiwayatDiagnosa::with('penyakit', 'user')->findOrFail($id);

        // Ambil alternative diagnoses dari JSON hasil diagnosa
        $alternativeDiagnoses = [];
        if (!empty($riwayat->hasil_diagnosa)) {
            $hasilDiagnosa = json_decode($riwayat->hasil_diagnosa, true);
            // Ambil selain utama (index 0), misal 3 alternatif
            $alternativeDiagnoses = array_slice($hasilDiagnosa, 1, 3);
        }

        return view('layouts.diagnosa.hasildiagnosa', compact('riwayat', 'role', 'alternativeDiagnoses'));
    }


    public function print($id)
    {
        $riwayat = \App\Models\RiwayatDiagnosa::with('penyakit', 'user')->findOrFail($id);
        $role = auth()->user()->role;

        // Decode hasil_diagnosa untuk alternatif diagnosa
        $hasilDiagnosa = json_decode($riwayat->hasil_diagnosa, true);
        $alternativeDiagnoses = [];
        if ($hasilDiagnosa) {
            // Ambil alternatif setelah utama, maksimal 3
            $alternativeDiagnoses = array_slice($hasilDiagnosa, 1, 3);
        }

        // Kirim data riwayat, role, dan alternativeDiagnoses ke view
        return view('layouts.diagnosa.print', compact('riwayat', 'role', 'alternativeDiagnoses'));
    }
}
