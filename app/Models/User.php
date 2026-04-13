<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Representasi dari Tabel Akun

    // GUARDED: Kolom yang diizinkan untuk diisi melalui form register
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role', // Penting untuk Single Table Inheritance
        'avatar',
        'bio', // Kolom tambahan untuk profil
    ];

    // HIDDEN: Menyembunyikan atribut sensitif agar tidak bocor saat data diubah ke array/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
