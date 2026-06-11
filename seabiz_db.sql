-- =============================================
-- SeaBiz Database Schema
-- Jalankan file ini di phpMyAdmin atau MySQL CLI
-- =============================================

CREATE DATABASE IF NOT EXISTS seabiz_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE seabiz_db;

-- --------- TABEL USERS ---------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('pengguna','penjual') DEFAULT 'pengguna',
    phone VARCHAR(30) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------- TABEL KATEGORI ---------
CREATE TABLE IF NOT EXISTS kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    icon VARCHAR(10) DEFAULT '🐟',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------- TABEL PRODUK ---------
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(15,2) NOT NULL,
    stok INT DEFAULT 0,
    satuan VARCHAR(30) DEFAULT 'kg',
    kategori_id INT,
    penjual_id INT,
    kota VARCHAR(100) DEFAULT 'Indonesia',
    badge VARCHAR(50) DEFAULT 'Baru',
    rating DECIMAL(3,1) DEFAULT 0,
    terjual INT DEFAULT 0,
    gambar_url VARCHAR(500) DEFAULT NULL,
    status ENUM('aktif','nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL,
    FOREIGN KEY (penjual_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tambahkan kolom produk baru jika file ini dijalankan pada database yang sudah ada
ALTER TABLE produk ADD COLUMN IF NOT EXISTS kota VARCHAR(100) DEFAULT 'Indonesia';
ALTER TABLE produk ADD COLUMN IF NOT EXISTS badge VARCHAR(50) DEFAULT 'Baru';
ALTER TABLE produk ADD COLUMN IF NOT EXISTS rating DECIMAL(3,1) DEFAULT 0;
ALTER TABLE produk ADD COLUMN IF NOT EXISTS terjual INT DEFAULT 0;

-- --------- TABEL PESANAN ---------
CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_pesanan VARCHAR(50) UNIQUE NOT NULL,
    pembeli_id INT NOT NULL,
    total DECIMAL(15,2) NOT NULL,
    status ENUM('belum_dibayar','sedang_dikemas','dikirim','selesai','dibatalkan','dikembalikan') DEFAULT 'belum_dibayar',
    alamat_pengiriman TEXT,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pembeli_id) REFERENCES users(id) ON DELETE CASCADE
);

-- --------- TABEL DETAIL PESANAN ---------
CREATE TABLE IF NOT EXISTS detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pesanan_id INT NOT NULL,
    produk_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(15,2) NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE CASCADE
);

-- --------- TABEL NOTIFIKASI ---------
CREATE TABLE IF NOT EXISTS notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    pesan TEXT NOT NULL,
    icon VARCHAR(10) DEFAULT '🔔',
    tipe ENUM('info','sukses','peringatan','error') DEFAULT 'info',
    dibaca TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- --------- TABEL ULASAN ---------
CREATE TABLE IF NOT EXISTS ulasan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produk_id INT NOT NULL,
    user_id INT NOT NULL,
    rating TINYINT CHECK (rating BETWEEN 1 AND 5),
    komentar TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- DATA AWAL (SEED)
-- =============================================

-- Kategori
INSERT INTO kategori (nama, icon) VALUES
('Ikan Segar', '🐟'),
('Ikan Beku', '🧊'),
('Hasil Laut', '🦐'),
('Olahan Ikan', '🍱'),
('Peralatan Nelayan', '🎣');

