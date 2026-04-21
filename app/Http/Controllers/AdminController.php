<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard-admin');
    }

    public function kostum()
    {
        return view('admin.kostum-admin');
    }

    public function pembayaran()
    {
        return view('admin.pembayaran-admin');
    }

    public function pengembalian()
    {
        return view('admin.pengembalian-admin');
    }

    public function riwayat()
    {
        return view('admin.riwayat-admin');
    }

    public function pengguna()
    {
        return view('admin.pengguna-admin');
    }
}
