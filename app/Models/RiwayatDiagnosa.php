<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penyakit;
use App\Models\Account;

class RiwayatDiagnosa extends Model
{
    protected $table = 'riwayat';
    protected $primaryKey = 'id_riwayat';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_penyakit',
        'nilai',
        'hasil_diagnosa',
        'tanggal',
    ];

    /**
     * Relasi ke tabel penyakit.
     */
    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'id_penyakit', 'id');
    }

    /**
     * Relasi ke tabel accounts (user yang melakukan diagnosa).
     */
    public function user()
    {
        return $this->belongsTo(Account::class, 'id_user', 'id');
    }
}
