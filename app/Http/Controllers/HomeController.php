<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    // Method untuk menampilkan Halaman Utama (Home)
    public function index()
    {
        // Instruksikan Rangga untuk membuat file: resources/views/home.blade.php
        return view('home');
    }

    // Method untuk menampilkan Halaman Contact Us
    public function contact()
    {
        // Instruksikan Rangga untuk membuat file: resources/views/contact.blade.php
        return view('contact');
    }
}
