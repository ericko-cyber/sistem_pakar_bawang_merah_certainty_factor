<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\RiwayatDiagnosa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalUser = Account::count();
        $totalDiagnosa = RiwayatDiagnosa::count();
        $totalPenyakit = Penyakit::count();
        $totalGejala = Gejala::count();

        // Ambil labels dan data untuk activity diagnosa 5 hari terakhir
        $labelsDiagnosa = collect(range(4, 0))->map(fn($i) => Carbon::today()->subDays($i)->format('d M'))->toArray();
        $dataDiagnosa = collect(range(4, 0))->map(function ($i) {
            return RiwayatDiagnosa::whereDate('tanggal', Carbon::today()->subDays($i))->count();
        })->toArray();

        // Ambil labels dan data untuk activity register 5 bulan terakhir
        $registerData = Account::selectRaw('MONTH(registered) as month, COUNT(*) as count')
            ->whereBetween('registered', [
                Carbon::now()->subMonths(5)->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format labels untuk activity register
        $labels = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('F'); // Format bulan (contoh: Januari, Februari)
        });

        // Data pendaftar per bulan untuk activity register
        $dataRegister = $registerData->map(function ($item) {
            return $item->count; // Jumlah pendaftar per bulan
        });

        return view('layouts.admin.dashboard', compact(
            'labelsDiagnosa',
            'dataDiagnosa',
            'labels',         // Labels untuk activity register (5 bulan terakhir)
            'dataRegister',   // Data untuk activity register
            'totalUser',
            'totalDiagnosa',
            'totalPenyakit',
            'totalGejala'
        ));
    }
}
