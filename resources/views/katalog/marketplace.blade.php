@extends('layouts.app')

@section('title', 'Marketplace — SeaBiz')

@section('styles')
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Nunito',sans-serif;background:#f8fafc;color:#0f172a;font-size:14px}

/* NAVBAR */
.topnav{background:#0d3b7c;color:#fff;padding:12px 20px;display:flex;align-items:center;gap:12px;position:sticky;top:0;z-index:100;box-shadow:0 4px 20px rgba(13,59,124,.3)}
.nav-logo{font-family:'Poppins',sans-serif;font-weight:800;font-size:16px;color:#fff;text-decoration:none;display:flex;align-items:center;gap:6px;white-space:nowrap}
.nav-search{flex:1;max-width:300px;display:flex;align-items:center;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);border-radius:20px;padding:6px 12px;gap:6px}
.nav-search input{background:transparent;border:none;outline:none;color:#fff;font-size:13px;width:100%;font-family:'Nunito',sans-serif}
.nav-search input::placeholder{color:rgba(255,255,255,.6)}
.nav-search button{background:none;border:none;color:rgba(255,255,255,.8);cursor:pointer;font-size:15px;line-height:1;padding:0}
.nav-links{display:flex;gap:6px;margin-left:auto}
.nav-link{color:rgba(255,255,255,.8);text-decoration:none;font-size:13px;font-weight:600;padding:6px 10px;border-radius:8px;transition:.15s}
.nav-link:hover,.nav-link.active{color:#fff;background:rgba(255,255,255,.15)}
.nav-cart{position:relative;text-decoration:none;color:#fff;padding:8px 10px;background:rgba(255,255,255,.15);border-radius:8px;font-size:13px;display:flex;align-items:center;gap:4px;transition:.15s}
.nav-cart:hover{background:rgba(255,255,255,.25)}
.cart-badge{background:#ef4444;color:#fff;border-radius:10px;font-size:10px;padding:1px 5px;font-weight:700;display:none}
.nav-user{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.85);font-size:13px;font-weight:600}
.nav-avatar{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.2);display:grid;place-items:center;font-size:16px}

/* MKT HEADER */
.mkt-header{background:linear-gradient(135deg,#0d3b7c,#1565c0);padding:18px 24px;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;position:relative;overflow:hidden}
.mkt-header::before{content:'';position:absolute;inset:0;background:url('../assets/img/hero-boat.png') center/cover;opacity:.07}
.mkt-header-inner{position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:14px;width:100%;flex-wrap:wrap}
.mkt-header h2{font-family:'Poppins',sans-serif;color:#fff;font-size:17px;font-weight:800}
.mkt-header p{color:rgba(255,255,255,.75);font-size:12px;margin-top:2px}
.mkt-search-bar{display:flex;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.28);border-radius:10px;overflow:hidden}
.mkt-search-bar input{padding:9px 14px;background:transparent;border:none;outline:none;color:#fff;font-size:13px;width:260px;font-family:'Nunito',sans-serif}
.mkt-search-bar input::placeholder{color:rgba(255,255,255,.6)}
.mkt-search-bar button{padding:9px 14px;background:rgba(255,255,255,.2);border:none;color:#fff;cursor:pointer;font-size:15px;transition:.15s}
.mkt-search-bar button:hover{background:rgba(255,255,255,.32)}

/* LAYOUT */
.mkt-wrap{max-width:1300px;margin:0 auto;padding:20px}
.mkt-layout{display:grid;grid-template-columns:220px 1fr;gap:18px}
@media(max-width:900px){.mkt-layout{grid-template-columns:1fr}}

/* FILTER PANEL */
.filter-panel{background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;align-self:start;position:sticky;top:80px;box-shadow:0 2px 8px rgba(15,23,42,.05)}
.filter-head{padding:14px 18px;background:#f0f8ff;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between}
.filter-head h4{font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;color:#0d3b7c}
.btn-reset{font-size:11px;color:#0d3b7c;background:none;border:none;font-weight:700;cursor:pointer}
.filter-sec{padding:14px 18px;border-bottom:1px solid #e2e8f0}
.filter-sec:last-child{border-bottom:none}
.filter-sec-label{font-size:10px;font-weight:900;color:#64748b;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px}
.filter-check{display:flex;align-items:center;gap:8px;padding:6px 0;font-size:12.5px;font-weight:600;cursor:pointer;color:#0f172a}
.filter-check input{width:14px;height:14px;accent-color:#0d3b7c;cursor:pointer}
.filter-check .cnt{margin-left:auto;background:#f1f5f9;color:#64748b;font-size:10px;padding:1px 6px;border-radius:6px}
.price-range{display:flex;gap:6px;align-items:center}
.price-range input{flex:1;padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;outline:none;font-family:'Nunito',sans-serif}
.price-range input:focus{border-color:#0d3b7c}
.price-range span{font-size:11px;color:#64748b}

/* TOOLBAR */
.toolbar{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:12px 18px;display:flex;align-items:center;gap:10px;margin-bottom:14px;box-shadow:0 2px 8px rgba(15,23,42,.05);flex-wrap:wrap}
.result-ct{font-size:12px;color:#64748b;flex:1}
.result-ct strong{color:#0f172a}
.sort-sel{padding:7px 10px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;background:#fff;color:#0f172a;cursor:pointer;outline:none;font-family:'Nunito',sans-serif}
.btn-add{padding:8px 16px;background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;transition:.15s;font-family:'Nunito',sans-serif}
.btn-add:hover{opacity:.9;transform:translateY(-1px)}

/* PRODUCT GRID */
.prod-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
@media(max-width:1100px){.prod-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:600px){.prod-grid{grid-template-columns:1fr}}

/* PRODUCT CARD */
.prod-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;cursor:pointer;transition:.2s;display:flex;flex-direction:column}
.prod-card:hover{border-color:#1565c0;transform:translateY(-2px);box-shadow:0 8px 20px rgba(21,101,192,.12)}
.prod-card:hover .prod-img img{transform:scale(1.05)}
.prod-img{height:150px;overflow:hidden;position:relative}
.prod-img img{width:100%;height:100%;object-fit:cover;transition:.3s}
.prod-badge{position:absolute;top:8px;left:8px;padding:3px 9px;border-radius:8px;font-size:10px;font-weight:700;color:#fff}
.badge-segar{background:#0d9488}.badge-hot{background:#ef4444}.badge-gold{background:#f59e0b}.badge-purple{background:#7c3aed}.badge-navy{background:#1e40af}
.prod-body{padding:12px;flex:1;display:flex;flex-direction:column;gap:4px}
.prod-name{font-size:13px;font-weight:700;line-height:1.35;color:#0f172a}
.prod-seller{font-size:11px;color:#64748b}
.prod-rating{font-size:11px;color:#64748b}
.prod-price{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:#0d3b7c;margin-top:auto}
.prod-footer{display:flex;gap:6px;padding:0 12px 12px}
.btn-cart{flex:1;padding:8px;background:#0d3b7c;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;transition:.15s;font-family:'Nunito',sans-serif}
.btn-cart:hover{background:#0b2f5b}
.btn-wish{width:34px;height:34px;background:transparent;border:1px solid #e2e8f0;border-radius:8px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.15s}
.btn-wish:hover{border-color:#ef4444}
.no-result{text-align:center;padding:60px;color:#64748b;font-size:14px;grid-column:1/-1}

/* MODAL DETAIL */
.modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.45);display:none;align-items:center;justify-content:center;z-index:999}
.modal-backdrop.open{display:flex}
.modal-box{background:#fff;border-radius:20px;max-width:600px;width:90%;max-height:85vh;overflow:auto;position:relative}
.modal-grid{display:grid;grid-template-columns:1fr 1fr}
.modal-img{min-height:260px;overflow:hidden}
.modal-img img{width:100%;height:100%;object-fit:cover}
.modal-close{position:absolute;top:12px;right:12px;background:rgba(0,0,0,.4);color:#fff;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;z-index:1}
.modal-body{padding:20px;display:flex;flex-direction:column;gap:10px}
.qty-row{display:flex;align-items:center;gap:8px}
.qty-ctrl{display:flex;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden}
.qty-btn{width:30px;height:30px;border:none;background:#fff;cursor:pointer;font-size:16px;font-weight:700;color:#0f172a;transition:.15s;display:flex;align-items:center;justify-content:center}
.qty-btn:hover{background:#eff6ff;color:#0d3b7c}
.qty-val{min-width:36px;text-align:center;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0}
.btn-primary{padding:11px;background:#0d3b7c;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;width:100%;transition:.15s;font-family:'Nunito',sans-serif}
.btn-primary:hover{background:#0b2f5b}

/* TOAST */
.toast{position:fixed;bottom:20px;right:20px;background:#0d3b7c;color:#fff;padding:11px 18px;border-radius:10px;font-size:13px;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;pointer-events:none}
.toast.show{transform:translateY(0);opacity:1}

@media(max-width:768px){
  .mkt-search-bar input{width:160px}
  .modal-grid{grid-template-columns:1fr}
  .modal-img{min-height:200px}
}
</style>
@endsection

@section('content')
@php
  $products = \App\Models\Product::query()
      ->where('is_active', true)
      ->where('stock', '>', 0)
      ->latest()
      ->get();

  $defaultProducts = [
      [
          'id' => 1,
          'kat' => 1,
          'nama' => 'Ikan Kakap Merah',
          'penjual' => 'UMKM Sukamaju',
          'kota' => 'Surabaya',
          'rating' => 4.8,
          'terjual' => 1200,
          'harga' => 20000,
          'satuan' => 'kg',
          'stok' => 50,
          'badge' => 'Segar',
          'img' => asset('assets/img/ikankakap.jpg'),
      ],
      [
          'id' => 2,
          'kat' => 3,
          'nama' => 'Udang Vaname',
          'penjual' => 'UMKM Sukamaju',
          'kota' => 'Sidoarjo',
          'rating' => 4.9,
          'terjual' => 340,
          'harga' => 30000,
          'satuan' => 'kg',
          'stok' => 20,
          'badge' => 'Segar',
          'img' => asset('assets/img/udang vaname.jpg'),
      ],
      [
          'id' => 3,
          'kat' => 3,
          'nama' => 'Kepiting Rajungan',
          'penjual' => 'Kec. Pesisir Barat',
          'kota' => 'Banten',
          'rating' => 4.9,
          'terjual' => 210,
          'harga' => 10000,
          'satuan' => 'kg',
          'stok' => 15,
          'badge' => 'Jumbo',
          'img' => asset('assets/img/kepiting rajungan.jpg'),
      ],
      [
          'id' => 4,
          'kat' => 2,
          'nama' => 'Cumi-cumi Beku',
          'penjual' => 'Kec. Pesisir Barat',
          'kota' => 'Banten',
          'rating' => 4.6,
          'terjual' => 890,
          'harga' => 10000,
          'satuan' => 'kg',
          'stok' => 200,
          'badge' => 'Beku',
          'img' => asset('assets/img/cumibeku.jpg'),
      ],
      [
          'id' => 5,
          'kat' => 4,
          'nama' => 'Ikan Bandeng Presto',
          'penjual' => 'UMKM Sukamaju',
          'kota' => 'Surabaya',
          'rating' => 4.8,
          'terjual' => 810,
          'harga' => 20000,
          'satuan' => 'pcs',
          'stok' => 80,
          'badge' => 'Olahan',
          'img' => asset('assets/img/ikanbandengpresto.jpg'),
      ],
      [
          'id' => 6,
          'kat' => 4,
          'nama' => 'Kerupuk Ikan Tenggiri',
          'penjual' => 'UMKM Melati',
          'kota' => 'Jakarta',
          'rating' => 4.4,
          'terjual' => 560,
          'harga' => 10000,
          'satuan' => 'pak',
          'stok' => 120,
          'badge' => 'Olahan',
          'img' => asset('assets/img/kerupuk ikan tenggiri.png'),
      ],
      [
          'id' => 7,
          'kat' => 3,
          'nama' => 'Lobster Mutiara',
          'penjual' => 'UMKM Melati',
          'kota' => 'Jakarta',
          'rating' => 4.3,
          'terjual' => 480,
          'harga' => 80000,
          'satuan' => 'ekor',
          'stok' => 10,
          'badge' => 'Premium',
          'img' => asset('assets/img/lobstermutiara.jpg'),
      ],
      [
          'id' => 8,
          'kat' => 1,
          'nama' => 'Ikan Tuna Segar',
          'penjual' => 'UMKM Nelayan',
          'kota' => 'Surabaya',
          'rating' => 4.7,
          'terjual' => 650,
          'harga' => 25000,
          'satuan' => 'kg',
          'stok' => 30,
          'badge' => 'Segar',
          'img' => asset('assets/img/ikantunasegar.jpg'),
      ],
  ];

  $productsData = collect($defaultProducts)
      ->merge($products->map(function ($product) {
          $seller = $product->relationLoaded('user') ? $product->user : null;
          $sellerName = $seller?->seller_name ?: $seller?->name ?: 'SeaBiz';
          $sellerAddress = $seller?->seller_address ?: '';

          return [
              'id' => $product->id,
              'kat' => 1,
              'nama' => $product->name,
              'penjual' => $sellerName,
              'kota' => $sellerAddress ? str_replace(["\n", "\r"], ' ', $sellerAddress) : 'Indonesia',
              'rating' => 4.8,
              'terjual' => 0,
              'harga' => (int) $product->price,
              'satuan' => $product->unit,
              'stok' => (int) $product->stock,
              'badge' => $product->stock > 10 ? 'Segar' : 'Baru',
              'img' => $product->image ? asset('storage/' . $product->image) : asset('assets/img/nelayan.jpg'),
          ];
      })->values())
      ->values()
      ->all();
@endphp
<!-- MKT HEADER -->
<div class="mkt-header">
  <div class="mkt-header-inner">
    <div>
      <h2>🛍️ Marketplace SeaBiz</h2>
      <p>Produk perikanan segar langsung dari nelayan lokal</p>
    </div>
    <div class="mkt-search-bar">
      <input type="text" id="mktSearch" placeholder="Cari produk..." oninput="filterProducts()"/>
      <button onclick="filterProducts()">🔍</button>
    </div>
  </div>
</div>

<div class="mkt-wrap">
  <div class="mkt-layout">
    <!-- FILTER SIDEBAR -->
    <aside class="filter-panel">
      <div class="filter-head">
        <h4>⚙️ Filter</h4>
        <button class="btn-reset" onclick="resetFilter()">Reset</button>
      </div>
      <div class="filter-sec">
        <div class="filter-sec-label">Kategori</div>
        <label class="filter-check"><input type="checkbox" class="fkat" value="1" onchange="filterProducts()"> Ikan Segar <span class="cnt">3</span></label>
        <label class="filter-check"><input type="checkbox" class="fkat" value="2" onchange="filterProducts()"> Ikan Beku <span class="cnt">1</span></label>
        <label class="filter-check"><input type="checkbox" class="fkat" value="3" onchange="filterProducts()"> Hasil Laut <span class="cnt">3</span></label>
        <label class="filter-check"><input type="checkbox" class="fkat" value="4" onchange="filterProducts()"> Olahan Ikan <span class="cnt">3</span></label>
      </div>
      <div class="filter-sec">
        <div class="filter-sec-label">Rentang Harga</div>
        <div class="price-range">
          <input type="number" id="minPrice" placeholder="Min" oninput="filterProducts()"/>
          <span>—</span>
          <input type="number" id="maxPrice" placeholder="Max" oninput="filterProducts()"/>
        </div>
      </div>
      <div class="filter-sec">
        <div class="filter-sec-label">Kota</div>
        <label class="filter-check"><input type="checkbox" class="floc" value="Surabaya" onchange="filterProducts()"> Surabaya</label>
        <label class="filter-check"><input type="checkbox" class="floc" value="Sidoarjo" onchange="filterProducts()"> Sidoarjo</label>
        <label class="filter-check"><input type="checkbox" class="floc" value="Banten" onchange="filterProducts()"> Banten</label>
        <label class="filter-check"><input type="checkbox" class="floc" value="Jakarta" onchange="filterProducts()"> Jakarta</label>
      </div>
      <div class="filter-sec">
        <div class="filter-sec-label">Rating</div>
        <label class="filter-check"><input type="checkbox" class="frating" value="4.5" onchange="filterProducts()"> ⭐ 4.5 ke atas</label>
        <label class="filter-check"><input type="checkbox" class="frating" value="4.0" onchange="filterProducts()"> ⭐ 4.0 ke atas</label>
      </div>
    </aside>

    <!-- PRODUCT AREA -->
    <div>
      <div class="toolbar">
        <span class="result-ct">Menampilkan <strong id="resultCount">0</strong> produk</span>
        <select class="sort-sel" id="sortSel" onchange="filterProducts()">
          <option value="popular">Terpopuler</option>
          <option value="price_asc">Harga ↑</option>
          <option value="price_desc">Harga ↓</option>
          <option value="rating">Rating Tertinggi</option>
          <option value="newest">Terbaru</option>
        </select>
        <button class="btn-add" onclick="showToast('Fitur Tambah Produk coming soon! 🚀')">+ Tambah Produk</button>
      </div>
      <div class="prod-grid" id="mktGrid"></div>
    </div>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-box">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <div class="modal-grid">
      <div class="modal-img"><img id="detImg" src="" alt=""/></div>
      <div class="modal-body">
        <span id="detBadge" class="prod-badge" style="position:static;display:inline-block;width:fit-content"></span>
        <div id="detName" style="font-family:'Poppins',sans-serif;font-size:16px;font-weight:800;color:#0f172a"></div>
        <div id="detMeta" style="font-size:12px;color:#64748b"></div>
        <div id="detPrice" style="font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:#0d3b7c"></div>
        <div id="detDesc" style="font-size:12px;color:#64748b;line-height:1.6"></div>
        <div>
          <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px">Jumlah</div>
          <div class="qty-row">
            <div class="qty-ctrl">
              <button class="qty-btn" onclick="changeDetQty(-1)">−</button>
              <span class="qty-val" id="detQty">1</span>
              <button class="qty-btn" onclick="changeDetQty(1)">+</button>
            </div>
          </div>
        </div>
        <button class="btn-primary" onclick="addDetToCart()">🛒 Tambah ke Keranjang</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL INPUT QUANTITY UNTUK TOMBOL KERANJANG -->
<div class="modal-backdrop" id="qtyModal">
  <div class="modal-box" style="max-width:400px;">
    <button class="modal-close" onclick="closeQtyModal()">✕</button>
    <div class="modal-body">
      <h3 style="font-family:'Poppins',sans-serif;font-size:16px;font-weight:800;color:#0f172a;margin-bottom:12px">🛒 Masukan Jumlah Produk</h3>
      <div id="qtyProdCard" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px;margin-bottom:16px;display:flex;gap:10px">
        <img id="qtyProdImg" src="" alt="" style="width:60px;height:60px;border-radius:8px;object-fit:cover">
        <div style="flex:1">
          <div id="qtyProdName" style="font-size:13px;font-weight:700;margin-bottom:4px"></div>
          <div id="qtyProdPrice" style="font-size:12px;color:#0d3b7c;font-weight:700"></div>
        </div>
      </div>
      <div style="margin-bottom:16px">
        <div style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">Jumlah</div>
        <div class="qty-row">
          <div class="qty-ctrl">
            <button class="qty-btn" onclick="changeQtyModalQty(-1)">−</button>
            <span class="qty-val" id="qtyModalVal">1</span>
            <button class="qty-btn" onclick="changeQtyModalQty(+1)">+</button>
          </div>
          <span id="qtyModalStock" style="margin-left:auto;font-size:12px;color:#64748b">Stok: 0</span>
        </div>
      </div>
      <div style="display:flex;gap:10px">
        <button class="btn-primary" style="background:#e2e8f0;color:#0f172a" onclick="closeQtyModal()">Batal</button>
        <button class="btn-primary" onclick="confirmAddToCart()" style="flex:1">✓ Tambah ke Keranjang</button>
      </div>
    </div>
  </div>
</div>

<script>
const PRODUCTS_MKT = @json($productsData);

const BADGE_CLASS = {Segar:'badge-segar','Best Seller':'badge-hot',Populer:'badge-gold',Premium:'badge-purple',Import:'badge-navy',Terlaris:'badge-hot',Beku:'badge-navy',Jumbo:'badge-purple',Olahan:'badge-gold',Baru:'badge-segar'};
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const fallbackImg = "{{ asset('assets/img/nelayan.jpg') }}";
let detProd = null, detQty = 1, qtyModalProd = null, qtyModalQty = 1;

// LOCAL STORAGE FUNCTIONS
function getCart() {
  try {
    const cart = localStorage.getItem('seabiz_cart');
    return cart ? JSON.parse(cart) : [];
  } catch(e) { return []; }
}

function addToCart(product) {
  const cart = getCart();
  const existing = cart.find(item => item.id === product.id);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({...product, qty: 1});
  }
  localStorage.setItem('seabiz_cart', JSON.stringify(cart));
}

function removeFromCart(productId) {
  let cart = getCart();
  cart = cart.filter(item => item.id !== productId);
  localStorage.setItem('seabiz_cart', JSON.stringify(cart));
}

function updateQty(productId, delta) {
  const cart = getCart();
  const item = cart.find(item => item.id === productId);
  if (item) {
    item.qty = Math.max(1, item.qty + delta);
    localStorage.setItem('seabiz_cart', JSON.stringify(cart));
  }
}

function getCartCount() {
  const cart = getCart();
  return cart.reduce((sum, item) => sum + item.qty, 0);
}

function prodCard(p) {
  const bc = BADGE_CLASS[p.badge] || 'badge-segar';
  return `<div class="prod-card">
    <div class="prod-img" onclick="openDetail(${p.id})">
      <img src="${p.img}" alt="${p.nama}" loading="lazy" onerror="this.src=fallbackImg">
      <span class="prod-badge ${bc}">${p.badge}</span>
    </div>
    <div class="prod-body" onclick="openDetail(${p.id})">
      <div class="prod-name">${p.nama}</div>
      <div class="prod-seller">🏪 ${p.penjual} · 📍 ${p.kota}</div>
      <div class="prod-rating">⭐ ${p.rating} (${p.terjual.toLocaleString('id-ID')} terjual)</div>
      <div class="prod-price">${rp(p.harga)}<small style="font-size:10px;font-weight:400;color:#64748b">/${p.satuan}</small></div>
    </div>
    <div class="prod-footer">
      <button class="btn-cart" onclick="event.stopPropagation();addToCartMkt(${p.id})">🛒 Keranjang</button>
      <button class="btn-wish" onclick="event.stopPropagation();this.textContent=this.textContent==='♡'?'♥':'♡'">♡</button>
    </div>
  </div>`;
}

function addToCartMkt(id) {
  const p = PRODUCTS_MKT.find(x => x.id === id);
  if (!p) return;
  qtyModalProd = p;
  qtyModalQty = 1;
  document.getElementById('qtyProdImg').src = p.img;
  document.getElementById('qtyProdName').textContent = p.nama;
  document.getElementById('qtyProdPrice').textContent = rp(p.harga) + ' / ' + p.satuan;
  document.getElementById('qtyModalVal').textContent = '1';
  document.getElementById('qtyModalStock').textContent = 'Stok: ' + p.stok;
  document.getElementById('qtyModal').classList.add('open');
}

function changeQtyModalQty(delta) {
  const maxQty = qtyModalProd ? qtyModalProd.stok : 99;
  qtyModalQty = Math.max(1, Math.min(qtyModalQty + delta, maxQty));
  document.getElementById('qtyModalVal').textContent = qtyModalQty;
}

function confirmAddToCart() {
  if (!qtyModalProd) return;
  for (let i = 0; i < qtyModalQty; i++) {
    addToCart(qtyModalProd);
  }
  updateCartBadge();
  closeQtyModal();
  showToast(`✅ ${qtyModalQty}x ${qtyModalProd.nama} ditambahkan ke keranjang!`, 'success');
}

function closeQtyModal() {
  document.getElementById('qtyModal').classList.remove('open');
  qtyModalProd = null;
  qtyModalQty = 1;
}

function filterProducts() {
  const q = (document.getElementById('mktSearch').value || '').toLowerCase();
  const kats = [...document.querySelectorAll('.fkat:checked')].map(i => +i.value);
  const locs = [...document.querySelectorAll('.floc:checked')].map(i => i.value);
  const ratings = [...document.querySelectorAll('.frating:checked')].map(i => +i.value);
  const minP = +document.getElementById('minPrice').value || 0;
  const maxP = +document.getElementById('maxPrice').value || Infinity;
  const sort = document.getElementById('sortSel').value;

  let data = PRODUCTS_MKT.filter(p =>
    (!q || p.nama.toLowerCase().includes(q) || p.penjual.toLowerCase().includes(q) || p.kota.toLowerCase().includes(q)) &&
    (!kats.length || kats.includes(p.kat)) &&
    (!locs.length || locs.includes(p.kota)) &&
    (!ratings.length || ratings.some(r => p.rating >= r)) &&
    p.harga >= minP && p.harga <= maxP
  );

  if (sort === 'price_asc') data.sort((a,b) => a.harga - b.harga);
  else if (sort === 'price_desc') data.sort((a,b) => b.harga - a.harga);
  else if (sort === 'rating') data.sort((a,b) => b.rating - a.rating);
  else if (sort === 'newest') data.sort((a,b) => b.id - a.id);
  else data.sort((a,b) => b.terjual - a.terjual);

  document.getElementById('resultCount').textContent = data.length;
  const grid = document.getElementById('mktGrid');
  if (!data.length) {
    grid.innerHTML = `<div class="no-result">😕 Produk tidak ditemukan.<br><small>Coba ubah filter atau kata kunci pencarian.</small></div>`;
    return;
  }
  grid.innerHTML = data.map(p => prodCard(p)).join('');
}

function resetFilter() {
  document.querySelectorAll('.fkat,.floc,.frating').forEach(i => i.checked = false);
  document.getElementById('minPrice').value = '';
  document.getElementById('maxPrice').value = '';
  document.getElementById('mktSearch').value = '';
  filterProducts();
}

function openDetail(id) {
  const p = PRODUCTS_MKT.find(x => x.id === id);
  if (!p) return;
  detProd = p; detQty = 1;
  document.getElementById('detImg').src = p.img;
  document.getElementById('detBadge').textContent = p.badge;
  document.getElementById('detBadge').className = 'prod-badge ' + (BADGE_CLASS[p.badge] || 'badge-segar');
  document.getElementById('detName').textContent = p.nama;
  document.getElementById('detMeta').textContent = `⭐ ${p.rating} · 🏪 ${p.penjual} · 📍 ${p.kota} · Stok: ${p.stok} ${p.satuan}`;
  document.getElementById('detPrice').textContent = `${rp(p.harga)} / ${p.satuan}`;
  document.getElementById('detDesc').textContent = `Produk berkualitas dari ${p.penjual} di ${p.kota}. Kami menjamin kesegaran dan kualitas terbaik untuk setiap pesanan Anda.`;
  document.getElementById('detQty').textContent = 1;
  document.getElementById('detailModal').classList.add('open');
}

function changeDetQty(d) {
  detQty = Math.max(1, Math.min(detQty + d, (detProd?.stok || 99)));
  document.getElementById('detQty').textContent = detQty;
}

function addDetToCart() {
  if (!detProd) return;
  for (let i = 0; i < detQty; i++) {
    if (typeof addToCart === 'function') addToCart(detProd);
  }
  updateCartBadge();
  closeModal();
  showToast(`✅ ${detQty}x ${detProd.nama} ditambahkan!`, 'success');
}

function closeModal() { document.getElementById('detailModal').classList.remove('open'); }

function updateCartBadge() {
  const n = typeof getCartCount === 'function' ? getCartCount() : 0;
  const b = document.getElementById('cartBadge');
  if (b) { b.textContent = n > 99 ? '99+' : n; b.style.display = n > 0 ? 'inline' : 'none'; }
}

function showToast(msg, type) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.style.background = type === 'error' ? '#dc2626' : type === 'success' ? '#0d9488' : '#0d3b7c';
  t.classList.add('show');
  clearTimeout(window._toastTimer);
  window._toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}

document.getElementById('detailModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
document.getElementById('qtyModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeQtyModal(); });

// Cek query string dari URL
const urlParams = new URLSearchParams(window.location.search);
const qParam = urlParams.get('q');
if (qParam) document.getElementById('mktSearch').value = qParam;

filterProducts();
updateCartBadge();
</script>
@endsection
