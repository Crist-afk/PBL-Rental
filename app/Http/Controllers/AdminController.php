<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function kostum()
    {
        return view('admin.kostum');
    }

    public function pembayaran()
    {
        return view('admin.pembayaran');
    }

    public function pengembalian()
    {
        return view('admin.pengembalian');
    }

    public function riwayat()
    {
        return view('admin.riwayat');
    }
}
