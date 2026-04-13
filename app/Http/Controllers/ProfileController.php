<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        return view('profile');
    }

    // Memproses update nama dan foto
    public function update(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500', // Tambahkan validasi bio
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $user = \App\Models\User::find(Auth::id());
        $user->nama = $request->nama; // Menggunakan 'nama' sesuai form registermu sebelumnya
        $user->bio = $request->bio; // Menyimpan bio yang diinputkan

        // 2. Logika Upload File
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (agar server tidak penuh)
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Simpan foto baru ke folder storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Simpan ke database
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
