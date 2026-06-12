@extends('layouts.admin')

@section('title', 'CosRent — Manage Costumes & Categories')

@push('styles')
    @vite(['resources/css/admin/kostum.css', 'resources/js/admin/kostum.js'])
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

        /* Per-size stock chips on card */
        .size-stock-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }
        .size-stock-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3px;
            border: 1px solid;
        }
        .size-stock-chip.in-stock {
            background: rgba(34, 197, 94, 0.12);
            color: var(--green);
            border-color: rgba(34, 197, 94, 0.3);
        }
        .size-stock-chip.out-stock {
            background: rgba(248, 113, 113, 0.12);
            color: var(--red);
            border-color: rgba(248, 113, 113, 0.3);
        }
        .size-stock-chip .chip-size { font-size: 10px; font-weight: 800; }
        .size-stock-chip .chip-count { font-size: 10px; font-weight: 600; opacity: 0.85; }

        /* Per-size stock inputs in modal */
        .size-stock-inputs { display: flex; flex-direction: column; gap: 0; }
        .size-stock-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 8px;
        }
        .size-input-group {
            display: flex;
            align-items: center;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            transition: border-color var(--tr);
        }
        .size-input-group:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .size-label-tag {
            padding: 0 12px;
            font-size: 12px;
            font-weight: 800;
            color: var(--text-1);
            background: var(--bg-hover);
            border-right: 1px solid var(--border);
            height: 100%;
            display: flex;
            align-items: center;
            min-width: 44px;
            justify-content: center;
            letter-spacing: 0.5px;
        }
        .size-qty-input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 10px 12px;
            color: var(--text-1);
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            outline: none;
            width: 100%;
        }
        .size-qty-input::placeholder { color: var(--text-3); font-weight: 400; }

        .size-hint {
            font-size: 11px;
            color: var(--text-3);
            margin-top: 6px;
            font-style: italic;
        }
        .stock-total-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--brand-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            margin-top: 10px;
        }
        .stock-total-preview .total-label { font-size: 11px; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.5px; }
        .stock-total-preview .total-val { font-size: 16px; font-weight: 800; color: var(--text-1); font-family: 'JetBrains Mono', monospace; }

        /* Size filter active badge */
        .size-filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(59,130,246,0.15);
            color: var(--blue);
            border: 1px solid rgba(59,130,246,0.3);
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 14px;
            cursor: pointer;
        }
        .size-filter-badge:hover { background: rgba(248,113,113,0.12); color: var(--red); border-color: rgba(248,113,113,0.3); }
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

      @if($errors->any())
        <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; animation: fadeIn 0.4s;">
          <div style="font-weight: 700; margin-bottom: 6px;">Oops! Input error occurred:</div>
          <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- PAGE HEADER -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Manage Costumes &amp; Categories</h1>
          <p class="page-sub">Manage the product catalog and rental categories</p>
        </div>
        <div class="header-btns">
          <button class="btn btn-primary" id="openModalBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:14px;height:14px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Costume
          </button>
          <button class="btn btn-secondary" onclick="openAddCategoryModal()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Manage Categories
          </button>
        </div>
      </div>

      <!-- CATEGORY TABS -->
      <div class="tabs" id="categoryTabs">
        <a href="{{ route('admin.kostum', ['q' => request('q'), 'size' => request('size'), 'low_stock' => request('low_stock')]) }}" class="tab {{ !request('kategori_id') ? 'active' : '' }}" style="text-decoration: none;">All</a>
        @foreach($kategoris as $kat)
          <a href="{{ route('admin.kostum', ['kategori_id' => $kat->id, 'q' => request('q'), 'size' => request('size'), 'low_stock' => request('low_stock')]) }}" class="tab {{ request('kategori_id') == $kat->id ? 'active' : '' }}" style="text-decoration: none; display: flex; align-items: center; gap: 6px;">
            {{ $kat->nama_kategori }}
            <span style="font-size: 10px; background: rgba(255,255,255,0.15); padding: 1px 6px; border-radius: 10px; display: inline-block;">{{ $kat->kostum_count ?? $kat->kostum()->count() }}</span>
          </a>
        @endforeach
        <button class="tab add" onclick="openAddCategoryModal()">+ Add Category</button>
      </div>

      <!-- TOOLBAR -->
      <div class="toolbar">
        <form action="{{ route('admin.kostum') }}" method="GET" style="display: flex; flex: 1; align-items: center; gap: 10px;" id="filterForm">
          @if(request('kategori_id'))
            <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
          @endif
          @if(request('size'))
            <input type="hidden" name="size" value="{{ request('size') }}" id="sizeFilterHidden">
          @endif
          @if(request('low_stock'))
            <input type="hidden" name="low_stock" value="1">
          @endif
          <div class="search-wrap" style="width: 100%;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="search-input" type="text" name="q" value="{{ request('q') }}" placeholder="Search costume name..." />
          </div>
        </form>

        <div class="toolbar-right">
          <!-- LOW STOCK TOGGLE -->
          <a href="{{ route('admin.kostum', array_filter(array_merge(request()->query(), ['low_stock' => $lowStockFilter ? null : 1]))) }}"
             class="dropdown-btn {{ $lowStockFilter ? 'open' : '' }}"
             style="text-decoration: none; display: flex; align-items: center; gap: 8px; {{ $lowStockFilter ? 'border-color: #fb923c; color: #fb923c; background: rgba(251, 146, 60, 0.1); font-weight: 700;' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ $lowStockFilter ? 'All Stock' : 'Low Stock Only' }}</span>
          </a>

          <!-- SIZE FILTER DROPDOWN -->
          <div class="dropdown-wrap" id="sizeDrop">
            <button class="dropdown-btn {{ $sizeFilter ? 'open' : '' }}" onclick="toggleDrop('sizeDrop')" type="button">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M4 6h16M8 12h8M11 18h2"/></svg>
              <span id="sizeLabel">{{ $sizeFilter ? 'Size: ' . strtoupper($sizeFilter) : 'Filter by Size' }}</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="dropdown-menu" id="sizeDropMenu">
              <div class="drop-item {{ !$sizeFilter ? 'selected' : '' }}" onclick="applySizeFilter('')">All Sizes</div>
              @foreach($allSizes as $sz)
                <div class="drop-item {{ $sizeFilter === $sz ? 'selected' : '' }}" onclick="applySizeFilter('{{ $sz }}')">Size {{ strtoupper($sz) }}</div>
              @endforeach
            </div>
          </div>

          <!-- VIEW TOGGLE -->
          <div class="view-toggle">
            <button class="view-btn active" title="Grid">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- ACTIVE FILTER BADGES -->
      <div class="active-filters-wrap" style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
        @if($sizeFilter)
          <a href="{{ route('admin.kostum', array_filter(array_merge(request()->query(), ['size' => null]))) }}" class="size-filter-badge" style="margin-bottom: 0;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:11px;height:11px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Filtered by size: <strong>{{ strtoupper($sizeFilter) }}</strong> &nbsp;— click to clear
          </a>
        @endif

        @if($lowStockFilter)
          <a href="{{ route('admin.kostum', array_filter(array_merge(request()->query(), ['low_stock' => null]))) }}" class="size-filter-badge" style="margin-bottom: 0; background: rgba(251, 146, 60, 0.15); color: #fb923c; border-color: rgba(251, 146, 60, 0.3);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:11px;height:11px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Filtered by: <strong>Low Stock Only</strong> &nbsp;— click to clear
          </a>
        @endif
      </div>

      <!-- COSTUME GRID -->
      <div class="costume-grid">
        @forelse($kostums as $kostum)
          <div class="costume-card">
            <div class="card-img" style="background: url('{{ $kostum->gambar_url }}') center/cover;">
              @if($kostum->stok === 0)
                <span class="status-badge tidak">Out of Stock</span>
              @elseif($kostum->stok === 1)
                <span class="status-badge disewa" style="background: rgba(251, 146, 60, 0.15); color: #fb923c; border: 1px solid rgba(251, 146, 60, 0.3);">Low Stock</span>
              @else
                <span class="status-badge tersedia">Available</span>
              @endif
            </div>
            <div class="card-body">
              <div class="card-top">
                <span class="card-name">{{ $kostum->nama_kostum }}</span>
                <span class="cat-tag">{{ $kostum->kategori?->nama_kategori ?? 'N/A' }}</span>
              </div>
              <div class="card-price">Rp</div>
              <div>
                <span class="price-val">{{ number_format($kostum->harga_sewa, 0, ',', '.') }}</span>
                <span class="price-unit"> /day</span>
              </div>

              {{-- Per-size stock chips --}}
              @php
                $stokPerUkuran = $kostum->stok_per_ukuran;
                $ukuranArr = array_filter(array_map('trim', explode(',', $kostum->ukuran ?? '')));
              @endphp
              @if(!empty($stokPerUkuran) && is_array($stokPerUkuran))
                <div class="size-stock-grid">
                  @foreach($stokPerUkuran as $size => $qty)
                    <span class="size-stock-chip {{ $qty > 0 ? 'in-stock' : 'out-stock' }}">
                      <span class="chip-size">{{ strtoupper($size) }}</span>
                      <span class="chip-count">: {{ $qty }}</span>
                    </span>
                  @endforeach
                </div>
              @elseif(!empty($ukuranArr))
                {{-- Fallback: show sizes without stock counts if stok_per_ukuran not set --}}
                <div class="size-stock-grid">
                  @foreach($ukuranArr as $size)
                    <span class="size-stock-chip in-stock">
                      <span class="chip-size">{{ strtoupper($size) }}</span>
                      <span class="chip-count">: ?</span>
                    </span>
                  @endforeach
                </div>
              @else
                <div style="font-size:10px; color:var(--text-3); margin-top:6px;">No sizes configured</div>
              @endif

              <div class="card-actions" style="margin-top:10px;">
                <button class="act-btn edit" onclick="event.stopPropagation(); openEditFormModal({{ json_encode($kostum) }})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>EDIT
                </button>
                <button class="act-btn lihat" onclick="event.stopPropagation(); openViewFormModal({{ json_encode($kostum) }})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>DETAIL
                </button>
                <button class="act-btn hapus" onclick="event.stopPropagation(); openDeleteFormModal({{ $kostum->id }}, '{{ addslashes($kostum->nama_kostum) }}')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>DELETE
                </button>
              </div>
            </div>
          </div>
        @empty
          <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; background: var(--bg-card); border-radius: 12px; border: 1px dashed var(--border); color: var(--text-3);">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 48px; height: 48px; margin-bottom: 12px; opacity: 0.5;"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            <div style="font-size: 16px; font-weight: 600; color: var(--text-2);">No Costumes Found</div>
            <div style="font-size: 13px; margin-top: 4px;">The costume catalog is empty or the search filter returned no results.</div>
          </div>
        @endforelse
      </div>

      <!-- PAGINATION -->
      <div class="pagination-bar" style="margin-top: 24px;">
        <span class="pagination-info">Showing {{ $kostums->firstItem() ?? 0 }}-{{ $kostums->lastItem() ?? 0 }} of {{ $kostums->total() }} costumes</span>
        <div class="pagination-container">
          {{ $kostums->links() }}
        </div>
      </div>
      
    </div>
  </main>
