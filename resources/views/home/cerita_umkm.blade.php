@extends('layouts.app')

@section('title', 'Cerita UMKM — SeaBiz')

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
.nav-search button{background:none;border:none;color:rgba(255,255,255,.8);cursor:pointer;font-size:15px}
.nav-links{display:flex;gap:6px;margin-left:auto}
.nav-link{color:rgba(255,255,255,.8);text-decoration:none;font-size:13px;font-weight:600;padding:6px 10px;border-radius:8px;transition:.15s}
.nav-link:hover,.nav-link.active{color:#fff;background:rgba(255,255,255,.15)}
.nav-cart{position:relative;text-decoration:none;color:#fff;padding:8px 10px;background:rgba(255,255,255,.15);border-radius:8px;font-size:13px;display:flex;align-items:center;gap:4px}
.cart-badge{background:#ef4444;color:#fff;border-radius:10px;font-size:10px;padding:1px 5px;font-weight:700;display:none}
.nav-user{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.85);font-size:13px;font-weight:600}
.nav-avatar{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.2);display:grid;place-items:center;font-size:16px}

/* PAGE */
.page-inner{max-width:1200px;margin:28px auto;padding:0 20px}

/* HERO */
.umkm-hero{background:linear-gradient(135deg,#0a2342 0%,#0d3b7c 60%,#0d6b5e 100%);border-radius:20px;padding:40px;margin-bottom:28px;position:relative;overflow:hidden}
.umkm-hero-bg{position:absolute;inset:0;background-image:url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1200&q=75');background-size:cover;background-position:center 40%;opacity:.22}
.umkm-hero-inner{position:relative;z-index:2}
.umkm-hero h1{font-family:'Poppins',sans-serif;font-size:28px;color:#fff;font-weight:900;margin-bottom:8px}
.umkm-hero p{color:rgba(255,255,255,.78);font-size:14px;max-width:600px;line-height:1.7}
.umkm-hero-tags{display:flex;gap:10px;margin-top:18px;flex-wrap:wrap}
.umkm-tag{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.22);border-radius:20px;padding:5px 14px;color:rgba(255,255,255,.88);font-size:12px;font-weight:600}

/* FEATURED STORY */
.featured-story{background:#fff;border:1px solid #e2e8f0;border-radius:20px;overflow:hidden;box-shadow:0 8px 24px rgba(15,23,42,.1);margin-bottom:28px;display:grid;grid-template-columns:1fr 1fr}
.featured-img{position:relative;min-height:320px;overflow:hidden}
.featured-img img{width:100%;height:100%;object-fit:cover;transition:.4s}
.featured-img:hover img{transform:scale(1.04)}
.feat-badge{position:absolute;top:16px;left:16px;background:#f59e0b;color:#fff;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:800}
.featured-body{padding:36px 32px;display:flex;flex-direction:column;justify-content:center}
.story-cat{font-size:12px;font-weight:700;color:#0d9488;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px}
.featured-body h2{font-family:'Poppins',sans-serif;font-size:22px;font-weight:800;line-height:1.35;margin-bottom:14px;color:#0f172a}
.story-quote{background:#e0f7f4;border-left:4px solid #0d9488;padding:14px 18px;border-radius:0 10px 10px 0;margin-bottom:18px;font-size:13px;font-style:italic;color:#475569;line-height:1.6}
.author-row{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.author-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0}
.author-info strong{display:block;font-size:14px;font-weight:700}
.author-info span{font-size:12px;color:#64748b}
.story-stats{display:flex;gap:16px;font-size:12px;color:#64748b;flex-wrap:wrap}
.story-stat strong{color:#0f172a;font-size:13px;display:block}
.btn-read-more{margin-top:18px;padding:11px 22px;background:#0d3b7c;color:#fff;border:none;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;transition:.15s;font-family:'Nunito',sans-serif}
.btn-read-more:hover{background:#0b2f5b}

/* FILTER TABS */
.stories-filter{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px}
.filter-tabs{display:flex;gap:8px;flex-wrap:wrap}
.filter-tab{padding:8px 18px;border-radius:20px;border:1.5px solid #e2e8f0;background:#fff;font-size:13px;font-weight:700;color:#64748b;cursor:pointer;transition:.2s;font-family:'Nunito',sans-serif}
.filter-tab:hover{border-color:#0d3b7c;color:#0d3b7c}
.filter-tab.active{background:#0d3b7c;border-color:#0d3b7c;color:#fff}
.search-story{display:flex;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;overflow:hidden}
.search-story input{padding:9px 14px;border:none;font-size:13px;outline:none;width:200px;font-family:'Nunito',sans-serif}
.search-story button{padding:9px 14px;background:none;border:none;cursor:pointer;font-size:15px}

/* STORIES GRID */
.stories-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:28px}
.story-card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;transition:.3s;cursor:pointer}
.story-card:hover{transform:translateY(-5px);box-shadow:0 12px 32px rgba(15,23,42,.12);border-color:rgba(13,148,136,.3)}
.story-card-img{height:200px;overflow:hidden;position:relative}
.story-card-img img{width:100%;height:100%;object-fit:cover;transition:.4s}
.story-card:hover .story-card-img img{transform:scale(1.07)}
.story-card-cat{position:absolute;top:10px;left:10px;background:rgba(10,35,66,.75);color:#fff;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;backdrop-filter:blur(6px)}
.story-card-body{padding:18px}
.story-card-body h4{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;line-height:1.4;margin-bottom:8px;color:#0f172a}
.story-card-body p{font-size:13px;color:#64748b;line-height:1.6;margin-bottom:14px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.story-card-footer{display:flex;align-items:center;justify-content:space-between}
.story-author{display:flex;align-items:center;gap:8px}
.story-author img{width:30px;height:30px;border-radius:50%;object-fit:cover;border:1.5px solid #e2e8f0}
.story-author span{font-size:12px;font-weight:600}
.btn-read{padding:6px 14px;border-radius:8px;background:#e0f7f4;color:#0d9488;border:none;font-size:12px;font-weight:700;cursor:pointer;transition:.2s;font-family:'Nunito',sans-serif}
.btn-read:hover{background:#0d9488;color:#fff}

/* MODAL */
.story-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:500;align-items:center;justify-content:center;padding:20px}
.story-modal.open{display:flex}
.story-modal-box{background:#fff;border-radius:20px;max-width:700px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 40px 100px rgba(0,0,0,.3);position:relative}
.modal-img{width:100%;height:280px;object-fit:cover}
.modal-body{padding:28px 32px}
.modal-cat{font-size:12px;font-weight:700;color:#0d9488;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px}
.modal-body h2{font-family:'Poppins',sans-serif;font-size:22px;font-weight:800;margin-bottom:16px;line-height:1.3}
.modal-author-row{display:flex;align-items:center;gap:12px;padding:16px 0;border-top:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;margin-bottom:20px}
.modal-author-row img{width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0}
.modal-author-row .info strong{display:block;font-size:14px;font-weight:700}
.modal-author-row .info span{font-size:12px;color:#64748b}
.modal-stats-row{display:flex;gap:20px;margin-bottom:20px;flex-wrap:wrap}
.mstat{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 16px;text-align:center}
.mstat strong{display:block;font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:#0d3b7c}
.mstat span{font-size:11px;color:#64748b}
.modal-content{font-size:14px;line-height:1.8;color:#0f172a}
.modal-content p{margin-bottom:14px}
.modal-quote{background:#e0f7f4;border-left:4px solid #0d9488;padding:16px 20px;border-radius:0 12px 12px 0;margin:18px 0;font-style:italic;color:#475569}
.modal-close{position:absolute;top:14px;right:14px;background:rgba(0,0,0,.45);border:none;color:#fff;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center}

/* TOAST */
.toast{position:fixed;bottom:20px;right:20px;background:#0d3b7c;color:#fff;padding:11px 18px;border-radius:10px;font-size:13px;z-index:9999;transform:translateY(80px);opacity:0;transition:.3s;pointer-events:none}
.toast.show{transform:translateY(0);opacity:1}

@media(max-width:900px){.featured-story{grid-template-columns:1fr}.featured-img{min-height:240px}.stories-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){.stories-grid{grid-template-columns:1fr}.featured-body{padding:24px}}
</style>
@endsection

@section('content')
<div class="page-inner">

  <!-- Hero -->
  <div class="umkm-hero">
    <div class="umkm-hero-bg"></div>
    <div class="umkm-hero-inner">
      <h1>🏪 Cerita UMKM</h1>
      <p>Kisah inspiratif para nelayan dan pelaku usaha perikanan yang bertahan dan berkembang di era digital. Setiap ikan yang kamu beli, ada perjuangan di baliknya.</p>
      <div class="umkm-hero-tags">
        <span class="umkm-tag">🎣 Nelayan Tradisional</span>
        <span class="umkm-tag">🏪 Pedagang Lokal</span>
        <span class="umkm-tag">👨‍👩‍👧 UMKM Keluarga</span>
        <span class="umkm-tag">🌱 Pertumbuhan Bisnis</span>
      </div>
    </div>
  </div>

  <!-- Featured Story -->
  <div class="featured-story" id="featuredStory"></div>

  <!-- Filter -->
  <div class="stories-filter">
    <div class="filter-tabs">
      <button class="filter-tab active" onclick="filterStories('all',this)">🌊 Semua</button>
      <button class="filter-tab" onclick="filterStories('nelayan',this)">🎣 Nelayan</button>
      <button class="filter-tab" onclick="filterStories('pedagang',this)">🏪 Pedagang</button>
      <button class="filter-tab" onclick="filterStories('olahan',this)">🍱 Produk Olahan</button>
      <button class="filter-tab" onclick="filterStories('sukses',this)">⭐ Kisah Sukses</button>
    </div>
    <div class="search-story">
      <input type="text" id="storySearch" placeholder="Cari cerita..." oninput="filterStories(currentFilter)"/>
      <button>🔍</button>
    </div>
  </div>

  <!-- Stories Grid -->
  <div class="stories-grid" id="storiesGrid"></div>

  <div style="height:40px;"></div>
</div>

<!-- Story Modal -->
<div class="story-modal" id="storyModal">
  <div class="story-modal-box">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <img id="modalImg" src="" alt="" class="modal-img"/>
    <div class="modal-body">
      <div class="modal-cat" id="modalCat"></div>
      <h2 id="modalTitle"></h2>
      <div class="modal-author-row">
        <img id="modalAvatar" src="" alt="" onerror="this.style.display='none'"/>
        <div class="info">
          <strong id="modalAuthorName"></strong>
          <span id="modalAuthorRole"></span>
        </div>
      </div>
      <div class="modal-stats-row" id="modalStats"></div>
      <div class="modal-content" id="modalContent"></div>
    </div>
  </div>
</div>



<script>
// STORIES DATA — menggunakan foto nelayan & pedagang asli
const fallbackImg = "{{ asset('assets/img/nelayan.jpg') }}";
const STORIES = [
  {
    id:1, kat:'nelayan', featured:true,
    title:'Herlina Suyanti: Dari Jaring Tradisional ke Jutaan Transaksi Digital',
    summary:'Nelayan perempuan asal Sidoarjo ini membuktikan bahwa keterbatasan bukanlah halangan untuk maju.',
    quote:'"Saya tak pernah menyangka produk ikan saya bisa sampai ke pelanggan di Jakarta, Bali, bahkan Kalimantan hanya lewat HP."',
    kategori:'🎣 Nelayan',
    author:'Herlina Suyanti', role:'Nelayan & Penjual · Sidoarjo',
    kota:'Sidoarjo', omset:'Rp 45 juta/bulan', bergabung:'2023',
    img:'https://images.unsplash.com/photo-1504944132186-7bf23c4c5e0e?w=800&q=80',
    avatar:'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=100&q=80',
    content:`<p>Herlina Suyanti adalah seorang ibu dari tiga anak yang sejak kecil sudah terbiasa dengan kehidupan nelayan di pesisir Sidoarjo. Selama bertahun-tahun, ia menjual ikan segar di pasar tradisional dengan pendapatan yang tidak menentu.</p>
    <div class="modal-quote">"Dulu saya harus bangun jam 3 pagi, ke TPI, bargain harga, terus keliling pasar. Sekarang saya cukup foto produk, upload ke SeaBiz, dan pesanan datang sendiri."</div>
    <p>Bergabung dengan SeaBiz pada 2023 mengubah segalanya. Dalam 6 bulan pertama, omset bulanannya naik dari Rp 8 juta menjadi Rp 45 juta. Produk andalannya — Bandeng Presto Sidoarjo — kini memiliki ribuan pelanggan setia dari berbagai penjuru Indonesia.</p>
    <p>Herlina juga kini mempekerjakan 5 warga sekitar untuk membantu produksi dan pengemasan, memberikan dampak ekonomi nyata bagi komunitasnya.</p>`
  },
  {
    id:2, kat:'pedagang',
    title:'Budi Raharjo: Toko Ikan Tua yang Kini Melek Digital',
    summary:'Toko ikan warisan kakek yang hampir gulung tikar kini jadi toko online dengan 2000+ pelanggan.',
    quote:'"Waktu bapak saya dulu, pelanggan datang sendiri. Sekarang saya yang harus jemput pelanggan lewat internet."',
    kategori:'🏪 Pedagang',
    author:'Budi Raharjo', role:'Pemilik Toko Bahari · Surabaya',
    kota:'Surabaya', omset:'Rp 120 juta/bulan', bergabung:'2022',
    img:'https://images.unsplash.com/photo-1545996124-0501ebae84d0?w=800&q=80',
    avatar:'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80',
    content:`<p>Toko Bahari milik Budi Raharjo sudah berdiri sejak 1978, diwariskan dari sang kakek yang merupakan nelayan ulung asal Madura. Namun memasuki era digital, toko yang dulu selalu ramai kini mulai sepi pengunjung.</p>
    <div class="modal-quote">"Dua tahun lalu, saya hampir tutup toko. Setiap bulan merugi. Tapi sekarang, justru kami kewalahan pesanan!"</div>
    <p>Bergabung dengan SeaBiz pada 2022 mengubah segalanya. Budi mengikuti pelatihan digital marketing dan mulai memfoto produknya secara profesional. Kini Toko Bahari memiliki lebih dari 2.000 pelanggan tetap di seluruh Indonesia.</p>`
  },
  {
    id:3, kat:'olahan',
    title:'Sari Kusuma: Mengubah Ikan Kecil jadi Produk Bernilai Tinggi',
    summary:'Ibu rumah tangga yang menyulap ikan kembung menjadi produk olahan premium dengan omset ratusan juta.',
    quote:'"Ikan yang orang anggap murah, saya jadikan produk premium. Kuncinya cuma kreativitas dan konsistensi."',
    kategori:'🍱 Produk Olahan',
    author:'Sari Kusuma', role:'Pengolah Hasil Laut · Gresik',
    kota:'Gresik', omset:'Rp 85 juta/bulan', bergabung:'2022',
    img:'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=800&q=80',
    avatar:'https://images.unsplash.com/photo-1520813792240-56fc4a3765a7?w=100&q=80',
    content:`<p>Berawal dari dapur rumah tangga di Gresik, Sari Kusuma kini memimpin usaha produk olahan laut yang meraih penghargaan UMKM Terbaik Jawa Timur 2023.</p>
    <div class="modal-quote">"Saya mulai dari modal Rp 500 ribu, kompor gas satu, dan satu resep warisan ibu. Kini kami punya 3 lini produk dan ekspor ke Malaysia."</div>
    <p>Produk andalan Sari adalah Abon Ikan Tuna, Kerupuk Udang Organik, dan Sambal Ikan Teri premium. Bergabung ke SeaBiz membantunya menjangkau pasar lebih luas tanpa biaya promosi yang besar.</p>`
  },
  {
    id:4, kat:'nelayan',
    title:'Ahmad Fauzi: Nelayan Muda yang Bangun Koperasi Digital',
    summary:'Nelayan berusia 28 tahun ini mengorganisir 40 nelayan lokal untuk berjualan bersama di platform digital.',
    quote:'"Satu nelayan itu lemah. Empat puluh nelayan yang bersatu? Kami bisa tentukan harga sendiri."',
    kategori:'🎣 Nelayan',
    author:'Ahmad Fauzi', role:'Ketua Koperasi Nelayan · Kenjeran',
    kota:'Surabaya', omset:'Rp 350 juta/bulan', bergabung:'2021',
    img:'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&q=80',
    avatar:'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&q=80',
    content:`<p>Ahmad Fauzi lulus dari Politeknik Kelautan Surabaya namun memilih kembali ke kampung nelayan di Kenjeran, bukan untuk sekadar meneruskan tradisi, tapi untuk mengubahnya.</p>
    <div class="modal-quote">"Saya lihat bapak-bapak nelayan ini kerja keras sekali tapi penghasilan tidak sebanding. Saya mau ubah itu."</div>
    <p>Ia mendirikan Koperasi Nelayan Digital Kenjeran yang kini beranggotakan 40 nelayan. Dengan SeaBiz sebagai platform utama, koperasi berhasil meningkatkan pendapatan rata-rata nelayan anggota sebesar 3 kali lipat.</p>`
  },
  {
    id:5, kat:'sukses',
    title:'Ratna Dewi: Dari Warung Pinggir Jalan ke Restoran Seafood Franchise',
    summary:'Warung seafood sederhana yang kini berkembang menjadi 7 cabang restoran dengan 50+ karyawan.',
    quote:'"SeaBiz bukan hanya tempat saya beli ikan. Mereka partner bisnis yang menghubungkan saya ke ribuan pelanggan baru."',
    kategori:'⭐ Kisah Sukses',
    author:'Ratna Dewi', role:'Owner Dapur Nelayan · Sidoarjo',
    kota:'Sidoarjo', omset:'Rp 500 juta/bulan', bergabung:'2020',
    img:'https://images.unsplash.com/photo-1606731219412-3b1e9a7c9c57?w=800&q=80',
    avatar:'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&q=80',
    content:`<p>Dua belas tahun lalu, Ratna Dewi berjualan pecel lele di pinggir jalan dengan modal pinjaman Rp 2 juta. Kini, "Dapur Nelayan" miliknya adalah brand restoran seafood dengan 7 cabang dan lebih dari 50 karyawan.</p>
    <div class="modal-quote">"Kunci sukses saya simpel: beli bahan baku segar langsung dari nelayan, masak dengan resep jujur, dan layani pelanggan dengan hati."</div>
    <p>Ratna bergabung SeaBiz sejak 2020 untuk memastikan pasokan ikan segar berkualitas langsung dari nelayan Kenjeran. Efisiensi rantai pasok ini memungkinkannya menjaga kualitas makanan sekaligus menekan biaya operasional.</p>`
  },
  {
    id:6, kat:'pedagang',
    title:'Pak Wayan: Pedagang Ikan Bali yang Go Nasional',
    summary:'Pedagang ikan tradisional asal Jembrana, Bali yang kini mengirim produk ke seluruh nusantara.',
    quote:'"Di Bali, laut adalah ibu kami. SeaBiz membantu saya membawa berkah laut Bali ke seluruh Indonesia."',
    kategori:'🏪 Pedagang',
    author:'I Wayan Suarjana', role:'Pedagang Ikan · Jembrana, Bali',
    kota:'Bali', omset:'Rp 95 juta/bulan', bergabung:'2023',
    img:'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=800&q=80',
    avatar:'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&q=80',
    content:`<p>I Wayan Suarjana tumbuh besar di tepi Selat Bali, menyaksikan kakek dan ayahnya melaut setiap pagi. Kini di usia 45, ia melanjutkan warisan itu dengan cara yang berbeda — berjualan online melalui SeaBiz.</p>
    <div class="modal-quote">"Dulu produk ikan Bali hanya dikenal di Bali saja. Sekarang pelanggan dari Kalimantan, Papua, bahkan Aceh pesan ikan dari kami."</div>
    <p>Produk unggulan Pak Wayan adalah Tongkol Bali dan Ikan Layar Segar yang ditangkap langsung oleh nelayan tradisional setempat. Bergabung ke SeaBiz membukakan akses pasar yang sebelumnya tidak terbayangkan.</p>`
  },
];

let currentFilter = 'all';

function renderFeatured() {
  const f = STORIES.find(s => s.featured);
  if (!f) return;
  document.getElementById('featuredStory').innerHTML = `
    <div class="featured-img">
      <img src="${f.img}" alt="${f.title}" onerror="this.src=fallbackImg">
      <span class="feat-badge">⭐ Kisah Pilihan</span>
    </div>
    <div class="featured-body">
      <div class="story-cat">${f.kategori}</div>
      <h2>${f.title}</h2>
      <div class="story-quote">${f.quote}</div>
      <div class="author-row">
        <img class="author-avatar" src="${f.avatar}" alt="${f.author}" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(f.author)}&background=0d3b7c&color=fff&size=48'"/>
        <div class="author-info">
          <strong>${f.author}</strong>
          <span>${f.role}</span>
        </div>
      </div>
      <div class="story-stats">
        <div class="story-stat"><strong>${f.omset}</strong><span>Omset Bulanan</span></div>
        <div class="story-stat"><strong>${f.bergabung}</strong><span>Bergabung</span></div>
        <div class="story-stat"><strong>📍 ${f.kota}</strong><span>Kota Asal</span></div>
      </div>
      <button class="btn-read-more" onclick="openModal(${f.id})">Baca Cerita Lengkap →</button>
    </div>`;
}

function filterStories(kat, btn) {
  currentFilter = kat;
  if (btn) {
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }
  const q = (document.getElementById('storySearch').value || '').toLowerCase();
  let data = STORIES.filter(s =>
    (kat === 'all' || s.kat === kat) &&
    (!q || s.title.toLowerCase().includes(q) || s.summary.toLowerCase().includes(q) || s.author.toLowerCase().includes(q))
  );
  document.getElementById('storiesGrid').innerHTML = data.map(s => `
    <div class="story-card" onclick="openModal(${s.id})">
      <div class="story-card-img">
        <img src="${s.img}" alt="${s.title}" loading="lazy" onerror="this.src=fallbackImg">
        <span class="story-card-cat">${s.kategori}</span>
      </div>
      <div class="story-card-body">
        <h4>${s.title}</h4>
        <p>${s.summary}</p>
        <div class="story-card-footer">
          <div class="story-author">
            <img src="${s.avatar}" alt="${s.author}" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(s.author)}&background=0d3b7c&color=fff&size=30'"/>
            <span>${s.author}</span>
          </div>
          <button class="btn-read" onclick="event.stopPropagation();openModal(${s.id})">Baca →</button>
        </div>
      </div>
    </div>`).join('') || `<div style="grid-column:1/-1;text-align:center;padding:60px;color:#64748b">😕 Cerita tidak ditemukan.</div>`;
}

function openModal(id) {
  const s = STORIES.find(x => x.id === id);
  if (!s) return;
  document.getElementById('modalImg').src = s.img;
  document.getElementById('modalImg').onerror = function(){ this.src = fallbackImg; };
  document.getElementById('modalCat').textContent = s.kategori;
  document.getElementById('modalTitle').textContent = s.title;
  document.getElementById('modalAvatar').src = s.avatar;
  document.getElementById('modalAuthorName').textContent = s.author;
  document.getElementById('modalAuthorRole').textContent = s.role;
  document.getElementById('modalStats').innerHTML = `
    <div class="mstat"><strong>${s.omset}</strong><span>Omset/Bulan</span></div>
    <div class="mstat"><strong>${s.bergabung}</strong><span>Bergabung</span></div>
    <div class="mstat"><strong>📍 ${s.kota}</strong><span>Kota Asal</span></div>`;
  document.getElementById('modalContent').innerHTML = s.content;
  document.getElementById('storyModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('storyModal').classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('storyModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });

// Init
renderFeatured();
filterStories('all');

// Update cart badge
function updateCartBadge() {
  const n = typeof getCartCount === 'function' ? getCartCount() : 0;
  const b = document.getElementById('cartBadge');
  if (b) { b.textContent = n; b.style.display = n > 0 ? 'inline' : 'none'; }
}
updateCartBadge();
</script>
@endsection
