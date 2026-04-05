<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - CosRent</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600 tracking-tight">CosRent<span class="text-rose-500">.</span></a>
                </div>
                
                <div class="hidden md:flex space-x-6 lg:space-x-8 items-center text-sm md:text-base ml-auto">
                    <a href="{{ route('home') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Home</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Cari Kostum</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">List Cosrent</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Forum</a>
                    <a href="#" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Jadwal Event</a>
                    
                    <a href="{{ route('contact') }}" class="text-indigo-600 font-bold border-b-2 border-indigo-600 pb-1 transition duration-200">Contact</a>
                    
                    <div class="border-l border-slate-300 h-6 mx-2"></div>

                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 font-semibold transition duration-200">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-200 shadow-sm ml-2">Buat Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-indigo-600 py-16 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-rose-500 opacity-20 rounded-full blur-2xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">Hubungi Kami</h1>
            <p class="text-indigo-100 max-w-2xl mx-auto text-sm md:text-base">
                Punya pertanyaan seputar sewa kostum, kemitraan vendor, atau butuh bantuan teknis? Tim CosRent siap membantu Anda!
            </p>
        </div>
    </div>

    <div class="flex-grow max-w-7xl mx-auto px-4 py-12 w-full grid grid-cols-1 lg:grid-cols-5 gap-10">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-headset text-indigo-500"></i> Tim Dukungan CosRent
                </h3>
                <p class="text-sm text-slate-500 mb-6">Silakan hubungi salah satu admin kami di bawah ini untuk respon yang lebih cepat via WhatsApp.</p>
                
                <div class="space-y-4">
                    <a href="https://wa.me/6289623467477" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all group">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Crist Garcia Pasaribu</p>
                            <p class="text-xs text-slate-500 font-medium">+62 896-2346-7477</p>
                        </div>
                    </a>

                    <a href="https://wa.me/6281261260195" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all group">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Rangga Surya Saputra</p>
                            <p class="text-xs text-slate-500 font-medium">+62 812-6126-0195</p>
                        </div>
                    </a>

                    <a href="https://wa.me/628117092501" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all group">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">Akbar Zamroni</p>
                            <p class="text-xs text-slate-500 font-medium">+62 811-7092-501</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                <h3 class="text-md font-bold text-indigo-900 mb-2">Jam Operasional Layanan</h3>
                <p class="text-sm text-indigo-700 leading-relaxed">
                    Tim kami aktif melayani pada hari <strong>Senin - Jumat</strong> pukul <strong>09:00 - 17:00 WIB</strong>. Pesan yang masuk di luar jam kerja akan dibalas pada hari kerja berikutnya.
                </p>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-lg border border-slate-100 h-full">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Kirim Pesan Langsung</h2>
                <p class="text-sm text-slate-500 mb-8">Isi formulir di bawah ini dan pesan akan langsung diteruskan ke sistem email kami.</p>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" id="contact_name" name="name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-1">Email Aktif</label>
                            <input type="email" id="contact_email" name="email" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm" placeholder="contoh@email.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-700 mb-1">Subjek Pertanyaan</label>
                        <select id="subject" name="subject" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm">
                            <option value="">-- Pilih Topik --</option>
                            <option value="Sewa Kostum">Informasi Sewa Kostum</option>
                            <option value="Kemitraan">Pendaftaran Mitra/Vendor</option>
                            <option value="Kendala Teknis">Kendala Aplikasi / Website</option>
                            <option value="Lainnya">Pertanyaan Lainnya</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 mb-1">Pesan Anda</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none text-sm" placeholder="Tuliskan detail pertanyaan atau keluhan Anda di sini secara lengkap..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex justify-center items-center gap-2">
                        <span>Kirim Pesan Sekarang</span>
                        <i class="fa-regular fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <footer class="w-full py-8 text-center border-t border-slate-200 bg-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-slate-400 tracking-tight">CosRent<span class="text-slate-300">.</span></span>
                <p class="text-sm text-slate-500 border-l border-slate-300 pl-2 ml-2">&copy; 2026 Hak Cipta Dilindungi</p>
            </div>
            
            <div class="flex space-x-6 text-sm font-medium">
                <a href="#" class="text-slate-500 hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="text-slate-500 hover:text-indigo-600 transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>