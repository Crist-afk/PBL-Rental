<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">

    <x-navbar auth-page="login" />

    <div class="flex-grow flex items-center justify-center px-4 pt-32 pb-10">

        <div class="w-full max-w-4xl glass-card rounded-[2rem] shadow-2xl flex flex-col md:flex-row overflow-hidden border-2 border-dark-chocolate/10">

            <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-14 bg-white/60 flex flex-col justify-center">
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-dark-chocolate tracking-tight mb-2">Login</h2>
                    <p class="text-dark-chocolate/70 font-medium">Masuk kembali ke akun Anda</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg font-medium">
                        <p><i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-dark-chocolate/10 pr-3 my-2">
                                <i class="fa-regular fa-envelope text-dark-chocolate/50"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-14 pr-4 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="Email">
                        </div>
                    </div>

                    <div>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-dark-chocolate/10 pr-3 my-2">
                                <i class="fa-solid fa-lock text-dark-chocolate/50"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-14 pr-12 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="Password">
                            <button type="button" id="togglePassword" class="absolute right-0 pr-4 flex items-center text-dark-chocolate/50 hover:text-sakura transition-colors focus:outline-none">
                                <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-dark-chocolate/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sakura"></div>
                            <span class="ms-3 text-sm font-bold text-dark-chocolate">Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-dark-chocolate hover:bg-black text-misty-rose font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        Login
                    </button>

                    <div class="text-center mt-4">
                        <a href="#" class="text-sm font-bold text-aloewood hover:text-sakura transition duration-200">Lupa Password?</a>
                    </div>
                </form>
            </div>

            <div class="hidden md:flex w-1/2 bg-dark-chocolate flex-col justify-center items-center text-center relative overflow-hidden p-8 sm:p-12">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-40 h-40 rounded-full bg-sakura opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-48 h-48 rounded-full bg-aloewood opacity-30 blur-3xl"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 bg-sakura text-dark-chocolate rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-lg">
                        🎭
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-misty-rose mb-4">Selamat Datang Kembali!</h2>
                    <p class="text-misty-rose/80 mb-8 leading-relaxed font-medium">
                        Kostum incaranmu mungkin sedang dipesan orang lain. Segera masuk dan amankan jadwal bookingmu sekarang.
                    </p>
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3 text-misty-rose font-bold border-2 border-sakura rounded-full hover:bg-sakura hover:text-dark-chocolate transition-colors duration-300 shadow-lg">
                        Buat Akun Baru
                    </a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
