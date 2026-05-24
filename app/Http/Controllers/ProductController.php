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
        $query = Kostum::with('kategori');

        // Filter by Search Keyword
        if ($request->filled('search')) {
            $query->where('nama_kostum', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Sort by Price
        if ($request->filled('sort')) {
            if ($request->sort == 'lowest') {
                $query->orderBy('harga_sewa', 'asc');
            } elseif ($request->sort == 'highest') {
                $query->orderBy('harga_sewa', 'desc');
            }
        } else {
            // Default sort: newest first
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('pages.product', compact('products', 'categories'));
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