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
        // Ambil data RiwayatDiagnosa berdasarkan ID
        $riwayat = RiwayatDiagnosa::with('penyakit', 'user')->findOrFail($id);

        // Mengecek apakah riwayat ditemukan
        if (!$riwayat) {
            abort(404, 'Riwayat tidak ditemukan');
        }

        // Kirim data ke tampilan
        return view('layouts.diagnosa.hasildiagnosa', compact('riwayat'));
    }

    public function print($id)
    {
        $riwayat = \App\Models\RiwayatDiagnosa::with('penyakit', 'user')->findOrFail($id);

        return view('layouts.diagnosa.print', compact('riwayat'));
    }
}
