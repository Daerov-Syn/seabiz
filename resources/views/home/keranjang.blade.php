@extends('layouts.app')

@section('title', 'Keranjang — SeaBiz')

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

/* PAGE */
.page-wrap{max-width:1100px;margin:24px auto;padding:0 20px;display:grid;grid-template-columns:1fr 300px;gap:20px}
@media(max-width:900px){.page-wrap{grid-template-columns:1fr}}

/* CART HEADER */
.cart-header{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;box-shadow:0 2px 8px rgba(15,23,42,.05)}
.cart-header h2{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700}
.cart-count-badge{background:#e0f2fe;color:#0369a1;border-radius:10px;padding:3px 10px;font-size:11px;font-weight:700}

/* SELECT ALL ROW */
.select-all-row{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:12px 18px;display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;font-size:13px;font-weight:600}
.custom-check{display:flex;align-items:center;gap:10px;cursor:pointer}
.custom-check input{width:16px;height:16px;accent-color:#0d3b7c;cursor:pointer}
.btn-hapus-semua{color:#ef4444;font-size:12px;font-weight:700;background:none;border:none;cursor:pointer;transition:.15s}
.btn-hapus-semua:hover{opacity:.7}

/* CART GROUP */
.cart-group{background:#fff;border:1px solid #e2e8f0;border-radius:14px;margin-bottom:10px;overflow:hidden;box-shadow:0 2px 8px rgba(15,23,42,.05)}
.cart-group-header{padding:11px 16px;background:#f8fafc;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:10px;font-size:12.5px;font-weight:700}

/* CART ITEM */
.cart-item{padding:14px 16px;display:flex;align-items:flex-start;gap:12px;border-bottom:1px solid #e2e8f0;transition:.15s}
.cart-item:last-child{border-bottom:none}
.cart-item:hover{background:#fafbfd}
.cart-item img{width:75px;height:75px;border-radius:10px;object-fit:cover;flex-shrink:0;border:1px solid #e2e8f0}
.cart-item-info{flex:1;min-width:0}
.cart-item-name{font-size:13px;font-weight:700;margin-bottom:3px;line-height:1.4}
.cart-item-meta{font-size:11px;color:#64748b;margin-bottom:6px}
.cart-item-price{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:#0d3b7c}
.cart-item-actions{display:flex;align-items:center;justify-content:space-between;margin-top:8px}
.qty-ctrl{display:flex;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden}
.qty-btn{width:30px;height:30px;border:none;background:#fff;font-size:16px;font-weight:700;color:#0f172a;cursor:pointer;transition:.15s;display:flex;align-items:center;justify-content:center}
.qty-btn:hover{background:#eff6ff;color:#0d3b7c}
.qty-val{min-width:36px;text-align:center;font-size:13px;font-weight:700;background:#fff;display:flex;align-items:center;justify-content:center;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0}
.btn-remove{color:#64748b;font-size:12px;background:none;border:none;cursor:pointer;font-weight:600;transition:.15s}
.btn-remove:hover{color:#ef4444}
.item-subtotal{font-size:12px;color:#64748b;font-weight:700;flex-shrink:0;text-align:right}

/* EMPTY */
.cart-empty{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:70px 40px;text-align:center;box-shadow:0 2px 8px rgba(15,23,42,.05)}
.cart-empty .empty-icon{font-size:56px;margin-bottom:14px}
.cart-empty h3{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;margin-bottom:8px}
.cart-empty p{color:#64748b;font-size:13px;margin-bottom:20px}
.btn-belanja{display:inline-block;padding:11px 28px;background:#0d3b7c;color:#fff;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:.15s}
.btn-belanja:hover{background:#0b2f5b}

/* SUMMARY */
.summary-box{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;align-self:start;position:sticky;top:80px;box-shadow:0 2px 8px rgba(15,23,42,.05)}
.summary-box h3{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;margin-bottom:16px}
.summary-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:12px}
.summary-row .lbl{color:#64748b}
.summary-row .val{font-weight:600}
.summary-divider{height:1px;background:#e2e8f0;margin:14px 0}
.summary-total{font-size:15px}
.summary-total .lbl{font-weight:700;color:#0f172a}
.summary-total .val{font-family:'Poppins',sans-serif;font-size:17px;font-weight:800;color:#0d3b7c}
.voucher-row{display:flex;gap:6px;margin-bottom:0}
.voucher-row input{flex:1;padding:9px 11px;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;outline:none;font-family:'Nunito',sans-serif}
.voucher-row input:focus{border-color:#0d3b7c}
.voucher-row button{padding:9px 14px;background:#f1f5f9;color:#0f172a;border:1px solid #e2e8f0;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:'Nunito',sans-serif;transition:.15s}
.voucher-row button:hover{background:#e2e8f0}
.btn-checkout{width:100%;padding:14px;background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:800;cursor:pointer;margin-top:14px;transition:.2s;font-family:'Poppins',sans-serif;letter-spacing:.3px}
.btn-checkout:hover{opacity:.9;transform:translateY(-1px)}
.btn-checkout:disabled{opacity:.5;cursor:not-allowed;transform:none}
.secure-note{text-align:center;font-size:11px;color:#94a3b8;margin-top:10px}
.trust-list{margin-top:14px;font-size:12px;color:#64748b;line-height:2}

/* REKO */
.reko-section{margin-top:16px}
.reko-section h4{font-family:'Poppins',sans-serif;font-size:13px;font-weight:700;margin-bottom:12px}
.reko-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
.reko-card{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;cursor:pointer;transition:.2s}
.reko-card:hover{border-color:#0d3b7c;transform:translateY(-1px)}
.reko-card img{width:100%;height:75px;object-fit:cover}
.reko-card-info{padding:8px}
.reko-card-info p{font-size:11px;font-weight:700;margin-bottom:2px;line-height:1.3}
.reko-card-info span{font-size:11px;color:#0d3b7c;font-weight:700}

/* TOAST */
.toast{position:fixed;bottom:20px;right:20px;background:#0d3b7c;color:#fff;padding:11px 18px;border-radius:10px;font-size:13px;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;pointer-events:none}
.toast.show{transform:translateY(0);opacity:1}
</style>
@endsection

@section('content')
<div class="page-wrap">
  <!-- LEFT: Cart Items -->
  <div>
    <div class="cart-header">
      <h2>🛒 Keranjang Belanja</h2>
      <span class="cart-count-badge" id="cartCountLabel">0 item</span>
    </div>

    <div class="select-all-row">
      <label class="custom-check">
        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"/> Pilih Semua
      </label>
      <button class="btn-hapus-semua" onclick="hapusSelected()">🗑️ Hapus Terpilih</button>
    </div>

    <div id="cartContent"></div>

    <div class="reko-section" id="rekoSection" style="display:none">
      <h4>🔥 Produk yang Sering Dibeli Bersama</h4>
      <div class="reko-grid" id="rekoGrid"></div>
    </div>
  </div>

  <!-- RIGHT: Summary -->
  <div>
    <div class="summary-box">
      <h3>📋 Ringkasan Belanja</h3>

      <div class="summary-row">
        <span class="lbl">Total Produk (<span id="sumItems">0</span> item)</span>
        <span class="val" id="sumSubtotal">Rp 0</span>
      </div>
      <div class="summary-row">
        <span class="lbl">Ongkos Kirim</span>
        <span class="val" id="sumOngkir">Rp 0</span>
      </div>
      <div class="summary-row" style="color:#0d9488">
        <span class="lbl" style="color:#0d9488">Diskon Voucher</span>
        <span class="val" id="sumDiskon">- Rp 0</span>
      </div>
      <div class="summary-divider"></div>
      <div class="summary-row summary-total">
        <span class="lbl">Total Pembayaran</span>
        <span class="val" id="sumTotal">Rp 0</span>
      </div>
      <div class="summary-divider"></div>

      <div class="voucher-row">
        <input type="text" id="voucherInput" placeholder="Kode voucher (NELAYAN10)"/>
        <button onclick="applyVoucher()">Pakai</button>
      </div>

      <button class="btn-checkout" id="checkoutBtn" onclick="checkout()" disabled>
        Beli Sekarang →
      </button>
      <p class="secure-note">🔒 Transaksi aman & terenkripsi</p>

      <div class="summary-divider"></div>
      <div class="trust-list">
        <div>✅ Gratis retur 7 hari</div>
        <div>✅ Produk 100% segar terjamin</div>
        <div>✅ Pengiriman same-day tersedia</div>
      </div>
    </div>
  </div>
</div>



<script>
let discount = 0;
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const fallbackImg = "{{ asset('assets/img/nelayan.jpg') }}";

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

function renderCart() {
  const cart = getCart();
  const count = cart.reduce((s,i) => s + i.qty, 0);
  const total = cart.reduce((s,i) => s + i.harga * i.qty, 0);
  const ongkir = count > 0 ? 15000 : 0;

  document.getElementById('cartCountLabel').textContent = count + ' item';
  document.getElementById('sumItems').textContent = count;
  document.getElementById('sumSubtotal').textContent = rp(total);
  document.getElementById('sumOngkir').textContent = rp(ongkir);
  document.getElementById('sumDiskon').textContent = '- ' + rp(discount);
  document.getElementById('sumTotal').textContent = rp(Math.max(0, total + ongkir - discount));
  document.getElementById('checkoutBtn').disabled = count === 0;

  // Update nav badge
  const b = document.getElementById('cartBadge');
  if (b) { b.textContent = count > 99 ? '99+' : count; b.style.display = count > 0 ? 'inline' : 'none'; }

  const content = document.getElementById('cartContent');

  if (!cart.length) {
    content.innerHTML = `<div class="cart-empty">
      <div class="empty-icon">🛒</div>
      <h3>Keranjang Masih Kosong</h3>
      <p>Yuk mulai belanja produk segar dari nelayan lokal!</p>
      <a href="{{ route('marketplace') }}" class="btn-belanja">Mulai Belanja →</a>
    </div>`;
    document.getElementById('rekoSection').style.display = 'none';
    return;
  }

  const grouped = {};
  cart.forEach(item => {
    const key = item.penjual || 'Toko Lainnya';
    if (!grouped[key]) grouped[key] = [];
    grouped[key].push(item);
  });

  let html = '';
  for (const [store, items] of Object.entries(grouped)) {
    html += `<div class="cart-group">
      <div class="cart-group-header">
        <input type="checkbox" class="store-check" style="width:15px;height:15px;accent-color:#0d3b7c"/>
        <span>🏪 ${store}</span>
        <span style="font-weight:400;color:#64748b;font-size:11px">· ${items[0].kota || 'Indonesia'}</span>
      </div>`;
    items.forEach(item => {
      html += `<div class="cart-item" id="item_${item.id}">
        <input type="checkbox" class="item-check" data-id="${item.id}" style="margin-top:4px;width:15px;height:15px;accent-color:#0d3b7c" checked/>
        <img src="${item.img}" alt="${item.nama}" onerror="this.src=fallbackImg">
        <div class="cart-item-info">
          <div class="cart-item-name">${item.nama}</div>
          <div class="cart-item-meta">📍 ${item.kota} · Stok tersedia</div>
          <div class="cart-item-price">${rp(item.harga)} <small style="font-size:11px;font-weight:400;color:#64748b">/ ${item.satuan}</small></div>
          <div class="cart-item-actions">
            <div class="qty-ctrl">
              <button class="qty-btn" onclick="changeQty(${item.id},-1)">−</button>
              <span class="qty-val">${item.qty}</span>
              <button class="qty-btn" onclick="changeQty(${item.id},+1)">+</button>
            </div>
            <button class="btn-remove" onclick="hapusItem(${item.id})">🗑️ Hapus</button>
            <span class="item-subtotal">${rp(item.harga * item.qty)}</span>
          </div>
        </div>
      </div>`;
    });
    html += '</div>';
  }
  content.innerHTML = html;

  // Reko
  document.getElementById('rekoSection').style.display = 'block';
  const reko = (typeof PRODUCTS_DB !== 'undefined' ? PRODUCTS_DB : []).filter(p => !cart.find(c => c.id === p.id)).slice(0,4);
  document.getElementById('rekoGrid').innerHTML = reko.map(p => `
    <div class="reko-card" onclick="if(typeof addToCart==='function'){addToCart(PRODUCTS_DB.find(x=>x.id===${p.id}));renderCart();showToast('✅ ${p.nama} ditambahkan!');}">
      <img src="${p.img}" alt="${p.nama}" onerror="this.src=fallbackImg">
      <div class="reko-card-info">
        <p>${p.nama}</p>
        <span>${rp(p.harga)}/${p.satuan}</span>
      </div>
    </div>`).join('');
}

function changeQty(id, delta) {
  updateQty(id, delta);
  renderCart();
}

function hapusItem(id) {
  if (confirm('Hapus produk ini dari keranjang?')) {
    removeFromCart(id);
    renderCart();
    showToast('🗑️ Produk dihapus dari keranjang');
  }
}

function toggleSelectAll(cb) {
  document.querySelectorAll('.item-check').forEach(c => c.checked = cb.checked);
}

function hapusSelected() {
  const checked = [...document.querySelectorAll('.item-check:checked')];
  if (!checked.length) { showToast('Pilih produk yang ingin dihapus'); return; }
  if (!confirm(`Hapus ${checked.length} produk terpilih?`)) return;
  checked.forEach(c => { removeFromCart(+c.dataset.id); });
  renderCart();
}

function applyVoucher() {
  const code = document.getElementById('voucherInput').value.trim().toUpperCase();
  const result = typeof VoucherStore !== 'undefined' ? VoucherStore.apply(code) : null;
  const vouchers = {NELAYAN10:10000, IKAN20:20000, SEABIZ:15000, UMKM30:30000};
  if (result ? result.valid : !!vouchers[code]) {
    discount = result ? result.amount : vouchers[code];
    localStorage.setItem('seabiz_voucher', JSON.stringify({ code, amount: discount }));
    showToast(`🎉 Voucher ${code} berhasil! Hemat ${rp(discount)}`, 'success');
  } else {
    discount = 0;
    localStorage.removeItem('seabiz_voucher');
    if (typeof VoucherStore !== 'undefined') VoucherStore.clear();
    showToast('❌ Voucher tidak valid', 'error');
  }
  renderCart();
}

function checkout() {
  const cart = getCart();
  if (!cart.length) return;
  // Sync voucher discount to localStorage before navigating
  const vInput = document.getElementById('voucherInput');
  if (vInput && vInput.value.trim() && discount > 0 && typeof VoucherStore !== 'undefined') {
    VoucherStore.save(vInput.value.trim().toUpperCase(), discount);
  }
  window.location.href = '{{ route('checkout') }}';
}

function showToast(msg, type) {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.style.background = type === 'error' ? '#dc2626' : type === 'success' ? '#0d9488' : '#0d3b7c';
  t.classList.add('show');
  clearTimeout(window._toastTimer);
  window._toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}

renderCart();
</script>
@endsection
