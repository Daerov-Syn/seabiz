@extends('layouts.app')

@section('title', 'Pesanan Saya — SeaBiz')

@section('styles')
<style>
.order-tabs-row { display:flex; gap:6px; overflow-x:auto; padding-bottom:4px; margin-bottom:18px; }
.order-tab { padding:9px 18px; border-radius:100px; border:1.5px solid var(--border); background:white; font-size:12.5px; font-weight:700; color:var(--mid); cursor:pointer; white-space:nowrap; transition:.2s; font-family:'Nunito',sans-serif; }
.order-tab.active { background:var(--primary); border-color:var(--primary); color:white; }
.order-search-row { display:flex; background:white; border:1.5px solid var(--border); border-radius:10px; overflow:hidden; margin-bottom:18px; box-shadow:var(--shadow-xs); }
.order-search-row input { flex:1; padding:12px 16px; border:none; font-size:13.5px; outline:none; font-family:'Nunito',sans-serif; }
.order-search-row button { padding:12px 16px; background:none; border:none; font-size:16px; cursor:pointer; color:var(--mid); }

.order-store-group { background:white; border:1px solid var(--border); border-radius:var(--radius-lg); margin-bottom:14px; overflow:hidden; box-shadow:var(--shadow-xs); }
.order-store-header { padding:13px 18px; background:var(--bg); border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
.order-store-name { font-weight:800; font-size:13.5px; }
.order-store-loc { font-size:11.5px; color:var(--mid); }
.status-pill { margin-left:auto; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:800; }
.sp-selesai { background:#d1fae5; color:#065f46; }
.sp-dikemas { background:#fef3c7; color:#92400e; }
.sp-belum  { background:#fee2e2; color:#991b1b; }
.sp-dikirim { background:#dbeafe; color:#1e40af; }
.sp-batal  { background:#f3f4f6; color:#6b7280; }

.order-item { padding:16px 18px; display:flex; align-items:flex-start; gap:14px; border-bottom:1px solid var(--border); }
.order-item:last-of-type { border-bottom:none; }
.order-item-img { width:70px; height:70px; border-radius:10px; object-fit:cover; border:1px solid var(--border); flex-shrink:0; }
.order-item-info { flex:1; }
.order-item-name { font-weight:700; font-size:13.5px; margin-bottom:3px; }
.order-item-meta { font-size:12px; color:var(--mid); margin-bottom:6px; }
.order-item-price { font-family:'Poppins',sans-serif; font-size:15px; font-weight:800; color:var(--primary-dark); }
.order-footer { padding:14px 18px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--bg); }
.order-total { font-size:13.5px; color:var(--mid); }
.order-total strong { color:var(--text); font-family:'Poppins',sans-serif; font-size:15px; }
.order-btns { display:flex; gap:8px; }
.order-btn { padding:8px 14px; border-radius:8px; font-size:12px; font-weight:800; cursor:pointer; border:none; transition:.2s; font-family:'Nunito',sans-serif; }
.order-btn.primary { background:linear-gradient(135deg,var(--primary),var(--primary-mid)); color:white; }
.order-btn.outline { background:white; border:1.5px solid var(--primary); color:var(--primary); }
.order-btn:hover { opacity:.9; transform:translateY(-1px); }

/* Rating modal */
.star-rating { display:flex; gap:6px; font-size:28px; cursor:pointer; margin:14px 0; justify-content:center; }
.star-rating span { transition:.2s; color:var(--border); }
.star-rating span.active { color:var(--gold); }

.toast{position:fixed;bottom:20px;right:20px;background:#0d3b7c;color:#fff;padding:11px 18px;border-radius:10px;font-size:13px;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;pointer-events:none}
.toast.show{transform:translateY(0);opacity:1}
</style>
@endsection

@section('content')
<div class="account-layout">
  <aside class="sidebar">
    <div class="sidebar-top">
      <div class="sidebar-avatar" id="sbAvatarEl">B</div>
      <div class="sidebar-name" id="sbNameEl">Budi Santoso</div>
      <div class="sidebar-username" id="sbUsernameEl">_budiputra</div>
    </div>
    
  </aside>

  <div>
    <div class="content-box">
      <div class="content-box-header">
        <span class="content-box-title">📦 Pesanan Saya</span>
      </div>
      <div style="padding:20px 24px 0;">
        <!-- Status tabs -->
        <div class="order-tabs-row">
          <button class="order-tab active" onclick="filterOrders('all',this)">Semua</button>
          <button class="order-tab" onclick="filterOrders('belum_dibayar',this)">Belum Dibayar</button>
          <button class="order-tab" onclick="filterOrders('dikemas',this)">Dikemas</button>
          <button class="order-tab" onclick="filterOrders('dikirim',this)">Dikirim</button>
          <button class="order-tab" onclick="filterOrders('selesai',this)">Selesai</button>
          <button class="order-tab" onclick="filterOrders('batal',this)">Dibatalkan</button>
        </div>
        <!-- Search -->
        <div class="order-search-row">
          <input type="text" id="orderSearch" placeholder="Cari nama toko, nomor pesanan, nama produk..." oninput="renderOrders()"/>
          <button>🔍</button>
        </div>
      </div>
      <div style="padding:0 24px 24px;" id="ordersList"></div>
    </div>
  </div>
</div>

<div id="toast" class="toast"></div>

<script>
  window.INITIAL_ORDERS = @json($orders);
</script>

<!-- Rating Modal -->
<div class="modal-backdrop" id="ratingModal">
  <div class="modal-box" style="max-width:480px;">
    <div class="modal-header"><span class="modal-title">⭐ Nilai Produk</span><button class="modal-close-btn" onclick="closeModal('ratingModal')">✕</button></div>
    <div class="modal-body">
      <div style="background:linear-gradient(135deg,var(--primary),var(--teal));color:white;padding:12px 16px;border-radius:9px;font-size:13px;font-weight:700;margin-bottom:18px;">
        ⭐ Beri penilaian & dapatkan 30 SeaBiz Coin!
      </div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;">
        <img id="ratingProdImg" src="" alt="" style="width:60px;height:60px;border-radius:10px;object-fit:cover;border:1px solid var(--border);"/>
        <strong id="ratingProdName" style="font-size:14px;"></strong>
      </div>
      <div class="form-group">
        <label class="form-label">Rating</label>
        <div class="star-rating" id="starRow">
          <span onclick="setRating(1)">★</span><span onclick="setRating(2)">★</span>
          <span onclick="setRating(3)">★</span><span onclick="setRating(4)">★</span>
          <span onclick="setRating(5)">★</span>
        </div>
        <div id="ratingLabel" style="text-align:center;font-size:12.5px;color:var(--mid);font-weight:700;"></div>
      </div>
      <div class="form-group">
        <label class="form-label">Ulasan</label>
        <textarea class="form-control" id="ratingText" rows="3" placeholder="Ceritakan pengalaman belanja kamu..."></textarea>
      </div>
      <div class="modal-footer" style="padding:0;border:none;margin-top:4px;">
        <button class="btn btn-outline" onclick="closeModal('ratingModal')">Batal</button>
        <button class="btn btn-primary" onclick="submitRating()">💾 Kirim Ulasan</button>
      </div>
    </div>
  </div>
</div>


<script>
const AUTH_USER = @json($user ?? []);

function normalizeUser(user = {}) {
  return {
    id: user.id || '',
    nama: user.nama || user.name || '',
    name: user.name || user.nama || '',
    username: user.username || '',
    phone: user.phone || '',
  };
}

function getUser() {
  const authUser = AUTH_USER && Object.keys(AUTH_USER).length ? AUTH_USER : null;
  const storedRaw = localStorage.getItem('sb_user') || localStorage.getItem('seabiz_user');
  const stored = storedRaw ? JSON.parse(storedRaw) : null;
  return normalizeUser(authUser || stored || { nama: 'Pengguna', username: 'user', phone: '' });
}

function applyUserToPage(user = getUser()) {
  const name = user.nama || user.name || 'Pengguna';
  const username = user.username || 'user';
  const avatarEl = document.getElementById('sbAvatarEl');
  const nameEl = document.getElementById('sbNameEl');
  const usernameEl = document.getElementById('sbUsernameEl');
  if (nameEl) nameEl.textContent = name;
  if (usernameEl) usernameEl.textContent = username;
  if (avatarEl) avatarEl.textContent = name.charAt(0).toUpperCase() || 'U';
}

function rupiah(n) {
  return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function showToast(msg, type = 'info') {
  const el = document.getElementById('toast');
  if (!el) return;
  el.textContent = msg;
  el.style.background = type === 'error' ? '#dc2626' : type === 'success' ? '#0d9488' : '#0d3b7c';
  el.classList.add('show');
  clearTimeout(window._toastTimer);
  window._toastTimer = setTimeout(() => el.classList.remove('show'), 2500);
}

function openModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.add('open');
}

function closeModal(id) {
  const el = document.getElementById(id);
  if (el) el.classList.remove('open');
}

/* ─── Load orders: localStorage first, fallback to demo ─── */
const DEMO_ORDERS = [
  {
    id:'ORD-2025001', store:'Toko Bahari', storeCity:'Surabaya', status:'selesai', date:'12 Apr 2025',
    pembayaran:'cod', total:255000+15000, ongkir:15000, diskon:0,
    alamat:{ nama:'Budi Santoso', telepon:'081234567890', alamat:'Jl. Nelayan No. 12', kota:'Sidoarjo', kecamatan:'Waru', catatan:'' },
    items: [
      { nama:'Ikan Tuna Segar', qty:2, harga:85000, satuan:'kg', img:'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=100' },
      { nama:'Ikan Bandeng Presto', qty:1, harga:35000, satuan:'ekor', img:'https://images.unsplash.com/photo-1574484284002-952d92456975?w=100' },
    ]
  },
  {
    id:'ORD-2025002', store:'Lombok Fresh', storeCity:'Lombok', status:'dikemas', date:'8 Apr 2025',
    pembayaran:'qris', total:350000+15000, ongkir:15000, diskon:0,
    alamat:{ nama:'Budi Santoso', telepon:'081234567890', alamat:'Jl. Nelayan No. 12', kota:'Sidoarjo', kecamatan:'Waru', catatan:'' },
    items: [{ nama:'Lobster Mutiara', qty:1, harga:350000, satuan:'ekor', img:'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=100' }]
  },
  {
    id:'ORD-2025003', store:'Sari Seafood', storeCity:'Sidoarjo', status:'belum_dibayar', date:'5 Apr 2025',
    pembayaran:'bank', total:130000+15000, ongkir:15000, diskon:0,
    alamat:{ nama:'Budi Santoso', telepon:'081234567890', alamat:'Jl. Nelayan No. 12', kota:'Sidoarjo', kecamatan:'Waru', catatan:'' },
    items: [{ nama:'Udang Vaname Premium', qty:2, harga:65000, satuan:'kg', img:'https://images.unsplash.com/photo-1565680018434-b1f2c97b5d4b?w=100' }]
  },
];

let ORDERS_DATA = (window.INITIAL_ORDERS && window.INITIAL_ORDERS.length ? window.INITIAL_ORDERS : (() => {
  try {
    const saved = JSON.parse(localStorage.getItem('sb_orders') || '[]');
    if (saved && saved.length > 0) return saved;
  } catch(e) {}
  return DEMO_ORDERS;
})());

function saveOrders() {
  localStorage.setItem('sb_orders', JSON.stringify(ORDERS_DATA));
}

let activeStatus = 'all';

const STATUS_LABELS = {
  selesai:'Selesai', dikemas:'Dikemas', belum_dibayar:'Belum Dibayar',
  dikirim:'Dikirim', batal:'Dibatalkan'
};
const STATUS_PILL = {
  selesai:'sp-selesai', dikemas:'sp-dikemas', belum_dibayar:'sp-belum',
  dikirim:'sp-dikirim', batal:'sp-batal'
};

function filterOrders(s, btn) {
  activeStatus = s;
  document.querySelectorAll('.order-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderOrders();
}

const PAY_LABELS = { cod:'🚚 COD', qris:'📱 QRIS', bank:'🏦 Transfer Bank' };

function renderOrders() {
  const q = document.getElementById('orderSearch').value.toLowerCase();
  let orders = ORDERS_DATA.filter(o => {
    const matchS = activeStatus === 'all' || o.status === activeStatus;
    const matchQ = !q || o.id.toLowerCase().includes(q) || o.store.toLowerCase().includes(q) || o.items.some(i => i.nama.toLowerCase().includes(q));
    return matchS && matchQ;
  });

  if (!orders.length) {
    document.getElementById('ordersList').innerHTML = `<div style="text-align:center;padding:60px 20px;"><div style="font-size:52px;margin-bottom:14px;">📦</div><h3 style="font-family:'Poppins',sans-serif;margin-bottom:8px;">Tidak ada pesanan</h3><p style="color:var(--mid);">Mulai belanja sekarang!</p><a href="{{ route('marketplace') }}" class="btn btn-primary" style="margin-top:16px;display:inline-flex;">🛍️ Ke Marketplace</a></div>`;
    return;
  }

  document.getElementById('ordersList').innerHTML = orders.map(o => {
    // Calculate total if not stored
    const total = o.total || (o.items.reduce((s, i) => s + i.harga * i.qty, 0) + (o.ongkir||15000) - (o.diskon||0));
    const payLabel = PAY_LABELS[o.pembayaran] || o.pembayaran || '';
    const addrLine = o.alamat ? `${o.alamat.nama} · ${o.alamat.telepon} · ${o.alamat.kota}` : '';

    const btns = o.status === 'selesai'
      ? `<button class="order-btn primary" onclick="openRating('${o.id}')">⭐ Nilai</button><button class="order-btn outline" onclick="rebuyOrder('${o.id}')">🔄 Beli Lagi</button>`
      : o.status === 'belum_dibayar'
      ? `<button class="order-btn primary" onclick="showPayInfo('${o.id}')">💳 Bayar</button><button class="order-btn outline" onclick="cancelOrder('${o.id}')">Batalkan</button>`
      : o.status === 'dikemas'
      ? `<button class="order-btn outline" onclick="showToast('📍 Fitur lacak pesanan segera hadir!','warn')">📍 Lacak</button>`
      : o.status === 'dikirim'
      ? `<button class="order-btn primary" onclick="confirmReceived('${o.id}')">✅ Konfirmasi Terima</button><button class="order-btn outline" onclick="showToast('📍 Fitur lacak segera hadir!','warn')">📍 Lacak</button>`
      : '';

    return `<div class="order-store-group" id="order_${o.id}">
      <div class="order-store-header">
        <span>🏪</span>
        <div>
          <div class="order-store-name">${o.store}</div>
          <div class="order-store-loc">📍 ${o.storeCity} · ${o.id}${payLabel ? ' · '+payLabel : ''}</div>
        </div>
        <span class="status-pill ${STATUS_PILL[o.status]||'sp-batal'}">${STATUS_LABELS[o.status]||o.status}</span>
      </div>
      ${o.items.map(item => `
        <div class="order-item">
          <img class="order-item-img" src="${item.img}" alt="${item.nama}" onerror="this.style.display='none'"/>
          <div class="order-item-info">
            <div class="order-item-name">${item.nama}</div>
            <div class="order-item-meta">${item.qty} ${item.satuan}</div>
            <div class="order-item-price">${rupiah(item.harga)} <span style="font-family:'Nunito',sans-serif;font-size:12px;color:var(--mid);font-weight:600;">/ ${item.satuan}</span></div>
          </div>
        </div>`).join('')}
      ${addrLine ? `<div style="padding:8px 18px;font-size:11.5px;color:var(--mid);background:var(--bg);border-top:1px solid var(--border)">📍 ${addrLine}</div>` : ''}
      <div class="order-footer">
        <div class="order-total">Total: <strong>${rupiah(total)}</strong> · 📅 ${o.date}</div>
        <div class="order-btns">${btns}</div>
      </div>
    </div>`;
  }).join('');
}

function cancelOrder(id) {
  if (confirm(`Batalkan pesanan ${id}?`)) {
    const o = ORDERS_DATA.find(x => x.id === id);
    if (o) { o.status = 'batal'; saveOrders(); }
    renderOrders();
    showToast('❌ Pesanan dibatalkan', 'error');
  }
}

function confirmReceived(id) {
  if (confirm(`Konfirmasi pesanan ${id} sudah diterima?`)) {
    const o = ORDERS_DATA.find(x => x.id === id);
    if (o) { o.status = 'selesai'; saveOrders(); }
    renderOrders();
    showToast('✅ Pesanan selesai! Jangan lupa beri ulasan.', 'success');
  }
}

function rebuyOrder(id) {
  const o = ORDERS_DATA.find(x => x.id === id);
  if (!o) return;
  if (typeof Cart !== 'undefined') {
    o.items.forEach(item => {
      Cart.add({ id: Date.now() + Math.random(), nama: item.nama, harga: item.harga, satuan: item.satuan,
        stok: 99, penjual:'', kota:'', img: item.img, deskripsi: '' }, item.qty);
    });
    showToast('🛒 Produk ditambahkan ke keranjang!', 'success');
    setTimeout(() => window.location.href = '{{ route('keranjang') }}', 1200);
  } else {
    showToast('🔄 Fitur beli lagi segera hadir!', 'warn');
  }
}

const PAY_INFO = {
  cod:  '🚚 Bayar tunai saat kurir tiba. Siapkan uang pas.',
  qris: '📱 Scan QR Code dari WhatsApp/email. Didukung semua e-wallet.',
  bank: '🏦 Transfer ke BCA 1234567890 a/n SeaBiz Indonesia, lalu konfirmasi via WA 081-SEABIZ.'
};
function showPayInfo(id) {
  const o = ORDERS_DATA.find(x => x.id === id);
  const info = PAY_INFO[o?.pembayaran] || '💳 Silakan lakukan pembayaran sesuai metode yang dipilih.';
  alert(`💳 Cara Pembayaran — ${id}\n\n${info}`);
}

let currentRating = 5;
function openRating(orderId) {
  const o = ORDERS_DATA.find(x => x.id === orderId);
  if (!o) return;
  const item = o.items[0];
  document.getElementById('ratingProdImg').src = item.img;
  document.getElementById('ratingProdName').textContent = item.nama;
  setRating(5);
  document.getElementById('ratingText').value = '';
  openModal('ratingModal');
}

function setRating(n) {
  currentRating = n;
  const stars = document.querySelectorAll('#starRow span');
  const labels = ['','Sangat Buruk','Buruk','Cukup','Bagus','Sangat Bagus! 🎉'];
  stars.forEach((s, i) => { s.classList.toggle('active', i < n); });
  document.getElementById('ratingLabel').textContent = labels[n];
}

function submitRating() {
  closeModal('ratingModal');
  showToast(`⭐ Ulasan berhasil dikirim! Kamu mendapat 30 SeaBiz Coin`, 'success');
}

// init sidebar user info
const u = getUser();
['sbNameEl','sbUsernameEl','sbAvatarEl'].forEach(id => {
  const el = document.getElementById(id);
  if (!el) return;
  if (id === 'sbAvatarEl') el.textContent = (u.nama||'U')[0].toUpperCase();
  else if (id === 'sbNameEl') el.textContent = u.nama || 'Pengguna';
  else el.textContent = u.username || '';
});

renderOrders();
</script>
@endsection
