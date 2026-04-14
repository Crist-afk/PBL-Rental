<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">

    <div class="fixed w-full top-0 z-50 px-6 py-4">
        <header class="bg-dark-chocolate text-misty-rose rounded-full shadow-lg max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2 font-bold text-xl">
                <span class="bg-sakura text-dark-chocolate p-2 rounded-full w-8 h-8 flex items-center justify-center">🛍️</span>
                <a href="{{ route('home') }}">CosRent</a>
            </div>
            <nav class="hidden md:flex gap-6 font-medium text-sm">
                <a href="{{ route('home') }}" class="hover:text-sakura transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-sakura transition">About</a>
                <a href="#" class="hover:text-sakura transition">Product</a>
                <a href="#" class="hover:text-sakura transition">Forum</a>
                <a href="{{ route('contact') }}" class="text-sakura transition">Contact</a>
            </nav>
            <div class="flex gap-4 items-center text-sm font-medium">
                @auth
                    <a href="{{ route('profile') }}" class="text-sakura font-bold hover:underline transition">
                        <i class="fa-solid fa-user-circle mr-1"></i> {{ Auth::user()->nama }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-misty-rose/20 text-misty-rose px-3 py-1.5 rounded-full hover:bg-sakura hover:text-dark-chocolate transition text-[10px] font-bold shadow-sm">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-sakura transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-sakura text-dark-chocolate px-5 py-2 rounded-full hover:bg-opacity-80 transition shadow">Register</a>
                @endauth
            </div>
        </header>
    </div>

    <main class="flex-grow pt-32 pb-20 px-6 max-w-7xl mx-auto w-full">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold mb-4 tracking-tight text-dark-chocolate">Hubungi <span class="text-sakura">CosRent</span></h1>
            <p class="text-dark-chocolate/80 text-lg max-w-2xl mx-auto font-medium">Punya pertanyaan seputar sewa kostum, kemitraan vendor, atau butuh bantuan teknis? Tim CosRent siap membantu Anda!</p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">

            <div class="space-y-6">
                <div class="glass-card p-8 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl">
                    <h3 class="text-2xl font-bold text-dark-chocolate mb-6">Tim Dukungan CosRent</h3>
                    <p class="text-sm text-dark-chocolate/70 font-medium mb-6">Silakan hubungi salah satu admin kami di bawah ini untuk respon yang lebih cepat via WhatsApp.</p>

                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Crist Garcia Pasaribu</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 896-2346-7477</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Rangga Surya Saputra</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 812-6126-0195</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-sakura rounded-full flex items-center justify-center text-dark-chocolate text-xl shadow-md">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-bold text-dark-chocolate">Akbar Zamroni</p>
                                <p class="text-sm text-dark-chocolate/70 font-medium">+62 811-7092-501</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-dark-chocolate text-misty-rose p-8 rounded-[2rem] shadow-xl border-2 border-dark-chocolate">
                    <h3 class="text-xl font-bold mb-3 text-sakura"><i class="fa-solid fa-clock mr-2"></i>Jam Operasional Layanan</h3>
                    <p class="text-misty-rose/80 text-sm leading-relaxed">
                        Tim kami aktif melayani pada hari <span class="font-bold text-white">Senin - Jumat</span> pukul <span class="font-bold text-white">09:00 - 17:00 WIB</span>. Pesan yang masuk di luar jam kerja akan dibalas pada hari kerja berikutnya.
                    </p>
                </div>
            </div>

            <div class="glass-card p-8 md:p-10 rounded-[2rem] border-2 border-dark-chocolate/10 shadow-xl h-fit">
                <h3 class="text-2xl font-bold text-dark-chocolate mb-2">Kirim Pesan Langsung</h3>
                <p class="text-sm text-dark-chocolate/70 font-medium mb-8">Isi formulir di bawah ini dan pesan akan langsung diteruskan ke sistem email kami.</p>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Nama Lengkap</label>
                            <input type="text" class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-bold text-dark-chocolate">Email Aktif</label>
                            <input type="email" class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium" placeholder="contoh@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-bold text-dark-chocolate">Subjek Pertanyaan</label>
                        <select class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium">
                            <option value="">-- Pilih Topik --</option>
                            <option value="sewa">Penyewaan Kostum</option>
                            <option value="vendor">Kemitraan Vendor</option>
                            <option value="teknis">Bantuan Teknis / Error</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-bold text-dark-chocolate">Pesan Anda</label>
                        <textarea rows="5" class="w-full p-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium resize-none" placeholder="Tuliskan detail pertanyaan atau keluhan Anda di sini secara lengkap..."></textarea>
                    </div>

                    <button type="button" class="w-full bg-dark-chocolate hover:bg-black text-misty-rose font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex justify-center items-center gap-2 mt-4">
                        <span>Kirim Pesan Sekarang</span>
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>

        </div>
    </main>

</body>
</html>
