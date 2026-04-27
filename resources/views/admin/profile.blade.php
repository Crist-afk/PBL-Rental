@extends('layouts.admin')

@section('title', 'Profil Admin - CosRent')

@push('styles')
    @vite(['resources/css/admin/profile.css'])
@endpush

@section('content')
<main class="main">
    <div class="main-inner">
        <div class="profile-container">

    {{-- Page Header --}}
    <div class="profile-page-header">
        <h1>Profil Admin</h1>
        <p>Kelola informasi akun dan pantau aktivitas sistem.</p>
    </div>

    {{-- ── Hero Card ── --}}
    <div class="profile-hero">
        <div class="profile-hero-banner"></div>
        <div class="profile-hero-body">
            <div class="profile-hero-avatar-row">
                <div style="display:flex;align-items:flex-end;gap:1rem;">
                    <div class="profile-avatar-circle">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                        @else
                            {{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h2 class="profile-hero-name">{{ Auth::user()->nama ?? 'Administrator' }}</h2>
                        <p class="profile-hero-email">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
                <span class="profile-role-badge">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Super Admin
                </span>
            </div>
        </div>
    </div>

    {{-- ── Quick Stats ── --}}
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-card-label">Total Pengguna</span>
            <span class="stat-card-value">128</span>
            <span class="stat-card-sub">Pelanggan terdaftar</span>
            <span class="stat-card-accent">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                +12 bulan ini
            </span>
        </div>
        <div class="stat-card">
            <span class="stat-card-label">Transaksi Aktif</span>
            <span class="stat-card-value">34</span>
            <span class="stat-card-sub">Sedang berjalan</span>
            <span class="stat-card-accent">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                5 menunggu konfirmasi
            </span>
        </div>
        <div class="stat-card">
            <span class="stat-card-label">Total Kostum</span>
            <span class="stat-card-value">72</span>
            <span class="stat-card-sub">Tersedia di katalog</span>
            <span class="stat-card-accent">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:10px;height:10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                8 sedang disewa
            </span>
        </div>
    </div>

    {{-- ── Info Grid: Account Info + System Role ── --}}
    <div class="info-grid">

        {{-- Account Information --}}
        <div class="profile-card">
            <div class="profile-card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Akun
            </div>
            <div class="info-row">
                <span class="info-row-label">Nama Lengkap</span>
                <span class="info-row-value">{{ Auth::user()->nama ?? 'Administrator' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Email</span>
                <span class="info-row-value">{{ Auth::user()->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Role Sistem</span>
                <span class="info-row-value" style="color:#8B5A2B;">Admin</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Bergabung</span>
                <span class="info-row-value">
                    {{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '-' }}
                </span>
            </div>
        </div>

        {{-- System Role & Permissions --}}
        <div class="profile-card">
            <div class="profile-card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Hak Akses Sistem
            </div>
            <div class="info-row">
                <span class="info-row-label">Kelola Kostum</span>
                <span class="info-row-value" style="color:#16a34a;">✓ Aktif</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Validasi Pembayaran</span>
                <span class="info-row-value" style="color:#16a34a;">✓ Aktif</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Kelola Pengguna</span>
                <span class="info-row-value" style="color:#16a34a;">✓ Aktif</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Laporan & Riwayat</span>
                <span class="info-row-value" style="color:#16a34a;">✓ Aktif</span>
            </div>
        </div>
    </div>

    {{-- ── Recent Activity Log ── --}}
    <div class="profile-card">
        <div class="profile-card-title">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Aktivitas Terakhir
        </div>

        {{-- Dummy activity items --}}
        <div class="activity-item">
            <span class="activity-dot" style="background:#EC9C9D;"></span>
            <div>
                <div class="activity-text">Memvalidasi pembayaran transaksi #TRX-0087</div>
                <div class="activity-time">Hari ini, 10:32</div>
            </div>
        </div>
        <div class="activity-item">
            <span class="activity-dot" style="background:#8B5A2B;"></span>
            <div>
                <div class="activity-text">Menambahkan kostum baru: "Naruto Sage Mode"</div>
                <div class="activity-time">Kemarin, 15:14</div>
            </div>
        </div>
        <div class="activity-item">
            <span class="activity-dot" style="background:#443025;"></span>
            <div>
                <div class="activity-text">Mengkonfirmasi pengembalian kostum oleh Rania</div>
                <div class="activity-time">23 Apr 2026, 09:05</div>
            </div>
        </div>
        <div class="activity-item">
            <span class="activity-dot" style="background:#EC9C9D;"></span>
            <div>
                <div class="activity-text">Menangguhkan akun pengguna karena pelanggaran</div>
                <div class="activity-time">22 Apr 2026, 16:48</div>
            </div>
        </div>
        <div class="activity-item">
            <span class="activity-dot" style="background:#8B5A2B;"></span>
            <div>
                <div class="activity-text">Login ke sistem admin dari perangkat baru</div>
                <div class="activity-time">21 Apr 2026, 08:22</div>
            </div>
        </div>
    </div>

        </div>
    </div>
</main>
@endsection
