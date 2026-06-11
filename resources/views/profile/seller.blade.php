@extends('layouts.app')

@section('title', 'Profil Penjual — SeaBiz')

@section('styles')
<style>
  .seller-shell { display:grid; gap:22px; margin:24px auto; max-width:1200px; padding:0 20px 28px; }
  .seller-card { background:white; border:1px solid var(--border); border-radius:24px; box-shadow:var(--shadow-sm); overflow:hidden; }
  .seller-hero { padding:24px; background:linear-gradient(135deg,#0d3b7c,#1890ff); color:white; }
  .seller-grid { display:grid; grid-template-columns:1.1fr .9fr; gap:18px; }
  .seller-stat { background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.2); border-radius:16px; padding:14px; }
  .seller-stat strong { display:block; font-size:1.5rem; margin-top:4px; }
  .seller-section { padding:22px 24px; }
  .seller-tabs { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px; }
  .seller-tab { padding:10px 14px; border-radius:999px; border:1px solid var(--border); background:#f8fbff; font-weight:700; color:var(--mid); cursor:pointer; }
  .seller-tab.active { background:var(--primary); color:white; border-color:var(--primary); }
  .seller-form-grid { display:grid; gap:14px; grid-template-columns:repeat(2, minmax(0, 1fr)); }
  .seller-input, .seller-textarea { width:100%; padding:12px 14px; border:1px solid var(--border); border-radius:12px; font-size:13.5px; }
  .seller-product-list { display:grid; gap:12px; }
  .seller-product { display:flex; gap:12px; padding:12px; border:1px solid var(--border); border-radius:14px; align-items:center; }
  .seller-product img { width:68px; height:68px; border-radius:10px; object-fit:cover; }
  .seller-empty { padding:24px; text-align:center; color:var(--mid); border:1px dashed var(--border); border-radius:14px; }
  @media (max-width: 900px) { .seller-grid, .seller-form-grid { grid-template-columns:1fr; } }
</style>
@endsection

@section('content')
<div class="seller-shell">
  <div class="seller-card">
    <div class="seller-hero">
      <div class="seller-grid">
        <div>
          <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; opacity:.8;">Profil Penjual</div>
          <h1 style="font-size:1.7rem; font-weight:800; margin-top:6px;">{{ $user->seller_name ?? $user->name }}</h1>
          <p style="margin-top:8px; color:rgba(255,255,255,.9); line-height:1.7;">{{ $user->seller_description ?? 'Toko resmi SeaBiz untuk menjual produk perikanan segar.' }}</p>
        </div>
        <div style="display:grid; gap:10px;">
          <div class="seller-stat">
            <span>📈 Pendapatan</span>
            <strong>Rp {{ number_format($user->seller_revenue ?? 0, 0, ',', '.') }}</strong>
          </div>
          <div class="seller-stat">
            <span>📦 Produk Aktif</span>
            <strong>{{ $products->count() }}</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="seller-section">
      <div class="seller-tabs">
        <button class="seller-tab active" onclick="showPanel('produk')">Produk Saya</button>
        <button class="seller-tab" onclick="showPanel('tambah')">Tambah Produk</button>
        <button class="seller-tab" onclick="showPanel('pendapatan')">Pendapatan</button>
      </div>

      <div id="panel-produk">
        @if($products->isEmpty())
          <div class="seller-empty">Belum ada produk yang ditambahkan. Tambahkan produk pertama Anda.</div>
        @else
          <div class="seller-product-list">
            @foreach($products as $product)
              <div class="seller-product">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/placeholder.jpg') }}" alt="{{ $product->name }}">
                <div style="flex:1;">
                  <div style="font-weight:800;">{{ $product->name }}</div>
                  <div style="font-size:12px; color:var(--mid); margin:3px 0;">{{ $product->description }}</div>
                  <div style="font-size:13px; font-weight:700; color:var(--primary-dark);">Rp {{ number_format($product->price, 0, ',', '.') }} / {{ $product->unit }}</div>
                  <div style="font-size:12px; color:var(--mid); margin-top:3px;">Stok: {{ $product->stock }}</div>
                </div>
                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline btn-sm" type="submit">Hapus</button>
                </form>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      <div id="panel-tambah" style="display:none;">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="seller-form-grid">
            <div>
              <label class="form-label">Nama Produk</label>
              <input class="seller-input" type="text" name="name" required placeholder="Contoh: Ikan Tuna Segar">
            </div>
            <div>
              <label class="form-label">Harga</label>
              <input class="seller-input" type="number" name="price" required min="0" placeholder="150000">
            </div>
            <div>
              <label class="form-label">Stok</label>
              <input class="seller-input" type="number" name="stock" required min="0" placeholder="20">
            </div>
            <div>
              <label class="form-label">Satuan</label>
              <input class="seller-input" type="text" name="unit" placeholder="kg / ekor / paket">
            </div>
          </div>
          <div style="margin-top:14px;">
            <label class="form-label">Deskripsi</label>
            <textarea class="seller-textarea" name="description" rows="3" placeholder="Jelaskan detail produk..."></textarea>
          </div>
          <div style="margin-top:14px;">
            <label class="form-label">Foto Produk</label>
            <input class="seller-input" type="file" name="image" accept="image/*">
          </div>
          <button class="btn btn-primary" style="margin-top:16px;" type="submit">➕ Tambah Produk</button>
        </form>
      </div>

      <div id="panel-pendapatan" style="display:none;">
        <div class="seller-empty">
          <div style="font-size:2rem; margin-bottom:8px;">💰</div>
          <strong>Ringkasan pendapatan</strong>
          <p style="margin-top:8px;">Pendapatan penjualan Anda akan tampil di sini. Fitur laporan lanjutan akan segera dikembangkan.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showPanel(id) {
  document.querySelectorAll('[id^="panel-"]').forEach(panel => panel.style.display = 'none');
  document.getElementById('panel-' + id).style.display = 'block';
  document.querySelectorAll('.seller-tab').forEach(tab => tab.classList.remove('active'));
  event?.target?.classList.add('active');
}
</script>
@endsection
