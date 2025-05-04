<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rules'; // Nama tabel rules
    protected $primaryKey = 'id'; // Primary key default
    public $timestamps = false; // Tidak pakai created_at dan updated_at

    protected $fillable = [
        'id_penyakit',
        'id_gejala',
        'cf_pakar',
    ];

    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'id_gejala');
    }

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class, 'id_penyakit');
    }
}
