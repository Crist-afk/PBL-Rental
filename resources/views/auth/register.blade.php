<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">

    <x-navbar auth-page="register" />

    <div class="flex-grow flex items-center justify-center px-4 pt-32 pb-10">
        <div class="w-full max-w-5xl glass-card rounded-[2rem] shadow-2xl flex flex-col md:flex-row overflow-hidden border-2 border-dark-chocolate/10">

            <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white/60">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-dark-chocolate tracking-tight mb-2">Gabung CosRent</h2>
                    <p class="text-dark-chocolate/70 text-sm font-medium">Buat akun untuk mulai menyewa atau menyewakan kostum cosplay impianmu.</p>
                </div>

                <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-bold text-dark-chocolate mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-dark-chocolate/50"></i>
                            </div>
                            <input type="text" id="name" name="nama" value="{{ old('nama') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="Misal: Crist">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-dark-chocolate mb-1">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-dark-chocolate/50"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="crist@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-dark-chocolate mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-dark-chocolate/10 pr-3 my-2">
                                <i class="fa-solid fa-lock text-dark-chocolate/50"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-14 pr-12 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="Minimal 8 karakter">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-dark-chocolate/50 hover:text-sakura transition-colors focus:outline-none">
                                <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-dark-chocolate mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-dark-chocolate/10 pr-3 my-2">
                                <i class="fa-solid fa-shield-check text-dark-chocolate/50"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full pl-14 pr-12 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="Ulangi password">
                            <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-dark-chocolate/50 hover:text-sakura transition-colors focus:outline-none">
                                <i class="fa-regular fa-eye-slash" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-dark-chocolate hover:bg-black text-misty-rose font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex justify-center items-center gap-2 mt-4">
                        <span>Daftar Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-dark-chocolate/80 font-medium">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-bold text-sakura hover:text-aloewood transition duration-200">Masuk di sini</a>
                </p>
            </div>

            <div class="hidden md:block w-1/2 bg-dark-chocolate relative overflow-hidden group">
                <div class="absolute inset-0 opacity-40 mix-blend-overlay transition-transform duration-700 group-hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1541959833400-049d37f98ccd?q=80&w=1000&auto=format&fit=crop" alt="Cosplay" class="object-cover w-full h-full">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-dark-chocolate via-transparent to-transparent"></div>

                <div class="absolute inset-0 flex flex-col justify-end p-12 text-misty-rose z-10">
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                        <h3 class="text-2xl font-bold mb-2">Eksplorasi Karaktermu</h3>
                        <p class="text-misty-rose/80 text-sm leading-relaxed">
                            Bergabunglah dengan ribuan cosplayer lainnya. Sewa kostum impianmu atau mulai hasilkan uang dari koleksimu sendiri.
                        </p>
                        <div class="flex gap-6 mt-6 pt-6 border-t border-white/10">
                            <div>
                                <p class="text-2xl font-bold text-sakura">12k+</p>
                                <p class="text-xs text-misty-rose/70 uppercase tracking-wider font-bold">Katalog</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-sakura">600+</p>
                                <p class="text-xs text-misty-rose/70 uppercase tracking-wider font-bold">Vendor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
