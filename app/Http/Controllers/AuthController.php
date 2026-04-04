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
        // 1. Validasi Input Brutal (Wajib sebelum menyentuh database)
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Harus ada input 'password_confirmation' di view
        ]);

        // 2. Simpan Data dengan Enkripsi Hash
        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi Bcrypt standar industri
            'role'     => 'pelanggan', // Default role untuk registrasi publik
        ]);

        // 3. (Opsional) Langsung login setelah register
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil, selamat datang!');
    }

    // === BAGIAN LOGIN ===
    public function showLoginForm()
    {
        return view('auth.login'); // View form login dari Rangga
    }

    public function processLogin(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // 2. Autentikasi dan Regenerasi Session (Mencegah pencurian sesi)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Routing Berdasarkan Role (Single Table Inheritance)
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('dashboard'); // Arahkan ke back-office
            }

            return redirect()->intended('/'); // Arahkan pelanggan ke front-office
        }

        // 4. Jika Gagal Login
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
