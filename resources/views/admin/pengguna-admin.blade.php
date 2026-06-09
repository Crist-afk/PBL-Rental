@extends('layouts.admin')

@section('title', 'CosRent — Manage User Accounts')

@push('styles')
    @vite(['resources/css/admin/pengguna.css', 'resources/js/admin/pengguna.js'])
    <style>
        /* Modern pagination custom styling to match the design */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 32px;
        }
        .pagination-container nav {
            display: flex;
            gap: 6px;
        }
        .pagination-container nav span, .pagination-container nav a {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-2);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .pagination-container nav a:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(59, 130, 246, 0.05);
        }
        .pagination-container nav .active span {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }
        .pagination-container nav .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
  <!-- MAIN CONTENT -->
  <main class="main">
    <div class="main-inner">

      <!-- FLASH MESSAGES -->
      @if(session('success'))
        <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 500; animation: fadeIn 0.4s;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 500; animation: fadeIn 0.4s;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      <!-- PAGE HEADER -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Manage User Accounts</h1>
          <p class="page-sub">Manage user data, account status, and order history</p>
        </div>
      </div>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <form action="{{ route('admin.pengguna') }}" method="GET" style="display: flex; flex: 1; align-items: center;">
          @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
          @endif
          <div class="search-wrap" style="width: 100%;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="search-input" type="text" name="q" value="{{ request('q') }}" placeholder="Search user name or email..." />
          </div>
        </form>

        <div class="toolbar-right">
          <!-- SORT DROPDOWN -->
          <div class="dropdown-wrap" id="sortDrop">
            <div class="dropdown-btn" id="sortBtn" onclick="toggleDrop('sortDrop')">
              <span id="sortLabel">Sort by: {{ request('sort') == 'terlama' ? 'Oldest Accounts' : 'Newest Accounts' }}</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="sortMenu">
              <div class="drop-item {{ request('sort', 'terbaru') != 'terlama' ? 'selected' : '' }}" onclick="window.location.href='{{ route('admin.pengguna', ['sort' => 'terbaru', 'q' => request('q')]) }}'">Newest Accounts</div>
              <div class="drop-item {{ request('sort') == 'terlama' ? 'selected' : '' }}" onclick="window.location.href='{{ route('admin.pengguna', ['sort' => 'terlama', 'q' => request('q')]) }}'">Oldest Accounts</div>
            </div>
          </div>
        </div>
      </div>

      <!-- USER TABLE -->
      <div class="user-table-wrapper">
        <table class="user-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Email &amp; Phone</th>
              <th>Date Joined</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pengguna as $u)
              <tr>
                <td><span class="user-id">#USR-{{ str_pad($u->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                <td>
                  <div class="user-info">
                    @if($u->avatar)
                      <img src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->nama }}" class="user-avatar-sm" style="width:32px; height:32px; border-radius:50%; object-fit:cover; display:flex; align-items:center; justify-content:center; font-weight:700;">
                    @else
                      <div class="user-avatar-sm" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); display:flex; align-items:center; justify-content:center; font-weight:700; color:#fff;">
                        {{ strtoupper(substr($u->nama, 0, 1)) }}
                      </div>
                    @endif
                    <div class="user-name">{{ $u->nama }}</div>
                  </div>
                </td>
                <td>
                  <div class="user-contact">{{ $u->email }}</div>
                  <div class="user-phone">{{ $u->no_hp ?? '-' }}</div>
                </td>
                <td>{{ $u->created_at->format('d M Y') }}</td>
                <td>
                  @if($u->is_active)
                    <span class="status-badge active">Active</span>
                  @else
                    <span class="status-badge suspended">Inactive</span>
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="act-btn katalog" onclick="openModal({{ $u->id }})">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                      Catalog
                    </button>
                    <button class="act-btn edit" onclick="openToggleActiveModal({{ $u->id }}, '{{ addslashes($u->nama) }}', {{ $u->is_active ? 1 : 0 }})" title="{{ $u->is_active ? 'Deactivate Account' : 'Activate Account' }}" style="background: rgba(249, 115, 22, 0.08); color: var(--orange); border: 1px solid rgba(249, 115, 22, 0.2); padding: 6px 8px;">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button class="act-btn delete" onclick="openDeleteModal({{ $u->id }}, '{{ addslashes($u->nama) }}')" title="Delete Account">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="text-align: center; padding: 40px 20px; color: var(--text-3);">
                  No users found.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="pagination-bar" style="margin-top: 24px;">
        <span class="pagination-info">Showing {{ $pengguna->firstItem() ?? 0 }}-{{ $pengguna->lastItem() ?? 0 }} of {{ $pengguna->total() }} users</span>
        <div class="pagination-container">
          {{ $pengguna->links() }}
        </div>
      </div>
      
    </div>
  </main>
