/* =============================================
   SeaBiz — Shared JS
   Cart, Utilities, Data, Navbar
   ============================================= */

// ======== PRODUCT DATABASE ========
const DB = {
  products: [
    { id:1,  nama:'Ikan Tuna Segar',       harga:85000,  satuan:'kg',   stok:150, kat:1, katNama:'Ikan Segar', penjual:'Toko Bahari',    kota:'Surabaya', rating:4.8, terjual:2341, badge:'Segar',       img:'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=500&q=80' },
    { id:2,  nama:'Udang Vaname Premium',  harga:65000,  satuan:'kg',   stok:80,  kat:3, katNama:'Hasil Laut', penjual:'Sari Seafood',   kota:'Sidoarjo', rating:4.9, terjual:1876, badge:'Best Seller',  img:'https://images.unsplash.com/photo-1565680018434-b1f2c97b5d4b?w=500&q=80' },
    { id:3,  nama:'Cumi-cumi Segar',       harga:45000,  satuan:'kg',   stok:200, kat:3, katNama:'Hasil Laut', penjual:'Pantai Indah',   kota:'Gresik',   rating:4.6, terjual:987,  badge:'Segar',       img:'https://images.unsplash.com/photo-1559737558-2f5a35f4523b?w=500&q=80' },
    { id:4,  nama:'Ikan Bandeng Presto',   harga:35000,  satuan:'ekor', stok:120, kat:4, katNama:'Olahan',     penjual:'Dapur Nelayan',  kota:'Sidoarjo', rating:4.7, terjual:3210, badge:'Populer',     img:'https://images.unsplash.com/photo-1574484284002-952d92456975?w=500&q=80' },
    { id:5,  nama:'Lobster Mutiara',       harga:350000, satuan:'ekor', stok:20,  kat:3, katNama:'Hasil Laut', penjual:'Lombok Fresh',   kota:'Lombok',   rating:5.0, terjual:421,  badge:'Premium',     img:'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=500&q=80' },
    { id:6,  nama:'Ikan Salmon Fillet',    harga:120000, satuan:'kg',   stok:60,  kat:1, katNama:'Ikan Segar', penjual:'Pacific Fish',   kota:'Jakarta',  rating:4.8, terjual:1543, badge:'Import',      img:'https://images.unsplash.com/photo-1612208695882-02f2322b7fee?w=500&q=80' },
    { id:7,  nama:'Kepiting Rajungan',     harga:75000,  satuan:'kg',   stok:90,  kat:3, katNama:'Hasil Laut', penjual:'Toko Bahari',    kota:'Surabaya', rating:4.7, terjual:654,  badge:'Segar',       img:'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=500&q=80' },
    { id:8,  nama:'Abon Ikan Tuna',        harga:28000,  satuan:'pcs',  stok:300, kat:4, katNama:'Olahan',     penjual:'Dapur Nelayan',  kota:'Sidoarjo', rating:4.9, terjual:4532, badge:'Terlaris',    img:'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=500&q=80' },
    { id:9,  nama:'Ikan Kembung Beku',     harga:32000,  satuan:'kg',   stok:500, kat:2, katNama:'Ikan Beku',  penjual:'Frozen Sea',     kota:'Surabaya', rating:4.5, terjual:876,  badge:'Beku',        img:'https://images.unsplash.com/photo-1535591273668-578e31182c4f?w=500&q=80' },
    { id:10, nama:'Kerupuk Ikan Tengiri',  harga:15000,  satuan:'pcs',  stok:800, kat:4, katNama:'Olahan',     penjual:'Camilan Laut',   kota:'Pasuruan', rating:4.6, terjual:5670, badge:'Olahan',      img:'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500&q=80' },
    { id:11, nama:'Ikan Kakap Merah',      harga:55000,  satuan:'kg',   stok:75,  kat:1, katNama:'Ikan Segar', penjual:'Nelayan Madura', kota:'Madura',   rating:4.8, terjual:1203, badge:'Segar',       img:'https://images.unsplash.com/photo-1606731219412-3b1e9a7c9c57?w=500&q=80' },
    { id:12, nama:'Udang Windu Jumbo',     harga:95000,  satuan:'kg',   stok:40,  kat:3, katNama:'Hasil Laut', penjual:'Tambak Prima',   kota:'Sidoarjo', rating:4.9, terjual:789,  badge:'Jumbo',       img:'https://images.unsplash.com/photo-1624992617228-a27e7a06b4ac?w=500&q=80' },
  ],
  categories: [
    { id:0, nama:'Semua', icon:'🐟' },
    { id:1, nama:'Ikan Segar', icon:'🐡' },
    { id:2, nama:'Ikan Beku', icon:'🧊' },
    { id:3, nama:'Hasil Laut', icon:'🦐' },
    { id:4, nama:'Olahan', icon:'🍱' },
    { id:5, nama:'Peralatan', icon:'🎣' },
  ],
};

