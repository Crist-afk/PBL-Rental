@extends('layouts.admin')

@section('title', 'CosRent — Manage Costumes & Categories')

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
          <h1 class="page-title">Manage Costumes &amp; Categories</h1>
          <p class="page-sub">Manage product catalog and rental categories</p>
        </div>
        <div class="header-btns">
          <button class="btn btn-primary" id="openModalBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Costume
          </button>
          <button class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Manage Categories
          </button>
        </div>
      </div>

      <!-- CATEGORY TABS -->
      <div class="tabs" id="categoryTabs">
        <button class="tab active" onclick="selectTab(this)">All</button>
        <button class="tab" onclick="selectTab(this)">Superhero</button>
        <button class="tab" onclick="selectTab(this)">Princess &amp; Prince</button>
        <button class="tab" onclick="selectTab(this)">Anime &amp; Character</button>
        <button class="tab" onclick="selectTab(this)">Horror</button>
        <button class="tab" onclick="selectTab(this)">Traditional</button>
        <button class="tab add" onclick="openAddCategoryModal()">+ Add Category</button>
      </div>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <div class="search-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input class="search-input" type="text" placeholder="Search costume name..." />
        </div>

        <div class="toolbar-right">
          <!-- STATUS DROPDOWN -->
          <div class="dropdown-wrap" id="statusDrop">
            <div class="dropdown-btn" id="statusBtn" onclick="toggleDrop('statusDrop')">
              <span id="statusLabel">Status: All</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="statusMenu">
              <div class="drop-item selected" onclick="selectDrop('statusDrop','Status: All',this)">Status: All</div>
              <div class="drop-item" onclick="selectDrop('statusDrop','Available',this)">Available</div>
              <div class="drop-item" onclick="selectDrop('statusDrop','Rented',this)">Rented</div>
              <div class="drop-item" onclick="selectDrop('statusDrop','Unavailable',this)">Unavailable</div>
            </div>
          </div>

          <!-- SORT DROPDOWN -->
          <div class="dropdown-wrap" id="sortDrop">
            <div class="dropdown-btn" id="sortBtn" onclick="toggleDrop('sortDrop')">
              <span id="sortLabel">Sort: Newest</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="dropdown-menu" id="sortMenu">
              <div class="drop-item selected" onclick="selectDrop('sortDrop','Sort: Newest',this)">Newest</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Sort: Oldest',this)">Oldest</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Sort: Highest Price',this)">Highest Price</div>
              <div class="drop-item" onclick="selectDrop('sortDrop','Sort: Most Popular',this)">Most Popular</div>
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
          <div class="card-img" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s') center/cover;">
            <span class="status-badge tersedia">Available</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Spiderman Costume</span><span class="cat-tag">Superhero</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">150.000</span><span class="price-unit"> /day</span></div>
            <div class="card-stock" style="margin-top:4px">STOCK: 3 UNITS</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>VIEW</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE</button>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="costume-card">
          <div class="card-img" style="background: url('https://ae01.alicdn.com/kf/S5c23516ed69b45b3ae3f35e3fbad217d6.jpg') center/cover;">
            <span class="status-badge disewa">Rented</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Yae Miko</span><span class="cat-tag">Anime & Character</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">200.000</span><span class="price-unit"> /day</span></div>
            <div class="card-stock" style="margin-top:4px">STOCK: 2 UNITS</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>VIEW</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE</button>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="costume-card">
          <div class="card-img" style="background: url('https://images-cdn.ubuy.co.in/65179920f4977158b35cafa6-gojo-satoru-costume-jujutsu-kaisen.jpg') center/cover;">
            <span class="status-badge tersedia">Available</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Gojo Satoru</span><span class="cat-tag">Anime & Character</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">120.000</span><span class="price-unit"> /day</span></div>
            <div class="card-stock" style="margin-top:4px">STOCK: 5 UNITS</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>VIEW</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE</button>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="costume-card">
          <div class="card-img" style="background: url('https://img.lazcdn.com/g/p/d0c4c82bfe98cbd19ceb04a0ae34f0ae.jpg_720x720q80.jpg') center/cover;">
            <span class="status-badge tidak">Unavailable</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Kafka</span><span class="cat-tag">Anime & Character</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">180.000</span><span class="price-unit"> /day</span></div>
            <div class="card-stock" style="margin-top:4px">STOCK: 1 UNIT</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>VIEW</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE</button>
            </div>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="costume-card">
          <div class="card-img" style="background: url('https://down-id.img.susercontent.com/file/id-11134207-7r98u-llolhikoxc3w2e') center/cover;">
            <span class="status-badge tersedia">Available</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Monkey D. Luffy</span><span class="cat-tag">Anime & Character</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">130.000</span><span class="price-unit"> /day</span></div>
            <div class="card-stock" style="margin-top:4px">STOCK: 4 UNITS</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>VIEW</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE</button>
            </div>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="costume-card">
          <div class="card-img" style="background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAyRb2yyqRYDoVriPxVzLrslGO3PT0rJ6G1g&s') center/cover;">
            <span class="status-badge tersedia">Available</span>
          </div>
          <div class="card-body">
            <div class="card-top"><span class="card-name">Raiden Shogun</span><span class="cat-tag">Anime & Character</span></div>
            <div class="card-price">Rp</div>
            <div><span class="price-val">160.000</span><span class="price-unit"> /day</span></div>
            <div class="card-stock" style="margin-top:4px">STOCK: 2 UNITS</div>
            <div class="card-actions">
              <button class="act-btn edit" onclick="openEditModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT</button>
              <button class="act-btn lihat" onclick="openViewModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>VIEW</button>
              <button class="act-btn hapus" onclick="openDeleteModal()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE</button>
            </div>
          </div>
        </div>

      </div><!-- /costume-grid -->

      <!-- PAGINATION -->
      <div class="pagination-bar">
        <span class="pagination-info">Showing 1-6 of 89 costumes</span>
        <div class="page-btns">
          <button class="page-btn arrow">Previous</button>
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
      <span class="modal-title">Add New Costume</span>
      <div class="modal-close" id="closeModalBtn">✕</div>
    </div>
    <div class="modal-body">
      <!-- Row 1 -->
      <div class="form-row">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Costume Name</label>
          <input class="form-input" type="text" placeholder="Example: Spiderman Costume" />
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Category</label>
          <select class="form-select form-input">
            <option value="" disabled selected>Choose Category</option>
            <option>Superhero</option>
            <option>Princess &amp; Prince</option>
            <option>Anime &amp; Character</option>
            <option>Horror</option>
            <option>Traditional</option>
          </select>
        </div>
      </div>

      <!-- Row 2 -->
      <div class="form-row" style="margin-top:16px">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Rental Price Per Day</label>
          <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input class="form-input" type="number" placeholder="0" min="0" />
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Stock Quantity</label>
          <input class="form-input" type="number" placeholder="0" min="0" />
        </div>
      </div>

      <!-- Ukuran -->
      <div class="form-group" style="margin-top:16px">
        <label class="form-label">Available Sizes</label>
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
        <label class="form-label">Costume Description</label>
        <textarea class="form-textarea" placeholder="Describe costume details, material, and included accessories..."></textarea>
      </div>

      <!-- Upload -->
      <div class="form-group">
        <label class="form-label">Upload Costume Photo</label>
        <div class="upload-zone">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>Click to upload a photo or drag &amp; drop</span>
          <span style="font-size:11px;color:var(--text-3)">PNG, JPG, WEBP — Max. 5MB</span>
        </div>
      </div>

      <!-- Status Toggle -->
      <div class="toggle-row">
        <div>
          <div class="toggle-label">Active Status</div>
          <div class="toggle-sub">Costume will appear on the rental page</div>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="statusToggle" checked />
          <div class="toggle-track"></div>
          <div class="toggle-thumb"></div>
        </label>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-ghost" id="cancelBtn">Cancel</button>
      <button class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Save Costume
      </button>
    </div>
  </div>
