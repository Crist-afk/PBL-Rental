<div>
  @extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-indigo-50 px-4">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md border-t-8 border-indigo-600">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Welcome Back!</h2>
            <p class="text-gray-500">Masuk untuk mengelola rental kamu</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.autentikasi') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                    placeholder="Masukkan username admin">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                    placeholder="••••••••">
            </div>
            <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 shadow-lg transition duration-300 transform active:scale-95">
                Login ke Dashboard
            </button>
        </form>
        <p class="mt-8 text-center text-sm text-gray-500">Lupa password? Hubungi tim IT Politeknik Negeri Batam.</p>
    </div>
</div>
@endsection
</div>
