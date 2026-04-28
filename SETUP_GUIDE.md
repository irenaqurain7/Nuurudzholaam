# PANDUAN SETUP WEBSITE PPDB NUURUDZHOLAAM

## Persiapan Awal

### Sebelum Mulai
Pastikan sudah memiliki:
- XAMPP/WAMP/MAMP (untuk Apache + MySQL)
- PHP 8.0 atau lebih tinggi
- Composer (https://getcomposer.org)
- Node.js & NPM (https://nodejs.org)

---

## LANGKAH 1: Setup Database

### A. Buat Database MySQL
1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Klik "New" untuk membuat database baru
3. Ketik nama database: `nuurudzholaam`
4. Klik "Create"

### B. Konfigurasi File .env
1. Di folder project, copy file `.env.example` menjadi `.env`
2. Edit file `.env` dan ubah bagian database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nuurudzholaam
DB_USERNAME=root
DB_PASSWORD=
```

---

## LANGKAH 2: Install Dependencies

### A. Install Composer Dependencies
```bash
cd Nuurudzholaam
composer install
```

### B. Install NPM Dependencies
```bash
npm install
```

### C. Generate Application Key
```bash
php artisan key:generate
```

---

## LANGKAH 3: Setup Database

### Jalankan Migrations
```bash
php artisan migrate
```

Ini akan membuat 7 tabel otomatis:
- `ppdb_registrations`
- `activities`
- `programs`
- `galleries`
- `announcements`
- `faqs`
- `school_info`

---

## LANGKAH 4: Setup Storage & Public

### A. Link Storage
```bash
php artisan storage:link
```

### B. Build Assets
```bash
npm run build
```

Atau untuk development (dengan watch):
```bash
npm run dev
```

---

## LANGKAH 5: Jalankan Server

### Terminal 1: Laravel Development Server
```bash
php artisan serve
```
Server akan berjalan di: `http://localhost:8000`

### Terminal 2: Vite Development Server (jika npm run dev)
```bash
npm run dev
```

---

## LANGKAH 6: Akses Website

### Public Website
- Homepage: http://localhost:8000
- PPDB: http://localhost:8000/ppdb
- Kegiatan: http://localhost:8000/kegiatan
- Program: http://localhost:8000/program
- Profil: http://localhost:8000/profil
- Kontak: http://localhost:8000/kontak
- FAQ: http://localhost:8000/faq

### Admin Panel
- Dashboard: http://localhost:8000/admin/dashboard
- (Perlu login terlebih dahulu)

---

## LANGKAH 7: Setup Admin User (Authentikasi)

### Opsi A: Menggunakan Tinker (Interaktif)
```bash
php artisan tinker
```

Kemudian jalankan:
```php
use App\Models\User;

User::create([
    'name' => 'Admin Sekolah',
    'email' => 'admin@nuurudzholaam.sch.id',
    'password' => bcrypt('password123'),
]);

exit
```

### Opsi B: Membuat Seeder
```bash
php artisan make:seeder AdminUserSeeder
```

Edit file `database/seeders/AdminUserSeeder.php`:
```php
<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@nuurudzholaam.sch.id',
            'password' => bcrypt('password123'),
        ]);
    }
}
```

Jalankan seeder:
```bash
php artisan db:seed --class=AdminUserSeeder
```

### Login Admin
- Email: `admin@nuurudzholaam.sch.id`
- Password: `password123`
- URL: http://localhost:8000/login

---

## LANGKAH 8: Setup Informasi Sekolah

1. Login ke admin panel
2. Klik menu "Pengaturan" → "Informasi Sekolah"
3. Isi informasi sekolah:
   - Nama Sekolah
   - Deskripsi
   - Visi
   - Misi
   - Alamat
   - No Telepon
   - Email
   - Website
   - Upload Logo (opsional)
   - Upload Gambar Utama (opsional)
4. Klik "Simpan Perubahan"

---

## LANGKAH 9: Tambah Program/Jurusan

1. Di admin panel, klik "Manajemen Konten" → "Program"
2. Klik tombol "Tambah Program"
3. Isi form:
   - Nama Program (contoh: "IPA", "IPS", "Keagamaan")
   - Deskripsi program
   - Kurikulum (opsional)
   - Kuota siswa
   - Upload gambar (opsional)
4. Klik "Simpan"

---

## LANGKAH 10: Tambah Kegiatan/Dokumentasi

1. Klik "Manajemen Konten" → "Kegiatan"
2. Klik "Tambah Kegiatan"
3. Isi form:
   - Judul kegiatan
   - Deskripsi
   - Tanggal
   - Kategori (Kegiatan/Dokumentasi/Berita/Pengumuman)
   - Visibility (Guru/Orang Tua/Publik)
   - Upload gambar
4. Klik "Simpan"

---

## LANGKAH 11: Buat Pengumuman

1. Klik "Manajemen Konten" → "Pengumuman"
2. Klik "Tambah Pengumuman"
3. Isi form:
   - Judul
   - Konten
   - Tipe (Umum/PPDB/Libur/Penting)
   - Status (Aktif/Arsip)
   - Tanggal mulai
   - Tanggal selesai (opsional)
4. Klik "Simpan"

---

## LANGKAH 12: Atur FAQ

1. Klik "Manajemen Konten" → "FAQ"
2. Klik "Tambah FAQ"
3. Isi form:
   - Pertanyaan
   - Jawaban
   - Kategori
   - Urutan (untuk sorting)
4. Klik "Simpan"

---

## TROUBLESHOOTING

### Error: "No Application Encryption Key Has Been Specified"
**Solusi:**
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000]: General Error"
**Solusi:**
```bash
php artisan migrate:fresh
```

### Error: Storage Link tidak bekerja
**Solusi:**
```bash
php artisan storage:link
```

### Page Blank atau 500 Error
**Solusi:**
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`
- Restart server: Ctrl+C lalu jalankan ulang `php artisan serve`

### File Upload tidak bekerja
**Solusi:**
- Pastikan folder `storage/app/public` memiliki write permission
- Di Windows, klik kanan folder → Properties → Security → Edit
- Pastikan file sudah ter-link dengan `php artisan storage:link`

---

## FILE & FOLDER PENTING

```
Nuurudzholaam/
├── app/
│   ├── Http/Controllers/
│   │   ├── PublicController.php      (Logic halaman publik)
│   │   ├── PPDBController.php        (Logic PPDB)
│   │   └── AdminController.php       (Logic admin)
│   └── Models/
│       ├── User.php
│       ├── PPDBRegistration.php
│       ├── Activity.php
│       ├── Program.php
│       ├── Gallery.php
│       ├── Announcement.php
│       ├── FAQ.php
│       └── SchoolInfo.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php        (Layout publik)
│   │   │   └── admin.blade.php      (Layout admin)
│   │   ├── *.blade.php              (Halaman publik)
│   │   └── admin/                   (Halaman admin)
│   ├── css/
│   │   ├── app.css
│   │   └── ppdb.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── routes/
│   ├── web.php                       (Semua routes)
│   ├── api.php
│   ├── channels.php
│   └── console.php
├── database/
│   ├── migrations/                   (Database schema)
│   └── seeders/                      (Sample data)
├── storage/
│   ├── app/public/                   (File uploads)
│   └── logs/                         (Log files)
├── public/
│   ├── index.php
│   ├── storage/ → ../storage/app/public
│   └── images/
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ...
├── .env                              (Configuration)
├── artisan                           (CLI tool)
├── composer.json                     (PHP dependencies)
├── package.json                      (NPM dependencies)
└── vite.config.js                    (Vite config)
```

---

## COMMANDS PENTING

```bash
# Database
php artisan migrate                  # Run migrations
php artisan migrate:rollback         # Undo migrations
php artisan migrate:fresh            # Reset & migrate
php artisan db:seed                  # Run seeders
php artisan tinker                   # Interactive shell

# Server
php artisan serve                    # Start dev server
npm run dev                          # Start Vite dev server
npm run build                        # Build production assets

# Maintenance
php artisan cache:clear              # Clear cache
php artisan config:clear             # Clear config
php artisan view:clear               # Clear views
php artisan storage:link             # Link storage

# Development
php artisan make:migration <name>    # Create migration
php artisan make:model <name>        # Create model
php artisan make:controller <name>   # Create controller
php artisan make:seeder <name>       # Create seeder
```

---

## NOTES KEAMANAN

1. **Jangan bagikan credentials** (password, API keys, secrets)
2. **Update dependencies** secara berkala:
   ```bash
   composer update
   npm update
   ```
3. **Gunakan HTTPS** di production
4. **Change default password** untuk admin user
5. **Backup database** secara regular
6. **Set file permissions** yang sesuai

---

## NEXT STEPS

Setelah setup selesai:
1. ✅ Tambah informasi sekolah
2. ✅ Tambah program/jurusan
3. ✅ Upload foto dokumentasi
4. ✅ Buat pengumuman
5. ✅ Atur FAQ
6. ✅ Test website dari desktop dan mobile
7. ✅ Bagikan link website ke masyarakat
8. ✅ Monitor pendaftaran PPDB

---

**Terima kasih telah menggunakan Website PPDB Nuurudzholaam!**

Untuk bantuan lebih lanjut, silakan hubungi admin atau developer.