</div>
<!-- ── MODAL EDIT KOSTUM ── -->
<div class="modal-overlay" id="modalEdit">
  <div class="modal" id="modalEditBox">
    <div class="modal-header">
      <span class="modal-title">Edit Costume Data</span>
      <div class="modal-close" onclick="closeModal('modalEdit')">✕</div>
    </div>
    <div class="modal-body">
      <!-- Row 1 -->
      <div class="form-row">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Costume Name</label>
          <input class="form-input" type="text" value="Batman Costume" />
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Category</label>
          <select class="form-select form-input">
            <option value="" disabled>Choose Category</option>
            <option selected>Superhero</option>
            <option>Princess &amp; Prince</option>
            <option>Anime &amp; Character</option>
            <option>Horror</option>
            <option>Traditional</option>
          </select>
        </div>
      </div>

      <!-- Row 2 -->
      <div class="form-row" style="margin-top:16px">
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Rental Price Per Day</label>
          <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input class="form-input" type="number" value="150000" min="0" />
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Stock Quantity</label>
          <input class="form-input" type="number" value="3" min="0" />
        </div>
      </div>

      <!-- Ukuran -->
      <div class="form-group" style="margin-top:16px">
        <label class="form-label">Available Sizes</label>
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
        <label class="form-label">Costume Description</label>
        <textarea class="form-textarea">Batman costume made from high-quality material, including mask and cape. Comfortable to wear all day.</textarea>
      </div>

      <!-- Upload -->
      <div class="form-group">
        <label class="form-label">Upload Costume Photo</label>
        <div class="upload-zone">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <span>Click to replace photo or drag &amp; drop</span>
          <span style="font-size:11px;color:var(--text-3)">PNG, JPG, WEBP — Max. 5MB</span>
        </div>
      </div>

      <!-- Status Toggle -->
      <div class="toggle-row">
        <div>
          <div class="toggle-label">Active Status</div>
          <div class="toggle-sub">Costume will appear on the rental page</div>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" checked />
          <div class="toggle-track"></div>
          <div class="toggle-thumb"></div>
        </label>
      </div>
    </div>

    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('modalEdit')">Cancel</button>
      <button class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Save Changes
      </button>
    </div>
  </div>
