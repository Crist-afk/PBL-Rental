<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // === BAGIAN REGISTER ===
    public function showRegisterForm()
    {
        return view('auth.register'); // View form register dari Rangga
    }

    public function processRegister(Request $request)
    {
        // Validasi ketat
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // 'confirmed' otomatis mengecek kolom password_confirmation
        ]);

        // Simpan ke Database
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // INI WAJIB AGAR BISA LOGIN
            'role' => 'pelanggan', // Default role untuk pendaftar baru
        ]);

        // Lempar ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
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

        // Coba cocokkan dengan database
        if (Auth::attempt($credentials)) {
            // Jika berhasil, perbarui sesi (keamanan anti-hijacking)
            $request->session()->regenerate();

            // Arahkan ke halaman profile atau home
            return redirect()->route('profile');
        }

        // Jika gagal, tendang kembali ke halaman login bawa pesan error
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    // === BAGIAN LOGOUT ===
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
