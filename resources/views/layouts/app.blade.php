<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CosRent - Sewa Kostum Cosplay')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="antialiased flex flex-col min-h-screen">

    <x-navbar />

    @yield('content')

    <footer class="bg-dark-chocolate text-misty-rose py-10 mt-auto border-t-[8px] border-sakura text-center relative z-50">
        <p class="text-sm opacity-60 font-medium">© 2026 CosRent. Dibuat dengan ❤️ oleh Tim PBL IF-2B Pagi.</p>
    </footer>

</body>
</html>
