<nav class="topnav">
  <a href="{{ route('dashboard') }}" class="nav-logo">🐟 Sea<strong>Biz</strong></a>
  <div class="nav-search">
    <input type="text" id="navSearch" placeholder="Cari produk perikanan..."
           onkeydown="if(event.key==='Enter') window.location.href='{{ route('marketplace') }}?q='+this.value"/>
    <button onclick="window.location.href='{{ route('marketplace') }}?q='+document.getElementById('navSearch').value">🔍</button>
  </div>
  <div class="nav-links">
    <a href="{{ route('dashboard') }}"    class="nav-link {{ request()->routeIs('dashboard')    ? 'active' : '' }}">Home</a>
    <a href="{{ route('marketplace') }}"  class="nav-link {{ request()->routeIs('marketplace')  ? 'active' : '' }}">Marketplace</a>
    <a href="{{ route('info-harga') }}"   class="nav-link {{ request()->routeIs('info-harga')   ? 'active' : '' }}">Info Harga</a>
    <a href="{{ route('cerita-umkm') }}"  class="nav-link {{ request()->routeIs('cerita-umkm')  ? 'active' : '' }}">Cerita UMKM</a>
    <a href="{{ route('notifikasi') }}"   class="nav-link {{ request()->routeIs('notifikasi')   ? 'active' : '' }}">Notifikasi</a>
  </div>
  <a href="{{ route('keranjang') }}" class="nav-cart">
    🛒 <span id="cartBadge" class="cart-badge">0</span>
  </a>
  <div class="nav-user" style="position:relative;cursor:pointer;" tabindex="0" role="button" aria-haspopup="true" aria-expanded="false">
    <div class="nav-avatar nav-avatar-circle" id="navAvatar">B</div>
    <span id="navUsername">_budiputra</span>
    <div class="user-dropdown">
      <div class="dropdown-header">
        <div class="dh-name" id="ddName">Budi Santoso</div>
        <div class="dh-role" id="ddRole">🎣 Pengguna Aktif</div>
      </div>
      <a class="dropdown-item" href="{{ route('akun') }}">
        <span class="di-icon">👤</span> Profil Saya
      </a>
      <a class="dropdown-item" href="{{ route('pesanan') }}">
        <span class="di-icon">📦</span> Pesanan Saya
      </a>
      <a class="dropdown-item" href="{{ route('keranjang') }}">
        <span class="di-icon">🛒</span> Keranjang
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item logout" href="{{ route('logout') }}"
         onclick="event.preventDefault();document.getElementById('navLogoutForm').submit()">
        <span class="di-icon">🚪</span> Keluar
      </a>
    </div>
  </div>
  <form id="navLogoutForm" action="{{ route('logout') }}" method="POST" style="display:none">
    @csrf
  </form>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const profileTrigger = document.querySelector('.nav-user');
    const dropdown = profileTrigger?.querySelector('.user-dropdown');

    if (!profileTrigger || !dropdown) return;

    const openMenu = () => {
      profileTrigger.classList.add('open');
      profileTrigger.setAttribute('aria-expanded', 'true');
      dropdown.style.display = 'block';
    };

    const closeMenu = () => {
      profileTrigger.classList.remove('open');
      profileTrigger.setAttribute('aria-expanded', 'false');
      dropdown.style.display = '';
    };

    profileTrigger.addEventListener('mouseenter', openMenu);
    profileTrigger.addEventListener('mouseleave', () => {
      if (!profileTrigger.classList.contains('is-clicked')) closeMenu();
    });

    profileTrigger.addEventListener('click', (event) => {
      if (event.target.closest('.dropdown-item')) return;
      event.stopPropagation();
      const shouldOpen = !profileTrigger.classList.contains('open');
      profileTrigger.classList.toggle('is-clicked', shouldOpen);
      if (shouldOpen) openMenu(); else closeMenu();
    });

    profileTrigger.addEventListener('focus', openMenu);
    profileTrigger.addEventListener('blur', (event) => {
      if (!profileTrigger.contains(event.relatedTarget)) closeMenu();
    });

    dropdown.addEventListener('mouseenter', openMenu);
    dropdown.addEventListener('mouseleave', () => {
      if (!profileTrigger.classList.contains('is-clicked')) closeMenu();
    });

    document.addEventListener('click', (event) => {
      if (!profileTrigger.contains(event.target)) {
        profileTrigger.classList.remove('is-clicked');
        closeMenu();
      }
    });
  });
</script>
