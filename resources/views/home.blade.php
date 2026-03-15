<div>
@extends('layouts.app')

@section('content')
<div class="relative bg-indigo-900 h-[500px] flex items-center overflow-hidden">
    <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&q=80&w=1470')] bg-cover bg-center"></div>
    <div class="container mx-auto px-6 relative z-10 text-white">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Jadi Karakter <br><span class="text-pink-400">Favoritmu!</span></h1>
        <p class="text-lg mb-8 max-w-lg">Sewa kostum cosplay kualitas premium dengan harga terjangkau. Dari anime klasik hingga game terbaru.</p>
        <a href="#koleksi" class="bg-pink-500 hover:bg-pink-600 px-8 py-3 rounded-lg font-semibold transition shadow-lg">Lihat Koleksi</a>
    </div>
</div>

<div id="koleksi" class="container mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Koleksi Terpopuler</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach(['Genshin Impact', 'Naruto', 'Cyberpunk'] as $item)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:-translate-y-2 transition duration-300">
            <div class="h-64 bg-gray-200 relative overflow-hidden">
                <img src="https://via.placeholder.com/400x300" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Cosplay">
                <span class="absolute top-4 left-4 bg-pink-500 text-white text-xs px-3 py-1 rounded-full">Tersedia</span>
            </div>
            <div class="p-6">
                <h3 class="font-bold text-xl mb-2">{{ $item }} Series</h3>
                <p class="text-gray-600 text-sm mb-4">Full set kostum + aksesoris senjata.</p>
                <div class="flex justify-between items-center">
                    <span class="text-indigo-600 font-bold">Rp 150.000 / hari</span>
                    <button class="text-pink-500 font-semibold hover:underline">Detail →</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
</div>
