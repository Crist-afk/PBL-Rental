<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CosRent - Premium Cosplay Costume Rental')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind Play CDN for robust development -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-chocolate': '#443025',
                        'sakura': '#EC9C9D',
                        'misty-rose': '#FFE4E1',
                        'aloewood': '#8B5A2B',
                        'milk-tea': '#D2B48C',
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body class="antialiased flex flex-col min-h-screen">

    <x-navbar />

    @yield('content')

    <x-footer />

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Mempertebal centang dan lingkaran success SweetAlert2 */
        .swal2-popup .swal2-success [class^=swal2-success-line] {
            height: 10px !important;
            border-radius: 5px !important;
        }
        .swal2-popup .swal2-success .swal2-success-ring {
            border-width: 10px !important;
        }
    </style>
    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#443025',
                background: '#FFE4E1',
                customClass: {
                    title: 'text-dark-chocolate font-black',
                    popup: 'rounded-[2rem] border-2 border-sakura/20 shadow-2xl'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#443025'
            });
        @endif
    </script>
</body>
</html>
