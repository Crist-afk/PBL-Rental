<?php

namespace App\Http\Controllers;

use App\Models\Kostum;

class HomeController extends Controller
{
    public function index()
    {
        $featuredKostums = Kostum::with('kategori')
            ->where('stok', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        return view('pages.home', compact('featuredKostums'));
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
