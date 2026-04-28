# Website PPDB Sekolah Islam Nuurudzholaam

## Deskripsi Website

Website PPDB (Penerimaan Peserta Didik Baru) ini dirancang khusus untuk Sekolah Islam Nuurudzholaam dengan fitur lengkap untuk mengelola pendaftaran siswa baru, membagikan informasi kegiatan, dokumentasi, dan komunikasi dengan masyarakat.

## Fitur Utama

### 1. **Halaman Publik (Public Pages)**
- **Homepage**: Menampilkan informasi sekolah, program, kegiatan terbaru, galeri, dan pengumuman
- **Halaman PPDB**: Form pendaftaran calon siswa dengan validasi lengkap
- **Halaman Program**: Menampilkan detail program/jurusan yang tersedia
- **Halaman Kegiatan**: Dokumentasi kegiatan dan berita sekolah
- **Halaman Profil**: Informasi lengkap tentang sekolah, visi, misi, dan galeri
- **Halaman Kontak**: Form kontak dan informasi kontak sekolah
- **Halaman FAQ**: Pertanyaan umum yang sering diajakan

### 2. **Admin Panel (Management Dashboard)**
- **Dashboard**: Ringkasan statistik (total PPDB, pending, kegiatan, program)
- **Manajemen PPDB**: 
  - Lihat daftar pendaftar
  - Detail pendaftar
  - Ubah status (pending, diterima, ditolak)
  - Export data
- **Manajemen Kegiatan**: CRUD kegiatan dengan kategori dan visibility
- **Manajemen Galeri**: Upload dan kelola foto dokumentasi
- **Manajemen Program**: CRUD program/jurusan dengan kuota
- **Manajemen Pengumuman**: CRUD pengumuman dengan tipe dan status
- **Manajemen FAQ**: CRUD FAQ dengan kategori
- **Pengaturan Sekolah**: Edit informasi sekolah, visi, misi, kontak

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript, Blade Templating
- **Styling**: Tailwind CSS + Custom CSS (Warna Hijau Islami)
- **Package Manager**: Composer, NPM/Vite
- **Icons**: Font Awesome 6

## Palet Warna

- **Primary (Hijau Islami Lembut)**: #1f7f5f, #2d8659
- **Secondary (Putih)**: #ffffff
- **Accent (Emas)**: #d4af37, #ffc107
- **Text Dark**: #1a202c
- **Text Light**: #4a5568
- **Background Light**: #f7fafc

## Struktur Database

### Tabel PPDB Registrations
```sql
- id (Primary Key)
- nama_lengkap
- email (unique)
- no_telepon
- asal_sekolah
- nama_ortu
- no_ortu
- tanggal_lahir
- program (ipa, ips, keagamaan)
- alamat
- file_ijazah (nullable)
- file_ktp (nullable)
- status (pending, diterima, ditolak)
- tgl_daftar
- timestamps
```

### Tabel Activities
```sql
- id (Primary Key)
- judul
- deskripsi
- tanggal
- gambar (nullable)
- kategori (kegiatan, dokumentasi, berita, pengumuman)
- visibility (guru, ortu, publik)
- timestamps
```

### Tabel Programs
```sql
- id (Primary Key)
- nama_program
- deskripsi
- kurikulum (nullable)
- gambar (nullable)
- kuota
- timestamps
```

### Tabel Galleries
```sql
- id (Primary Key)
- judul
- deskripsi (nullable)
- gambar
- tanggal
- kategori
- timestamps
```

### Tabel Announcements
```sql
- id (Primary Key)
- judul
- konten
- tipe (umum, ppdb, libur, penting)
- tanggal_mulai
- tanggal_selesai (nullable)
- status (aktif, arsip)
- timestamps
```

### Tabel FAQs
```sql
- id (Primary Key)
- pertanyaan
- jawaban
- kategori (umum, ppdb, akademik, fasilitas)
- urutan
- timestamps
```

### Tabel School Info
```sql
- id (Primary Key)
- nama_sekolah
- deskripsi
- visi (nullable)
- misi (nullable)
- alamat
- no_telepon
- email
- website (nullable)
- logo (nullable)
- gambar_utama (nullable)
- timestamps
```

## Instalasi & Setup

### 1. Clone Repository atau Copy Files
```bash
cd Project_WebprogIII/Nuurudzholaam
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Copy Environment File
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database
Edit file `.env` dan sesuaikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nuurudzholaam
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrations
```bash
php artisan migrate
```

### 7. Build Assets
```bash
npm run build
```

### 8. Jalankan Server
```bash
php artisan serve
```

Website akan accessible di `http://localhost:8000`

## Routes yang Tersedia

