<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $user->loadCount('forumPosts');

        $latestForumPosts = $user->forumPosts()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $profileStats = [
            'forum_posts' => $user->forum_posts_count,
            'rental_count' => 0,
            'rating_label' => '-',
        ];

        return view('pages.profile', compact('user', 'latestForumPosts', 'profileStats'));
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

        $user = $request->user();
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

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    // Memproses update foto sampul
    public function updateCover(Request $request)
    {
        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('cover_photo')) {
            if ($user->cover_photo && Storage::exists('public/' . $user->cover_photo)) {
                Storage::delete('public/' . $user->cover_photo);
            }

            $path = $request->file('cover_photo')->store('covers', 'public');
            $user->cover_photo = $path;
            $user->save();
        }

        return redirect()->route('profile')->with('success', 'Foto sampul berhasil diperbarui!');
    }
}