</div>

<!-- ── MODAL ADD KOSTUM ── -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal" id="modalBox">
    <div class="modal-header">
      <span class="modal-title">Add New Costume</span>
      <div class="modal-close" id="closeModalBtn">✕</div>
    </div>
    <form action="{{ route('admin.kostum.store') }}" method="POST" enctype="multipart/form-data" id="addKostumForm">
      @csrf
      <div class="modal-body">
        <!-- Row 1 -->
        <div class="form-row">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Costume Name</label>
            <input class="form-input" type="text" name="nama_kostum" placeholder="e.g., Spiderman Costume" required />
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Category</label>
            <select class="form-select form-input" name="kategori_id" required>
              <option value="" disabled selected>Select Category</option>
              @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Row 2 -->
        <div class="form-group" style="margin-top:16px; margin-bottom:0">
          <label class="form-label">Rental Price Per Day</label>
          <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input class="form-input" type="number" name="harga_sewa" placeholder="0" min="0" required />
          </div>
        </div>

        <!-- Sizes + Per-size Stock -->
        <div class="form-group" style="margin-top:16px">
          <label class="form-label">Available Sizes &amp; Stock Per Size</label>
          <input class="form-input" type="text" id="addUkuranInput" name="ukuran" placeholder="e.g. S, M, L, XL" required oninput="generateAddSizeInputs()" style="margin-bottom:10px;" />
          <div class="size-hint">Type sizes separated by comma — stock fields will appear automatically below.</div>

          <div id="addSizeStockContainer" class="size-stock-inputs" style="margin-top:12px;"></div>

          <div class="stock-total-preview" id="addStockTotalPreview" style="display:none;">
            <span class="total-label">Total Stock:</span>
            <span class="total-val" id="addTotalVal">0</span>
            <span style="font-size:11px;color:var(--text-3);margin-left:2px;">units</span>
          </div>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
          <label class="form-label">Description / Costume Accessories</label>
          <textarea class="form-textarea" name="kelengkapan" placeholder="Describe the included accessories, wig, weapons, etc..."></textarea>
        </div>

        <!-- Upload -->
        <div class="form-group">
          <label class="form-label">Upload Costume Photo</label>
          <input type="file" name="gambar" accept="image/*" style="display: none;" id="addGambarInput" onchange="previewImageFile(this, 'addUploadZoneText')">
          <div class="upload-zone" onclick="document.getElementById('addGambarInput').click()" style="cursor: pointer;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span id="addUploadZoneText">Click to upload photo or drag &amp; drop</span>
            <span style="font-size:11px;color:var(--text-3)">PNG, JPG, WEBP — Max. 5MB</span>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-ghost" id="cancelBtn">Cancel</button>
        <button type="submit" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Save Costume
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ── MODAL EDIT KOSTUM ── -->
<div class="modal-overlay" id="modalEdit">
  <div class="modal" id="modalEditBox">
    <div class="modal-header">
      <span class="modal-title">Edit Costume Data</span>
      <div class="modal-close" onclick="closeModal('modalEdit')">✕</div>
    </div>
    <form action="" method="POST" enctype="multipart/form-data" id="editKostumForm">
      @csrf
      @method('PUT')
      <div class="modal-body">
        <!-- Row 1 -->
        <div class="form-row">
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Costume Name</label>
            <input class="form-input" type="text" name="nama_kostum" id="edit_nama_kostum" required />
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label class="form-label">Category</label>
            <select class="form-select form-input" name="kategori_id" id="edit_kategori_id" required>
              @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Row 2 -->
        <div class="form-group" style="margin-top:16px; margin-bottom:0">
          <label class="form-label">Rental Price Per Day</label>
          <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input class="form-input" type="number" name="harga_sewa" id="edit_harga_sewa" min="0" required />
          </div>
        </div>

        <!-- Sizes + Per-size Stock -->
        <div class="form-group" style="margin-top:16px">
          <label class="form-label">Available Sizes &amp; Stock Per Size</label>
          <div style="display:flex; gap:8px; align-items:center; margin-bottom:10px;">
            <input class="form-input" type="text" id="editUkuranInput" name="ukuran" placeholder="e.g. S, M, L, XL" required oninput="generateEditSizeInputs()" style="flex:1;" />
            <button type="button" onclick="generateEditSizeInputs()" style="background:var(--blue);color:#fff;border:none;border-radius:var(--radius-sm);padding:10px 14px;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;">Regenerate</button>
          </div>
          <div class="size-hint">Existing stock per size is pre-filled. Adjust as needed.</div>

          <div id="editSizeStockContainer" class="size-stock-inputs" style="margin-top:12px;"></div>

          <div class="stock-total-preview" id="editStockTotalPreview" style="display:none;">
            <span class="total-label">Total Stock:</span>
            <span class="total-val" id="editTotalVal">0</span>
            <span style="font-size:11px;color:var(--text-3);margin-left:2px;">units</span>
          </div>
        </div>

        <!-- Deskripsi -->
        <div class="form-group">
          <label class="form-label">Description / Costume Accessories</label>
          <textarea class="form-textarea" name="kelengkapan" id="edit_kelengkapan"></textarea>
        </div>

        <!-- Upload -->
        <div class="form-group">
          <label class="form-label">Current Costume Photo / Replace</label>
          <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
            <img src="" id="edit_preview_img" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); display: none;">
            <div style="font-size: 12px; color: var(--text-2);" id="edit_no_image_text">No image yet</div>
          </div>
          <input type="file" name="gambar" accept="image/*" style="display: none;" id="editGambarInput" onchange="previewImageFile(this, 'editUploadZoneText')">
          <div class="upload-zone" onclick="document.getElementById('editGambarInput').click()" style="cursor: pointer;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span id="editUploadZoneText">Click to replace photo or drag &amp; drop</span>
            <span style="font-size:11px;color:var(--text-3)">PNG, JPG, WEBP — Max. 5MB</span>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-ghost" onclick="closeModal('modalEdit')">Cancel</button>
        <button type="submit" class="btn btn-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Save Changes
        </button>
      </div>
    </form>
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
      <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap: wrap;">
        <!-- Image Preview -->
        <img src="" id="view_gambar" style="width:140px;height:160px;object-fit:cover;border-radius:12px;flex-shrink:0;border: 1px solid var(--border);">
        <!-- Info -->
        <div style="flex:1; min-width: 200px;">
          <h2 style="margin:0;font-size:20px;color:var(--text-1);" id="view_nama_kostum">Spiderman</h2>
          <div style="margin-top:6px;font-size:12px;font-weight:700;color:var(--blue);background:rgba(59,130,246,0.12);border:1px solid rgba(59,130,246,0.2);padding:4px 10px;border-radius:20px;display:inline-block;text-transform:uppercase;" id="view_kategori">SUPERHERO</div>
          
          <div style="margin-top:16px;display:flex;gap:24px;">
            <div>
              <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;">Rental Price</div>
              <div style="font-size:16px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono', monospace;margin-top:2px;" id="view_harga">Rp 150.000 <span style="font-size:12px;color:var(--text-3);font-family:'Sora',sans-serif;">/day</span></div>
            </div>
            <div>
              <div style="font-size:11px;color:var(--text-3);text-transform:uppercase;font-weight:600;letter-spacing:0.5px;">Total Stock</div>
              <div style="font-size:16px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono', monospace;margin-top:2px;" id="view_stok">3 Unit</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Per-size stock table in view modal -->
      <div style="margin-top:24px;">
        <div style="font-size:11.5px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Stock Per Size</div>
        <div id="view_size_stock_table" style="display:flex;flex-wrap:wrap;gap:8px;">
          <!-- filled dynamically -->
        </div>
      </div>

      <div style="margin-top:20px;">
        <div style="font-size:11.5px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Description / Accessories</div>
        <p style="font-size:13px;color:var(--text-2);line-height:1.6;white-space: pre-line; background: var(--bg-body); padding: 12px; border-radius: 8px; border: 1px solid var(--border);" id="view_kelengkapan">-</p>
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
    <form action="" method="POST" id="deleteKostumForm">
      @csrf
      @method('DELETE')
      <div class="modal-body" style="padding-top:32px;">
        <div style="width:64px;height:64px;background:rgba(248,113,113,0.15);color:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 16px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:32px;height:32px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:var(--text-1);margin-bottom:8px;">Delete Costume?</h3>
        <p style="font-size:13.5px;color:var(--text-2);line-height:1.5;">Are you sure you want to delete <strong id="delete_kostum_name">Spiderman Costume</strong>? Deleted data cannot be recovered.</p>
      </div>
      <div class="modal-footer" style="justify-content:center;border-top:none;padding-top:0;">
        <button type="button" class="btn btn-ghost" onclick="closeModal('modalDelete')">Cancel</button>
        <button type="submit" class="btn btn-primary" style="background:var(--red);border-color:var(--red);box-shadow:0 4px 12px rgba(248,113,113,0.3);">
          Yes, Delete
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ── MODAL TAMBAH KATEGORI ── -->
<div class="modal-overlay" id="modalAddCategory">
  <div class="modal" id="modalAddCategoryBox" style="width:420px;">
    <div class="modal-header">
      <span class="modal-title">Category Management</span>
      <div class="modal-close" onclick="closeModal('modalAddCategory')">✕</div>
    </div>
    <div class="modal-body">
      <!-- Daftar Kategori Saat Ini -->
      <div style="margin-bottom: 20px;">
        <div style="font-size:12px;font-weight:700;color:var(--text-2);text-transform:uppercase;margin-bottom:8px;">Current Categories</div>
        <div style="display: flex; flex-direction: column; gap: 8px; max-height: 180px; overflow-y: auto; background: var(--bg-body); padding: 10px; border-radius: 8px; border: 1px solid var(--border);">
          @foreach($kategoris as $kat)
            <div style="display: flex; justify-content: space-between; align-items: center; background: var(--bg-card); padding: 8px 12px; border-radius: 6px; border: 1px solid var(--border);">
              <div>
                <strong style="color: var(--text-1); font-size: 13px;">{{ $kat->nama_kategori }}</strong>
                @if($kat->franchise)
                  <span style="font-size: 11px; color: var(--text-3); display: block;">Franchise: {{ $kat->franchise }}</span>
                @endif
              </div>
              <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Delete category {{ $kat->nama_kategori }}? Costumes in this category will also be deleted!')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: none; color: var(--red); cursor: pointer; display: flex; align-items: center;" title="Delete Category">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                </button>
              </form>
            </div>
          @endforeach
        </div>
      </div>

      <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0;">

      <!-- Form Tambah Kategori -->
      <form action="{{ route('admin.kategori.store') }}" method="POST" id="addCategoryForm">
        @csrf
        <div style="font-size:12px;font-weight:700;color:var(--text-2);text-transform:uppercase;margin-bottom:8px;">Add New Category</div>
        <div class="form-group" style="margin-bottom:12px">
          <label class="form-label">Category Name</label>
          <input class="form-input" type="text" name="nama_kategori" placeholder="e.g., Genshin Impact" required />
        </div>
        <div class="form-group" style="margin-bottom:0">
          <label class="form-label">Franchise (Optional)</label>
          <input class="form-input" type="text" name="franchise" placeholder="e.g., HoYoverse" />
        </div>
        <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
          <button type="submit" class="btn btn-primary" style="width: 100%;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save New Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview selected file name
    function previewImageFile(input, textId) {
        const textSpan = document.getElementById(textId);
        if (input.files && input.files[0]) {
            textSpan.textContent = "Photo selected: " + input.files[0].name;
            textSpan.style.color = "var(--blue)";
        }
    }

    // ── Apply size filter via URL ──
    window.applySizeFilter = function(size) {
        const url = new URL(window.location.href);
        if (size) {
            url.searchParams.set('size', size);
        } else {
            url.searchParams.delete('size');
        }
        window.location.href = url.toString();
    }

    // ── Generate per-size stock input rows (Add modal) ──
    window.generateAddSizeInputs = function() {
        const ukuranVal = document.getElementById('addUkuranInput').value;
        const container = document.getElementById('addSizeStockContainer');
        const previewBox = document.getElementById('addStockTotalPreview');
        const sizes = ukuranVal.split(',').map(s => s.trim()).filter(s => s !== '');

        container.innerHTML = '';
        if (sizes.length === 0) {
            previewBox.style.display = 'none';
            return;
        }

        // Build rows of 2 columns
        for (let i = 0; i < sizes.length; i += 2) {
            const row = document.createElement('div');
            row.className = 'size-stock-row';

            [sizes[i], sizes[i + 1]].forEach(size => {
                if (!size) return;
                const group = document.createElement('div');
                group.className = 'size-input-group';
                group.innerHTML = `
                    <span class="size-label-tag">${size.toUpperCase()}</span>
                    <input type="number" class="size-qty-input" name="stok_per_ukuran[${size}]"
                        placeholder="0" min="0" value="0"
                        oninput="recalcTotal('addSizeStockContainer','addTotalVal','addStockTotalPreview')" required>
                `;
                row.appendChild(group);
            });

            container.appendChild(row);
        }
        previewBox.style.display = 'flex';
        recalcTotal('addSizeStockContainer','addTotalVal','addStockTotalPreview');
    }

    // ── Generate per-size stock input rows (Edit modal) ──
    window.generateEditSizeInputs = function(existingStok) {
        const ukuranVal = document.getElementById('editUkuranInput').value;
        const container = document.getElementById('editSizeStockContainer');
        const previewBox = document.getElementById('editStockTotalPreview');
        const sizes = ukuranVal.split(',').map(s => s.trim()).filter(s => s !== '');

        container.innerHTML = '';
        if (sizes.length === 0) {
            previewBox.style.display = 'none';
            return;
        }

        for (let i = 0; i < sizes.length; i += 2) {
            const row = document.createElement('div');
            row.className = 'size-stock-row';

            [sizes[i], sizes[i + 1]].forEach(size => {
                if (!size) return;
                const prefillVal = (existingStok && existingStok[size] !== undefined) ? existingStok[size] : 0;
                const group = document.createElement('div');
                group.className = 'size-input-group';
                group.innerHTML = `
                    <span class="size-label-tag">${size.toUpperCase()}</span>
                    <input type="number" class="size-qty-input" name="stok_per_ukuran[${size}]"
                        placeholder="0" min="0" value="${prefillVal}"
                        oninput="recalcTotal('editSizeStockContainer','editTotalVal','editStockTotalPreview')" required>
                `;
                row.appendChild(group);
            });

            container.appendChild(row);
        }
        previewBox.style.display = 'flex';
        recalcTotal('editSizeStockContainer','editTotalVal','editStockTotalPreview');
    }

    // ── Recalculate displayed total stock ──
    window.recalcTotal = function(containerId, totalValId, previewId) {
        const container = document.getElementById(containerId);
        const inputs = container.querySelectorAll('.size-qty-input');
        let total = 0;
        inputs.forEach(inp => total += parseInt(inp.value || 0));
        document.getElementById(totalValId).textContent = total;
        document.getElementById(previewId).style.display = 'flex';
    }

    // ── Open Edit Modal with pre-filled per-size data ──
    window.openEditFormModal = function(kostum) {
        const form = document.getElementById('editKostumForm');
        form.action = `/admin/kostum/${kostum.id}`;

        document.getElementById('edit_nama_kostum').value = kostum.nama_kostum;
        document.getElementById('edit_kategori_id').value = kostum.kategori_id;
        document.getElementById('edit_harga_sewa').value = kostum.harga_sewa;
        document.getElementById('edit_kelengkapan').value = kostum.kelengkapan || '';

        // Set ukuran and generate per-size inputs with existing stock
        document.getElementById('editUkuranInput').value = kostum.ukuran || '';
        const stokPerUkuran = kostum.stok_per_ukuran || {};
        generateEditSizeInputs(stokPerUkuran);

        const previewImg = document.getElementById('edit_preview_img');
        const noImgText = document.getElementById('edit_no_image_text');
        
        if (kostum.gambar) {
            let imgUrl = '';
            if (kostum.gambar.startsWith('http://') || kostum.gambar.startsWith('https://')) {
                imgUrl = kostum.gambar;
            } else {
                imgUrl = '/storage/' + kostum.gambar;
            }
            previewImg.src = imgUrl;
            previewImg.style.display = 'block';
            noImgText.style.display = 'none';
        } else {
            previewImg.style.display = 'none';
            noImgText.style.display = 'block';
        }

        document.getElementById('modalEdit').classList.add('show');
    }

    // ── Open View Modal with per-size stock table ──
    window.openViewFormModal = function(kostum) {
        document.getElementById('view_nama_kostum').textContent = kostum.nama_kostum;
        document.getElementById('view_kategori').textContent = kostum.kategori ? kostum.kategori.nama_kategori : 'N/A';
        
        const hargaFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(kostum.harga_sewa);
        document.getElementById('view_harga').innerHTML = hargaFormatted + ' <span style="font-size:12px;color:var(--text-3);font-family:\'Sora\',sans-serif;">/day</span>';
        
        document.getElementById('view_stok').textContent = kostum.stok + ' Unit';
        document.getElementById('view_kelengkapan').textContent = kostum.kelengkapan || 'No special accessories/description.';

        // Render per-size stock table
        const tableContainer = document.getElementById('view_size_stock_table');
        tableContainer.innerHTML = '';
        const stokPerUkuran = kostum.stok_per_ukuran || {};
        const sizes = Object.keys(stokPerUkuran);

        if (sizes.length > 0) {
            sizes.forEach(size => {
                const qty = stokPerUkuran[size];
                const isAvail = qty > 0;
                const chip = document.createElement('div');
                chip.style.cssText = `
                    display:inline-flex; align-items:center; gap:8px;
                    padding:8px 14px; border-radius:8px; border:1px solid;
                    background:${isAvail ? 'rgba(34,197,94,0.12)' : 'rgba(248,113,113,0.12)'};
                    border-color:${isAvail ? 'rgba(34,197,94,0.3)' : 'rgba(248,113,113,0.3)'};
                `;
                chip.innerHTML = `
                    <span style="font-size:14px;font-weight:800;color:${isAvail ? 'var(--green)' : 'var(--red)'};">${size.toUpperCase()}</span>
                    <span style="font-size:11px;color:var(--text-3);font-weight:600;">—</span>
                    <span style="font-size:14px;font-weight:700;color:var(--text-1);font-family:'JetBrains Mono',monospace;">${qty}</span>
                    <span style="font-size:11px;color:var(--text-3);">unit${qty !== 1 ? 's' : ''}</span>
                `;
                tableContainer.appendChild(chip);
            });
        } else if (kostum.ukuran) {
            const sizes2 = kostum.ukuran.split(',').map(s => s.trim()).filter(Boolean);
            sizes2.forEach(size => {
                const chip = document.createElement('div');
                chip.style.cssText = "display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;border:1px solid var(--border);background:var(--bg-card2);";
                chip.innerHTML = `<span style="font-size:14px;font-weight:800;color:var(--text-1);">${size.toUpperCase()}</span><span style="font-size:12px;color:var(--text-3);">— stock unknown</span>`;
                tableContainer.appendChild(chip);
            });
        } else {
            tableContainer.innerHTML = '<span style="color:var(--text-3);font-size:13px;font-style:italic;">No sizes configured</span>';
        }

        // Image
        const viewImg = document.getElementById('view_gambar');
        if (kostum.gambar) {
            let imgUrl = '';
            if (kostum.gambar.startsWith('http://') || kostum.gambar.startsWith('https://')) {
                imgUrl = kostum.gambar;
            } else {
                imgUrl = '/storage/' + kostum.gambar;
            }
            viewImg.src = imgUrl;
            viewImg.style.display = 'block';
        } else {
            viewImg.src = 'https://via.placeholder.com/400x500.png?text=No+Image';
        }

        document.getElementById('modalView').classList.add('show');
    }

    window.openDeleteFormModal = function(id, nama) {
        const form = document.getElementById('deleteKostumForm');
        form.action = `/admin/kostum/${id}`;
        document.getElementById('delete_kostum_name').textContent = nama;
        document.getElementById('modalDelete').classList.add('show');
    }
</script>
@endpush
