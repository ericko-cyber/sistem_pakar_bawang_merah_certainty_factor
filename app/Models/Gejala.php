<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala'; 
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Relasi ke tabel penyakit melalui pivot 'rules'
    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'gambar'
    ];
    public function penyakit()
    {
        return $this->belongsToMany(Penyakit::class, 'rules', 'id_gejala', 'id_penyakit');
    }
}