</div>

<!-- ── MODAL LIHAT KOSTUM ── -->
<div class="modal-overlay" id="modalView">
  <div class="modal" id="modalViewBox">
    <div class="modal-header">
      <span class="modal-title">Costume Details</span>
      <div class="modal-close" onclick="closeModal('modalView')">✕</div>
    </div>
    <div class="modal-body">
      <!-- Detail Kostum Content -->
      <div style="display:flex;gap:20px;align-items:flex-start;">
        <!-- Image Placeholder -->
        <div style="width:140px;height:140px;background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSdpITVxwRDN82bcorTgLgb7VW0kbodTzzadA&s') center/cover;border-radius:12px;flex-shrink:0;">
        </div>
        <!-- Info -->
        <div style="flex:1;">
          <h2 style="margin:0;font-size:20px;color:var(--text-1);">Spiderman Costume</h2>
          <div style="margin-top:6px;font-size:12px;font-weight:700;color:var(--blue);background:rgba(59,130,246,0.12);border:1px solid rgba(59,130,246,0.2);padding:4px 10px;border-radius:20px;display:inline-block;">SUPERHERO</div>
          
          <div style="margin-top:16px;display:flex;gap:24px;">
            <div>
              <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;">Rental Price</div>
              <div style="font-size:16px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono', monospace;margin-top:2px;">Rp 150.000 <span style="font-size:12px;color:var(--text-3);font-family:'Sora',sans-serif;">/day</span></div>
            </div>
            <div>
              <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;">Available Stock</div>
              <div style="font-size:16px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono', monospace;margin-top:2px;">3 Units</div>
            </div>
          </div>
        </div>
      </div>
      
      <div style="margin-top:24px;">
        <div style="font-size:11.5px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Available Sizes</div>
        <div style="display:flex;gap:8px;">
          <div style="background:var(--bg-card);border:1px solid var(--border);padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;color:var(--text-1);">S</div>
          <div style="background:var(--bg-card);border:1px solid var(--border);padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;color:var(--text-1);">M</div>
          <div style="background:var(--bg-card);border:1px solid var(--border);padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;color:var(--text-1);">L</div>
        </div>
      </div>

      <div style="margin-top:20px;">
        <div style="font-size:11.5px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Costume Description</div>
        <p style="font-size:13px;color:var(--text-2);line-height:1.6;">Batman costume made from high-quality material, including mask and cape. Comfortable to wear all day. Perfect for cosplay events, Halloween, or costume parties.</p>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" onclick="closeModal('modalView')">Close</button>
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
      <h3 style="font-size:18px;font-weight:700;color:var(--text-1);margin-bottom:8px;">Delete Costume?</h3>
      <p style="font-size:13.5px;color:var(--text-2);line-height:1.5;">Are you sure you want to delete <strong>Batman Costume</strong>? Deleted data cannot be restored.</p>
    </div>
    <div class="modal-footer" style="justify-content:center;border-top:none;padding-top:0;">
      <button class="btn btn-ghost" onclick="closeModal('modalDelete')">Cancel</button>
      <button class="btn btn-primary" style="background:var(--red);border-color:var(--red);box-shadow:0 4px 12px rgba(248,113,113,0.3);" onclick="closeModal('modalDelete'); alert('Costume deleted successfully!');">
        Yes, Delete
      </button>
    </div>
  </div>
</div>

<!-- ── MODAL TAMBAH KATEGORI ── -->
<div class="modal-overlay" id="modalAddCategory">
  <div class="modal" id="modalAddCategoryBox" style="width:400px;">
    <div class="modal-header">
      <span class="modal-title">Add New Category</span>
      <div class="modal-close" onclick="closeModal('modalAddCategory')">✕</div>
    </div>
    <div class="modal-body">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Category Name</label>
        <input class="form-input" type="text" placeholder="Example: Superhero" />
      </div>
      <div class="form-group" style="margin-top:16px; margin-bottom:0">
        <label class="form-label">Short Description</label>
        <textarea class="form-textarea" placeholder="Description for this category..."></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('modalAddCategory')">Cancel</button>
      <button class="btn btn-primary" onclick="closeModal('modalAddCategory'); alert('Category added successfully!');">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Save Category
      </button>
    </div>
  </div>
</div>
@endsection
