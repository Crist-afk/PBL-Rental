<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function autentikasi(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === 'admin' && $password === 'admin123') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Login Gagal. Periksa kembali username dan password Anda.');
        }
    }
}
