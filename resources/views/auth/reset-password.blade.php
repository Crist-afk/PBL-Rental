<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">

    <x-navbar auth-page="login" />

    <div class="flex-grow flex items-center justify-center px-4 pt-32 pb-10">
        <div class="w-full max-w-4xl glass-card rounded-[2rem] shadow-2xl flex flex-col md:flex-row overflow-hidden border-2 border-dark-chocolate/10">
            <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-14 bg-white/60 flex flex-col justify-center">
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-dark-chocolate tracking-tight mb-2">Reset Password</h2>
                    <p class="text-dark-chocolate/70 font-medium">Create a new password for your CosRent account.</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg font-medium">
                        <p><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-dark-chocolate">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-dark-chocolate/10 pr-3 my-2">
                                <i class="fa-regular fa-envelope text-dark-chocolate/50"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required
                                class="w-full pl-14 pr-4 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                                placeholder="you@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-bold text-dark-chocolate">New Password</label>
                        <input type="password" id="password" name="password" required minlength="8"
                            class="w-full px-4 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                            placeholder="Minimum 8 characters">
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-bold text-dark-chocolate">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                            class="w-full px-4 py-3 bg-white border-2 border-dark-chocolate/10 text-dark-chocolate rounded-xl focus:ring-0 focus:border-sakura transition-colors font-medium"
                            placeholder="Repeat your new password">
                    </div>

                    <button type="submit" class="w-full bg-dark-chocolate hover:bg-black text-misty-rose font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                        Reset Password
                    </button>
                </form>
            </div>

            <div class="hidden md:flex w-1/2 bg-dark-chocolate flex-col justify-center items-center text-center relative overflow-hidden p-8 sm:p-12">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-40 h-40 rounded-full bg-sakura opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-48 h-48 rounded-full bg-aloewood opacity-30 blur-3xl"></div>

                <div class="relative z-10">
                    <div class="w-20 h-20 bg-sakura text-dark-chocolate rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-lg">
                        <img src="{{ asset('images/Logo-CosRent.png') }}" alt="CosRent Logo" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; object-position: center 20%; border: 2px solid rgba(236,156,157,0.6); box-shadow: 0 2px 10px rgba(236,156,157,0.4); flex-shrink: 0;">
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-misty-rose mb-4">Almost There</h2>
                    <p class="text-misty-rose/80 leading-relaxed font-medium">
                        Choose a secure password and return to your rentals with confidence.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
