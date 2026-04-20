<footer class="bg-dark-chocolate text-misty-rose py-16 border-t-[16px] border-sakura">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">

        <div>
            <div class="flex items-center gap-2 font-bold text-2xl mb-6">
                <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-10 h-10 flex items-center justify-center">🛍️</span>
                CosRent
            </div>
            <p class="text-sm opacity-80 mb-6 leading-relaxed">
                Platform sewa kostum cosplay premium terlengkap di Indonesia. Kualitas kain terbaik, higienis, dan pilihan ukuran lengkap.
            </p>
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full border border-misty-rose/30 flex items-center justify-center hover:bg-sakura hover:text-dark-chocolate transition">IG</a>
                <a href="#" class="w-10 h-10 rounded-full border border-misty-rose/30 flex items-center justify-center hover:bg-sakura hover:text-dark-chocolate transition">FB</a>
                <a href="#" class="w-10 h-10 rounded-full border border-misty-rose/30 flex items-center justify-center hover:bg-sakura hover:text-dark-chocolate transition">TW</a>
            </div>
        </div>

        <div>
            <h4 class="font-bold text-sakura mb-6 text-lg">Layanan Kami</h4>
            <ul class="space-y-4 text-sm opacity-90">
                <li><a href="#" class="hover:text-sakura transition">Katalog Kostum</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-sakura transition">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-sakura transition">FAQ</a></li>
                <li><a href="#" class="hover:text-sakura transition">Syarat & Ketentuan</a></li>
                <li><a href="#" class="hover:text-sakura transition">Kebijakan Pengembalian</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-sakura mb-6 text-lg">Hubungi Kami</h4>
            <ul class="space-y-4 text-sm opacity-90">
                <li class="flex items-start gap-3">
                    <span class="mt-1">📍</span>
                    <span>Jl. Cosplay No. 123, Jakarta Selatan, Indonesia</span>
                </li>
                <li class="flex items-center gap-3">
                    <span>📞</span>
                    <span>+62 812-3456-7890</span>
                </li>
                <li class="flex items-center gap-3">
                    <span>✉️</span>
                    <span>support@cosrent.id</span>
                </li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold text-sakura mb-6 text-lg">Lokasi Toko</h4>
            <div class="w-full h-32 bg-aloewood rounded-xl border border-misty-rose/20 relative overflow-hidden flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=400&q=80" alt="Map" class="absolute inset-0 w-full h-full object-cover opacity-40">
                <button class="relative z-10 bg-dark-chocolate/80 text-misty-rose px-4 py-2 rounded border border-misty-rose/50 text-sm hover:bg-sakura hover:text-dark-chocolate transition">Buka Maps</button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-misty-rose/10 text-center text-sm opacity-60">
        © {{ date('Y') }} CosRent. All rights reserved. Crafted with ❤️ for Cosplayers.
    </div>
</footer>
