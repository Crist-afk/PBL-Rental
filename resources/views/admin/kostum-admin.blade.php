@extends('layouts.admin')

@section('title', 'CosRent — Kelola Kostum & Kategori')

@push('styles')
    @vite(['resources/css/admin/kostum.css', 'resources/js/admin/kostum.js'])
@endpush

@section('content')
  <!-- MAIN CONTENT -->
  <main class="main">
    <div class="main-inner">

      <!-- PAGE HEADER -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Kelola Kostum &amp; Kategori</h1>
          <p class="page-sub">Atur katalog produk dan kategori penyewaan</p>
        </div>
        <div class="header-btns">
          <button class="btn btn-primary" id="openModalBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Kostum Baru
          </button>
          <button class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Kelola Kategori
          </button>
        </div>
      </div>

      <!-- CATEGORY TABS -->
      <div class="tabs" id="categoryTabs">
        <button class="tab active" onclick="selectTab(this)">Semua</button>
        <button class="tab" onclick="selectTab(this)">Superhero</button>
        <button class="tab" onclick="selectTab(this)">Putri &amp; Pangeran</button>
        <button class="tab" onclick="selectTab(this)">Anime &amp; Karakter</button>
        <button class="tab" onclick="selectTab(this)">Horror</button>
        <button class="tab" onclick="selectTab(this)">Tradisional</button>
        <button class="tab add">+ Tambah Kategori</button>
      </div>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <div class="search-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input class="search-input" type="text" placeholder="Cari nama kostum..." />
        </div>

        <div class="toolbar-right">
          <!-- STATUS DROPDOWN -->
          <div class="dropdown-wrap" id="statusDrop">
            <div class="dropdown-btn" id="statusBtn" onclick="toggleDrop('statusDrop')">
              <span id="statusLabel">Status: Semua</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="statusMenu">
              <div class="drop-item selected" onclick="selectDrop('statusDrop','Status: Semua',this)">Status: Semua</div>
              <div class="drop-item" onclick="selectDrop('statusDrop','Tersedia',this)">Tersedia</div>
              <div class="drop-item" onclick="selectDrop('statusDrop','Disewa',this)">Disewa</div>
              <div class="drop-item" onclick="selectDrop('statusDrop','Tidak Tersedia',this)">Tidak Tersedia</div>
            </div>
          </div>

          <!-- SORT DROPDOWN -->
          <div class="dropdown-wrap" id="sortDrop">
            <div class="dropdown-btn" id="sortBtn" onclick="toggleDrop('sortDrop')">
              <span id="sortLabel">Urutkan: Terbaru</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="sortMenu">
              <div class="drop-item selected" onclick="selectDrop('sortDrop','Urutkan: Terbaru',this)">Terbaru</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Urutkan: Terlama',this)">Terlama</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Urutkan: Harga Tertinggi',this)">Harga Tertinggi</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Urutkan: Terpopuler',this)">Terpopuler</div>
            </div>
          </div>

          <!-- VIEW TOGGLE -->
          <div class="view-toggle">
            <button class="view-btn active" title="Grid">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </button>
            <button class="view-btn" title="List">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- COSTUME GRID -->
      <div class="costume-grid">

        <!-- Card 1 -->
        <div class="costume-card">
          <div class="card-img" style="background:linear-gradient(135deg,#1e3a8a,#3b82f6)">
            🦸
            <span class="status-badge tersedia">Tersedia</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Kostum Batman</span><span class="cat-tag">Superhero</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">150.000</span><span class="price-unit"> /hari</span></div>
            <div class="card-stock" style="margin-top:4px">STOK: 3 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>LIHAT</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>HAPUS</button>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="costume-card">
          <div class="card-img" style="background:linear-gradient(135deg,#831843,#ec4899)">
            👗
            <span class="status-badge disewa">Disewa</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Gaun Cinderella</span><span class="cat-tag">Putri & Pangeran</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">200.000</span><span class="price-unit"> /hari</span></div>
            <div class="card-stock" style="margin-top:4px">STOK: 2 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>LIHAT</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>HAPUS</button>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="costume-card">
          <div class="card-img" style="background:linear-gradient(135deg,#7c2d12,#f97316)">
            🥷
            <span class="status-badge tersedia">Tersedia</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Kostum Naruto</span><span class="cat-tag">Anime</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">120.000</span><span class="price-unit"> /hari</span></div>
            <div class="card-stock" style="margin-top:4px">STOK: 5 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>LIHAT</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>HAPUS</button>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="costume-card">
          <div class="card-img" style="background:linear-gradient(135deg,#7f1d1d,#dc2626)">
            👘
            <span class="status-badge tidak">Tidak Tersedia</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Baju Kimono</span><span class="cat-tag">Tradisional</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">180.000</span><span class="price-unit"> /hari</span></div>
            <div class="card-stock" style="margin-top:4px">STOK: 1 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>LIHAT</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>HAPUS</button>
            </div>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="costume-card">
          <div class="card-img" style="background:linear-gradient(135deg,#3b0764,#7c3aed)">
            🧛
            <span class="status-badge tersedia">Tersedia</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Kostum Drakula</span><span class="cat-tag">Horror</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">130.000</span><span class="price-unit"> /hari</span></div>
            <div class="card-stock" style="margin-top:4px">STOK: 4 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>LIHAT</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>HAPUS</button>
            </div>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="costume-card">
          <div class="card-img" style="background:linear-gradient(135deg,#14532d,#16a34a)">
            🧝
            <span class="status-badge tersedia">Tersedia</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Kostum Elf</span><span class="cat-tag">Anime</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">160.000</span><span class="price-unit"> /hari</span></div>
            <div class="card-stock" style="margin-top:4px">STOK: 2 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>LIHAT</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>HAPUS</button>
            </div>
          </div>
        </div>

      </div><!-- /costume-grid -->

      <!-- PAGINATION -->
      <div class="pagination-bar">
        <span class="pagination-info">Menampilkan 1-6 dari 89 kostum</span>
        <div class="page-btns">
          <button class="page-btn arrow">Prev</button>
          <button class="page-btn active">1</button>
          <button class="page-btn">2</button>
          <button class="page-btn">3</button>
          <span class="page-dots">…</span>
          <button class="page-btn">15</button>
          <button class="page-btn arrow">Next</button>
        </div>
      </div>
      
    </div>
  </main>
</div>

<!-- ── MODAL ── -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal" id="modalBox">
    <div class="modal-header">
      <span class="modal-title">Tambah Kostum Baru</span>
      <div class="modal-close" id="closeModalBtn">✕</div>
    </div>
    <div class="modal-body">
      <!-- Row 1 -->
      <div class="form-row">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Nama Kostum</label>
          <input class="form-input" type="text" placeholder="Contoh: Kostum Spiderman" />
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Kategori</label>
          <select class="form-select form-input">
            <option value="" disabled selected>Pilih Kategori</option>
            <option>Superhero</option>
            <option>Putri &amp; Pangeran</option>
            <option>Anime &amp; Karakter</option>
            <option>Horror</option>
            <option>Tradisional</option>
          </select>
        </div>
      </div>

      <!-- Row 2 -->
      <div class="form-row" style="margin-top:16px">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Harga Sewa Per Hari</label>
          <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input class="form-input" type="number" placeholder="0" min="0" />
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Jumlah Stok</label>
          <input class="form-input" type="number" placeholder="0" min="0" />
        </div>
      </div>

      <!-- Ukuran -->
      <div class="form-group" style="margin-top:16px">
        <label class="form-label">Ukuran Tersedia</label>
        <div class="size-checks">
          <label class="size-check"><input type="checkbox" /> S</label>
          <label class="size-check"><input type="checkbox" /> M</label>
          <label class="size-check"><input type="checkbox" /> L</label>
          <label class="size-check"><input type="checkbox" /> XL</label>
          <label class="size-check"><input type="checkbox" /> XXL</label>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="form-group">
        <label class="form-label">Deskripsi Kostum</label>
        <textarea class="form-textarea" placeholder="Jelaskan detail kostum, bahan, dan aksesoris yang didapat..."></textarea>
      </div>

      <!-- Upload -->
      <div class="form-group">
        <label class="form-label">Upload Foto Kostum</label>
        <div class="upload-zone">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>Klik untuk upload foto atau drag &amp; drop</span>
          <span style="font-size:11px;color:var(--text-3)">PNG, JPG, WEBP — Maks. 5MB</span>
        </div>
      </div>

      <!-- Status Toggle -->
      <div class="toggle-row">
        <div>
          <div class="toggle-label">Status Aktif</div>
          <div class="toggle-sub">Kostum akan terlihat di halaman penyewaan</div>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="statusToggle" checked />
          <div class="toggle-track"></div>
          <div class="toggle-thumb"></div>
        </label>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-ghost" id="cancelBtn">Batal</button>
      <button class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Kostum
      </button>
    </div>
  </div>
</div>
<!-- ── MODAL EDIT KOSTUM ── -->
<div class="modal-overlay" id="modalEdit">
  <div class="modal" id="modalEditBox">
    <div class="modal-header">
      <span class="modal-title">Edit Data Kostum</span>
      <div class="modal-close" onclick="closeModal('modalEdit')">✕</div>
    </div>
    <div class="modal-body">
      <!-- Row 1 -->
      <div class="form-row">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Nama Kostum</label>
          <input class="form-input" type="text" value="Kostum Batman" />
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Kategori</label>
          <select class="form-select form-input">
            <option value="" disabled>Pilih Kategori</option>
            <option selected>Superhero</option>
            <option>Putri &amp; Pangeran</option>
            <option>Anime &amp; Karakter</option>
            <option>Horror</option>
            <option>Tradisional</option>
          </select>
        </div>
      </div>

      <!-- Row 2 -->
      <div class="form-row" style="margin-top:16px">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Harga Sewa Per Hari</label>
          <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input class="form-input" type="number" value="150000" min="0" />
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Jumlah Stok</label>
          <input class="form-input" type="number" value="3" min="0" />
        </div>
      </div>

      <!-- Ukuran -->
      <div class="form-group" style="margin-top:16px">
        <label class="form-label">Ukuran Tersedia</label>
        <div class="size-checks">
          <label class="size-check"><input type="checkbox" checked /> S</label>
          <label class="size-check"><input type="checkbox" checked /> M</label>
          <label class="size-check"><input type="checkbox" checked /> L</label>
          <label class="size-check"><input type="checkbox" /> XL</label>
          <label class="size-check"><input type="checkbox" /> XXL</label>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="form-group">
        <label class="form-label">Deskripsi Kostum</label>
        <textarea class="form-textarea">Kostum Batman bahan berkualitas tinggi, termasuk topeng dan jubah. Nyaman dipakai seharian.</textarea>
      </div>

      <!-- Upload -->
      <div class="form-group">
        <label class="form-label">Upload Foto Kostum</label>
        <div class="upload-zone">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>Klik untuk ganti foto atau drag &amp; drop</span>
          <span style="font-size:11px;color:var(--text-3)">PNG, JPG, WEBP — Maks. 5MB</span>
        </div>
      </div>

      <!-- Status Toggle -->
      <div class="toggle-row">
        <div>
          <div class="toggle-label">Status Aktif</div>
          <div class="toggle-sub">Kostum akan terlihat di halaman penyewaan</div>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" checked />
          <div class="toggle-track"></div>
          <div class="toggle-thumb"></div>
        </label>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('modalEdit')">Batal</button>
      <button class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Perubahan
      </button>
    </div>
  </div>
</div>

<!-- ── MODAL LIHAT KOSTUM ── -->
<div class="modal-overlay" id="modalView">
  <div class="modal" id="modalViewBox">
    <div class="modal-header">
      <span class="modal-title">Detail Kostum</span>
      <div class="modal-close" onclick="closeModal('modalView')">✕</div>
    </div>
    <div class="modal-body">
      <!-- Detail Kostum Content -->
      <div style="display:flex;gap:20px;align-items:flex-start;">
        <!-- Image Placeholder -->
        <div style="width:140px;height:140px;background:linear-gradient(135deg,#1e3a8a,#3b82f6);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:48px;flex-shrink:0;">
          🦸
        </div>
        <!-- Info -->
        <div style="flex:1;">
          <h2 style="margin:0;font-size:20px;color:var(--text-1);">Kostum Batman</h2>
          <div style="margin-top:6px;font-size:12px;font-weight:700;color:var(--blue);background:rgba(59,130,246,0.12);border:1px solid rgba(59,130,246,0.2);padding:4px 10px;border-radius:20px;display:inline-block;">SUPERHERO</div>
          
          <div style="margin-top:16px;display:flex;gap:24px;">
            <div>
              <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;">Harga Sewa</div>
              <div style="font-size:16px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono', monospace;margin-top:2px;">Rp 150.000 <span style="font-size:12px;color:var(--text-3);font-family:'Sora',sans-serif;">/hari</span></div>
            </div>
            <div>
              <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;">Stok Tersedia</div>
              <div style="font-size:16px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono', monospace;margin-top:2px;">3 Unit</div>
            </div>
          </div>
        </div>
      </div>
      
      <div style="margin-top:24px;">
        <div style="font-size:11.5px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Ukuran Tersedia</div>
        <div style="display:flex;gap:8px;">
          <div style="background:var(--bg-card);border:1px solid var(--border);padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;color:var(--text-1);">S</div>
          <div style="background:var(--bg-card);border:1px solid var(--border);padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;color:var(--text-1);">M</div>
          <div style="background:var(--bg-card);border:1px solid var(--border);padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;color:var(--text-1);">L</div>
        </div>
      </div>

      <div style="margin-top:20px;">
        <div style="font-size:11.5px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Deskripsi Kostum</div>
        <p style="font-size:13px;color:var(--text-2);line-height:1.6;">Kostum Batman bahan berkualitas tinggi, termasuk topeng dan jubah. Nyaman dipakai seharian. Sangat cocok untuk acara cosplay, halloween, atau pesta kostum.</p>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" onclick="closeModal('modalView')">Tutup</button>
    </div>
  </div>
</div>

<!-- ── MODAL HAPUS KOSTUM ── -->
<div class="modal-overlay" id="modalDelete">
  <div class="modal" id="modalDeleteBox" style="width:400px;text-align:center;">
    <div class="modal-body" style="padding-top:32px;">
      <div style="width:64px;height:64px;background:rgba(248,113,113,0.15);color:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 16px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px;height:32px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
      </div>
      <h3 style="font-size:18px;font-weight:700;color:var(--text-1);margin-bottom:8px;">Hapus Kostum?</h3>
      <p style="font-size:13.5px;color:var(--text-2);line-height:1.5;">Apakah Anda yakin ingin menghapus <strong>Kostum Batman</strong>? Data yang dihapus tidak dapat dikembalikan.</p>
    </div>
    <div class="modal-footer" style="justify-content:center;border-top:none;padding-top:0;">
      <button class="btn btn-ghost" onclick="closeModal('modalDelete')">Batal</button>
      <button class="btn btn-primary" style="background:var(--red);border-color:var(--red);box-shadow:0 4px 12px rgba(248,113,113,0.3);" onclick="closeModal('modalDelete'); alert('Kostum berhasil dihapus!');">
        Ya, Hapus
      </button>
    </div>
  </div>
</div>
@endsection
