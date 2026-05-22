@extends('layouts.admin')

@section('title', 'CosRent — Manage User Accounts')

@push('styles')
    @vite(['resources/css/admin/pengguna.css', 'resources/js/admin/pengguna.js'])
@endpush

@section('content')
  <!-- MAIN CONTENT -->
  <main class="main">
    <div class="main-inner">

      <!-- PAGE HEADER -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Manage User Accounts</h1>
          <p class="page-sub">Manage user data, account status, and order history</p>
        </div>
      </div>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <div class="search-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input class="search-input" type="text" placeholder="Search user name or email..." />
        </div>

        <div class="toolbar-right">
          <!-- SORT DROPDOWN -->
          <div class="dropdown-wrap" id="sortDrop">
            <div class="dropdown-btn" id="sortBtn" onclick="toggleDrop('sortDrop')">
              <span id="sortLabel">Sort: Newest Accounts</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="sortMenu">
              <div class="drop-item selected" onclick="selectDrop('sortDrop','Sort: Newest Accounts',this)">Newest Accounts</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Sort: Oldest Accounts',this)">Oldest Accounts</div>
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
              <th>Email &amp; Phone No.</th>
              <th>Join Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Row 1 -->
            <tr>
              <td><span class="user-id">#USR-001</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6)">R</div>
                  <div class="user-name">Ridho</div>
                </div>
              </td>
              <td>
                <div class="user-contact">ridho@example.com</div>
                <div class="user-phone">0812-3456-7890</div>
              </td>
              <td>12 Jan 2026</td>
              <td><span class="status-badge active">Active</span></td>
              <td>
                <div class="action-buttons">
                  <button class="act-btn katalog" onclick="openModal('usr1')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Catalog
                  </button>
                  <button class="act-btn delete" onclick="openDeleteModal('usr1')" title="Delete Account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                  </button>
                </div>
              </td>
            </tr>
            <!-- Row 2 -->
            <tr>
              <td><span class="user-id">#USR-002</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #831843, #ec4899)">A</div>
                  <div class="user-name">Asep Sudrajat</div>
                </div>
              </td>
              <td>
                <div class="user-contact">asep.sudrajat@email.com</div>
                <div class="user-phone">0856-1234-5678</div>
              </td>
              <td>05 Feb 2026</td>
              <td><span class="status-badge active">Active</span></td>
              <td>
                <div class="action-buttons">
                  <button class="act-btn katalog" onclick="openModal('usr2')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Catalog
                  </button>
                  <button class="act-btn delete" onclick="openDeleteModal('usr2')" title="Delete Account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                  </button>
                </div>
              </td>
            </tr>
            <!-- Row 3 -->
            <tr>
              <td><span class="user-id">#USR-003</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #7c2d12, #f97316)">S</div>
                  <div class="user-name">Siti Aminah</div>
                </div>
              </td>
              <td>
                <div class="user-contact">siti.aminah@mail.com</div>
                <div class="user-phone">0811-9876-5432</div>
              </td>
              <td>20 Mar 2026</td>
              <td><span class="status-badge suspended">Suspended</span></td>
              <td>
                <div class="action-buttons">
                  <button class="act-btn katalog" onclick="openModal('usr3')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Catalog
                  </button>
                  <button class="act-btn delete" onclick="openDeleteModal('usr3')" title="Delete Account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                  </button>
                </div>
              </td>
            </tr>
            <!-- Row 4 -->
            <tr>
              <td><span class="user-id">#USR-004</span></td>
              <td>
                <div class="user-info">
                  <div class="user-avatar-sm" style="background: linear-gradient(135deg, #14532d, #16a34a)">B</div>
                  <div class="user-name">Budi Santoso</div>
                </div>
              </td>
              <td>
                <div class="user-contact">budisantoso@gmail.com</div>
                <div class="user-phone">0821-3344-5566</div>
              </td>
              <td>15 Apr 2026</td>
              <td><span class="status-badge active">Active</span></td>
              <td>
                <div class="action-buttons">
                  <button class="act-btn katalog" onclick="openModal('usr4')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Catalog
                  </button>
                  <button class="act-btn delete" onclick="openDeleteModal('usr4')" title="Delete Account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="pagination-bar">
        <span class="pagination-info">Showing 1-4 of 45 users</span>
        <div class="page-btns">
          <button class="page-btn arrow">Previous</button>
          <button class="page-btn active">1</button>
          <button class="page-btn">2</button>
          <button class="page-btn">3</button>
          <span class="page-dots">…</span>
          <button class="page-btn">8</button>
          <button class="page-btn arrow">Next</button>
        </div>
      </div>
      
    </div>
  </main>
</div>

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
              <th>Rental Date</th>
              <th>Return Date</th>
              <th>Duration</th>
              <th>Price/Day</th>
              <th>Total</th>
              <th>Penalty</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="riwayatTableBody">
            <!-- Filled by JavaScript -->
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
@endsection
