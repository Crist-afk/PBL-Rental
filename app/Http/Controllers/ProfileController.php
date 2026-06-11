<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $user->loadCount(['forumPosts', 'transaksi']);

        $latestForumPosts = $user->forumPosts()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $profileStats = [
            'forum_posts' => $user->forum_posts_count,
            'rental_count' => $user->transaksi_count,
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
            'no_hp' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $user = $request->user();
        $user->nama = $request->nama; // Menggunakan 'nama' sesuai form registermu sebelumnya
        $user->bio = $request->bio; // Menyimpan bio yang diinputkan
        if ($request->has('no_hp')) {
            $user->no_hp = $request->no_hp;
        }

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

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
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

        return redirect()->route('profile')->with('success', 'Cover photo updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ], 'updatePassword');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile')
            ->with('success', 'Password updated successfully.')
            ->with('password_success', 'Password updated successfully.');
    }

    public function destroyAccount(Request $request)
    {
        $request->validateWithBag('deleteAccount', [
            'password' => 'required',
        ]);

        $user = $request->user();

        if ($user->role === 'admin') {
            return back()->withErrors([
                'password' => 'Admin accounts cannot be deleted from the customer profile page.',
            ], 'deleteAccount');
        }

        if ($user->role !== 'pelanggan') {
            return back()->withErrors([
                'password' => 'Only customer accounts can be deleted from this page.',
            ], 'deleteAccount');
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ], 'deleteAccount');
        }

        foreach (['avatar', 'cover_photo'] as $imageField) {
            if ($user->{$imageField} && Storage::disk('public')->exists($user->{$imageField})) {
                Storage::disk('public')->delete($user->{$imageField});
            }
        }

        $user->nama = 'Deleted User';
        $user->email = 'deleted_user_' . $user->id . '@cosrent.local';
        $user->no_hp = null;
        $user->bio = null;
        $user->avatar = null;
        $user->cover_photo = null;
        $user->password = Hash::make(Str::random(64));
        $user->remember_token = null;
        $user->is_active = false;
        $user->save();
        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Your account has been deactivated successfully. You have been logged out.');
    }
}
