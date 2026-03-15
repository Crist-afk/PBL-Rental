@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="w-64 bg-indigo-800 min-h-screen text-white p-6 hidden md:block">
        <h2 class="text-xl font-bold mb-8">Admin Menu</h2>
        <nav class="space-y-4">
            <a href="{{ route('dashboard') }}" class="block p-3 bg-indigo-700 rounded-lg">Dashboard</a>
            <a href="{{ route('produk') }}" class="block p-3 hover:bg-indigo-700 rounded-lg transition">Data Produk</a>
            <a href="#" class="block p-3 hover:bg-indigo-700 rounded-lg transition">Riwayat Sewa</a>
        </nav>
    </div>

    <div class="flex-1 p-10 bg-gray-100">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Ringkasan Statistik</h1>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm">
                <span class="text-gray-600">Status: <span class="text-green-500 font-bold">Online</span></span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-indigo-500 hover:shadow-md transition">
                <p class="text-gray-500 font-medium">Total Kostum</p>
                <h3 class="text-4xl font-extrabold text-indigo-900 mt-2">152</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-pink-500 hover:shadow-md transition">
                <p class="text-gray-500 font-medium">Sewa Berjalan</p>
                <h3 class="text-4xl font-extrabold text-pink-600 mt-2">24</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-yellow-500 hover:shadow-md transition">
                <p class="text-gray-500 font-medium">Pendapatan</p>
                <h3 class="text-4xl font-extrabold text-gray-800 mt-2">Rp 8.2jt</h3>
            </div>
        </div>

        <div class="mt-12 bg-white rounded-2xl shadow-sm p-8">
            <h2 class="text-xl font-bold mb-6">Penyewaan Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 border-b">
                            <th class="pb-4">Nama Pelanggan</th>
                            <th class="pb-4">Kostum</th>
                            <th class="pb-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <tr class="border-b italic">
                            <td colspan="3" class="py-6 text-center">Belum ada data penyewaan baru.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection