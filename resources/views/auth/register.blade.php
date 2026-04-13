<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - CosRent</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
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
                    <a href="{{ route('contact') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200">Contact</a>
                    
                    <a href="{{ route('login') }}" class="text-indigo-600 font-semibold transition duration-200 ml-4">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4 py-10">
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row overflow-hidden border border-slate-100">
            
            <div class="w-full md:w-1/2 p-8 sm:p-12">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Gabung CosRent </h2>
                    <p class="text-slate-500 text-sm">Buat akun untuk mulai menyewa atau menyewakan kostum cosplay impianmu.</p>
                </div>

                <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
                    @csrf 

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-slate-400"></i>
                            </div>
                            <input type="text" id="name" name="nama" value="{{ old('nama') }}" required 
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors duration-200" 
                                placeholder="Misal: Crist">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors duration-200" 
                                placeholder="crist@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none border-r border-slate-200 pr-3 my-1">
                                <i class="fa-solid fa-lock text-slate-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required 
                                class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors duration-200" 
                                placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none border-r border-slate-200 pr-3 my-1">
                                <i class="fa-solid fa-shield-check text-slate-400"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required 
                                class="w-full pl-12 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors duration-200" 
                                placeholder="Ulangi password">
                        </div>
                    </div>

                    <div class="flex items-start mt-2">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer">
                        </div>
                        <div class="ml-2 text-sm">
                            <label for="terms" class="font-medium text-slate-600 cursor-pointer text-xs sm:text-sm">Saya setuju dengan <a href="#" class="text-indigo-600 hover:underline">Syarat & Ketentuan</a> CosRent.</label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex justify-center items-center gap-2 mt-4">
                        <span>Daftar Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition duration-200">Masuk di sini</a>
                </p>
            </div>

            <div class="hidden md:block w-1/2 bg-gradient-to-br from-indigo-600 to-violet-700 relative overflow-hidden group">
                <div class="absolute inset-0 opacity-30 mix-blend-overlay transition-transform duration-700 group-hover:scale-110">
                    <img src="https://images.unsplash.com/photo-1541959833400-049d37f98ccd?q=80&w=1000&auto=format&fit=crop" alt="Cosplay" class="object-cover w-full h-full">
                </div>
                
                <div class="absolute inset-0 flex flex-col justify-end p-12 text-white">
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                        <h3 class="text-2xl font-bold mb-2">Eksplorasi Karaktermu</h3>
                        <p class="text-indigo-100 text-sm leading-relaxed">
                            Bergabunglah dengan ribuan cosplayer lainnya. Sewa kostum impianmu atau mulai hasilkan uang dari koleksimu sendiri.
                        </p>
                        <div class="flex gap-4 mt-6 pt-6 border-t border-white/10">
                            <div>
                                <p class="text-xl font-bold">12k+</p>
                                <p class="text-[10px] text-indigo-200 uppercase tracking-wider">Katalog</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold">600+</p>
                                <p class="text-[10px] text-indigo-200 uppercase tracking-wider">Vendor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="w-full py-6 text-center border-t border-slate-200 bg-white mt-auto">
        <p class="text-sm text-slate-500">Platform Sewa Kostum Cosplay &copy; 2026 CosRent.com</p>
    </footer>

</body>
</html>