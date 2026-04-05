<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosRent - Platform Sewa Kostum Cosplay</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Kustomisasi scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600 tracking-tight">CosRent<span class="text-rose-500">.</span></a>
                </div>
                
                <div class="hidden md:flex space-x-6 lg:space-x-8 items-center text-sm md:text-base">
                    <a href="{{ route('home') }}" class="text-indigo-600 font-medium transition duration-200">Home</a>
                    
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Cari Kostum</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">List Cosrent</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Forum</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Jadwal Event</a>
                    
                    <a href="{{ route('contact') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Contact</a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition duration-200">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-full transition duration-200 shadow-sm">
                        Buat Akun
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <header class="max-w-5xl mx-auto px-4 pt-16 pb-12 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
            Platform Sewa Kostum Cosplay
        </h1>
        
        <div class="flex flex-wrap justify-center items-center gap-6 text-sm md:text-base text-slate-500 mb-10 font-medium">
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-indigo-500"></i>
                <span>12.495 Katalog</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-users text-rose-500"></i>
                <span>616 Cosrent</span>
            </div>
        </div>

        <div class="max-w-3xl mx-auto relative group">
            <input type="text" 
                class="w-full bg-white border border-slate-300 text-slate-900 text-base rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-4 pl-6 pr-12 shadow-sm transition duration-300" 
                placeholder="Cari karakter, anime, atau game...">
            <button class="absolute right-2 top-2 bottom-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition duration-200">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <div class="max-w-4xl mx-auto mt-6 flex flex-wrap justify-center gap-3">
            <select class="bg-white border border-slate-200 text-slate-600 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5 px-4 shadow-sm hover:border-slate-300 cursor-pointer transition">
                <option selected>Semua Provinsi</option>
                <option value="Jawa Barat">Jawa Barat</option>
            </select>
            <select class="bg-white border border-slate-200 text-slate-600 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5 px-4 shadow-sm hover:border-slate-300 cursor-pointer transition">
                <option selected>Semua Kota</option>
                <option value="Batam">Batam</option>
            </select>
        </div>
    </header>

<section class="max-w-7xl mx-auto px-4 pb-20">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Trending </h2>
            <a href="{{ route('produk') }}" class="px-4 py-2 text-sm font-semibold text-indigo-600 bg-transparent border border-indigo-600 rounded-lg hover:bg-indigo-50 transition duration-200">
                Selengkapnya
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            <x-card-kostum />
            <x-card-kostum />
            <x-card-kostum />
            <x-card-kostum />
            <x-card-kostum />
            <x-card-kostum />
            <x-card-kostum />
            <x-card-kostum />

        </div>
    </section>

<section id="contact" class="bg-white py-20 border-t border-slate-100 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-rose-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 transform -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Hubungi Kami 💌</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Punya pertanyaan seputar sewa kostum, kemitraan vendor, atau kendala teknis? Jangan ragu untuk mengirimkan pesan kepada tim CosRent.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                
                <div class="flex flex-col space-y-8 p-8 sm:p-10 bg-indigo-50/50 backdrop-blur-sm rounded-3xl border border-indigo-100 shadow-sm">
                    
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center flex-shrink-0 text-white text-xl shadow-md">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Kantor Pusat</h4>
                            <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                                Batam Centre, Kota Batam<br>
                                Kepulauan Riau, Indonesia
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center flex-shrink-0 text-white text-xl shadow-md">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">Alamat Email</h4>
                            <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                                support@cosrent.id<br>
                                partnership@cosrent.id
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0 text-white text-xl shadow-md">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 mb-1">WhatsApp (Fast Response)</h4>
                            <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                                +62 896-2346-7477<br>
                                <span class="text-xs text-slate-500 font-medium bg-white px-2 py-1 rounded border border-slate-200 mt-2 inline-block">Senin - Jumat (09:00 - 17:00)</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-100">
                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-slate-700 mb-1">Nama Anda</label>
                                <input type="text" id="contact_name" name="name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="Misal: Crist">
                            </div>
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-1">Email Anda</label>
                                <input type="email" id="contact_email" name="email" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="crist@example.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-slate-700 mb-1">Subjek</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="Contoh: Info Kemitraan Vendor">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none text-sm" placeholder="Tuliskan detail pertanyaan atau keluhan Anda di sini..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-semibold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex justify-center items-center gap-2 mt-2">
                            <span>Kirim Pesan</span>
                            <i class="fa-regular fa-paper-plane text-sm"></i>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </section>

    <footer class="w-full py-8 text-center border-t border-slate-200 bg-slate-50 mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-slate-400 tracking-tight">CosRent<span class="text-slate-300">.</span></span>
                <p class="text-sm text-slate-500 border-l border-slate-300 pl-2 ml-2">&copy; 2026 Hak Cipta Dilindungi</p>
            </div>
            
            <div class="flex space-x-6 text-sm font-medium">
                <a href="#" class="text-slate-500 hover:text-indigo-600 transition-colors">@CosRent_ID</a>
                <a href="#" class="text-slate-500 hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="text-slate-500 hover:text-indigo-600 transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    
</body>
</html>