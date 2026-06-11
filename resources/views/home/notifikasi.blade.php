@extends('layouts.app')

@section('title', 'Notifikasi — SeaBiz')

@section('styles')
<style>
.notif-item { display:flex; gap:14px; align-items:flex-start; padding:16px 18px; border-bottom:1px solid var(--border); transition:.2s; cursor:pointer; position:relative; }
.notif-item:hover { background:var(--bg); }
.notif-item.unread { background:#eff6ff; }
.notif-item.unread::before { content:''; position:absolute; left:0; top:0; bottom:0; width:3px; background:var(--primary); border-radius:0 2px 2px 0; }
.notif-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; }
.ni-success { background:#d1fae5; }
.ni-info    { background:#dbeafe; }
.ni-warn    { background:#fef3c7; }
.ni-error   { background:#fee2e2; }
.notif-content { flex:1; }
.notif-title { font-size:13.5px; font-weight:800; margin-bottom:3px; color:var(--text); }
.notif-msg { font-size:12.5px; color:var(--mid); line-height:1.6; }
.notif-time { font-size:11px; color:var(--muted); margin-top:4px; font-weight:600; }
.notif-unread-dot { width:8px; height:8px; border-radius:50%; background:var(--primary); flex-shrink:0; margin-top:6px; }
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
        <span class="content-box-title">🔔 Notifikasi</span>
        <button class="btn btn-sm" style="border:1.5px solid var(--border);background:white;" onclick="markAllRead()">✅ Tandai Semua Dibaca</button>
      </div>
      <div id="notifList"></div>
    </div>
  </div>
</div>


<script>
const NOTIFS = [
  { id:1, icon:'📦', type:'success', title:'Pesanan Dikonfirmasi', msg:'Pesanan #ORD-2025001 telah dikonfirmasi oleh Toko Bahari. Estimasi pengiriman 1-2 hari.', time:'2 jam lalu', read:false },
  { id:2, icon:'🎁', type:'info', title:'Promo Flash Sale! 30% Off', msg:'Dapatkan diskon 30% untuk semua produk ikan segar hari ini saja. Jangan sampai ketinggalan!', time:'5 jam lalu', read:false },
  { id:3, icon:'⭐', type:'success', title:'Pesanan Selesai & Minta Ulasan', msg:'Pesanan #ORD-2025002 telah selesai. Berikan penilaian dan dapatkan 30 SeaBiz Coin!', time:'1 hari lalu', read:false },
  { id:4, icon:'🔒', type:'warn', title:'Login Baru Terdeteksi', msg:'Ada login baru dari perangkat baru pada Rabu 12 Apr 2025. Bukan kamu? Segera ganti password.', time:'2 hari lalu', read:true },
  { id:5, icon:'🚀', type:'info', title:'Fitur Baru: Cerita UMKM', msg:'Kini kamu bisa membaca kisah inspiratif para nelayan dan pengusaha UMKM perikanan lokal!', time:'3 hari lalu', read:true },
  { id:6, icon:'🎉', type:'success', title:'Selamat Datang di SeaBiz!', msg:'Akun kamu berhasil dibuat. Mulai jelajahi ribuan produk perikanan segar dari seluruh Indonesia.', time:'1 minggu lalu', read:true },
];

const TYPE_CLS = { success:'ni-success', info:'ni-info', warn:'ni-warn', error:'ni-error' };

function renderNotifs() {
  document.getElementById('notifList').innerHTML = NOTIFS.map(n => `
    <div class="notif-item ${n.read ? '' : 'unread'}" onclick="markRead(${n.id})">
      <div class="notif-icon ${TYPE_CLS[n.type] || 'ni-info'}">${n.icon}</div>
      <div class="notif-content">
        <div class="notif-title">${n.title}</div>
        <div class="notif-msg">${n.msg}</div>
        <div class="notif-time">${n.time}</div>
      </div>
      ${n.read ? '' : '<div class="notif-unread-dot"></div>'}
    </div>`).join('');
}

function markRead(id) {
  const n = NOTIFS.find(x => x.id === id);
  if (n) n.read = true;
  renderNotifs();
}

function markAllRead() {
  NOTIFS.forEach(n => n.read = true);
  renderNotifs();
  showToast('✅ Semua notifikasi ditandai dibaca', 'success');
}

const u = getUser();
['sbNameEl','sbUsernameEl','sbAvatarEl'].forEach(id => {
  const el = document.getElementById(id);
  if (!el) return;
  if (id === 'sbAvatarEl') el.textContent = (u.nama||'U')[0].toUpperCase();
  else if (id === 'sbNameEl') el.textContent = u.nama || 'Pengguna';
  else el.textContent = u.username || '';
});

renderNotifs();
</script>
@endsection