// ======== USER ========
function getUser() {
  const stored = localStorage.getItem('sb_user');
  if (stored) {
    try {
      return JSON.parse(stored);
    } catch (e) {
      console.warn('Gagal membaca sb_user:', e);
    }
  }
  const defaultUser = { id: 1, nama: 'Budi Santoso', username: '_budiputra', email: 'budi@seabiz.id', role: 'pengguna', phone: '', bio: '' };
  localStorage.setItem('sb_user', JSON.stringify(defaultUser));
  return defaultUser;
}
function setUser(u) { localStorage.setItem('sb_user', JSON.stringify({ ...getUser(), ...u })); }

class ApiClient {
  static buildUrl(controller, action, params = {}) {
    const query = new URLSearchParams({ controller, action, ...params }).toString();
    return `php/index.php?${query}`;
  }

  static async request(controller, action, method = 'GET', body = null, params = {}) {
    const url = this.buildUrl(controller, action, params);
    const options = { method, headers: {} };
    if (body && ['POST', 'PUT', 'PATCH'].includes(method.toUpperCase())) {
      options.headers['Content-Type'] = 'application/json';
      options.body = JSON.stringify(body);
    }
    const res = await fetch(url, options);
    const data = await res.json().catch(() => null);
    if (!res.ok) {
      throw new Error(data?.error || `Request ${controller}/${action} gagal`);
    }
    return data;
  }
}

class AuthService {
  static async me() {
    return ApiClient.request('auth', 'me', 'GET');
  }

  static async updateProfile(payload) {
    return ApiClient.request('auth', 'update_profile', 'POST', payload);
  }

  static async changePassword(oldPassword, newPassword) {
    return ApiClient.request('auth', 'change_password', 'POST', { old_password: oldPassword, new_password: newPassword });
  }
}

class ProductService {
  static async list(search = '', kategori = 0, limit = 1000, offset = 0) {
    return ApiClient.request('product', 'list', 'GET', null, { search, kategori, limit, offset });
  }

  static async detail(id) {
    return ApiClient.request('product', 'detail', 'GET', null, { id });
  }

  static async create(data) {
    return ApiClient.request('product', 'create', 'POST', data);
  }

  static async update(id, data) {
    return ApiClient.request('product', 'update', 'PUT', data, { id });
  }

  static async softDelete(id) {
    return ApiClient.request('product', 'delete', 'DELETE', null, { id });
  }
}

class OrderService {
  static async create(payload) {
    const res = await ApiClient.request('order', 'create', 'POST', payload);
    return res;
  }

  static async list(status = '', search = '') {
    const res = await ApiClient.request('order', 'list', 'GET', null, { status, search });
    return res.data || [];
  }

  static async cancel(id) {
    return ApiClient.request('order', 'cancel', 'PUT', null, { id });
  }
}

class NotificationService {
  static async list() {
    const res = await ApiClient.request('notification', 'list', 'GET');
    return res.data || [];
  }

  static async markRead(id) {
    return ApiClient.request('notification', 'markRead', 'PUT', null, { id });
  }

  static async markAllRead() {
    return ApiClient.request('notification', 'markAllRead', 'PUT');
  }
}

// ======== CART ========
class ProductStore {
  static getAll() { return DB.products; }
  static findById(id) { return this.getAll().find(p => p.id === Number(id)); }
  static normalize(product) {
    if (!product) return null;
    return {
      id: Number(product.id),
      nama: product.nama || product.name || '',
      harga: Number(product.harga || 0),
      satuan: product.satuan || product.unit || '',
      stok: Number(product.stok || 0),
      penjual: product.penjual || product.seller || '',
      kota: product.kota || product.location || '',
      img: product.img || product.gambar_url || product.gambar || '',
      deskripsi: product.deskripsi || product.description || ''
    };
  }
}