</div>

<!-- FORM HAPUS AKUN -->
<form id="deleteUserForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<!-- ── MODAL KATALOG PESANAN ── -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal modal-wide" id="modalBox">
    <div class="modal-header">
      <div class="modal-header-left">
        <div class="modal-user-avatar" id="modalAvatar">R</div>
        <div>
          <div class="modal-title" id="modalTitle">Order Catalog</div>
          <div class="modal-subtitle" id="modalSubtitle">ridho@example.com</div>
        </div>
      </div>
      <div class="modal-close" id="closeModalBtn">✕</div>
    </div>
    <div class="modal-body">

      <!-- STATS STRIP -->
      <div class="modal-stats" id="modalStats">
        <div class="mstat">
          <div class="mstat-icon">📦</div>
          <div>
            <div class="mstat-val" id="mstatTotal">0</div>
            <div class="mstat-label">Total Orders</div>
          </div>
        </div>
        <div class="mstat">
          <div class="mstat-icon">✅</div>
          <div>
            <div class="mstat-val" id="mstatSelesai">0</div>
            <div class="mstat-label">Completed</div>
          </div>
        </div>
        <div class="mstat">
          <div class="mstat-icon">🔄</div>
          <div>
            <div class="mstat-val" id="mstatBerjalan">0</div>
            <div class="mstat-label">Ongoing</div>
          </div>
        </div>
        <div class="mstat">
          <div class="mstat-icon">💰</div>
          <div>
            <div class="mstat-val" id="mstatTotal2">Rp 0</div>
            <div class="mstat-label">Total Paid</div>
          </div>
        </div>
      </div>

      <!-- ORDER TABLE -->
      <div class="riwayat-section-title">Complete Order History</div>
      <div class="riwayat-table-wrap">
        <table class="riwayat-table">
          <thead>
            <tr>
              <th>Order No.</th>
              <th>Costume</th>
              <th>Rent Date</th>
              <th>Return Date</th>
              <th>Duration</th>
              <th>Total</th>
              <th>Fine</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="riwayatTableBody">
            <!-- Diisi oleh JavaScript -->
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- ── MODAL KONFIRMASI HAPUS ── -->
<div class="modal-overlay" id="deleteModalOverlay">
  <div class="modal delete-modal" id="deleteModalBox">
    <div class="delete-modal-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
    </div>
    <div class="delete-modal-title">Delete User Account?</div>
    <div class="delete-modal-text">This action cannot be undone. All data, order history, and information related to user <strong id="deleteUserName">Name</strong> will be permanently deleted.</div>
    <div class="delete-modal-actions">
      <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="btn-confirm-delete" onclick="confirmDelete()">Yes, Delete Account</button>
    </div>
  </div>
</div>

<!-- ── MODAL KONFIRMASI STATUS AKUN ── -->
<div class="modal-overlay" id="toggleActiveModalOverlay">
  <div class="modal delete-modal" id="toggleActiveModalBox" style="border-color: rgba(249, 115, 22, 0.3);">
    <div class="delete-modal-icon" id="toggleActiveModalIcon" style="background: rgba(249, 115, 22, 0.1); color: var(--orange); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 32px; height: 32px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <div class="delete-modal-title" id="toggleActiveModalTitle">Change Account Status?</div>
    <div class="delete-modal-text" id="toggleActiveModalText">Are you sure you want to change the active status of user <strong id="toggleActiveUserName">Name</strong>?</div>
    <div class="delete-modal-actions">
      <button class="btn-cancel" onclick="closeToggleActiveModal()">Cancel</button>
      <button class="btn-confirm-delete" id="btnConfirmToggleActive" onclick="confirmToggleActive()" style="background: var(--orange); box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);">Yes, Change Status</button>
    </div>
  </div>
</div>

<!-- FORM TOGGLE STATUS -->
<form id="toggleActiveUserForm" method="POST" style="display: none;">
  @csrf
  @method('PATCH')
</form>
@endsection
