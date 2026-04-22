@extends('layouts.app')

@section('title', 'Profil Saya - CosRent')

@section('content')
    <main class="flex-grow pt-28 pb-20 px-4 sm:px-6 max-w-5xl mx-auto w-full">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border-2 border-green-200 bg-green-100 p-4 font-bold text-green-800 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-red-700 shadow-sm">
                <p class="font-bold">Perubahan profil belum tersimpan.</p>
                <ul class="mt-2 space-y-1 text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('pages.profile.partials._header')

        <div class="mb-4 border-b-2 border-dark-chocolate/10">
            <ul class="flex flex-wrap -mb-px text-center text-sm font-bold" id="profile-tabs" data-tabs-toggle="#profile-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block rounded-t-lg border-b-4 border-sakura p-4 text-dark-chocolate hover:border-aloewood hover:text-aloewood" id="aktivitas-tab" data-tabs-target="#aktivitas" type="button" role="tab" aria-controls="aktivitas" aria-selected="true">
                        <i class="fa-regular fa-comments mr-2"></i>Aktivitas Forum
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block rounded-t-lg border-b-4 border-transparent p-4 text-dark-chocolate/60 hover:border-aloewood hover:text-aloewood" id="sewa-tab" data-tabs-target="#sewa" type="button" role="tab" aria-controls="sewa" aria-selected="false">
                        <i class="fa-solid fa-bag-shopping mr-2"></i>Riwayat Sewa
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-block rounded-t-lg border-b-4 border-transparent p-4 text-dark-chocolate/60 hover:border-aloewood hover:text-aloewood" id="pengaturan-tab" data-tabs-target="#pengaturan" type="button" role="tab" aria-controls="pengaturan" aria-selected="false">
                        <i class="fa-solid fa-gear mr-2"></i>Pengaturan Akun
                    </button>
                </li>
            </ul>
        </div>

        <div id="profile-tab-content">
            @include('pages.profile.partials._activity-tab')
            @include('pages.profile.partials._rental-tab')
            @include('pages.profile.partials._settings-tab')
        </div>
    </main>

    @include('pages.profile.partials._edit-profile-modal')
@endsection
