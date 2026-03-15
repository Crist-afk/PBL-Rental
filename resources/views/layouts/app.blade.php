<div>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CosRent - Sewa Kostum Impianmu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">Cos<span class="text-pink-500">Rent</span></a>
            <div class="space-x-8 font-medium">
                <a href="{{ route('home') }}" class="hover:text-pink-500 transition">Home</a>
                <a href="{{ route('contact') }}" class="hover:text-pink-500 transition">Contact</a>
                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition">Login</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-gray-900 text-white py-10 mt-20">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 CosRent Project. Crafted with ❤️ for Cosplayers.</p>
        </div>
    </footer>
</body>
</html>
</div>