class Cart {
  static KEY = 'sb_cart';

  static load() {
    return JSON.parse(localStorage.getItem(this.KEY) || '[]');
  }

  static save(items) {
    localStorage.setItem(this.KEY, JSON.stringify(items));
    this.syncBadge();
  }

  static getItems() {
    return this.load();
  }

  static getCount() {
    return this.getItems().reduce((sum, item) => sum + item.qty, 0);
  }

  static getTotal() {
    return this.getItems().reduce((sum, item) => sum + item.harga * item.qty, 0);
  }

  static add(product, qty = 1) {
    const normalized = ProductStore.normalize(product);
    if (!normalized || !normalized.id) return false;
    const items = this.load();
    const existing = items.find(item => item.id === normalized.id);
    if (existing) {
      existing.qty += qty;
      existing.img = existing.img || normalized.img;
    } else {
      items.push({ ...normalized, qty });
    }
    this.save(items);
    return true;
  }

  static remove(id) {
    this.save(this.getItems().filter(item => item.id !== Number(id)));
  }

  static updateQty(id, delta) {
    const items = this.load();
    const item = items.find(i => i.id === Number(id));
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) return this.remove(id);
    this.save(items);
  }

  static clear() {
    localStorage.removeItem(this.KEY);
    this.syncBadge();
  }

  static find(id) {
    return this.getItems().find(i => i.id === Number(id));
  }

  static syncBadge() {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;
    const n = this.getCount();
    badge.textContent = n > 99 ? '99+' : n;
    badge.style.display = n > 0 ? 'flex' : 'none';
  }
}

function getCart() { return Cart.getItems(); }
function saveCart(c) { Cart.save(c); }
function addToCart(produk, qty = 1) {
  if (!produk) return;
  if (!Cart.add(produk, qty)) return;
  showToast(`✅ ${produk.nama} ditambahkan ke keranjang!`);
}
function confirmAddToCart(produk, qty = 1) {
  if (!produk) return false;
  const message = qty > 1
    ? `Tambah ${qty} x ${produk.nama} ke keranjang?`
    : `Tambah ${produk.nama} ke keranjang?`;
  if (!confirm(message)) return false;
  addToCart(produk, qty);
  return true;
}

function goToCartPage() {
  const path = window.location.pathname;
  window.location.href = `${path}?page=keranjang`;
}

function addToCartAndGoCart(produk, qty = 1) {
  if (!produk) return;
  addToCart(produk, qty);
  goToCartPage();
}

function syncCartBadge() { Cart.syncBadge(); }
function removeFromCart(id) { Cart.remove(id); }
function updateQty(id, delta) { Cart.updateQty(id, delta); }
function clearCart() { Cart.clear(); }
function cartCount() { return Cart.getCount(); }
function cartTotal() { return Cart.getTotal(); }
function getCartCount() { return Cart.getCount(); }
function getCartTotal() { return Cart.getTotal(); }

function updateNavUser() {
  const u = getUser();
  const uname = document.getElementById('navUname') || document.getElementById('navUsername');
  const avatarEl = document.getElementById('navAvatar');
  const ddName = document.getElementById('ddName');
  const ddRole = document.getElementById('ddRole');
  if (uname) uname.textContent = u.username || u.nama;
  if (avatarEl) avatarEl.textContent = (u.nama || 'U')[0].toUpperCase();
  if (ddName) ddName.textContent = u.nama || '';
  if (ddRole) ddRole.textContent = u.role === 'penjual' ? '🏪 Penjual Aktif' : '🎣 Pengguna Aktif';
}

const PRODUCTS_DB = DB.products;

function doNavSearch() {
  const q = document.getElementById('navSearchInput')?.value.trim();
  if (!q) return;
  if (document.getElementById('searchPrice') && typeof renderTable === 'function') {
    document.getElementById('searchPrice').value = q;
    renderTable();
    return;
  }
  if (document.getElementById('storySearch') && typeof filterStories === 'function') {
    document.getElementById('storySearch').value = q;
    filterStories(currentFilter || 'all');
    return;
  }
  window.location.href = `?page=marketplace&q=${encodeURIComponent(q)}`;
}

