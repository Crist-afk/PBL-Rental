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
            // 'confirmed' otomatis mengecek kolom password_confirmation
            'password' => 'required|min:8|confirmed',
        ]);

        // Membuat user baru di database. Pastikan password di-hash agar aman
        // (tidak disimpan dalam bentuk teks biasa).
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

        // === HARDCODE ADMIN LOGIN ===
        if ($credentials['email'] === 'admin@gmail.com' && $credentials['password'] === 'admin123') {
            // Pastikan user admin ada di database agar Auth::login() berfungsi
            $adminUser = User::firstOrCreate(
                ['email' => 'admin@gmail.com'],
                [
                    'nama' => 'Admin',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin'
                ]
            );

            Auth::login($adminUser);
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }
        // ============================

        // Coba cocokkan dengan database
        if (Auth::attempt($credentials)) {
            // Jika berhasil, perbarui sesi (keamanan anti-hijacking)
            $request->session()->regenerate();

            // Cek role user untuk menentukan arah halaman (redirect)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Arahkan pelanggan ke halaman Dashboard Pelanggan
            return redirect()->intended(route('dashboard.pelanggan'));
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

        return redirect()->route('login');
    }
}
