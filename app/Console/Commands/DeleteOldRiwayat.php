<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiwayatDiagnosa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteOldRiwayat extends Command
{
    protected $signature = 'riwayat:delete-old';
    protected $description = 'Hapus riwayat diagnosa yang lebih dari 7 hari';

    public function handle()
    {
        Log::info('Command riwayat:delete-old dijalankan cron job pada '.now());
        $cutoffDate = Carbon::now()->subDays(7);
        $deleted = RiwayatDiagnosa::where('tanggal', '<', $cutoffDate)->delete();

        $this->info("Berhasil menghapus {$deleted} data riwayat yang lebih dari 7 hari.");
    }
}
