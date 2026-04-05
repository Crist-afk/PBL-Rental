<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CosRent</title>
    
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
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

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
                    
                    <a href="{{ route('register') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-200 ml-4">
                        Buat Akun
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4 py-10">
        
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row overflow-hidden border border-slate-100">
            
            <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-14 bg-white flex flex-col justify-center">
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-slate-800 tracking-tight mb-2">Login</h2>
                    <p class="text-slate-500">Masuk ke akun Anda</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-sm rounded-r-lg">
                        <p><i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                    @csrf 

                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-slate-200 pr-3 my-2">
                                <i class="fa-regular fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                class="w-full pl-14 pr-4 py-3 bg-white border border-slate-300 text-slate-900 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                placeholder="Email">
                        </div>
                    </div>

                    <div>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-slate-200 pr-3 my-2">
                                <i class="fa-solid fa-lock text-slate-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required 
                                class="w-full pl-14 pr-12 py-3 bg-white border border-slate-300 text-slate-900 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                placeholder="Password">
                            <button type="button" id="togglePassword" class="absolute right-0 pr-4 text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                                <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 group-hover:bg-slate-300 peer-checked:group-hover:bg-indigo-700"></div>
                            <span class="ms-3 text-sm font-medium text-slate-600">Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        Login
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline transition duration-200">Lupa Password?</a>
                    </div>
                </form>
            </div>

            <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center items-center text-center relative overflow-hidden bg-gradient-to-br from-indigo-600 to-violet-800">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-indigo-400 opacity-20 blur-2xl"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Belum Punya Akun?</h2>
                    <p class="text-indigo-100 mb-8 leading-relaxed text-sm md:text-base">
                        Mari bergabung bersama kami! Jangkau lebih banyak pelanggan dengan CosRent. Gratis tanpa biaya apapun!
                    </p>
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3 text-white font-semibold border-2 border-white rounded-lg hover:bg-white hover:text-indigo-600 transition-colors duration-300 shadow-lg hover:shadow-xl">
                        Buat Akun
                    </a>
                </div>
            </div>

        </div>
    </div>

    <footer class="w-full py-6 text-center border-t border-slate-200 bg-slate-50 mt-auto">
        <p class="text-sm text-slate-500 mb-2">Platform Sewa Kostum Cosplay &copy; 2026 CosRent.com</p>
        <div class="flex justify-center space-x-4 text-sm">
            <a href="#" class="text-indigo-600 hover:underline">@CosRent_ID</a>
            <span class="text-slate-300">|</span>
            <a href="#" class="text-indigo-600 hover:underline">Kebijakan Privasi</a>
        </div>
    </footer>

</body>
</html>