// ======== TOAST ========
let _toastTimer;
function showToast(msg, type = 'default') {
  let t = document.getElementById('sb-toast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'sb-toast';
    document.body.appendChild(t);
  }
  t.textContent = msg;
  t.style.background = type === 'error' ? '#e53935' : type === 'warn' ? '#fb8c00' : type === 'success' ? '#1abc9c' : '#0d3b7c';
  t.classList.add('show');
  clearTimeout(_toastTimer);
  _toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
}

// ======== FORMAT ========
function rupiah(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }
function stars(r) {
  const full = Math.round(r);
  return '★'.repeat(full) + '☆'.repeat(5 - full);
}

// ======== NAVBAR INIT ========
document.addEventListener('DOMContentLoaded', async () => {
  syncCartBadge();
  updateNavUser();

  try {
    const response = await AuthService.me();
    if (response.user) {
      setUser(response.user);
      updateNavUser();
    }
  } catch (err) {
    // Tidak ada sesi aktif atau API belum tersedia
  }

  // Nav search sync
  const navInp = document.getElementById('navSearchInput');
  if (navInp) {
    navInp.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        const q = navInp.value.trim();
        if (q) window.location.href = `?page=marketplace&q=${encodeURIComponent(q)}`;
      }
    });
  }
});

function confirmNavigation(message, url) {
  if (!confirm(message)) return false;
  if (url) window.location.href = url;
  return true;
}

document.addEventListener('click', e => {
  const btn = e.target.closest('[data-confirm]');
  if (!btn) return;
  const message = btn.dataset.confirm;
  if (!message) return;
  if (!confirm(message)) {
    e.preventDefault();
    e.stopPropagation();
  }
});

// ======== COMING SOON (Seller features) ========
function showComingSoon(feature) {
  const feature_name = feature || 'Fitur Penjual';
  showToast(`🔔 ${feature_name} — Coming Soon! Fitur untuk penjual/nelayan sedang dalam pengembangan.`, 'warn');
  // Also show modal if available
  const m = document.getElementById('comingSoonModal');
  if (m) {
    document.getElementById('csFeatureName').textContent = feature_name;
    m.classList.add('open');
  }
}

// ======== MODAL HELPERS ========
function openModal(id) { document.getElementById(id)?.classList.add('open'); }
function closeModal(id) { document.getElementById(id)?.classList.remove('open'); }
window.addEventListener('click', e => {
  document.querySelectorAll('.modal-backdrop.open').forEach(m => {
    if (e.target === m) m.classList.remove('open');
  });
});

// ======== ORDER STORE ========
class OrderStore {
  static KEY = 'sb_orders';

  static getAll() {
    try { return JSON.parse(localStorage.getItem(this.KEY) || '[]'); }
    catch(e) { return []; }
  }

  static add(order) {
    const orders = this.getAll();
    orders.unshift(order);
    localStorage.setItem(this.KEY, JSON.stringify(orders));
  }

  static cancel(id) {
    const orders = this.getAll();
    const o = orders.find(x => x.id === id);
    if (o) { o.status = 'batal'; localStorage.setItem(this.KEY, JSON.stringify(orders)); }
  }

  static save(orders) {
    localStorage.setItem(this.KEY, JSON.stringify(orders));
  }

  static generateId() {
    const d = new Date();
    const y = d.getFullYear();
    const m = String(d.getMonth()+1).padStart(2,'0');
    const day = String(d.getDate()).padStart(2,'0');
    return `ORD-${y}${m}${day}-${Math.floor(Math.random()*9000+1000)}`;
  }
}

// ======== VOUCHER STORE ========
const VoucherStore = {
  VOUCHERS: { NELAYAN10: 10000, IKAN20: 20000, SEABIZ: 15000, UMKM30: 30000 },
  save(code, amount) { localStorage.setItem('sb_voucher', JSON.stringify({ code, amount })); },
  load() { try { return JSON.parse(localStorage.getItem('sb_voucher') || 'null'); } catch(e) { return null; } },
  clear() { localStorage.removeItem('sb_voucher'); },
  apply(code) {
    const upper = (code||'').toUpperCase().trim();
    if (this.VOUCHERS[upper]) {
      this.save(upper, this.VOUCHERS[upper]);
      return { valid: true, code: upper, amount: this.VOUCHERS[upper] };
    }
    this.clear();
    return { valid: false };
  }
};
