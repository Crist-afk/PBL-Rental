<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// [STANDAR PENAMAAN] Class menggunakan Pascal Case (diawali huruf kapital)
class AuthController extends Controller
{
    // === BAGIAN REGISTER ===
    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Fungsi (Method) menggunakan Camel Case
    public function processRegister(Request $request)
    {
        // Validasi input dari pengguna sebelum data dimasukkan ke database untuk keamanan.
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        // Membuat user baru di database. Pastikan password di-hash agar aman
        // (tidak disimpan dalam bentuk teks biasa).
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // INI WAJIB AGAR BISA LOGIN
            'role' => 'pelanggan', // Default role untuk pendaftar baru
            'has_seen_guide' => false, // Onboarding: user baru belum baca panduan
        ]);

        // Auto-login user baru setelah registrasi
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect ke halaman Panduan Rental untuk onboarding
        return redirect()->route('panduan.index');
    }

    // === BAGIAN LOGIN ===
    public function showLoginForm()
    {
        return view('auth.login'); // View form login dari Rangga
    }

    public function processLogin(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $existingUser = User::withTrashed()
            ->where('email', $request->email)
            ->first();
        if ($existingUser && (! $existingUser->is_active || $existingUser->trashed())) {
            return back()->withErrors([
                'email' => 'your account has been deactivated due to actions you have taken',
            ])->onlyInput('email');
        }

        // Coba cocokkan dengan database
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil, perbarui sesi (keamanan anti-hijacking)
            $request->session()->regenerate();

            // Cek role user untuk menentukan arah halaman (redirect)
            if (Auth::user()->role === 'admin') {
                session()->flash('admin_login', true);
                return redirect()->intended(route('admin.dashboard'));
            }

            // Cek onboarding: jika pelanggan belum membaca panduan, arahkan ke panduan
            if (Auth::user()->role === 'pelanggan' && !Auth::user()->has_seen_guide) {
                return redirect()->route('panduan.index');
            }

            // Arahkan pelanggan ke halaman Dashboard Pelanggan
            return redirect()->intended(route('dashboard.pelanggan'));
        }

        // Jika gagal, tendang kembali ke halaman login bawa pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // === BAGIAN LOGOUT ===
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
