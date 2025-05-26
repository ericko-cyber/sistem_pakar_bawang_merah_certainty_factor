<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiwayatDiagnosa;
use Carbon\Carbon;

class DeleteOldRiwayat extends Command
{
    protected $signature = 'riwayat:delete-old';
    protected $description = 'Hapus riwayat diagnosa yang lebih dari 7 hari';

    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(7);
        $deleted = RiwayatDiagnosa::where('tanggal', '<', $cutoffDate)->delete();

        $this->info("Berhasil menghapus {$deleted} data riwayat yang lebih dari 7 hari.");
    }
}