### Public Routes
```
GET  /                          - Homepage
GET  /ppdb                      - Halaman PPDB
POST /ppdb                      - Submit Pendaftaran PPDB
GET  /kegiatan                  - Halaman Kegiatan
GET  /program                   - Halaman Program
GET  /profil                    - Halaman Profil
GET  /kontak                    - Halaman Kontak
POST /kontak                    - Submit Form Kontak
GET  /faq                       - Halaman FAQ
```

### Admin Routes (Protected by Auth Middleware)
```
GET  /admin/dashboard                    - Dashboard Admin
GET  /admin/ppdb                         - List PPDB
GET  /admin/ppdb/{id}                    - Detail PPDB
PATCH /admin/ppdb/{id}/status/{status}   - Update Status PPDB

GET  /admin/activity                     - List Kegiatan
GET  /admin/activity/create              - Form Tambah Kegiatan
POST /admin/activity                     - Store Kegiatan
GET  /admin/activity/{id}/edit           - Form Edit Kegiatan
PUT  /admin/activity/{id}                - Update Kegiatan
DELETE /admin/activity/{id}              - Hapus Kegiatan

GET  /admin/program                      - List Program
GET  /admin/program/create               - Form Tambah Program
POST /admin/program                      - Store Program
GET  /admin/program/{id}/edit            - Form Edit Program
PUT  /admin/program/{id}                 - Update Program
DELETE /admin/program/{id}               - Hapus Program

GET  /admin/gallery                      - List Galeri
GET  /admin/gallery/create               - Form Tambah Foto
POST /admin/gallery                      - Store Foto
DELETE /admin/gallery/{id}               - Hapus Foto

GET  /admin/announcement                 - List Pengumuman
GET  /admin/announcement/create          - Form Tambah Pengumuman
POST /admin/announcement                 - Store Pengumuman
GET  /admin/announcement/{id}/edit       - Form Edit Pengumuman
PUT  /admin/announcement/{id}            - Update Pengumuman
DELETE /admin/announcement/{id}          - Hapus Pengumuman

GET  /admin/faq                          - List FAQ
GET  /admin/faq/create                   - Form Tambah FAQ
POST /admin/faq                          - Store FAQ
GET  /admin/faq/{id}/edit                - Form Edit FAQ
PUT  /admin/faq/{id}                     - Update FAQ
DELETE /admin/faq/{id}                   - Hapus FAQ

GET  /admin/school-info/edit             - Form Edit Informasi Sekolah
PUT  /admin/school-info                  - Update Informasi Sekolah
```

## Penggunaan

### Untuk Masyarakat/Calon Siswa
1. Kunjungi website di URL yang diberikan
2. Jelajahi informasi sekolah melalui menu navigasi
3. Lihat program yang tersedia di halaman "Program"
4. Daftarkan diri dengan mengklik "Daftar PPDB" dan isi form pendaftaran
5. Sekolah akan menghubungi Anda dalam 24 jam
6. Bawa dokumen pendukung ke kantor sekolah

### Untuk Admin/Staff Sekolah
1. Login ke admin panel (akses dari URL `/admin/login`)
2. Di dashboard, Anda dapat melihat statistik PPDB
3. Kelola pendaftar PPDB dengan melihat, menerima, atau menolak
4. Tambahkan kegiatan dan foto dokumentasi
5. Atur program/jurusan dan kuota siswa
6. Kelola pengumuman dan FAQ
7. Update informasi sekolah di pengaturan

## Fitur Responsif

Website ini sepenuhnya responsif dan dapat diakses dari:
- Desktop/Laptop (1920px dan lebih besar)
- Tablet (768px - 1024px)
- Mobile Phone (320px - 768px)

Navigation bar secara otomatis menjadi hamburger menu di perangkat mobile.

## Keamanan

- Middleware authentikasi untuk admin panel
- Input validation di semua form
- CSRF protection
- File upload validation
- Email unique validation untuk PPDB

## Fitur Tambahan yang Bisa Dikembangkan

1. Sistem authentikasi pengguna (orang tua/siswa)
2. Email notification saat pendaftaran
3. SMS notification
4. Integration dengan payment gateway untuk biaya pendaftaran
5. Sistem pesan internal (messaging)
6. Hasil pengumuman online
7. PDF export untuk dokumen
8. QR code untuk share informasi
9. Live chat support
10. Multi-language support

## Support & Contact

Untuk pertanyaan atau dukungan teknis, silakan hubungi admin sekolah.

---

**Dibuat untuk**: Sekolah Islam Nuurudzholaam  
**Tanggal**: April 2024  
**Tahun Ajaran**: 2024/2025
