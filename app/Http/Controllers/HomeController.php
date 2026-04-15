<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Memanggil file view resources/views/home.blade.php
        return view('home');
    }

    public function product()
    {
        return view('product');
    }

    public function forum()
    {
        return view('forum');
    }

    public function contact()
    {
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }

}
