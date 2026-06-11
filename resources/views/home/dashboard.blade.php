@extends('layouts.app')

@section('title', 'Dashboard — SeaBiz')

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

/* HERO */
.hero{background:linear-gradient(135deg,#0d3b7c,#1565c0);color:#fff;padding:36px 20px;text-align:center;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1400&q=70') center/cover;opacity:.12}
.hero-content{position:relative;z-index:1}
.hero-sub{font-size:11px;text-transform:uppercase;letter-spacing:2px;opacity:.8;margin-bottom:8px;font-weight:700}
.hero h1{font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;line-height:1.3;margin-bottom:8px}
.hero p{font-size:13px;opacity:.85;margin-bottom:20px;max-width:500px;margin-left:auto;margin-right:auto}
.hero-search{display:flex;max-width:440px;margin:0 auto;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);border-radius:24px;overflow:hidden}
.hero-search input{flex:1;padding:12px 18px;background:transparent;border:none;outline:none;color:#fff;font-size:13px;font-family:'Nunito',sans-serif}
.hero-search input::placeholder{color:rgba(255,255,255,.65)}
.hero-search button{padding:10px 18px;background:rgba(255,255,255,.2);border:none;color:#fff;cursor:pointer;font-size:14px;transition:.15s}
.hero-search button:hover{background:rgba(255,255,255,.3)}

/* FEATURE CARDS */
.feature-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;padding:20px;max-width:900px;margin:0 auto}
.feat-card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:18px;text-align:center;cursor:pointer;transition:.2s;text-decoration:none;display:block;color:inherit}
.feat-card:hover{border-color:#1565c0;transform:translateY(-3px);box-shadow:0 8px 24px rgba(21,101,192,.15)}
.feat-icon{font-size:32px;margin-bottom:10px}
.feat-title{font-family:'Poppins',sans-serif;font-weight:700;font-size:13px;margin-bottom:4px;color:#0f172a}
.feat-desc{font-size:12px;color:#64748b}

/* SECTION */
.section-wrap{max-width:1300px;margin:0 auto;padding:0 20px 32px}
.section-header{display:flex;justify-content:space-between;align-items:center;padding:20px 0 12px}
.section-title{font-family:'Poppins',sans-serif;font-weight:700;font-size:16px;color:#0f172a}
.see-all{color:#1565c0;font-size:12px;font-weight:700;text-decoration:none;cursor:pointer}
.see-all:hover{text-decoration:underline}

/* FLASH SALE BANNER */
.flash-banner{background:linear-gradient(135deg,#ff6b35,#f59e0b);border-radius:16px;padding:18px 24px;display:flex;align-items:center;justify-content:space-between;gap:12px;margin:0 20px 4px;box-shadow:0 6px 20px rgba(255,107,53,.25);overflow:hidden;position:relative}
.flash-banner::after{content:'🐟🦐🦞🦑';position:absolute;right:120px;font-size:32px;opacity:.15;letter-spacing:8px}
.flash-text{color:#fff;position:relative;z-index:1}
.flash-text h3{font-family:'Poppins',sans-serif;font-weight:800;font-size:15px;margin-bottom:3px}
.flash-text p{font-size:12px;opacity:.9}
.flash-btn{background:#fff;color:#f97316;font-weight:800;padding:10px 20px;border-radius:10px;text-decoration:none;font-size:13px;white-space:nowrap;transition:.15s;flex-shrink:0;position:relative;z-index:1}
.flash-btn:hover{background:#fff7ed;transform:scale(1.03)}

/* CAT PILLS */
.cat-pills{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px}
.cat-pill{padding:7px 16px;border-radius:20px;border:1.5px solid #e2e8f0;background:#fff;font-size:12px;font-weight:700;cursor:pointer;transition:.15s;color:#64748b}
.cat-pill:hover{border-color:#1565c0;color:#1565c0}
.cat-pill.active{background:#0d3b7c;border-color:#0d3b7c;color:#fff}

/* PRODUCT GRID */
.prod-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:12px}
@media(max-width:1100px){.prod-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
@media(max-width:700px){.prod-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}

/* PRODUCT CARD */
.prod-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;cursor:pointer;transition:.2s;display:flex;flex-direction:column}
.prod-card:hover{border-color:#1565c0;transform:translateY(-2px);box-shadow:0 8px 20px rgba(21,101,192,.12)}
.prod-card:hover .prod-img img{transform:scale(1.05)}
.prod-img{height:130px;overflow:hidden;position:relative}
.prod-img img{width:100%;height:100%;object-fit:cover;transition:.3s}
.prod-badge{position:absolute;top:7px;left:7px;padding:3px 8px;border-radius:8px;font-size:10px;font-weight:700;color:#fff}
.badge-segar{background:#0d9488}.badge-hot{background:#ef4444}.badge-gold{background:#f59e0b}.badge-purple{background:#7c3aed}.badge-navy{background:#1e40af}
.prod-body{padding:10px;flex:1;display:flex;flex-direction:column;gap:3px}
.prod-name{font-size:12px;font-weight:700;line-height:1.35;color:#0f172a}
.prod-seller{font-size:11px;color:#64748b}
.prod-rating{font-size:11px;color:#64748b}
.prod-price{font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;color:#0d3b7c;margin-top:auto}
.prod-footer{display:flex;gap:6px;padding:0 10px 10px;margin-top:auto}
.btn-cart{flex:1;padding:7px;background:#0d3b7c;color:#fff;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;transition:.15s}
.btn-cart:hover{background:#0b2f5b}
.btn-wish{width:30px;height:30px;background:transparent;border:1px solid #e2e8f0;border-radius:8px;cursor:pointer;font-size:13px;display:flex;align-items:center;justify-content:center;transition:.15s}
.btn-wish:hover{border-color:#ef4444}

/* MODAL */
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
.qty-btn{width:30px;height:30px;border:none;background:transparent;cursor:pointer;font-size:16px;font-weight:700;color:#0f172a;transition:.15s}
.qty-btn:hover{background:#f1f5f9}
.qty-val{min-width:36px;text-align:center;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0}
.btn-primary{padding:11px;background:#0d3b7c;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;width:100%;transition:.15s;font-family:'Nunito',sans-serif}
.btn-primary:hover{background:#0b2f5b}

/* TOAST */
.toast{position:fixed;bottom:20px;right:20px;background:#0d3b7c;color:#fff;padding:11px 18px;border-radius:10px;font-size:13px;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;pointer-events:none}
.toast.show{transform:translateY(0);opacity:1}

@media(max-width:768px){
  .feature-cards{grid-template-columns:1fr;max-width:100%}
  .flash-banner{flex-direction:column;text-align:center}
  .modal-grid{grid-template-columns:1fr}
  .modal-img{min-height:200px}
}
</style>
@endsection

@section('content')
<!-- HERO -->
<div class="hero">
  <div class="hero-content">
    <p class="hero-sub">Selamat Datang!</p>
    <h1>Temukan Produk Perikanan Terbaik</h1>
    <p>Marketplace ikan segar dari nelayan lokal Kenjeran, Surabaya</p>
    <div class="hero-search">
      <input type="text" id="heroSearch" placeholder="Cari produk segar..." onkeydown="if(event.key==='Enter') window.location.href='?page=marketplace&q='+this.value"/>
      <button onclick="window.location.href='?page=marketplace&q='+document.getElementById('heroSearch').value">🔍</button>
    </div>
  </div>
</div>

<!-- FEATURE CARDS -->
<div class="feature-cards">
  <a href="{{ route('marketplace') }}" class="feat-card">
    <div class="feat-icon">🛍️</div>
    <div class="feat-title">Marketplace</div>
    <div class="feat-desc">Belanja produk segar dari nelayan lokal</div>
  </a>
  <a href="{{ route('info-harga') }}" class="feat-card">
    <div class="feat-icon">💰</div>
    <div class="feat-title">Info Harga</div>
    <div class="feat-desc">Update harga ikan & hasil laut terbaru</div>
  </a>
  <a href="{{ route('cerita-umkm') }}" class="feat-card">
    <div class="feat-icon">🏪</div>
    <div class="feat-title">Cerita UMKM</div>
    <div class="feat-desc">Kisah inspiratif pelaku usaha perikanan</div>
  </a>
</div>

<!-- FLASH SALE -->
<div class="flash-banner">
  <div class="flash-text">
    <h3>🎉 Flash Sale! Diskon s/d 30%</h3>
    <p>Berlaku hari ini — Stok terbatas untuk produk pilihan perikanan lokal!</p>
  </div>
  <a href="{{ route('marketplace') }}" class="flash-btn">Belanja Sekarang →</a>
</div>

<!-- PRODUCTS SECTION -->
<div class="section-wrap">
  <div class="section-header">
    <span class="section-title">🔥 Produk Terbaru</span>
    <a href="{{ route('marketplace') }}" class="see-all">Lihat Semua →</a>
  </div>

  <div class="cat-pills" id="catPills">
    <button class="cat-pill active" onclick="filterHome(0,this)">🐟 Semua</button>
    <button class="cat-pill" onclick="filterHome(1,this)">Ikan Segar</button>
    <button class="cat-pill" onclick="filterHome(2,this)">Ikan Beku</button>
    <button class="cat-pill" onclick="filterHome(3,this)">Hasil Laut</button>
    <button class="cat-pill" onclick="filterHome(4,this)">Olahan</button>
  </div>

  <div class="prod-grid" id="homeGrid"></div>

  <div class="section-header" style="margin-top:12px">
    <span class="section-title">✨ Rekomendasi Untukmu</span>
    <a href="{{ route('marketplace') }}" class="see-all">Lihat Semua →</a>
  </div>
  <div class="prod-grid" id="rekoGrid"></div>
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



<script>
const DB = {
  products: [
    {id:1,kat:1,nama:'Ikan Kakap Merah',penjual:'UMKM Sukamaju',kota:'Surabaya',rating:4.8,terjual:1200,harga:20000,satuan:'kg',stok:50,badge:'Segar',img:'{{ asset('assets/img/ikankakap.jpg') }}'},
    {id:2,kat:3,nama:'Udang Vaname',penjual:'UMKM Sukamaju',kota:'Sidoarjo',rating:4.9,terjual:340,harga:30000,satuan:'kg',stok:20,badge:'Segar',img:'{{ asset('assets/img/udang vaname.jpg') }}'},
    {id:3,kat:3,nama:'Kepiting Rajungan',penjual:'Kec. Pesisir Barat',kota:'Banten',rating:4.9,terjual:210,harga:10000,satuan:'kg',stok:15,badge:'Jumbo',img:'{{ asset('assets/img/kepiting rajungan.jpg') }}'},
    {id:4,kat:2,nama:'Cumi-cumi Beku',penjual:'Kec. Pesisir Barat',kota:'Banten',rating:4.6,terjual:890,harga:10000,satuan:'kg',stok:200,badge:'Beku',img:'{{ asset('assets/img/cumibeku.jpg') }}'},
    {id:5,kat:4,nama:'Ikan Bandeng Presto',penjual:'UMKM Sukamaju',kota:'Surabaya',rating:4.8,terjual:810,harga:20000,satuan:'pcs',stok:80,badge:'Olahan',img:'{{ asset('assets/img/ikanbandengpresto.jpg') }}'},
    {id:6,kat:4,nama:'Kerupuk Ikan Tenggiri',penjual:'UMKM Melati',kota:'Jakarta',rating:4.4,terjual:560,harga:10000,satuan:'pak',stok:120,badge:'Olahan',img:'{{ asset('assets/img/kerupuk ikan tenggiri.png') }}'},
    {id:7,kat:3,nama:'Lobster Mutiara',penjual:'UMKM Melati',kota:'Jakarta',rating:4.3,terjual:480,harga:80000,satuan:'ekor',stok:10,badge:'Premium',img:'{{ asset('assets/img/lobstermutiara.jpg') }}'},
    {id:8,kat:1,nama:'Ikan Tuna Segar',penjual:'UMKM Nelayan',kota:'Surabaya',rating:4.7,terjual:650,harga:25000,satuan:'kg',stok:30,badge:'Segar',img:'{{ asset('assets/img/ikantunasegar.jpg') }}'}
  ]
};

const BADGE_CLASS = {Segar:'badge-segar','Best Seller':'badge-hot',Populer:'badge-gold',Premium:'badge-purple',Import:'badge-navy',Terlaris:'badge-hot',Beku:'badge-navy',Jumbo:'badge-purple',Olahan:'badge-gold',Baru:'badge-segar'};
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const fallbackImg = "{{ asset('assets/img/nelayan.jpg') }}";

let detProd = null, detQty = 1, homeKat = 0;

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
      <div class="prod-rating">⭐ ${p.rating} (${p.terjual.toLocaleString('id-ID')})</div>
      <div class="prod-price">${rp(p.harga)}<small style="font-size:10px;font-weight:400;color:#64748b">/${p.satuan}</small></div>
    </div>
    <div class="prod-footer">
      <button class="btn-cart" onclick="event.stopPropagation();addToCartDash(${p.id})">🛒 Keranjang</button>
      <button class="btn-wish" onclick="event.stopPropagation();this.textContent=this.textContent==='♡'?'♥':'♡'">♡</button>
    </div>
  </div>`;
}

function addToCartDash(id) {
  const p = DB.products.find(x => x.id === id);
  if (!p) return;
  if (typeof addToCart === 'function') addToCart(p);
  updateCartBadge();
  showToast('✅ ' + p.nama + ' ditambahkan ke keranjang!', 'success');
}

function filterHome(kat, btn) {
  homeKat = kat;
  document.querySelectorAll('#catPills .cat-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderHome();
}

function renderHome() {
  const data = homeKat ? DB.products.filter(p => p.kat === homeKat) : DB.products;
  document.getElementById('homeGrid').innerHTML = data.slice(0,12).map(p => prodCard(p)).join('');
}

function renderReko() {
  // Show all products shuffled, or fallback to reverse order for "rekomendasi"
  const shuffled = [...DB.products].sort(() => .5 - Math.random());
  const display = shuffled.length >= 6 ? shuffled.slice(0,6) : [...DB.products].reverse().slice(0,6);
  const grid = document.getElementById('rekoGrid');
  if (grid) grid.innerHTML = display.map(p => prodCard(p)).join('');
}

function openDetail(id) {
  const p = DB.products.find(x => x.id === id);
  if (!p) return;
  detProd = p; detQty = 1;
  document.getElementById('detImg').src = p.img;
  document.getElementById('detBadge').textContent = p.badge;
  document.getElementById('detBadge').className = 'prod-badge ' + (BADGE_CLASS[p.badge] || 'badge-segar');
  document.getElementById('detName').textContent = p.nama;
  document.getElementById('detMeta').textContent = `⭐ ${p.rating} · 🏪 ${p.penjual} · 📍 ${p.kota} · Stok: ${p.stok} ${p.satuan}`;
  document.getElementById('detPrice').textContent = `${rp(p.harga)} / ${p.satuan}`;
  document.getElementById('detDesc').textContent = `Produk berkualitas dari ${p.penjual} di ${p.kota}. Kami menjamin kesegaran dan kualitas terbaik setiap pesanan.`;
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

// Ensure DOM is ready before rendering
document.addEventListener('DOMContentLoaded', function() {
  renderHome();
  renderReko();
  updateCartBadge();
});
// Also render immediately in case DOMContentLoaded already fired
if (document.readyState !== 'loading') {
  renderHome();
  renderReko();
  updateCartBadge();
}
</script>
@endsection
