# ChipiChapa Store
**LnT Final Project – Back-End Development (Laravel 9)**

Aplikasi pendataan & penjualan barang berbasis web untuk PT ChipiChapa.

---

## Fitur Utama
- **Admin**: CRUD Barang (+ upload foto), CRUD Kategori Barang
- **User**: Katalog barang, Keranjang belanja, Cetak faktur/invoice
- **Auth**: Login & Register user, Admin via seeder
- **Middleware**: Role-based access (admin/user)
- **Validasi**: Stok habis, format email, nomor HP, kode pos, dll.
- **Seeder & Factory**: Data dummy user, admin, kategori, barang

---

## Cara Setup

### 1. Clone / Salin Project
```bash
composer create-project laravel/laravel chipichapa "^9.0"
cd chipichapa
```

### 2. Salin semua file dari repository ini ke dalam folder project Laravel

### 3. Install dependencies
```bash
composer install
```

### 4. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi database di `.env`
```env
DB_DATABASE=chipichapa_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Buat database di MySQL
```sql
CREATE DATABASE chipichapa_db;
```

### 7. Jalankan migration & seeder
```bash
php artisan migrate --seed
```

### 8. Buat symbolic link untuk storage (foto barang)
```bash
php artisan storage:link
```

### 9. Jalankan server
```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## Akun Default (dari Seeder)

| Role  | Email             | Password  |
|-------|-------------------|-----------|
| Admin | admin@gmail.com   | admin123  |
| User  | *(dari factory)*  | password  |

> Admin hanya bisa dibuat lewat seeder/database secara manual, tidak ada halaman register untuk admin.

---

## Struktur Database

| Tabel           | Keterangan                            |
|-----------------|---------------------------------------|
| `users`         | Data user & admin (role-based)        |
| `kategori_barang` | Kategori barang                     |
| `barang`        | Data barang (FK ke kategori_barang)   |
| `fakturs`       | Header faktur/invoice                 |
| `faktur_items`  | Detail item per faktur                |

---

## Struktur Folder Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── Admin/
│   │   │   ├── BarangController.php
│   │   │   └── KategoriController.php
│   │   └── User/
│   │       ├── KatalogController.php
│   │       ├── KeranjangController.php
│   │       └── FakturController.php
│   ├── Middleware/
│   │   ├── RoleMiddleware.php
│   │   ├── Authenticate.php
│   │   └── RedirectIfAuthenticated.php
│   └── Kernel.php
├── Models/
│   ├── User.php
│   ├── KategoriBarang.php
│   ├── Barang.php
│   ├── Faktur.php
│   └── FakturItem.php
database/
├── migrations/         # 5 file migration
├── seeders/            # AdminSeeder, UserSeeder, KategoriSeeder, BarangSeeder
└── factories/          # UserFactory, KategoriBarangFactory, BarangFactory
resources/views/
├── layouts/app.blade.php
├── auth/               # login.blade.php, register.blade.php
├── admin/
│   ├── barang/         # index, create, edit
│   └── kategori/       # index, create, edit
└── user/
    ├── katalog/        # index
    └── faktur/         # keranjang, create, show, cetak, history
routes/
└── web.php
```

---

## Validasi yang Diterapkan

### User Register
- Nama Lengkap: min 3, max 40 huruf
- Email: harus `@gmail.com`
- Password: min 6, max 12 huruf
- No. HP: harus diawali `08`

### Barang (Admin)
- Nama Barang: min 5, max 80 huruf
- Harga: required integer, display `Rp.`
- Jumlah: required integer
- Foto: image (jpeg/png/jpg/gif), max 2MB

### Faktur (User)
- Alamat Pengiriman: min 10, max 100 huruf
- Kode Pos: tepat 5 digit angka

### Middleware
- User biasa coba akses halaman Admin → redirect ke katalog
- Barang habis → pesan validasi stok habis

---

**Deadline**: 6 April 2026, pukul 23.59 WIB  
**Bonus** jika selesai sebelum 31 Maret 2026 pukul 23.59 WIB 🎯
