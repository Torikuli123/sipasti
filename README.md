# SIPASTI — Sistem Pengelolaan Arsip

Aplikasi manajemen arsip institusi berbasis Laravel dengan fitur AI Recommendation.

## Fitur
- 🔐 Autentikasi pengguna (Login/Logout)
- 📊 Dashboard dengan statistik real-time
- 📁 CRUD Arsip lengkap (Form Input Arsip)
- 🔍 Filter dan pencarian arsip
- 📤 Export data ke Excel/CSV
- 🤖 AI Recommendation (klasifikasi & deteksi duplikat)
- 📱 Responsive design

## Persyaratan
- PHP >= 8.1
- Composer
- MySQL / PostgreSQL / SQLite
- Laravel 10+

---

## Instalasi

### 1. Clone / salin project
```bash
# Jika dari Git
git clone <repo-url> sipasti
cd sipasti
```

### 2. Install dependencies
```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_NAME="SIPASTI"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipasti
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup database
```bash
# Buat database sipasti di MySQL, lalu:
php artisan migrate
php artisan db:seed
```

### 5. Storage link
```bash
php artisan storage:link
```

### 6. Jalankan server
```bash
php artisan serve
```

Akses: **http://localhost:8000**

---

## Login Default
| Field    | Value              |
|----------|--------------------|
| Email    | admin@sipasti.id   |
| Password | password           |

---

## Struktur Halaman

| Route           | Halaman                |
|-----------------|------------------------|
| `/login`        | Halaman Login          |
| `/`             | Dashboard              |
| `/arsip`        | Daftar Arsip           |
| `/arsip/create` | Form Tambah Arsip      |
| `/arsip/{id}/edit` | Edit Arsip          |
| `/export`       | Export Excel           |
| `/ai`           | AI Recommendation      |

---

## Teknologi
- **Backend**: Laravel 10, PHP 8.1+
- **Frontend**: Blade Templates, CSS Custom, Vanilla JS
- **Font**: Plus Jakarta Sans + DM Mono
- **Icons**: Font Awesome 6
- **Database**: MySQL/SQLite
- **File Upload**: Laravel Storage (local/S3)

---

## Kustomisasi Warna (CSS Variables)
Edit `public/css/app.css` bagian `:root`:
```css
:root {
    --primary: #1a3a5c;      /* Sidebar background */
    --accent: #2563EB;        /* Primary blue */
    --success: #10B981;       /* Green */
    /* ... */
}
```

## Export Excel Sesungguhnya
Untuk export `.xlsx` yang sesungguhnya, install **Maatwebsite Excel**:
```bash
composer require maatwebsite/excel
```
Kemudian buat `ArsipExport` class dan gunakan `Excel::download()` di `ExportController`.
