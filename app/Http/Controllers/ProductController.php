<?php

namespace App\Http\Controllers;

use App\Models\Kostum;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk.
     * Mengambil data langsung dari database melalui Eloquent Model.
     */
    public function index(Request $request)
    {
        // Eager-load relasi 'kategori' agar tidak terjadi N+1 query problem
        $products = Kostum::with('kategori')
            ->paginate(12);

        return view('pages.product', compact('products'));
    }

    /**
     * Menampilkan halaman detail satu kostum.
     * Menggunakan findOrFail() agar otomatis melempar 404 jika ID tidak ditemukan.
     */
    public function show($id)
    {
        // Eager-load relasi 'kategori' untuk menampilkan nama kategori di detail page
        $kostum = Kostum::with('kategori')->findOrFail($id);

        return view('pages.product-detail', compact('kostum'));
    }
}