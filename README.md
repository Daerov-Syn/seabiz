# 🐟 SeaBiz — Platform Bisnis Perikanan

## Cara Menjalankan

### 1. Install dependencies
```bash
composer install
npm install
```

### 2. Setup database
Edit `.env` jika password MySQL berbeda:
```
DB_DATABASE=seabiz_db
DB_USERNAME=root
DB_PASSWORD=        ← isi jika ada password
```

### 3. Import database
```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS seabiz_db;"
mysql -u root -p seabiz_db < seabiz_db.sql
```

### 4. Jalankan (buka 2 terminal)
```bash
# Terminal 1
npm run dev

# Terminal 2
php artisan serve
```

Buka: http://localhost:8000

---
> APP_KEY sudah di-generate otomatis. Tidak perlu `php artisan key:generate`.