-- User demo (password: demo1234 — di produksi gunakan password_hash())
INSERT INTO users (nama, email, username, password, role) VALUES
('Budi Santoso', 'budi@seabiz.id', '_budiputra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pengguna'),
('Sari Nelayan', 'sari@seabiz.id', '_sarinelayan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'penjual'),
('Toko Bahari', 'bahari@seabiz.id', '_tokobahari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'penjual');

-- Produk demo dengan gambar dari Unsplash (free)
INSERT INTO produk (nama, deskripsi, harga, stok, satuan, kategori_id, penjual_id, kota, badge, rating, terjual, gambar_url, status) VALUES
('Ikan Tuna Segar', 'Ikan tuna segar langsung dari nelayan, cocok untuk sashimi dan steak ikan. Ditangkap hari ini!', 85000, 150, 'kg', 1, 2, 'Surabaya', 'Segar', 4.8, 2341, 'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=400&q=80', 'aktif'),

('Udang Vaname Premium', 'Udang vaname segar ukuran jumbo, cocok untuk berbagai masakan. Tanpa kepala beku.', 65000, 80, 'kg', 3, 2, 'Sidoarjo', 'Best Seller', 4.9, 1876, 'https://images.unsplash.com/photo-1565680018434-b1f2c97b5d4b?w=400&q=80', 'aktif'),

('Cumi-cumi Segar', 'Cumi-cumi segar hasil tangkapan laut dalam. Tekstur kenyal dan lezat.', 45000, 200, 'kg', 3, 3, 'Gresik', 'Segar', 4.6, 987, 'https://images.unsplash.com/photo-1559737558-2f5a35f4523b?w=400&q=80', 'aktif'),

('Ikan Bandeng Presto', 'Bandeng presto tulang lunak, bumbu rempah khas Jawa Tengah. Praktis dan lezat.', 35000, 120, 'ekor', 4, 3, 'Sidoarjo', 'Populer', 4.7, 3210, 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&q=80', 'aktif'),

('Lobster Mutiara', 'Lobster mutiara segar berukuran besar dari perairan Lombok. Tinggi protein!', 350000, 20, 'ekor', 3, 2, 'Lombok', 'Premium', 5.0, 421, 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?w=400&q=80', 'aktif'),

('Ikan Salmon Fillet', 'Salmon fillet impor premium, tanpa tulang, cocok untuk salmon roll dan bakar.', 120000, 60, 'kg', 1, 3, 'Jakarta', 'Import', 4.8, 1543, 'https://images.unsplash.com/photo-1612208695882-02f2322b7fee?w=400&q=80', 'aktif'),

('Kepiting Rajungan', 'Kepiting rajungan segar dari tambak Sidoarjo. Dagingnya manis dan penuh.', 75000, 90, 'kg', 3, 2, 'Sidoarjo', 'Jumbo', 4.7, 654, 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=400&q=80', 'aktif'),

('Abon Ikan Tuna', 'Abon ikan tuna homemade, dimasak dengan bumbu rempah pilihan. Tahan 3 bulan.', 28000, 300, 'pcs', 4, 3, 'Sidoarjo', 'Terlaris', 4.9, 4532, 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400&q=80', 'aktif');

-- Notifikasi demo
INSERT INTO notifikasi (user_id, judul, pesan, icon, tipe) VALUES
(1, 'Pesanan Dikonfirmasi', 'Pesanan #ORD-2025001 Anda telah dikonfirmasi oleh penjual.', '📦', 'sukses'),
(1, 'Promo Weekend', 'Dapatkan diskon 20% untuk semua produk ikan segar akhir pekan ini!', '🎁', 'info'),
(1, 'Pesanan Selesai', 'Pesanan #ORD-2025002 telah selesai. Berikan penilaian produk!', '⭐', 'sukses');

-- Pesanan demo
INSERT INTO pesanan (nomor_pesanan, pembeli_id, total, status, alamat_pengiriman) VALUES
('ORD-2025001', 1, 255000, 'selesai', 'Jl. Nelayan No. 12, Sidoarjo, Jawa Timur'),
('ORD-2025002', 1, 85000, 'sedang_dikemas', 'Jl. Nelayan No. 12, Sidoarjo, Jawa Timur'),
('ORD-2025003', 1, 350000, 'belum_dibayar', 'Jl. Nelayan No. 12, Sidoarjo, Jawa Timur');

INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga_satuan, subtotal) VALUES
(1, 1, 2, 85000, 170000),
(1, 4, 1, 85000, 85000),
(2, 1, 1, 85000, 85000),
(3, 5, 1, 350000, 350000);
