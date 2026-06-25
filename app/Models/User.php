<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users'; // Representasi dari Tabel Akun

    // GUARDED: Kolom yang diizinkan untuk diisi melalui form register
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role', // Penting untuk Single Table Inheritance
        'is_active',
        'avatar',
        'cover_photo',
        'bio', // Kolom tambahan untuk profil
        'no_hp',
        'has_seen_guide', // Onboarding: sudah membaca panduan rental?
    ];

    // HIDDEN: Menyembunyikan atribut sensitif agar tidak bocor saat data diubah ke array/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_seen_guide' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class, 'user_id');
    }

    public function forumComments()
    {
        return $this->hasMany(ForumComment::class, 'user_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}
