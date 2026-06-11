@extends('layouts.app')

@section('title', 'Info Harga — SeaBiz')

@section('styles')
<style>
*{box-sizing:border-box}
:root{
  --ocean-deep:#0d3b7c;--ocean-mid:#0d9488;--ocean-bright:#0d9488;--ocean-pale:#e0f7f4;
  --border:#e2e8f0;--bg:#f8fafc;--bg2:#f1f5f9;--text:#0f172a;--mid:#64748b;
  --radius:16px;--radius-lg:20px;--shadow-sm:0 2px 8px rgba(15,23,42,.06);--shadow-md:0 8px 24px rgba(15,23,42,.1);
  --red:#dc2626;--gold:#f59e0b;
}
body{font-family:'Nunito',sans-serif;background:#f8fafc;color:#0f172a;font-size:14px}
.topnav{background:#0d3b7c;color:#fff;padding:12px 20px;display:flex;align-items:center;gap:12px;position:sticky;top:0;z-index:100;box-shadow:0 4px 20px rgba(13,59,124,.3)}
.nav-logo{font-family:'Poppins',sans-serif;font-weight:800;font-size:16px;color:#fff;text-decoration:none;display:flex;align-items:center;gap:6px;white-space:nowrap}
.nav-search{flex:1;max-width:300px;display:flex;align-items:center;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);border-radius:20px;padding:6px 12px;gap:6px}
.nav-search input{background:transparent;border:none;outline:none;color:#fff;font-size:13px;width:100%;font-family:'Nunito',sans-serif}
.nav-search input::placeholder{color:rgba(255,255,255,.6)}
.nav-search button{background:none;border:none;color:rgba(255,255,255,.8);cursor:pointer;font-size:15px}
.nav-links{display:flex;gap:6px;margin-left:auto}
.nav-link{color:rgba(255,255,255,.8);text-decoration:none;font-size:13px;font-weight:600;padding:6px 10px;border-radius:8px;transition:.15s}
.nav-link:hover,.nav-link.active{color:#fff;background:rgba(255,255,255,.15)}
.nav-cart{position:relative;text-decoration:none;color:#fff;padding:8px 10px;background:rgba(255,255,255,.15);border-radius:8px;font-size:13px;display:flex;align-items:center;gap:4px;transition:.15s}
.nav-cart:hover{background:rgba(255,255,255,.25)}
.cart-badge{background:#ef4444;color:#fff;border-radius:10px;font-size:10px;padding:1px 5px;font-weight:700;display:none}
.nav-user{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.85);font-size:13px;font-weight:600}
.nav-avatar{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.2);display:grid;place-items:center;font-size:16px}

.page-inner { max-width:1200px; margin:28px auto; padding:0 20px; }

/* Page header */
.price-hero {
  background:linear-gradient(135deg, var(--ocean-deep), #1a6a8a);
  border-radius:var(--radius); padding:32px 36px; margin-bottom:24px;
  position:relative; overflow:hidden;
}
.price-hero::before {
  content:''; position:absolute; right:0; top:0; bottom:0; width:50%;
  background-image:url('assets/img/nelayan.jpg');
  background-size:cover; background-position:center; opacity:.15;
}
.price-hero h1 { font-family:'Fraunces',serif; font-size:1.8rem; color:white; font-weight:700; margin-bottom:8px; }
.price-hero p { color:rgba(255,255,255,.65); font-size:14px; }
.price-hero-stats { display:flex; gap:24px; margin-top:20px; }
.price-stat {
  background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
  border-radius:10px; padding:12px 20px; color:white;
}
.price-stat strong { display:block; font-family:'Fraunces',serif; font-size:1.4rem; }
.price-stat span { font-size:12px; opacity:.65; }
.last-update { position:absolute; top:20px; right:24px; background:rgba(26,188,156,.2); border:1px solid rgba(26,188,156,.4); border-radius:8px; padding:6px 14px; color:var(--ocean-bright); font-size:12px; font-weight:600; z-index:1; }

/* Filter row */
.filter-row {
  display:flex; gap:12px; align-items:center; margin-bottom:20px; flex-wrap:wrap;
}
.filter-row select, .filter-row input {
  padding:10px 14px; border:1.5px solid var(--border); border-radius:10px;
  font-size:13px; font-family:'Plus Jakarta Sans',sans-serif; outline:none; color:var(--text);
  background:white;
}
.filter-row select:focus, .filter-row input:focus { border-color:var(--ocean-bright); }
.filter-row .search-box { flex:1; min-width:200px; }

/* Price cards (top) */
.price-highlights { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
.price-hi-card {
  background:white; border:1.5px solid var(--border); border-radius:var(--radius);
  padding:18px; transition:.25s; cursor:pointer;
}
.price-hi-card:hover { box-shadow:var(--shadow-md); border-color:rgba(26,188,156,.3); transform:translateY(-3px); }
.hi-fish { font-size:36px; margin-bottom:10px; }
.hi-name { font-size:13px; font-weight:700; margin-bottom:6px; }
.hi-price { font-family:'Fraunces',serif; font-size:1.5rem; font-weight:700; color:var(--ocean-mid); }
.hi-unit { font-size:11px; color:var(--mid); }
.hi-trend {
  display:inline-flex; align-items:center; gap:4px; margin-top:8px;
  font-size:12px; font-weight:700; padding:3px 8px; border-radius:6px;
}
.trend-up { background:#fef2f2; color:#dc2626; }
.trend-down { background:#f0fdf4; color:#16a34a; }
.trend-stable { background:#f8fafc; color:var(--mid); }

/* Table */
.price-table-wrap {
  background:white; border:1px solid var(--border); border-radius:var(--radius);
  overflow:hidden; box-shadow:var(--shadow-sm); margin-bottom:24px;
}
.table-header {
  padding:18px 24px; border-bottom:1px solid var(--border);
  display:flex; align-items:center; justify-content:space-between;
  background:var(--bg);
}
.table-header h3 { font-family:'Fraunces',serif; font-size:1rem; font-weight:700; }
.btn-download { padding:8px 16px; background:var(--ocean-pale); color:var(--ocean-mid); border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; }

table { width:100%; border-collapse:collapse; }
thead { background:var(--ocean-deep); color:white; }
thead th { padding:12px 16px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; white-space:nowrap; }
tbody tr { border-bottom:1px solid var(--border); transition:.15s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:#f8fcff; }
tbody td { padding:14px 16px; font-size:13px; }
.td-fish { display:flex; align-items:center; gap:10px; }
.td-fish img { width:40px; height:40px; object-fit:cover; border-radius:8px; border:1px solid var(--border); }
.td-fish strong { display:block; font-weight:700; font-size:13px; }
.td-fish span { font-size:11px; color:var(--mid); }
.td-price { font-family:'Fraunces',serif; font-size:15px; font-weight:700; color:var(--ocean-mid); }
.td-change { font-size:12px; font-weight:700; }
.change-up { color:#dc2626; }
.change-down { color:#16a34a; }
.status-badge { padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.status-aktif { background:#d1fae5; color:#065f46; }
.status-langka { background:#fee2e2; color:#991b1b; }
.status-normal { background:#dbeafe; color:#1e3a8a; }

/* Chart area */
.chart-section {
  background:white; border:1px solid var(--border); border-radius:var(--radius);
  padding:24px; box-shadow:var(--shadow-sm); margin-bottom:24px;
}
.chart-section h3 { font-family:'Fraunces',serif; font-size:1rem; font-weight:700; margin-bottom:20px; }
.chart-pills { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.chart-pill {
  padding:6px 14px; border-radius:20px; border:1.5px solid var(--border);
  background:white; font-size:12px; font-weight:700; cursor:pointer; transition:.2s;
}
.chart-pill.active { background:var(--ocean-mid); border-color:var(--ocean-mid); color:white; }

.chart-svg-wrap { overflow-x:auto; }
svg.price-chart { font-family:'Plus Jakarta Sans',sans-serif; }

/* Pasar references */
.pasar-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
.pasar-card {
  background:white; border:1px solid var(--border); border-radius:var(--radius); padding:18px;
}
.pasar-card h4 { font-weight:700; font-size:13px; margin-bottom:4px; }
.pasar-card .loc { font-size:11px; color:var(--mid); margin-bottom:12px; }
.pasar-item { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px dashed var(--border); font-size:12px; }
.pasar-item:last-child { border-bottom:none; }
.pasar-item .pname { color:var(--text); }
.pasar-item .pprice { font-weight:700; color:var(--ocean-mid); }

@media(max-width:900px) {
  .price-highlights { grid-template-columns:repeat(2,1fr); }
  .pasar-grid { grid-template-columns:1fr; }
}
@media(max-width:600px) {
  .price-highlights { grid-template-columns:repeat(2,1fr); }
  .price-hero-stats { flex-wrap:wrap; }
  .filter-row { flex-direction:column; align-items:stretch; }
  table { font-size:12px; }
  thead th { padding:10px; }
  tbody td { padding:10px; }
}
</style>
@endsection

@section('content')
<div class="page-inner">

  <!-- Hero -->
  <div class="price-hero">
    <span class="last-update">🔄 Update: <span id="updateTime"></span></span>
    <h1>💰 Info Harga Ikan</h1>
    <p>Pantau harga pasar ikan & hasil laut terkini dari berbagai daerah Indonesia</p>
    <div class="price-hero-stats">
      <div class="price-stat"><strong>47</strong><span>Jenis Ikan</span></div>
      <div class="price-stat"><strong>23</strong><span>Kota Referensi</span></div>
      <div class="price-stat"><strong>Hari Ini</strong><span>Terakhir Update</span></div>
    </div>
  </div>

  <!-- Filter -->
  <div class="filter-row">
    <input class="search-box" type="text" id="searchPrice" placeholder="🔍 Cari nama ikan..." oninput="renderTable()"/>
    <select id="filterKat" onchange="renderTable()">
      <option value="">Semua Jenis</option>
      <option value="segar">Ikan Segar</option>
      <option value="laut">Hasil Laut</option>
      <option value="olahan">Olahan</option>
    </select>
    <select id="filterKota" onchange="renderTable()">
      <option value="">Semua Kota</option>
      <option value="Surabaya">Surabaya</option>
      <option value="Sidoarjo">Sidoarjo</option>
      <option value="Jakarta">Jakarta</option>
      <option value="Semarang">Semarang</option>
    </select>
    <select id="sortPrice" onchange="renderTable()">
      <option value="">Urut Default</option>
      <option value="asc">Harga Terendah</option>
      <option value="desc">Harga Tertinggi</option>
    </select>
  </div>

  <!-- Highlight Cards -->
  <div class="price-highlights" id="highlights"></div>

  <!-- Price Chart -->
  <div class="chart-section">
    <h3>📈 Grafik Tren Harga (7 Hari Terakhir)</h3>
    <div class="chart-pills">
      <button class="chart-pill active" onclick="setChartFish('Ikan Tuna',this)">Ikan Tuna</button>
      <button class="chart-pill" onclick="setChartFish('Udang Vaname',this)">Udang Vaname</button>
      <button class="chart-pill" onclick="setChartFish('Lobster',this)">Lobster</button>
      <button class="chart-pill" onclick="setChartFish('Cumi-cumi',this)">Cumi-cumi</button>
    </div>
    <div class="chart-svg-wrap">
      <svg class="price-chart" id="priceChart" width="780" height="220" viewBox="0 0 780 220"></svg>
    </div>
  </div>

  <!-- Price Table -->
  <div class="price-table-wrap">
    <div class="table-header">
      <h3>📋 Daftar Harga Lengkap</h3>
      <button class="btn-download" onclick="downloadCSV()">⬇️ Download CSV</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>Nama Ikan</th>
          <th>Jenis</th>
          <th>Harga / Kg</th>
          <th>Perubahan</th>
          <th>Kota</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="priceTableBody"></tbody>
    </table>
  </div>

  <!-- Pasar Referensi -->
  <h3 style="font-family:'Fraunces',serif;font-size:1.1rem;font-weight:700;margin-bottom:14px;">🏪 Harga di Pasar Referensi</h3>
  <div class="pasar-grid" id="pasarGrid"></div>

  <div style="height:40px;"></div>
</div>


<script>
// Price data
const PRICE_DATA = [
  { nama:'Ikan Tuna', emoji:'🐟', kat:'segar', harga:85000, prev:80000, kota:'Surabaya', status:'aktif', img:'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=60&q=70' },
  { nama:'Ikan Salmon', emoji:'🐠', kat:'segar', harga:120000, prev:125000, kota:'Jakarta', status:'aktif', img:'https://images.unsplash.com/photo-1612208695882-02f2322b7fee?w=60&q=70' },
  { nama:'Ikan Kakap Merah', emoji:'🐡', kat:'segar', harga:55000, prev:55000, kota:'Madura', status:'normal', img:'https://images.unsplash.com/photo-1606731219412-3b1e9a7c9c57?w=60&q=70' },
  { nama:'Ikan Kembung', emoji:'🐟', kat:'segar', harga:32000, prev:30000, kota:'Surabaya', status:'aktif', img:'https://images.unsplash.com/photo-1535591273668-578e31182c4f?w=60&q=70' },
  { nama:'Ikan Bandeng', emoji:'🐟', kat:'segar', harga:28000, prev:28000, kota:'Sidoarjo', status:'aktif', img:'https://images.unsplash.com/photo-1574484284002-952d92456975?w=60&q=70' },
  { nama:'Udang Vaname', emoji:'🦐', kat:'laut', harga:65000, prev:60000, kota:'Sidoarjo', status:'aktif', img:'https://images.unsplash.com/photo-1565680018434-b1f2c97b5d4b?w=60&q=70' },
  { nama:'Udang Windu', emoji:'🦐', kat:'laut', harga:95000, prev:98000, kota:'Sidoarjo', status:'normal', img:'https://images.unsplash.com/photo-1624992617228-a27e7a06b4ac?w=60&q=70' },
  { nama:'Cumi-cumi', emoji:'🦑', kat:'laut', harga:45000, prev:48000, kota:'Gresik', status:'aktif', img:'https://images.unsplash.com/photo-1559737558-2f5a35f4523b?w=60&q=70' },
  { nama:'Kepiting Rajungan', emoji:'🦀', kat:'laut', harga:75000, prev:72000, kota:'Surabaya', status:'aktif', img:'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=60&q=70' },
  { nama:'Lobster Mutiara', emoji:'🦞', kat:'laut', harga:350000, prev:340000, kota:'Lombok', status:'langka', img:'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=60&q=70' },
  { nama:'Kerang Hijau', emoji:'🐚', kat:'laut', harga:25000, prev:24000, kota:'Gresik', status:'aktif', img:'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=60&q=70' },
  { nama:'Abon Ikan', emoji:'🍱', kat:'olahan', harga:28000, prev:28000, kota:'Sidoarjo', status:'aktif', img:'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=60&q=70' },
];

function getTrend(harga, prev) {
  const diff = harga - prev;
  const pct = prev > 0 ? ((diff/prev)*100).toFixed(1) : 0;
  if (diff > 0) return { cls:'trend-up', icon:'↑', text:`+${pct}%`, tdCls:'change-up' };
  if (diff < 0) return { cls:'trend-down', icon:'↓', text:`${pct}%`, tdCls:'change-down' };
  return { cls:'trend-stable', icon:'→', text:'Stabil', tdCls:'' };
}

function renderHighlights() {
  const top = PRICE_DATA.slice(0,4);
  document.getElementById('highlights').innerHTML = top.map(p => {
    const t = getTrend(p.harga, p.prev);
    return `<div class="price-hi-card" onclick="filterByFish('${p.nama}')">
      <div class="hi-fish">${p.emoji}</div>
      <div class="hi-name">${p.nama}</div>
      <div class="hi-price">Rp ${p.harga.toLocaleString('id-ID')}</div>
      <div class="hi-unit">per kilogram · ${p.kota}</div>
      <span class="hi-trend ${t.cls}">${t.icon} ${t.text}</span>
    </div>`;
  }).join('');
}

function renderTable() {
  const q = document.getElementById('searchPrice').value.toLowerCase();
  const kat = document.getElementById('filterKat').value;
  const kota = document.getElementById('filterKota').value;
  const sort = document.getElementById('sortPrice').value;

  let data = PRICE_DATA.filter(p =>
    (!q || p.nama.toLowerCase().includes(q)) &&
    (!kat || p.kat === kat) &&
    (!kota || p.kota === kota)
  );
  if (sort === 'asc') data.sort((a,b) => a.harga-b.harga);
  if (sort === 'desc') data.sort((a,b) => b.harga-a.harga);

  document.getElementById('priceTableBody').innerHTML = data.map(p => {
    const t = getTrend(p.harga, p.prev);
    const sts = { aktif:'status-aktif', langka:'status-langka', normal:'status-normal' };
    return `<tr>
      <td><div class="td-fish">
        <img src="${p.img}" alt="${p.nama}" onerror="this.style.display='none'"/>
        <div><strong>${p.nama}</strong><span>${p.emoji} ${p.kat}</span></div>
      </div></td>
      <td>${p.kat}</td>
      <td class="td-price">Rp ${p.harga.toLocaleString('id-ID')}</td>
      <td class="td-change ${t.tdCls}">${t.icon} ${t.text}</td>
      <td>📍 ${p.kota}</td>
      <td><span class="status-badge ${sts[p.status]}">${p.status}</span></td>
      <td><button class="btn btn-sm btn-primary" onclick="addToCart(PRODUCTS_DB.find(x=>x.nama.includes('${p.nama.split(' ')[0]}'))||PRODUCTS_DB[0])">🛒</button></td>
    </tr>`;
  }).join('');
}

function filterByFish(nama) {
  document.getElementById('searchPrice').value = nama;
  renderTable();
}

// Chart
const CHART_DATA = {
  'Ikan Tuna': [78000,80000,79000,82000,81000,83000,85000],
  'Udang Vaname': [58000,60000,59000,62000,63000,64000,65000],
  'Lobster': [330000,335000,328000,342000,345000,348000,350000],
  'Cumi-cumi': [48000,46000,47000,45000,44000,46000,45000],
};
const DAYS = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];

function setChartFish(fish, btn) {
  document.querySelectorAll('.chart-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  drawChart(CHART_DATA[fish] || CHART_DATA['Ikan Tuna']);
}

function drawChart(data) {
  const svg = document.getElementById('priceChart');
  const W=780, H=200, PAD=60, INNER_W=W-PAD*2, INNER_H=H-40;
  const min=Math.min(...data)*0.95, max=Math.max(...data)*1.05;
  const xs = data.map((_,i) => PAD + (i/(data.length-1))*INNER_W);
  const ys = data.map(v => 20 + INNER_H*(1-(v-min)/(max-min)));

  const pathD = xs.map((x,i) => `${i===0?'M':'L'}${x},${ys[i]}`).join(' ');
  const areaD = pathD + ` L${xs[xs.length-1]},${H-20} L${xs[0]},${H-20} Z`;

  svg.innerHTML = `
    <defs>
      <linearGradient id="lineGrad" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="#1abc9c" stop-opacity=".25"/>
        <stop offset="100%" stop-color="#1abc9c" stop-opacity="0"/>
      </linearGradient>
    </defs>
    ${[0,1,2,3].map(i => {
      const y = 20 + INNER_H*i/3;
      const val = max - (max-min)*i/3;
      return `<line x1="${PAD}" y1="${y}" x2="${W-PAD}" y2="${y}" stroke="#e2eaf5" stroke-width="1"/>
              <text x="${PAD-8}" y="${y+4}" text-anchor="end" fill="#94a3b8" font-size="10">
                ${(val/1000).toFixed(0)}k
              </text>`;
    }).join('')}
    <path d="${areaD}" fill="url(#lineGrad)"/>
    <path d="${pathD}" fill="none" stroke="#1abc9c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
    ${xs.map((x,i) => `
      <circle cx="${x}" cy="${ys[i]}" r="5" fill="white" stroke="#1abc9c" stroke-width="2"/>
      <text x="${x}" y="${H-4}" text-anchor="middle" fill="#94a3b8" font-size="11">${DAYS[i]}</text>
    `).join('')}
  `;
}

// Pasar
const PASAR = [
  { nama:'Pasar Ikan Surabaya', lokasi:'Surabaya, Jawa Timur', items:[{n:'Ikan Tuna',p:85000},{n:'Udang Vaname',p:65000},{n:'Cumi-cumi',p:45000},{n:'Kepiting',p:75000}] },
  { nama:'Pasar Ikan Sidoarjo', lokasi:'Sidoarjo, Jawa Timur', items:[{n:'Bandeng Presto',p:35000},{n:'Udang Windu',p:95000},{n:'Abon Ikan',p:28000},{n:'Ikan Kembung',p:30000}] },
  { nama:'Pasar Ikan Jakarta', lokasi:'Jakarta Utara, DKI Jakarta', items:[{n:'Salmon Fillet',p:120000},{n:'Lobster',p:350000},{n:'Kerang Hijau',p:25000},{n:'Cumi Beku',p:40000}] },
];

function renderPasar() {
  document.getElementById('pasarGrid').innerHTML = PASAR.map(p => `
    <div class="pasar-card">
      <h4>🏪 ${p.nama}</h4>
      <div class="loc">📍 ${p.lokasi}</div>
      ${p.items.map(i => `<div class="pasar-item"><span class="pname">${i.n}</span><span class="pprice">Rp ${i.p.toLocaleString('id-ID')}/kg</span></div>`).join('')}
    </div>`).join('');
}

function downloadCSV() {
  const rows = [['Nama Ikan','Jenis','Harga/kg','Perubahan','Kota','Status']];
  PRICE_DATA.forEach(p => {
    const t = getTrend(p.harga, p.prev);
    rows.push([p.nama, p.kat, p.harga, t.text, p.kota, p.status]);
  });
  const csv = rows.map(r => r.join(',')).join('\n');
  const blob = new Blob([csv], {type:'text/csv'});
  const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
  a.download = 'harga_ikan_seabiz.csv'; a.click();
  showToast('📥 CSV berhasil diunduh!');
}

// Init
const now = new Date();
document.getElementById('updateTime').textContent = now.toLocaleString('id-ID',{hour:'2-digit',minute:'2-digit'}) + ' WIB';
renderHighlights();
renderTable();
renderPasar();
drawChart(CHART_DATA['Ikan Tuna']);
</script>
@endsection
