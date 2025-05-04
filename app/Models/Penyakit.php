<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit'; 
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'subjudul',
        'deskripsi',
        'penanganan',
        'gambar',
    ];

    // Relasi ke tabel 'rules'
    public function rules()
    {
        return $this->hasMany(Rule::class, 'id_penyakit');
    }

    // Relasi ke tabel 'gejala' melalui tabel pivot 'rules'
    public function gejala()
    {
        return $this->belongsToMany(Gejala::class, 'rules', 'id_penyakit', 'id_gejala');
    }
}
