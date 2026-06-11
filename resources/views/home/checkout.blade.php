@extends('layouts.app')

@section('title', 'Checkout — SeaBiz')

@section('styles')
<style>
/* ── Layout ── */
.co-wrap{max-width:1100px;margin:0 auto;padding:20px 20px 40px}
.co-breadcrumb{display:flex;align-items:center;gap:8px;margin-bottom:18px;font-size:13px;color:var(--mid)}
.co-breadcrumb a{color:var(--primary);font-weight:700;text-decoration:none}
.co-breadcrumb a:hover{text-decoration:underline}
.co-breadcrumb .sep{color:var(--border)}
.co-grid{display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start}
@media(max-width:860px){.co-grid{grid-template-columns:1fr}}

/* ── Section Cards ── */
.co-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);margin-bottom:14px;overflow:hidden;box-shadow:var(--shadow-xs)}
.co-card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--bg),#fff)}
.co-card-header h3{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:var(--primary-deep);margin:0}
.co-card-body{padding:20px}

/* ── Steps indicator ── */
.co-steps{display:flex;align-items:center;gap:0;margin-bottom:22px;background:#fff;border:1px solid var(--border);border-radius:50px;padding:5px 5px;width:fit-content}
.co-step{display:flex;align-items:center;gap:6px;padding:7px 18px;border-radius:50px;font-size:12.5px;font-weight:700;color:var(--mid);transition:.2s}
.co-step.done{color:var(--teal)}
.co-step.active{background:var(--primary-deep);color:#fff}
.co-step-num{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;background:rgba(255,255,255,.25);flex-shrink:0}
.co-step.done .co-step-num{background:var(--teal);color:#fff}
.co-step-sep{width:24px;height:2px;background:var(--border);border-radius:2px}

/* ── Form ── */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
@media(max-width:500px){.form-row{grid-template-columns:1fr}}
.co-label{display:block;font-size:12px;font-weight:800;color:var(--mid);margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px}
.co-input{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:9px;font-size:13.5px;font-family:'Nunito',sans-serif;color:var(--text);background:#fff;outline:none;transition:.2s;box-sizing:border-box}
.co-input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(24,144,255,.12)}
.co-input.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1)}
.co-input::placeholder{color:#b0bec5}
.co-textarea{resize:vertical;min-height:72px}
.co-form-group{margin-bottom:14px}
.co-form-group:last-child{margin-bottom:0}
.error-msg{color:#ef4444;font-size:11px;font-weight:700;margin-top:4px;display:none}

/* ── Payment methods ── */
.pay-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
@media(max-width:500px){.pay-grid{grid-template-columns:1fr}}
.pay-card{border:2px solid var(--border);border-radius:12px;padding:14px 12px;cursor:pointer;transition:.2s;text-align:center;background:#fff;user-select:none;position:relative}
.pay-card:hover{border-color:var(--primary);background:#f8fbff}
.pay-card.selected{border-color:var(--primary-deep);background:linear-gradient(135deg,#eff6ff,#e8f4fd)}
.pay-card.selected::after{content:'✓';position:absolute;top:6px;right:8px;font-size:11px;font-weight:900;color:var(--primary-deep)}
.pay-icon{font-size:24px;margin-bottom:6px}
.pay-name{font-size:12.5px;font-weight:800;color:var(--text);margin-bottom:2px}
.pay-desc{font-size:10.5px;color:var(--mid);line-height:1.4}

/* ── Voucher ── */
.voucher-row{display:flex;gap:8px}
.voucher-row .co-input{border-radius:9px 0 0 9px;border-right:0;text-transform:uppercase;letter-spacing:.6px;font-weight:700}
.btn-voucher{padding:11px 18px;background:var(--primary-deep);color:#fff;border:1.5px solid var(--primary-deep);border-radius:0 9px 9px 0;font-size:13px;font-weight:800;cursor:pointer;white-space:nowrap;transition:.2s;font-family:'Nunito',sans-serif}
.btn-voucher:hover{background:var(--primary-mid)}
.voucher-result{margin-top:8px;padding:8px 12px;border-radius:8px;font-size:12px;font-weight:700;display:none}
.voucher-result.ok{background:#d1fae5;color:#065f46}
.voucher-result.err{background:#fee2e2;color:#991b1b}
.voucher-chips{display:flex;gap:6px;flex-wrap:wrap;margin-top:10px}
.voucher-chip{padding:4px 10px;background:var(--bg);border:1.5px dashed var(--border);border-radius:20px;font-size:11px;font-weight:700;color:var(--mid);cursor:pointer;transition:.15s}
.voucher-chip:hover{border-color:var(--primary);color:var(--primary);background:#eff6ff}

/* ── Summary ── */
.sum-sticky{position:sticky;top:80px}
.sum-items-list{margin-bottom:14px}
.sum-item{display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--border)}
.sum-item:last-child{border-bottom:none}
.sum-item img{width:52px;height:52px;border-radius:8px;object-fit:cover;border:1px solid var(--border);flex-shrink:0}
.sum-item-info{flex:1;min-width:0}
.sum-item-name{font-size:12.5px;font-weight:700;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.sum-item-meta{font-size:11px;color:var(--mid);margin-top:1px}
.sum-item-price{font-size:13px;font-weight:800;color:var(--primary-dark);white-space:nowrap}
.sum-rows{margin-top:4px}
.sum-row{display:flex;justify-content:space-between;font-size:13px;padding:6px 0}
.sum-row .lbl{color:var(--mid)}
.sum-row .val{font-weight:700}
.sum-row.discount .val{color:var(--teal)}
.sum-divider{height:1px;background:var(--border);margin:10px 0}
.sum-total-row{display:flex;justify-content:space-between;padding:8px 0;font-weight:800}
.sum-total-row .lbl{font-size:14px;color:var(--text)}
.sum-total-row .val{font-family:'Poppins',sans-serif;font-size:18px;color:var(--primary-deep)}

/* ── Place order button ── */
.btn-place{width:100%;padding:16px;border:none;border-radius:12px;font-size:15px;font-weight:800;font-family:'Poppins',sans-serif;cursor:pointer;transition:.2s;letter-spacing:.3px;background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;margin-top:16px;box-shadow:0 4px 12px rgba(13,148,136,.3)}
.btn-place:hover{opacity:.9;transform:translateY(-2px);box-shadow:0 6px 18px rgba(13,148,136,.4)}
.btn-place:active{transform:translateY(0)}
.btn-place:disabled{opacity:.5;cursor:not-allowed;transform:none;box-shadow:none}
.secure-badge{display:flex;align-items:center;justify-content:center;gap:6px;font-size:11.5px;color:var(--mid);margin-top:10px;font-weight:600}

/* ── Empty cart redirect ── */
.co-empty{text-align:center;padding:60px 20px;background:#fff;border-radius:var(--radius-lg);border:1px solid var(--border)}
.co-empty .ico{font-size:56px;margin-bottom:16px}

/* ── Toast ── */
.co-toast{position:fixed;bottom:20px;right:20px;background:#0d3b7c;color:#fff;padding:12px 16px;border-radius:10px;font-size:13px;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;pointer-events:none}
.co-toast.show{transform:translateY(0);opacity:1}

/* ── Loading overlay ── */
.co-loading{position:fixed;inset:0;background:rgba(255,255,255,.85);display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:9999;gap:14px;display:none}
.co-spinner{width:44px;height:44px;border:4px solid var(--border);border-top-color:var(--primary-deep);border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

/* ── Success overlay ── */
.co-success{position:fixed;inset:0;background:rgba(13,59,124,.92);display:flex;align-items:center;justify-content:center;z-index:9999;display:none}
.co-success-box{background:#fff;border-radius:20px;padding:40px 36px;text-align:center;max-width:400px;width:90%}
.co-success-anim{font-size:64px;margin-bottom:12px;animation:pop .4s cubic-bezier(.34,1.56,.64,1)}
@keyframes pop{from{transform:scale(0)}to{transform:scale(1)}}
.co-success-box h2{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--primary-deep);margin-bottom:8px}
.co-success-box p{color:var(--mid);font-size:13.5px;line-height:1.6;margin-bottom:6px}
.co-success-id{font-family:'Poppins',sans-serif;font-size:15px;font-weight:800;color:var(--teal);margin:14px 0}
.co-success-btn{display:inline-block;padding:12px 28px;background:var(--primary-deep);color:#fff;border-radius:10px;font-size:14px;font-weight:800;text-decoration:none;margin-top:8px;transition:.2s}
.co-success-btn:hover{background:var(--primary-mid)}
</style>
@endsection

@section('content')
<div class="co-wrap">

  {{-- Breadcrumb --}}
  <div class="co-breadcrumb">
    <a href="{{ route('marketplace') }}">🏪 Marketplace</a>
    <span class="sep">›</span>
    <a href="{{ route('keranjang') }}">🛒 Keranjang</a>
    <span class="sep">›</span>
    <span style="color:var(--text);font-weight:700">Checkout</span>
  </div>

  {{-- Step Indicator --}}
  <div class="co-steps">
    <div class="co-step done"><div class="co-step-num">✓</div> Keranjang</div>
    <div class="co-step-sep"></div>
    <div class="co-step active"><div class="co-step-num">2</div> Checkout</div>
    <div class="co-step-sep"></div>
    <div class="co-step"><div class="co-step-num">3</div> Selesai</div>
  </div>

  {{-- Empty cart guard (shows if JS detects empty cart) --}}
  <div id="emptyGuard" style="display:none">
    <div class="co-empty">
      <div class="ico">🛒</div>
      <h3 style="font-family:'Poppins',sans-serif;margin-bottom:8px">Keranjang Kosong</h3>
      <p style="color:var(--mid);margin-bottom:20px">Tambahkan produk ke keranjang terlebih dahulu.</p>
      <a href="{{ route('marketplace') }}" class="btn btn-primary">🛍️ Mulai Belanja</a>
    </div>
  </div>

  {{-- Main checkout grid --}}
  <div class="co-grid" id="checkoutGrid" style="display:none">

    {{-- ─── LEFT: Forms ─── --}}
    <div>

      {{-- 1. Informasi Penerima --}}
      <div class="co-card">
        <div class="co-card-header"><h3>👤 Informasi Penerima</h3></div>
        <div class="co-card-body">
          <div class="form-row">
            <div class="co-form-group">
              <label class="co-label">Nama Penerima <span style="color:#ef4444">*</span></label>
              <input type="text" id="recvName" class="co-input" placeholder="Nama lengkap penerima"/>
              <div class="error-msg" id="err-recvName">Nama penerima wajib diisi</div>
            </div>
            <div class="co-form-group">
              <label class="co-label">Nomor Telepon <span style="color:#ef4444">*</span></label>
              <input type="tel" id="recvPhone" class="co-input" placeholder="08xx-xxxx-xxxx"/>
              <div class="error-msg" id="err-recvPhone">Nomor telepon wajib diisi</div>
            </div>
          </div>
        </div>
      </div>

      {{-- 2. Alamat Pengiriman --}}
      <div class="co-card">
        <div class="co-card-header"><h3>📍 Alamat Pengiriman</h3></div>
        <div class="co-card-body">
          <div class="co-form-group">
            <label class="co-label">Alamat Lengkap <span style="color:#ef4444">*</span></label>
            <textarea id="recvAddress" class="co-input co-textarea" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan..."></textarea>
            <div class="error-msg" id="err-recvAddress">Alamat pengiriman wajib diisi</div>
          </div>
          <div class="form-row">
            <div class="co-form-group">
              <label class="co-label">Kota / Kabupaten <span style="color:#ef4444">*</span></label>
              <input type="text" id="recvCity" class="co-input" placeholder="Contoh: Sidoarjo"/>
              <div class="error-msg" id="err-recvCity">Kota wajib diisi</div>
            </div>
            <div class="co-form-group">
              <label class="co-label">Kecamatan</label>
              <input type="text" id="recvDistrict" class="co-input" placeholder="Contoh: Waru"/>
            </div>
          </div>
          <div class="co-form-group">
            <label class="co-label">Catatan untuk Kurir <span style="color:var(--mid);font-weight:600">(opsional)</span></label>
            <input type="text" id="recvNote" class="co-input" placeholder="Warna pagar, patokan, instruksi khusus..."/>
          </div>
        </div>
      </div>

      {{-- 3. Metode Pembayaran --}}
      <div class="co-card">
        <div class="co-card-header"><h3>💳 Metode Pembayaran</h3></div>
        <div class="co-card-body">
          <div class="pay-grid" id="payGrid">
            <div class="pay-card selected" data-method="cod" onclick="selectPayment(this,'cod')">
              <div class="pay-icon">🚚</div>
              <div class="pay-name">COD</div>
              <div class="pay-desc">Bayar di tempat saat barang tiba</div>
            </div>
            <div class="pay-card" data-method="qris" onclick="selectPayment(this,'qris')">
              <div class="pay-icon">📱</div>
              <div class="pay-name">QRIS</div>
              <div class="pay-desc">Scan QR • GoPay, OVO, Dana, dll</div>
            </div>
            <div class="pay-card" data-method="bank" onclick="selectPayment(this,'bank')">
              <div class="pay-icon">🏦</div>
              <div class="pay-name">Transfer Bank</div>
              <div class="pay-desc">BCA, BNI, BRI, Mandiri, BSI</div>
            </div>
          </div>
          <div id="payDetail" style="margin-top:14px;padding:12px;background:var(--bg);border-radius:10px;font-size:12.5px;color:var(--mid);display:none"></div>
        </div>
      </div>

      {{-- 4. Voucher --}}
      <div class="co-card">
        <div class="co-card-header"><h3>🎟️ Kode Voucher</h3></div>
        <div class="co-card-body">
          <div class="voucher-row">
            <input type="text" id="voucherInput" class="co-input" placeholder="Masukkan kode voucher" style="text-transform:uppercase;border-radius:9px 0 0 9px;border-right:0"/>
            <button class="btn-voucher" onclick="applyVoucher()">Pakai</button>
          </div>
          <div id="voucherResult" class="voucher-result"></div>
          <div class="voucher-chips">
            <span class="voucher-chip" onclick="tryVoucher('NELAYAN10')">🎁 NELAYAN10 (-10rb)</span>
            <span class="voucher-chip" onclick="tryVoucher('IKAN20')">🎁 IKAN20 (-20rb)</span>
            <span class="voucher-chip" onclick="tryVoucher('SEABIZ')">🎁 SEABIZ (-15rb)</span>
            <span class="voucher-chip" onclick="tryVoucher('UMKM30')">🎁 UMKM30 (-30rb)</span>
          </div>
        </div>
      </div>

    </div>{{-- end LEFT --}}

    {{-- ─── RIGHT: Summary ─── --}}
    <div class="sum-sticky">
      <div class="co-card">
        <div class="co-card-header">
          <h3>🛒 Ringkasan Pesanan</h3>
          <span id="sumBadge" style="margin-left:auto;background:#e0f2fe;color:#0369a1;border-radius:10px;padding:2px 9px;font-size:11px;font-weight:800">0 item</span>
        </div>
        <div class="co-card-body" style="padding:14px 16px">
          <div class="sum-items-list" id="summaryItems"></div>
          <div class="sum-rows">
            <div class="sum-row">
              <span class="lbl">Subtotal (<span id="sumQty">0</span> item)</span>
              <span class="val" id="sumSubtotal">Rp 0</span>
            </div>
            <div class="sum-row">
              <span class="lbl">Ongkos Kirim</span>
              <span class="val" id="sumOngkir">Rp 15.000</span>
            </div>
            <div class="sum-row discount" id="discountRow" style="display:none">
              <span class="lbl">Diskon Voucher</span>
              <span class="val" id="sumDiskon">- Rp 0</span>
            </div>
          </div>
          <div class="sum-divider"></div>
          <div class="sum-total-row">
            <span class="lbl">Total Pembayaran</span>
            <span class="val" id="sumTotal">Rp 0</span>
          </div>
          <button class="btn-place" id="btnPlace" onclick="placeOrder()">
            ✅ Pesan Sekarang
          </button>
          <div class="secure-badge">🔒 Transaksi aman &amp; terenkripsi</div>
          <div style="margin-top:12px;font-size:11.5px;color:var(--mid);line-height:2">
            ✅ Gratis retur 7 hari<br>
            ✅ Produk segar terjamin<br>
            ✅ Same-day delivery tersedia
          </div>
        </div>
      </div>
    </div>

  </div>{{-- end co-grid --}}
</div>

{{-- Loading overlay --}}
<div id="coLoading" class="co-loading">
  <div class="co-spinner"></div>
  <p style="font-size:14px;font-weight:700;color:var(--primary-deep)">Memproses pesanan...</p>
</div>

{{-- Toast --}}
<div id="coToast" class="co-toast"></div>

{{-- Success overlay --}}
<div id="coSuccess" class="co-success">
  <div class="co-success-box">
    <div class="co-success-anim">🎉</div>
    <h2 id="successTitle">Pesanan Berhasil!</h2>
    <p id="successMessage">Pesanan kamu telah kami terima.<br>Segera diproses oleh penjual.</p>
    <div class="co-success-id" id="successOrderId">ORD-XXXXXXXXXX</div>
    <div id="paymentInstructions" style="display:none;background:#f8fafc;border:1px solid var(--border);border-radius:10px;padding:12px 14px;margin:12px 0;text-align:left;font-size:12.5px;color:var(--text)"></div>
    <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px">
      <button id="confirmPaymentBtn" class="co-success-btn" style="display:none" onclick="confirmPayment()">✅ Saya Sudah Bayar</button>
      <a href="{{ route('pesanan') }}" class="co-success-btn" id="viewOrdersBtn">📦 Lihat Pesanan Saya</a>
    </div>
  </div>
</div>

<script>
/* ─── State ─── */
let cart = [];
let discount = 0;
let voucherCode = '';
let selectedPayment = 'cod';
let pendingOrderId = '';
const ONGKIR = 15000;
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const fallbackImg = "{{ asset('assets/img/nelayan.jpg') }}";

function getCart() {
  try { return JSON.parse(localStorage.getItem('seabiz_cart') || '[]'); } catch(e) { return []; }
}

function clearCart() {
  localStorage.removeItem('seabiz_cart');
}

function getUser() {
  try {
    return JSON.parse(localStorage.getItem('seabiz_user') || 'null') || { nama: 'Pengguna', phone: '', username: 'user' };
  } catch(e) {
    return { nama: 'Pengguna', phone: '', username: 'user' };
  }
}

const VoucherStore = {
  load() {
    try { return JSON.parse(localStorage.getItem('seabiz_voucher') || 'null'); } catch(e) { return null; }
  },
  save(code, amount) {
    localStorage.setItem('seabiz_voucher', JSON.stringify({ code, amount }));
  },
  clear() {
    localStorage.removeItem('seabiz_voucher');
  },
  apply(code) {
    const vouchers = { NELAYAN10: 10000, IKAN20: 20000, SEABIZ: 15000, UMKM30: 30000 };
    const c = (code || '').trim().toUpperCase();
    if (vouchers[c]) {
      this.save(c, vouchers[c]);
      return { valid: true, code: c, amount: vouchers[c] };
    }
    this.clear();
    return { valid: false, code: c, amount: 0 };
  }
};

const OrderStore = {
  generateId() {
    return 'ORD-' + Date.now();
  },
  add(order) {
    try {
      const orders = JSON.parse(localStorage.getItem('sb_orders') || '[]');
      orders.unshift(order);
      localStorage.setItem('sb_orders', JSON.stringify(orders));
    } catch(e) {}
  }
};

function showToast(msg, type = 'info') {
  const el = document.getElementById('coToast');
  if (!el) return;
  el.textContent = msg;
  el.style.background = type === 'error' ? '#dc2626' : type === 'success' ? '#0d9488' : '#0d3b7c';
  el.classList.add('show');
  clearTimeout(window._coToastTimer);
  window._coToastTimer = setTimeout(() => el.classList.remove('show'), 2500);
}

function showPaymentSuccess(orderId, method, paymentCode) {
  pendingOrderId = orderId;
  document.getElementById('successOrderId').textContent = orderId;
  const title = document.getElementById('successTitle');
  const message = document.getElementById('successMessage');
  const instructions = document.getElementById('paymentInstructions');
  const confirmBtn = document.getElementById('confirmPaymentBtn');
  const viewBtn = document.getElementById('viewOrdersBtn');

  if (method === 'qris') {
    title.textContent = 'Pembayaran QRIS';
    message.innerHTML = 'Silakan bayar melalui QRIS berikut. Setelah pembayaran diterima, pesanan Anda akan langsung dikemas.';
    instructions.innerHTML = `<strong>Kode QRIS</strong><div style="margin-top:6px;font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:var(--primary-deep)">${paymentCode}</div><div style="margin-top:6px;color:var(--mid)">Tunjukkan kode ini saat melakukan pembayaran.</div>`;
    instructions.style.display = 'block';
    confirmBtn.style.display = 'inline-block';
    viewBtn.style.display = 'none';
  } else if (method === 'bank') {
    title.textContent = 'Pembayaran Transfer Bank';
    message.innerHTML = 'Silakan transfer ke rekening berikut. Setelah kami menerima pembayaran, pesanan Anda akan dikemas.';
    instructions.innerHTML = `<strong>Transfer ke</strong><div style="margin-top:6px;font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:var(--primary-deep)">BCA 1234567890 a/n SeaBiz</div><div style="margin-top:6px;color:var(--mid)">Kode pembayaran: <strong>${paymentCode}</strong></div>`;
    instructions.style.display = 'block';
    confirmBtn.style.display = 'inline-block';
    viewBtn.style.display = 'none';
  } else {
    title.textContent = 'Pesanan Berhasil!';
    message.innerHTML = 'Pesanan kamu telah kami terima.<br>Segera diproses oleh penjual.';
    instructions.style.display = 'none';
    confirmBtn.style.display = 'none';
    viewBtn.style.display = 'inline-block';
  }

  document.getElementById('coSuccess').style.display = 'flex';
}

function confirmPayment() {
  if (!pendingOrderId) return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  fetch('{{ route('checkout.confirm-payment') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify({ order_id: pendingOrderId }),
  })
    .then(res => res.json())
    .then(data => {
      if (!data.success) throw new Error('Gagal mengonfirmasi pembayaran');
      window.location.href = '{{ route('pesanan') }}';
    })
    .catch(err => {
      showToast(err.message || 'Gagal mengonfirmasi pembayaran', 'error');
    });
}

/* ─── Init ─── */
document.addEventListener('DOMContentLoaded', function() {
  cart = getCart();

  if (!cart.length) {
    document.getElementById('emptyGuard').style.display = 'block';
    document.getElementById('checkoutGrid').style.display = 'none';
    return;
  }

  document.getElementById('checkoutGrid').style.display = 'grid';

  // Pre-fill name from user profile
  const user = getUser();
  if (user) {
    const nameEl = document.getElementById('recvName');
    if (nameEl && !nameEl.value) nameEl.value = user.nama || '';
    const phoneEl = document.getElementById('recvPhone');
    if (phoneEl && !phoneEl.value) phoneEl.value = user.phone || '';
  }

  // Load saved voucher from keranjang
  const saved = VoucherStore.load();
  if (saved && saved.code) {
    discount = saved.amount;
    voucherCode = saved.code;
    document.getElementById('voucherInput').value = saved.code;
    showVoucherResult(true, saved.code, saved.amount);
  }

  renderSummary();
  showPayDetail('cod');
});

/* ─── Summary ─── */
function renderSummary() {
  const subtotal = cart.reduce((s,i) => s+i.harga*i.qty, 0);
  const qty      = cart.reduce((s,i) => s+i.qty, 0);
  const total    = subtotal + ONGKIR - discount;

  document.getElementById('sumBadge').textContent = qty + ' item';
  document.getElementById('sumQty').textContent   = qty;
  document.getElementById('sumSubtotal').textContent = rp(subtotal);
  document.getElementById('sumOngkir').textContent   = rp(ONGKIR);
  document.getElementById('sumTotal').textContent    = rp(Math.max(0, total));

  const discRow = document.getElementById('discountRow');
  if (discount > 0) {
    discRow.style.display = 'flex';
    document.getElementById('sumDiskon').textContent = '- ' + rp(discount);
  } else {
    discRow.style.display = 'none';
  }

  // Items
  const html = cart.map(item => `
    <div class="sum-item">
      <img src="${item.img}" alt="${item.nama}" onerror="this.src='${fallbackImg}'" />
      <div class="sum-item-info">
        <div class="sum-item-name">${item.nama}</div>
        <div class="sum-item-meta">${item.qty} × ${rp(item.harga)} / ${item.satuan}</div>
      </div>
      <div class="sum-item-price">${rp(item.harga * item.qty)}</div>
    </div>`).join('');
  document.getElementById('summaryItems').innerHTML = html;
}

/* ─── Payment ─── */
function selectPayment(el, method) {
  document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  selectedPayment = method;
  showPayDetail(method);
}

const PAY_DETAILS = {
  cod:  '🚚 Siapkan uang tunai saat kurir tiba. Tidak ada biaya tambahan untuk COD.',
  qris: '📱 Scan QR Code yang akan dikirim via WhatsApp/email. Didukung semua e-wallet & m-banking.',
  bank: '🏦 Transfer ke rekening: BCA 1234567890 a/n SeaBiz Indonesia. Konfirmasi via WhatsApp setelah transfer.'
};
function showPayDetail(method) {
  const el = document.getElementById('payDetail');
  el.innerHTML = PAY_DETAILS[method] || '';
  el.style.display = 'block';
}

/* ─── Voucher ─── */
function tryVoucher(code) {
  document.getElementById('voucherInput').value = code;
  applyVoucher();
}

function applyVoucher() {
  const code = (document.getElementById('voucherInput').value || '').trim().toUpperCase();
  const result = VoucherStore.apply(code);
  if (result.valid) {
    discount    = result.amount;
    voucherCode = result.code;
    showVoucherResult(true, result.code, result.amount);
  } else {
    discount    = 0;
    voucherCode = '';
    showVoucherResult(false);
  }
  renderSummary();
}

function showVoucherResult(valid, code, amount) {
  const el = document.getElementById('voucherResult');
  if (valid) {
    el.textContent = `✅ Voucher "${code}" berhasil! Hemat ${rp(amount)}`;
    el.className = 'voucher-result ok';
  } else {
    el.textContent = '❌ Kode voucher tidak valid. Coba kode lain.';
    el.className = 'voucher-result err';
  }
  el.style.display = 'block';
}

/* ─── Validation ─── */
function validateForm() {
  let ok = true;
  const fields = [
    { id:'recvName',    err:'err-recvName',    msg:'Nama penerima wajib diisi' },
    { id:'recvPhone',   err:'err-recvPhone',   msg:'Nomor telepon wajib diisi' },
    { id:'recvAddress', err:'err-recvAddress', msg:'Alamat pengiriman wajib diisi' },
    { id:'recvCity',    err:'err-recvCity',    msg:'Kota wajib diisi' },
  ];
  fields.forEach(f => {
    const inp  = document.getElementById(f.id);
    const errEl = document.getElementById(f.err);
    if (!inp.value.trim()) {
      inp.classList.add('error');
      if (errEl) { errEl.textContent = f.msg; errEl.style.display = 'block'; }
      ok = false;
    } else {
      inp.classList.remove('error');
      if (errEl) errEl.style.display = 'none';
    }
  });
  return ok;
}

/* ─── Place Order ─── */
function placeOrder() {
  if (!validateForm()) {
    // Scroll to first error
    const firstErr = document.querySelector('.co-input.error');
    if (firstErr) firstErr.scrollIntoView({ behavior:'smooth', block:'center' });
    showToast('⚠️ Lengkapi data pengiriman terlebih dahulu', 'warn');
    return;
  }

  // Build order payload
  const subtotal  = cart.reduce((s,i) => s+i.harga*i.qty, 0);
  const totalBayar = Math.max(0, subtotal + ONGKIR - discount);
  const orderPayload = {
    items: cart.map(item => ({
      nama: item.nama,
      qty: item.qty,
      harga: item.harga,
      satuan: item.satuan,
      img: item.img,
    })),
    address: {
      nama: document.getElementById('recvName').value.trim(),
      telepon: document.getElementById('recvPhone').value.trim(),
      alamat: document.getElementById('recvAddress').value.trim(),
      kota: document.getElementById('recvCity').value.trim(),
      kecamatan: document.getElementById('recvDistrict').value.trim(),
      catatan: document.getElementById('recvNote').value.trim(),
    },
    payment_method: selectedPayment,
    voucher_code: voucherCode,
    discount_amount: discount,
    shipping_fee: ONGKIR,
    subtotal,
    total: totalBayar,
  };

  // Show loading
  document.getElementById('coLoading').style.display = 'flex';
  document.getElementById('btnPlace').disabled = true;

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  fetch('{{ route('checkout.place-order') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify(orderPayload),
  })
    .then(res => res.json())
    .then(data => {
      if (!data.success) throw new Error('Gagal menyimpan pesanan');
      clearCart();
      VoucherStore.clear();
      document.getElementById('coLoading').style.display = 'none';
      showPaymentSuccess(data.order_id || 'ORD-XXXX', data.payment_method || selectedPayment, data.payment_code || '');
    })
    .catch(err => {
      document.getElementById('coLoading').style.display = 'none';
      document.getElementById('btnPlace').disabled = false;
      showToast(err.message || 'Gagal memproses pesanan', 'error');
    });
}

// Remove error class on input
document.querySelectorAll('.co-input').forEach(inp => {
  inp.addEventListener('input', function() {
    this.classList.remove('error');
    const errId = 'err-' + this.id;
    const errEl = document.getElementById(errId);
    if (errEl) errEl.style.display = 'none';
  });
});
</script>
@endsection
