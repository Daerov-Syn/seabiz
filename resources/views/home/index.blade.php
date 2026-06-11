<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SeaBiz - Platform Bisnis Perikanan Indonesia</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
:root {
      --ocean-deep: #0a2342;
      --ocean-mid: #1a5276;
      --ocean-bright: #1abc9c;
      --ocean-light: #48c9b0;
      --foam: #d6eaf8;
      --sand: #fef9e7;
      --coral: #e74c3c;
      --gold: #f39c12;
      --text-dark: #1a2744;
      --text-mid: #445566;
      --white: #ffffff;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--text-dark);
      overflow-x: hidden;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      padding: 16px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(10, 35, 66, 0.85);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(255,255,255,0.08);
      transition: all 0.3s ease;
    }

    .nav-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: var(--white);
    }

    .nav-logo-fish {
      font-size: 28px;
      filter: drop-shadow(0 0 8px rgba(72,201,176,0.6));
    }

    .nav-logo-text {
      font-family: 'Fraunces', serif;
      font-size: 22px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .nav-logo-text strong { color: var(--ocean-bright); }

    .nav-links {
      display: flex;
      gap: 32px;
      list-style: none;
    }

    .nav-links a {
      color: rgba(255,255,255,0.75);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: color 0.2s;
    }
    .nav-links a:hover { color: var(--white); }

    .nav-buttons {
      display: flex;
      gap: 12px;
    }

    .btn-nav-outline {
      padding: 9px 20px;
      border: 1.5px solid rgba(255,255,255,0.4);
      border-radius: 8px;
      color: var(--white);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.2s;
    }
    .btn-nav-outline:hover {
      border-color: var(--ocean-bright);
      color: var(--ocean-bright);
    }

    .btn-nav-primary {
      padding: 9px 20px;
      background: var(--ocean-bright);
      border-radius: 8px;
      color: var(--white);
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .btn-nav-primary:hover {
      background: var(--ocean-light);
      transform: translateY(-1px);
    }

    /* ===== HERO SECTION ===== */
    .hero {
      min-height: 100vh;
      position: relative;
      display: flex;
      align-items: center;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      background-image: url('https://images.unsplash.com/photo-1504309092620-4d0ec726efa4?w=1800&q=80');
      background-size: cover;
      background-position: center;
      filter: brightness(0.4) saturate(1.2);
    }

    /* Gradient overlay */
    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        135deg,
        rgba(10, 35, 66, 0.92) 0%,
        rgba(26, 82, 118, 0.7) 50%,
        rgba(10, 35, 66, 0.5) 100%
      );
    }

    .hero-content {
      position: relative;
      z-index: 10;
      max-width: 1200px;
      margin: 0 auto;
      padding: 120px 40px 80px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
      width: 100%;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(26, 188, 156, 0.15);
      border: 1px solid rgba(26, 188, 156, 0.4);
      border-radius: 100px;
      padding: 6px 16px;
      color: var(--ocean-bright);
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 24px;
      backdrop-filter: blur(8px);
    }

    .hero-title {
      font-family: 'Fraunces', serif;
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 900;
      color: var(--white);
      line-height: 1.1;
      margin-bottom: 20px;
      letter-spacing: -1px;
    }

    .hero-title em {
      font-style: italic;
      color: var(--ocean-bright);
    }

    .hero-subtitle {
      font-size: 17px;
      color: rgba(255,255,255,0.7);
      line-height: 1.7;
      margin-bottom: 36px;
      max-width: 480px;
    }

    .hero-cta {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 52px;
    }

    .btn-hero-main {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 15px 32px;
      background: linear-gradient(135deg, var(--ocean-bright), #16a085);
      color: var(--white);
      text-decoration: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      transition: all 0.3s;
      box-shadow: 0 8px 32px rgba(26,188,156,0.35);
    }
    .btn-hero-main:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 48px rgba(26,188,156,0.45);
    }

    .btn-hero-ghost {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 15px 28px;
      border: 2px solid rgba(255,255,255,0.3);
      color: var(--white);
      text-decoration: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      transition: all 0.3s;
    }
    .btn-hero-ghost:hover {
      border-color: var(--white);
      background: rgba(255,255,255,0.1);
    }

    .hero-stats {
      display: flex;
      gap: 40px;
    }

    .stat-item strong {
      display: block;
      font-family: 'Fraunces', serif;
      font-size: 2rem;
      color: var(--white);
      font-weight: 700;
    }

    .stat-item span {
      font-size: 13px;
      color: rgba(255,255,255,0.55);
      font-weight: 500;
    }

    /* ===== HERO VISUAL (right side) ===== */
    .hero-visual {
      position: relative;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .hero-img-card {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0,0,0,0.5);
      border: 1px solid rgba(255,255,255,0.1);
      position: relative;
    }

    .hero-img-card img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      display: block;
    }

    .hero-img-overlay {
      position: absolute;
      bottom: 0;
      left: 0; right: 0;
      padding: 20px;
      background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
      color: white;
    }

    .hero-img-overlay h4 {
      font-family: 'Fraunces', serif;
      font-size: 18px;
      font-weight: 700;
    }

    .hero-img-overlay p { font-size: 13px; opacity: 0.75; }

    .live-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: rgba(231,76,60,0.9);
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 700;
      margin-top: 8px;
    }

    .live-dot {
      width: 6px; height: 6px;
      background: white;
      border-radius: 50%;
      animation: pulse 1.2s infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    .floating-chips {
      display: flex;
      gap: 12px;
    }

    .chip {
      flex: 1;
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 14px;
      padding: 16px;
      color: white;
    }

    .chip .chip-icon { font-size: 24px; margin-bottom: 8px; }
    .chip .chip-label { font-size: 12px; opacity: 0.6; }
    .chip .chip-value { font-size: 16px; font-weight: 700; }

    /* ===== FEATURES SECTION ===== */
    .features {
      padding: 100px 40px;
      background: linear-gradient(180deg, #0d1b2a 0%, #f0f8ff 100%);
    }

    .features-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-label {
      display: inline-block;
      color: var(--ocean-bright);
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 12px;
    }

    .section-title {
      font-family: 'Fraunces', serif;
      font-size: clamp(1.8rem, 3vw, 2.8rem);
      font-weight: 700;
      color: var(--white);
      margin-bottom: 16px;
      letter-spacing: -0.5px;
    }

    .section-title.dark { color: var(--text-dark); }
    .section-sub { color: rgba(255,255,255,0.55); font-size: 16px; margin-bottom: 60px; }
    .section-sub.dark { color: var(--text-mid); }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }

    .feature-card {
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 20px;
      padding: 32px;
      transition: all 0.3s;
    }

    .feature-card:hover {
      transform: translateY(-6px);
      border-color: rgba(26,188,156,0.3);
      box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .feature-icon {
      width: 56px; height: 56px;
      border-radius: 14px;
      background: linear-gradient(135deg, rgba(26,188,156,0.2), rgba(72,201,176,0.1));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .feature-card h3 {
      font-family: 'Fraunces', serif;
      font-size: 20px;
      color: var(--white);
      margin-bottom: 10px;
      font-weight: 700;
    }

    .feature-card p {
      font-size: 14px;
      color: rgba(255,255,255,0.55);
      line-height: 1.7;
    }

    /* ===== PRODUCTS PREVIEW ===== */
    .products-preview {
      padding: 100px 40px;
      background: #f8fdff;
    }

    .products-preview-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .preview-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 48px;
    }

    .btn-see-all {
      padding: 10px 24px;
      border: 2px solid var(--ocean-mid);
      border-radius: 10px;
      color: var(--ocean-mid);
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .btn-see-all:hover {
      background: var(--ocean-mid);
      color: white;
    }

    .products-grid-preview {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }

    .product-preview-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 2px 20px rgba(0,0,0,0.07);
      transition: all 0.3s;
      border: 1px solid #eef5ff;
    }

    .product-preview-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 48px rgba(26,82,118,0.15);
    }

    .product-img-wrap {
      position: relative;
      height: 180px;
      overflow: hidden;
    }

    .product-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s;
    }

    .product-preview-card:hover .product-img-wrap img {
      transform: scale(1.07);
    }

    .product-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: var(--ocean-bright);
      color: white;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
    }

    .product-info {
      padding: 16px;
    }

    .product-info h4 {
      font-weight: 700;
      font-size: 15px;
      color: var(--text-dark);
      margin-bottom: 4px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .product-info .product-seller {
      font-size: 12px;
      color: var(--text-mid);
      margin-bottom: 10px;
    }

    .product-info .product-price {
      font-family: 'Fraunces', serif;
      font-size: 18px;
      font-weight: 700;
      color: var(--ocean-mid);
    }

    .product-info .product-price span {
      font-size: 12px;
      color: var(--text-mid);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 400;
    }

    /* ===== ROLES SECTION ===== */
    .roles-section {
      padding: 100px 40px;
      background: linear-gradient(135deg, var(--ocean-deep), var(--ocean-mid));
      position: relative;
      overflow: hidden;
    }

    .roles-bg-img {
      position: absolute;
      inset: 0;
      background-image: url('assets/img/nelayan.jpg');
      background-size: cover;
      background-position: center;
      opacity: 0.12;
    }

    .roles-inner {
      max-width: 900px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
      text-align: center;
    }

    .roles-cards {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      margin-top: 48px;
    }

    .role-card {
      background: rgba(255,255,255,0.07);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 20px;
      padding: 40px 32px;
      transition: all 0.3s;
      text-align: left;
    }

    .role-card:hover {
      background: rgba(255,255,255,0.12);
      transform: translateY(-4px);
      box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    }

    .role-card.featured {
      border-color: rgba(26,188,156,0.5);
      position: relative;
    }

    .role-badge {
      position: absolute;
      top: -12px; right: 24px;
      background: var(--gold);
      color: var(--text-dark);
      font-size: 12px;
      font-weight: 700;
      padding: 4px 14px;
      border-radius: 20px;
    }

    .role-icon { font-size: 48px; margin-bottom: 16px; }

    .role-card h3 {
      font-family: 'Fraunces', serif;
      font-size: 22px;
      color: white;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .role-card p {
      font-size: 14px;
      color: rgba(255,255,255,0.6);
      line-height: 1.7;
      margin-bottom: 24px;
    }

    .btn-role {
      display: inline-block;
      padding: 12px 24px;
      border-radius: 10px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 700;
      border: 2px solid rgba(255,255,255,0.3);
      color: white;
      transition: all 0.3s;
    }
    .btn-role:hover { border-color: var(--ocean-bright); color: var(--ocean-bright); }

    .btn-role.featured-btn {
      background: var(--ocean-bright);
      border-color: var(--ocean-bright);
    }
    .btn-role.featured-btn:hover {
      background: var(--ocean-light);
      border-color: var(--ocean-light);
      color: white;
    }

    /* ===== FOOTER ===== */
    .footer {
      background: var(--ocean-deep);
      padding: 40px;
      text-align: center;
      border-top: 1px solid rgba(255,255,255,0.06);
    }

    .footer-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-family: 'Fraunces', serif;
      font-size: 20px;
      color: white;
      margin-bottom: 12px;
    }
    .footer-logo strong { color: var(--ocean-bright); }

    .footer p {
      font-size: 13px;
      color: rgba(255,255,255,0.35);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
      .hero-content { grid-template-columns: 1fr; gap: 40px; }
      .features-grid { grid-template-columns: repeat(2, 1fr); }
      .products-grid-preview { grid-template-columns: repeat(2, 1fr); }
      .roles-cards { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .navbar { padding: 14px 20px; }
      .nav-links { display: none; }
      .hero-content { padding: 100px 20px 60px; }
      .features { padding: 60px 20px; }
      .features-grid { grid-template-columns: 1fr; }
      .products-preview { padding: 60px 20px; }
      .products-grid-preview { grid-template-columns: 1fr; }
      .roles-section { padding: 60px 20px; }
      .preview-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="?page=index" class="nav-logo">
    <span class="nav-logo-fish">🐟</span>
    <span class="nav-logo-text">Sea<strong>Biz</strong></span>
  </a>
  <ul class="nav-links">
    <li><a href="#">Beranda</a></li>
    <li><a href="#">Tentang</a></li>
    <li><a href="#">Layanan</a></li>
    <li><a href="#">Kontak</a></li>
  </ul>
  <div class="nav-buttons">
    <a href="{{ route('login') }}" class="btn-nav-outline">Masuk</a>
    <a href="{{ route('register') }}" class="btn-nav-primary">Daftar Gratis</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-text">
      <div class="hero-badge">
        🌊 Platform Perikanan #1 Indonesia
      </div>
      <h1 class="hero-title">
        Kelola Bisnis<br>
        <em>Perikanan</em> Anda<br>
        Lebih Mudah
      </h1>
      <p class="hero-subtitle">
        SeaBiz menghubungkan nelayan, pedagang, dan pembeli dalam satu ekosistem digital yang modern dan terpercaya.
      </p>
      <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn-hero-main">
          Mulai Sekarang
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="{{ route('login') }}" class="btn-hero-ghost">Sudah Punya Akun?</a>
      </div>
      <div class="hero-stats">
        <div class="stat-item">
          <strong>12K+</strong>
          <span>Nelayan</span>
        </div>
        <div class="stat-item">
          <strong>5K+</strong>
          <span>Pedagang</span>
        </div>
        <div class="stat-item">
          <strong>98%</strong>
          <span>Kepuasan</span>
        </div>
      </div>
    </div>

    <div class="hero-visual">
      <div class="hero-img-card">
        <img src="{{ asset('assets/img/nelayan.jpg') }}" alt="Nelayan di laut" />
        <div class="hero-img-overlay">
          <h4>Pasar Ikan Segar</h4>
          <p>Langsung dari nelayan ke meja makan Anda</p>
          <span class="live-badge"><span class="live-dot"></span> Live Marketplace</span>
        </div>
      </div>
      <div class="floating-chips">
        <div class="chip">
          <div class="chip-icon">🐟</div>
          <div class="chip-label">Ikan Tuna</div>
          <div class="chip-value">Rp 85.000/kg</div>
        </div>
        <div class="chip">
          <div class="chip-icon">🦐</div>
          <div class="chip-label">Udang Vaname</div>
          <div class="chip-value">Rp 65.000/kg</div>
        </div>
        <div class="chip">
          <div class="chip-icon">🦞</div>
          <div class="chip-label">Lobster</div>
          <div class="chip-value">Rp 350.000/ekor</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features">
  <div class="features-inner">
    <div class="section-label">Keunggulan Platform</div>
    <h2 class="section-title">Mengapa Pilih SeaBiz?</h2>
    <p class="section-sub">Fitur lengkap untuk mendukung bisnis perikanan Anda dari hulu ke hilir</p>

    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">📈</div>
        <h3>Harga Real-Time</h3>
        <p>Pantau pergerakan harga ikan dan hasil laut secara langsung dari berbagai wilayah Indonesia.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🛡️</div>
        <h3>Transaksi Aman</h3>
        <p>Sistem escrow dan verifikasi penjual memastikan setiap transaksi terlindungi dan terpercaya.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🚚</div>
        <h3>Pengiriman Cepat</h3>
        <p>Bermitra dengan jasa pengiriman khusus produk segar untuk menjaga kualitas hingga ke tangan Anda.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📱</div>
        <h3>Akses Mudah</h3>
        <p>Platform responsif yang bisa diakses dari mana saja — desktop, tablet, maupun smartphone.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Analitik Bisnis</h3>
        <p>Dashboard lengkap untuk memantau penjualan, tren permintaan, dan performa toko Anda.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🤝</div>
        <h3>Komunitas UMKM</h3>
        <p>Bergabung dengan ribuan pelaku usaha perikanan dan bangun jaringan bisnis yang kuat.</p>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCT PREVIEW -->
<section class="products-preview">
  <div class="products-preview-inner">
    <div class="preview-header">
      <div>
        <div class="section-label" style="color: var(--ocean-mid);">Produk Pilihan</div>
        <h2 class="section-title dark">Hasil Laut Terbaik</h2>
        <p class="section-sub dark">Tersedia segar langsung dari nelayan lokal</p>
      </div>
      <a href="{{ route('login') }}" class="btn-see-all">Lihat Semua →</a>
    </div>

    <div class="products-grid-preview" id="previewGrid">
      <!-- Filled by JS -->
    </div>
  </div>
</section>

<!-- ROLES SECTION -->
<section class="roles-section">
  <div class="roles-bg-img"></div>
  <div class="roles-inner">
    <div class="section-label">Bergabung Bersama Kami</div>
    <h2 class="section-title">Pilih Peran Anda</h2>
    <p class="section-sub">Mulai perjalanan bisnis perikanan digital Anda hari ini</p>

    <div class="roles-cards">
      <div class="role-card">
        <div class="role-icon">🎣</div>
        <h3>Pengguna / Nelayan</h3>
        <p>Jual hasil tangkapan langsung ke pasar, pantau harga real-time, dan kelola stok dengan mudah dari mana saja.</p>
        <a href="?page=register&role=pengguna" class="btn-role">Daftar sebagai Nelayan</a>
      </div>
      <div class="role-card featured">
        <div class="role-badge">⭐ Populer</div>
        <div class="role-icon">🏪</div>
        <h3>Penjual / Pedagang</h3>
        <p>Buka toko online, kelola inventaris, terima pesanan dari seluruh Indonesia, dan tingkatkan omset bisnis Anda.</p>
        <a href="?page=register&role=penjual" class="btn-role featured-btn">Daftar sebagai Penjual</a>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-logo">🐟 Sea<strong>Biz</strong></div>
  <p>© 2025 SeaBiz. Platform Bisnis Perikanan Indonesia. Semua hak dilindungi.</p>
</footer>

<script>
// Preview produk di halaman utama (simulasi data dari API)
const previewProducts = [
  { nama: 'Ikan Tuna Segar', harga: 85000, satuan: 'kg', penjual: 'Toko Bahari', img: 'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=400&q=80', badge: 'Segar' },
  { nama: 'Udang Vaname Premium', harga: 65000, satuan: 'kg', penjual: 'Sari Seafood', img: 'https://images.unsplash.com/photo-1565680018434-b1f2c97b5d4b?w=400&q=80', badge: 'Best Seller' },
  { nama: 'Lobster Mutiara', harga: 350000, satuan: 'ekor', penjual: 'Lombok Fresh', img: 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=400&q=80', badge: 'Premium' },
  { nama: 'Ikan Salmon Fillet', harga: 120000, satuan: 'kg', penjual: 'Pacific Fish', img: 'https://images.unsplash.com/photo-1612208695882-02f2322b7fee?w=400&q=80', badge: 'Import' },
];

const grid = document.getElementById('previewGrid');
previewProducts.forEach(p => {
  grid.innerHTML += `
    <div class="product-preview-card">
      <div class="product-img-wrap">
        <img src="${p.img}" alt="${p.nama}" loading="lazy" />
        <span class="product-badge">${p.badge}</span>
      </div>
      <div class="product-info">
        <h4>${p.nama}</h4>
        <p class="product-seller">🏪 ${p.penjual}</p>
        <div class="product-price">Rp ${p.harga.toLocaleString('id-ID')} <span>/ ${p.satuan}</span></div>
      </div>
    </div>`;
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
  const nav = document.querySelector('.navbar');
  if (window.scrollY > 60) {
    nav.style.background = 'rgba(10, 35, 66, 0.98)';
  } else {
    nav.style.background = 'rgba(10, 35, 66, 0.85)';
  }
});
</script>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
