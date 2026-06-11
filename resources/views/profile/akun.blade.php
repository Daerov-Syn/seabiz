@extends('layouts.app')

@section('title', 'Akun Saya — SeaBiz')

@section('styles')
<style>
.stats-strip { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:22px; }
.stat-box { background:white; border:1px solid var(--border); border-radius:var(--radius); padding:16px; text-align:center; box-shadow:var(--shadow-xs); }
.profile-avatar-big img, .sidebar-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; display:block; }
.stat-box .si { font-size:26px; margin-bottom:6px; }
.stat-box strong { display:block; font-family:'Poppins',sans-serif; font-size:1.4rem; font-weight:800; color:var(--primary-dark); }
.stat-box span { font-size:11.5px; color:var(--mid); font-weight:600; }

.profile-top { display:flex; align-items:center; gap:18px; padding:18px; background:linear-gradient(135deg,var(--bg2),var(--bg)); border-radius:var(--radius); margin-bottom:22px; border:1px solid var(--border); }
.profile-avatar-big { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,var(--primary),var(--primary-dark)); display:flex; align-items:center; justify-content:center; font-size:34px; font-weight:900; color:white; border:3px solid white; box-shadow:var(--shadow-sm); flex-shrink:0; }
.profile-info h3 { font-family:'Poppins',sans-serif; font-size:1.05rem; font-weight:800; margin-bottom:3px; }
.profile-info p { font-size:12.5px; color:var(--mid); margin-bottom:8px; }
.btn-change-photo { padding:7px 14px; border:1.5px solid var(--primary); border-radius:7px; color:var(--primary); background:white; font-size:12px; font-weight:700; cursor:pointer; transition:.2s; font-family:'Nunito',sans-serif; }
.btn-change-photo:hover { background:var(--primary); color:white; }

