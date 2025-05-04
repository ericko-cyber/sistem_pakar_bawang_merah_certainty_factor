<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Gunakan kolom 'username' untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'username'; // Jika menggunakan 'username' untuk login
    }

    // Menggunakan ID numerik untuk otentikasi
    public function getAuthIdentifier()
    {
        return $this->id;  // Mengembalikan ID numerik pengguna
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'username', // Tambahkan kolom username jika digunakan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
