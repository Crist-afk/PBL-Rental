@extends('layouts.admin')

@section('title', 'Profil Admin - CosRent')

@push('styles')
<style>
    /* ─── Admin Profile Page Styles ─── */
    .profile-container {
        padding: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    /* Page Header */
    .profile-page-header {
        margin-bottom: 2rem;
    }
    .profile-page-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary, #443025);
        margin-bottom: 0.25rem;
    }
    .profile-page-header p {
        font-size: 0.875rem;
        color: var(--text-secondary, #8B5A2B);
    }

    /* Profile Hero Card */
    .profile-hero {
        background: var(--card-bg, #fff);
        border: 1px solid var(--border-color, rgba(68,48,37,0.12));
        border-radius: 1.5rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 24px rgba(68,48,37,0.07);
    }
    .profile-hero-banner {
        height: 130px;
        background: linear-gradient(135deg, #443025 0%, #6b3a2a 50%, #8B5A2B 100%);
        position: relative;
    }
    .profile-hero-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23EC9C9D' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .profile-hero-body {
        padding: 0 2rem 1.75rem;
    }
    .profile-hero-avatar-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-top: -2.5rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 10;
    }
    .profile-avatar-circle {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        background: #EC9C9D;
        border: 4px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #443025;
        box-shadow: 0 4px 16px rgba(68,48,37,0.18);
        flex-shrink: 0;
        overflow: hidden;
    }
    .profile-avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        background: linear-gradient(135deg, #443025, #6b3a2a);
        color: #FFE4E1;
        border: none;
        align-self: flex-start;
        margin-top: 0.5rem;
    }
    .profile-hero-name {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--text-primary, #443025);
        margin: 0 0 0.25rem;
    }
    .profile-hero-email {
        font-size: 0.875rem;
        color: var(--text-secondary, #8B5A2B);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 640px) {
        .info-grid { grid-template-columns: 1fr; }
        .profile-container { padding: 1rem; }
    }

    /* Cards */
    .profile-card {
        background: var(--card-bg, #fff);
        border: 1px solid var(--border-color, rgba(68,48,37,0.12));
        border-radius: 1.25rem;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(68,48,37,0.06);
    }
    .profile-card-title {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-secondary, #8B5A2B);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .profile-card-title svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    /* Info rows inside cards */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.625rem 0;
        border-bottom: 1px solid var(--border-color, rgba(68,48,37,0.08));
        font-size: 0.875rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-label {
        color: var(--text-secondary, #8B5A2B);
        font-weight: 500;
    }
    .info-row-value {
        font-weight: 600;
        color: var(--text-primary, #443025);
        text-align: right;
    }

    /* Stat cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
    .stat-card {
        background: var(--card-bg, #fff);
        border: 1px solid var(--border-color, rgba(68,48,37,0.12));
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 2px 12px rgba(68,48,37,0.06);
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }
    .stat-card-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--text-secondary, #8B5A2B);
    }
    .stat-card-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary, #443025);
        line-height: 1;
    }
    .stat-card-sub {
        font-size: 0.75rem;
        color: var(--text-secondary, #8B5A2B);
        font-weight: 500;
    }
    .stat-card-accent {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.72rem;
        font-weight: 700;
        color: #16a34a;
        background: #f0fdf4;
        border-radius: 9999px;
        padding: 0.2rem 0.6rem;
        margin-top: 0.25rem;
        align-self: flex-start;
    }

    /* Activity Log */
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color, rgba(68,48,37,0.08));
        font-size: 0.875rem;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 0.35rem;
    }
    .activity-text { color: var(--text-primary, #443025); font-weight: 500; }
    .activity-time { color: var(--text-secondary, #8B5A2B); font-size: 0.75rem; margin-top: 0.125rem; }
</style>
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