/* Password strength */
.pw-strength-bar { height:4px; border-radius:2px; margin-top:6px; background:var(--border); transition:.3s; }
.pw-strength-bar.weak { background:#ef4444; width:33%; }
.pw-strength-bar.medium { background:#f59e0b; width:66%; }
.pw-strength-bar.strong { background:#22c55e; width:100%; }

/* Address cards */
.addr-card { background:var(--bg); border:1.5px solid var(--border); border-radius:var(--radius); padding:16px; display:flex; gap:14px; margin-bottom:10px; transition:.2s; }
.addr-card:hover, .addr-card.default { border-color:var(--primary); }
.addr-card.default { background:#eff6ff; }
.addr-icon-big { font-size:26px; flex-shrink:0; margin-top:2px; }
.addr-body { flex:1; }
.addr-name { font-weight:800; font-size:13.5px; margin-bottom:2px; }
.addr-phone { font-size:12px; color:var(--mid); margin-bottom:5px; }
.addr-text { font-size:13px; color:var(--text); line-height:1.5; }
.addr-default-tag { display:inline-block; background:#dbeafe; color:var(--primary-dark); font-size:10.5px; font-weight:800; padding:2px 8px; border-radius:4px; margin-top:5px; }
.addr-actions { display:flex; flex-direction:column; gap:6px; flex-shrink:0; }
.addr-action-btn { padding:6px 12px; border-radius:7px; font-size:11.5px; font-weight:700; cursor:pointer; border:1.5px solid var(--border); background:white; transition:.2s; font-family:'Nunito',sans-serif; }
.addr-action-btn:hover { border-color:var(--primary); color:var(--primary); }
.addr-action-btn.del:hover { border-color:var(--red); color:var(--red); }

/* Recent orders */
.recent-order-row { display:flex; align-items:center; gap:12px; padding:13px; border:1px solid var(--border); border-radius:var(--radius); margin-bottom:8px; transition:.2s; cursor:pointer; }
.recent-order-row:hover { border-color:var(--primary); background:var(--bg2); }
.ro-thumb { width:50px; height:50px; border-radius:8px; object-fit:cover; flex-shrink:0; border:1px solid var(--border); }
.ro-info { flex:1; }
.ro-name { font-size:13px; font-weight:700; margin-bottom:2px; }
.ro-date { font-size:11.5px; color:var(--mid); }
.ro-status-pill { padding:4px 10px; border-radius:20px; font-size:11px; font-weight:800; }
.st-selesai { background:#d1fae5; color:#065f46; }
.st-proses  { background:#fef3c7; color:#92400e; }
.st-batal   { background:#fee2e2; color:#991b1b; }

@media(max-width:640px) { .stats-strip { grid-template-columns:repeat(2,1fr); } }
</style>
@endsection

@section('content')
<!-- NAVBAR -->

<div class="account-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-top">
      <div class="sidebar-avatar" id="sbAvatarEl">B</div>
      <div class="sidebar-name" id="sbNameEl">Budi Santoso</div>
      <div class="sidebar-username" id="sbUsernameEl">_budiputra</div>
    </div>
    <nav class="sidebar-nav">
      <a class="sidebar-link active" onclick="switchTab('info',null);document.querySelectorAll('.sidebar-link').forEach(l=>l.classList.remove('active'));this.classList.add('active')">
        <span class="sl-icon">👤</span> Info Pribadi
      </a>
      <a class="sidebar-link" onclick="switchTab('sandi',null);document.querySelectorAll('.sidebar-link').forEach(l=>l.classList.remove('active'));this.classList.add('active')">
        <span class="sl-icon">🔒</span> Ganti Password
      </a>
      <a class="sidebar-link" onclick="switchTab('alamat',null);document.querySelectorAll('.sidebar-link').forEach(l=>l.classList.remove('active'));this.classList.add('active')">
        <span class="sl-icon">📍</span> Alamat Saya
      </a>
      <a class="sidebar-link" onclick="switchTab('riwayat',null);document.querySelectorAll('.sidebar-link').forEach(l=>l.classList.remove('active'));this.classList.add('active')">
        <span class="sl-icon">📦</span> Riwayat Pesanan
      </a>
      <div class="sidebar-divider"></div>
      <a class="sidebar-link" href="{{ route('marketplace') }}">
        <span class="sl-icon">🏪</span> Marketplace
      </a>
      <a class="sidebar-link" href="{{ route('keranjang') }}">
        <span class="sl-icon">🛒</span> Keranjang
      </a>
      <div class="sidebar-divider"></div>
      <a class="sidebar-link" style="color:var(--red)"
         href="{{ route('logout') }}"
         onclick="event.preventDefault();document.getElementById('logoutFormProfile').submit()">
        <span class="sl-icon">🚪</span> Keluar
      </a>
    </nav>
    <form id="logoutFormProfile" action="{{ route('logout') }}" method="POST" style="display:none">
      @csrf
    </form>
  </aside>

  <!-- MAIN -->
  <div>
    <!-- Stats -->
    <div class="stats-strip">
      <div class="stat-box"><div class="si">📦</div><strong id="statOrders">3</strong><span>Pesanan</span></div>
      <div class="stat-box"><div class="si">⭐</div><strong>12</strong><span>Ulasan</span></div>
      <div class="stat-box"><div class="si">💰</div><strong>250</strong><span>Coin</span></div>
      <div class="stat-box"><div class="si">🎫</div><strong>3</strong><span>Voucher</span></div>
    </div>

    <div class="content-box">
      <!-- Tabs -->
      <div class="content-box-header" style="padding-bottom:0;border-bottom:none;">
        <div class="tabs-bar" style="width:100%;border-bottom:none;">
          <button class="tab-btn active" id="tab-btn-info" onclick="switchTab('info',this)">👤 Info Pribadi</button>
          <button class="tab-btn" id="tab-btn-sandi" onclick="switchTab('sandi',this)">🔒 Ganti Password</button>
          <button class="tab-btn" id="tab-btn-alamat" onclick="switchTab('alamat',this)">📍 Alamat</button>
          <button class="tab-btn" id="tab-btn-riwayat" onclick="switchTab('riwayat',this)">📦 Riwayat</button>
        </div>
      </div>

      <div style="padding:22px 24px;">

        <!-- TAB: INFO PRIBADI -->
        <div class="tab-panel active" id="tab-info">
          <div class="profile-top">
            <div class="profile-avatar-big" id="profileAvatar">B</div>
            <div class="profile-info">
              <h3 id="profileName">Budi Santoso</h3>
              <p>Pengguna Aktif · Bergabung sejak 2024</p>
              <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">
                <input type="file" id="avatarInput" accept="image/*" style="display:none" onchange="previewAvatar(event)">
                <label class="btn-change-photo" for="avatarInput" style="display:inline-block;">📷 Ganti Foto</label>
                <button type="button" class="btn btn-outline btn-sm" onclick="showSellerModal()" id="sellerActionBtn">🏪 Daftar Sebagai Penjual</button>
              </div>
            </div>
          </div>

          <form id="profileForm" onsubmit="saveInfo(event)" enctype="multipart/form-data">
                    @csrf
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="fNama" placeholder="Nama lengkap" required/>
              </div>
              <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" id="fUsername" placeholder="@username"/>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="fEmail" placeholder="email@contoh.com"/>
              </div>
              <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="tel" class="form-control" id="fPhone" placeholder="08xxxxxxxxxx"/>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="fBirthdate"/>
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="fGender">
                  <option value="">Pilih...</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Bio</label>
              <textarea class="form-control" id="fBio" rows="2" placeholder="Ceritakan tentang Anda..."></textarea>
            </div>
            <div style="display:flex;gap:10px;">
              <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
              <button type="button" class="btn btn-outline" onclick="loadUserData()">↺ Reset</button>
            </div>
          </form>
        </div>

        <!-- TAB: GANTI PASSWORD -->
        <div class="tab-panel" id="tab-sandi">
          <div style="max-width:440px;">
            <div style="background:var(--bg2);border-radius:var(--radius);padding:14px 16px;margin-bottom:22px;font-size:13px;color:var(--mid);border:1px solid var(--border);">
              🔒 Password harus minimal 8 karakter, kombinasikan huruf besar, kecil, angka, dan simbol untuk keamanan terbaik.
            </div>
            <form onsubmit="changePassword(event)">
                    @csrf
              <div class="form-group">
                <label class="form-label">Password Lama</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="fOldPw" placeholder="Masukkan password saat ini" required/>
                  <button type="button" class="input-addon" onclick="toggleVisibility('fOldPw',this)">👁️</button>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Password Baru</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="fNewPw" placeholder="Minimal 8 karakter" required oninput="checkPwStrength()"/>
                  <button type="button" class="input-addon" onclick="toggleVisibility('fNewPw',this)">👁️</button>
                </div>
                <div class="pw-strength-bar" id="pwBar"></div>
                <div id="pwLabel" style="font-size:11.5px;margin-top:4px;font-weight:700;"></div>
              </div>
              <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="fConfPw" placeholder="Ulangi password baru" required/>
                  <button type="button" class="input-addon" onclick="toggleVisibility('fConfPw',this)">👁️</button>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">🔒 Ubah Password</button>
            </form>
          </div>
        </div>

        <!-- TAB: ALAMAT -->
        <div class="tab-panel" id="tab-alamat">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <span style="font-weight:800;font-size:14px;">Daftar Alamat Pengiriman</span>
            <button class="btn btn-primary btn-sm" onclick="showToast('📍 Form tambah alamat — segera hadir!','warn')">+ Tambah Alamat</button>
          </div>
          <div id="addrList"></div>
        </div>

        <!-- TAB: RIWAYAT -->
        <div class="tab-panel" id="tab-riwayat">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <span style="font-weight:800;font-size:14px;">Riwayat Pesanan Terbaru</span>
            <a href="{{ route('pesanan') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
          </div>
          <div id="recentOrdersList"></div>
        </div>

      </div><!-- end padding -->
    </div><!-- end content-box -->
  </div>
</div>

<div class="modal-backdrop" id="sellerModal">
  <div class="modal-box" style="max-width:480px;">
    <div class="modal-header">
      <span class="modal-title">🏪 Daftar Sebagai Penjual</span>
      <button class="modal-close-btn" onclick="closeModal('sellerModal')">✕</button>
    </div>
    <div class="modal-body">
      <form action="{{ route('seller.upgrade') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Nama Toko</label>
          <input class="form-control" type="text" name="seller_name" id="sellerNameInput" placeholder="Contoh: SeaFresh Store" required>
        </div>
        <div class="form-group">
          <label class="form-label">Deskripsi Toko</label>
          <textarea class="form-control" name="seller_description" rows="3" placeholder="Jelaskan produk dan keunggulan toko Anda"></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Nomor Telepon</label>
          <input class="form-control" type="text" name="seller_phone" id="sellerPhoneInput" placeholder="08xxxxxxxxxx">
        </div>
        <div class="form-group">
          <label class="form-label">Alamat Toko</label>
          <textarea class="form-control" name="seller_address" rows="2" placeholder="Alamat toko / lokasi"></textarea>
        </div>
        <div style="display:flex; gap:10px; justify-content:flex-end;">
          <button type="button" class="btn btn-outline" onclick="closeModal('sellerModal')">Batal</button>
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Coming Soon Modal -->
<div class="modal-backdrop" id="comingSoonModal">
  <div class="modal-box" style="max-width:400px;">
    <div class="modal-header"><span class="modal-title">🔔 Pemberitahuan</span><button class="modal-close-btn" onclick="closeModal('comingSoonModal')">✕</button></div>
    <div class="modal-body"><div style="text-align:center;padding:16px 0;">
      <div style="font-size:52px;margin-bottom:14px;">🚀</div>
      <div style="font-family:'Poppins',sans-serif;font-size:1.2rem;font-weight:800;color:var(--primary-deep);margin-bottom:10px;">Coming Soon!</div>
      <p style="color:var(--mid);font-size:13.5px;line-height:1.7;margin-bottom:20px;">Fitur <strong id="csFeatureName">ini</strong> untuk Penjual & Nelayan sedang dalam pengembangan aktif.</p>
      <button class="btn btn-primary" onclick="closeModal('comingSoonModal');showToast('✅ Kamu akan diberitahu saat fitur ini siap!','success')">🔔 Beritahu Saya</button>
    </div></div>
  </div>
</div>


<script>
const AUTH_USER = @json($currentUser ?? []);
const PROFILE_UPDATE_URL = '{{ route('profile.update') }}';
const PROFILE_PASSWORD_URL = '{{ route('profile.password') }}';
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

function normalizeUser(user = {}) {
  return {
    id: user.id || '',
    nama: user.nama || user.name || '',
    name: user.name || user.nama || '',
    username: user.username || '',
    email: user.email || '',
    phone: user.phone || '',
    bio: user.bio || '',
    avatar: user.avatar || '',
    birthdate: user.birth_date || user.birthdate || '',
    gender: user.gender || '',
  };
}

function getUser() {
  const storedRaw = localStorage.getItem('sb_user') || localStorage.getItem('seabiz_user');
  const stored = storedRaw ? JSON.parse(storedRaw) : null;
  const base = AUTH_USER && Object.keys(AUTH_USER).length ? AUTH_USER : (stored || {});
  return normalizeUser(base);
}

function setUser(user) {
  const normalized = normalizeUser(user);
  window.AUTH_USER = normalized;
  localStorage.setItem('sb_user', JSON.stringify(normalized));
  localStorage.setItem('seabiz_user', JSON.stringify(normalized));
  return normalized;
}

function renderAvatar(user) {
  const avatarEl = document.getElementById('profileAvatar');
  const sbAvatarEl = document.getElementById('sbAvatarEl');
  const initial = (user.nama || user.name || 'U')[0].toUpperCase();
  const avatarSrc = user.avatar ? `{{ asset('storage') }}/${user.avatar}` : '';

  if (avatarSrc) {
    avatarEl.innerHTML = `<img src="${avatarSrc}" alt="Foto profil">`;
    sbAvatarEl.innerHTML = `<img src="${avatarSrc}" alt="Foto profil">`;
  } else {
    avatarEl.textContent = initial;
    sbAvatarEl.textContent = initial;
  }
}

// Tab switching
function switchTab(name, btn) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + name)?.classList.add('active');
  if (btn) btn.classList.add('active');
  else document.getElementById('tab-btn-' + name)?.classList.add('active');

  // sync sidebar
  document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
}

// Load user data into form
function showSellerModal() {
  const u = getUser();
  const sellerNameInput = document.getElementById('sellerNameInput');
  const sellerPhoneInput = document.getElementById('sellerPhoneInput');
  if (sellerNameInput) sellerNameInput.value = u.nama || '';
  if (sellerPhoneInput) sellerPhoneInput.value = u.phone || '';
  openModal('sellerModal');
}

function loadUserData() {
  const u = getUser();
  document.getElementById('fNama').value = u.nama || '';
  document.getElementById('fUsername').value = u.username || '';
  document.getElementById('fEmail').value = u.email || '';
  document.getElementById('fPhone').value = u.phone || '';
  document.getElementById('fBirthdate').value = u.birthdate || '';
  document.getElementById('fGender').value = u.gender || '';
  document.getElementById('fBio').value = u.bio || '';
  document.getElementById('profileName').textContent = u.nama || 'Pengguna';
  document.getElementById('sbNameEl').textContent = u.nama || 'Pengguna';
  document.getElementById('sbUsernameEl').textContent = u.username || '';
  const sellerBtn = document.getElementById('sellerActionBtn');
  if (sellerBtn) {
    sellerBtn.textContent = u.role === 'penjual' ? '🏪 Lihat Profil Penjual' : '🏪 Daftar Sebagai Penjual';
    sellerBtn.onclick = u.role === 'penjual' ? () => window.location.href = '{{ route('seller.profile') }}' : showSellerModal;
  }
  renderAvatar(u);
}

function previewAvatar(event) {
  const file = event.target.files && event.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function (e) {
    const avatarEl = document.getElementById('profileAvatar');
    avatarEl.innerHTML = `<img src="${e.target.result}" alt="Pratinjau foto profil">`;
  };
  reader.readAsDataURL(file);
}

async function saveInfo(e) {
  e.preventDefault();
  const formData = new FormData();
  const avatarInput = document.getElementById('avatarInput');
  const name = document.getElementById('fNama').value.trim();
  const username = document.getElementById('fUsername').value.trim();
  const email = document.getElementById('fEmail').value.trim();
  const phone = document.getElementById('fPhone').value.trim();
  const birthdate = document.getElementById('fBirthdate').value;
  const gender = document.getElementById('fGender').value;
  const bio = document.getElementById('fBio').value.trim();

  formData.append('name', name);
  formData.append('username', username);
  formData.append('email', email);
  formData.append('phone', phone);
  formData.append('birth_date', birthdate);
  formData.append('gender', gender);
  formData.append('bio', bio);

  if (avatarInput.files && avatarInput.files[0]) {
    formData.append('avatar', avatarInput.files[0]);
  }

  try {
    const res = await fetch(PROFILE_UPDATE_URL, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
      body: formData,
    });
    const data = await res.json();
    if (!res.ok || !data.success) throw new Error(data.error || 'Gagal menyimpan profil');
    setUser(data.user);
    loadUserData();
    showToast('✅ Profil berhasil disimpan!', 'success');
    avatarInput.value = '';
  } catch (err) {
    showToast(err.message || 'Gagal menyimpan profil', 'error');
  }
}

function toggleVisibility(id, btn) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  btn.textContent = inp.type === 'password' ? '👁️' : '🙈';
}

function checkPwStrength() {
  const pw = document.getElementById('fNewPw').value;
  const bar = document.getElementById('pwBar');
  const lbl = document.getElementById('pwLabel');
  if (!pw) { bar.className = 'pw-strength-bar'; lbl.textContent = ''; return; }
  const isStrong = pw.length >= 8 && /[A-Z]/.test(pw) && /[0-9]/.test(pw) && /[^A-Za-z0-9]/.test(pw);
  const isMedium = pw.length >= 6;
  if (isStrong) { bar.className = 'pw-strength-bar strong'; lbl.textContent = '✅ Password kuat'; lbl.style.color = '#22c55e'; }
  else if (isMedium) { bar.className = 'pw-strength-bar medium'; lbl.textContent = '⚠️ Password sedang'; lbl.style.color = '#f59e0b'; }
  else { bar.className = 'pw-strength-bar weak'; lbl.textContent = '❌ Password lemah'; lbl.style.color = '#ef4444'; }
}

async function changePassword(e) {
  e.preventDefault();
  const oldPw = document.getElementById('fOldPw').value;
  const newPw = document.getElementById('fNewPw').value;
  const confPw = document.getElementById('fConfPw').value;
  if (!oldPw) { showToast('Masukkan password lama', 'error'); return; }
  if (newPw.length < 8) { showToast('Password baru minimal 8 karakter', 'error'); return; }
  if (newPw !== confPw) { showToast('Konfirmasi password tidak cocok!', 'error'); return; }
  try {
    const res = await fetch(PROFILE_PASSWORD_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
      },
      body: JSON.stringify({ current_password: oldPw, password: newPw, password_confirmation: confPw }),
    });
    const d = await res.json();
    if (!res.ok || d.error) throw new Error(d.error || 'Gagal mengubah password');
    ['fOldPw','fNewPw','fConfPw'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('pwBar').className = 'pw-strength-bar';
    document.getElementById('pwLabel').textContent = '';
    showToast('🔒 Password berhasil diubah!', 'success');
  } catch (err) {
    showToast(err.message || 'Gagal mengubah password', 'error');
  }
}

// Addresses
const ADDRESSES = [
  { id:1, icon:'🏠', name:'Budi Santoso', phone:'081234567890', text:'Jl. Nelayan No. 12, RT 03/RW 02, Sidokare, Sidoarjo, Jawa Timur 61219', isDefault:true },
  { id:2, icon:'🏢', name:'Budi (Kantor)', phone:'081234567890', text:'Jl. Ahmad Yani No. 45, Sekardangan, Sidoarjo, Jawa Timur 61200', isDefault:false },
];
document.getElementById('addrList').innerHTML = ADDRESSES.map(a => `
  <div class="addr-card ${a.isDefault ? 'default' : ''}">
    <div class="addr-icon-big">${a.icon}</div>
    <div class="addr-body">
      <div class="addr-name">${a.name}</div>
      <div class="addr-phone">📞 ${a.phone}</div>
      <div class="addr-text">${a.text}</div>
      ${a.isDefault ? '<span class="addr-default-tag">✅ Alamat Utama</span>' : ''}
    </div>
    <div class="addr-actions">
      <button class="addr-action-btn" onclick="showToast('✏️ Edit alamat segera hadir!','warn')">✏️ Edit</button>
      ${!a.isDefault ? `<button class="addr-action-btn del" onclick="showToast('🗑️ Alamat dihapus','success')">🗑️ Hapus</button>` : ''}
    </div>
  </div>`).join('');

// Recent orders — baca dari localStorage atau demo
const DEMO_RECENT = [
  { img:'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=100', name:'Ikan Tuna Segar 2kg', date:'12 Apr 2025', total:'Rp 170.000', status:'selesai' },
  { img:'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=100', name:'Lobster Mutiara 1 ekor', date:'8 Apr 2025', total:'Rp 350.000', status:'proses' },
  { img:'https://images.unsplash.com/photo-1565680018434-b1f2c97b5d4b?w=100', name:'Udang Vaname 1kg', date:'1 Apr 2025', total:'Rp 65.000', status:'batal' },
];

function getRecentOrders() {
  try {
    const saved = JSON.parse(localStorage.getItem('sb_orders') || '[]');
    if (saved && saved.length > 0) {
      return saved.slice(0, 3).map(o => {
        const firstItem = o.items && o.items[0];
        const name = firstItem
          ? `${firstItem.nama}${o.items.length > 1 ? ' +' + (o.items.length-1) + ' lainnya' : ''}`
          : o.id;
        const img = firstItem ? firstItem.img : '';
        const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
        const statusMap = { selesai:'selesai', dikemas:'proses', dikirim:'proses', belum_dibayar:'proses', batal:'batal', dikembalikan:'batal' };
        return {
          img,
          name,
          date: o.date || '-',
          total: rp(o.total || 0),
          status: statusMap[o.status] || 'proses'
        };
      });
    }
  } catch(e) {}
  return DEMO_RECENT;
}

const RECENT_ORDERS = getRecentOrders();
document.getElementById('recentOrdersList').innerHTML = RECENT_ORDERS.map(o => `
  <div class="recent-order-row" onclick="location.href = '{{ route('pesanan') }}'">
    <img class="ro-thumb" src="${o.img}" alt="" onerror="this.style.display='none'"/>
    <div class="ro-info">
      <div class="ro-name">${o.name}</div>
      <div class="ro-date">📅 ${o.date} · ${o.total}</div>
    </div>
    <span class="ro-status-pill st-${o.status}">${{selesai:'✅ Selesai',proses:'⏳ Diproses',batal:'❌ Dibatalkan'}[o.status]||o.status}</span>
  </div>`).join('');

loadUserData();
</script>
@endsection
