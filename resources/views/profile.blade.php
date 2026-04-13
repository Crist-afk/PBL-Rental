<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - CosRent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FFFDFB] text-dark-choco flex flex-col min-h-screen">

    <main class="flex-grow py-12 px-4">
        <div class="max-w-3xl mx-auto">
            
            @if(session('success'))
                <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50" role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <span class="sr-only">Info</span>
                    <div class="ms-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <div class="w-full bg-white border border-sakura/30 rounded-3xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <div class="h-32 bg-dark-choco relative">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#F2CF2A 2px, transparent 2px); background-size: 20px 20px;"></div>
                </div>
                
                <div class="flex flex-col items-center pb-10 -mt-16 relative z-10">
                    @if(Auth::user()->avatar)
                        <img class="w-32 h-32 mb-3 rounded-full shadow-lg border-4 border-white object-cover bg-white" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil"/>
                    @else
                        <div class="w-32 h-32 mb-3 rounded-full shadow-lg border-4 border-white bg-sakura text-dark-choco flex items-center justify-center text-4xl font-bold">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </div>
                    @endif
                    
                    <h5 class="mb-1 text-2xl font-bold text-dark-choco">{{ Auth::user()->nama }}</h5>
                    <span class="text-sm text-aloewood">{{ Auth::user()->email }}</span>
                    <div class="mt-2 mb-4">
                        <span class="bg-misty-rose/30 text-dark-choco text-xs font-semibold px-2.5 py-0.5 rounded border border-misty-rose">
                            {{ Auth::user()->role ?? 'Pelanggan' }}
                        </span>
                    </div>

                    <button data-modal-target="edit-profile-modal" data-modal-toggle="edit-profile-modal" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-center text-white bg-aloewood rounded-full hover:bg-dark-choco focus:ring-4 focus:outline-none focus:ring-sakura transition-colors" type="button">
                        <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profil & Foto
                    </button>
                </div>
            </div>
        </div>
    </main>

    <div id="edit-profile-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-sakura/20">
                    <h3 class="text-xl font-semibold text-dark-choco">
                        Edit Profil
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-profile-modal">
                        <i class="fa-solid fa-xmark text-lg"></i>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-dark-choco">Nama Tampilan</label>
                            <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-dark-choco text-sm rounded-lg focus:ring-aloewood focus:border-aloewood block w-full p-2.5" value="{{ Auth::user()->nama }}" required />
                        </div>
                        
                        <div>
                            <label class="block mb-2 text-sm font-medium text-dark-choco" for="avatar">Upload Foto Profil Baru</label>
                            <input class="block w-full text-sm text-dark-choco border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-aloewood file:text-white hover:file:bg-dark-choco" aria-describedby="avatar_help" id="avatar" name="avatar" type="file" accept="image/png, image/jpeg, image/jpg">
                            <p class="mt-1 text-xs text-milk-tea" id="avatar_help">PNG, JPG atau JPEG (Maks. 2MB).</p>
                        </div>
                        
                        <button type="submit" class="w-full text-white bg-dark-choco hover:bg-black focus:ring-4 focus:outline-none focus:ring-sakura font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>
</html>