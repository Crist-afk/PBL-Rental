<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Memanggil file view resources/views/home.blade.php
        return view('pages.home');
    }

    public function product()
    {
        return view('pages.product');
    }

    public function forum()
    {
        return view('pages.forum');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

}
