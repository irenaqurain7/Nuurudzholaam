# Dokumentasi Tampilan Guru (Teacher Dashboard)

## 📋 Daftar Isi
1. [Fitur Utama](#fitur-utama)
2. [Navigasi Menu](#navigasi-menu)
3. [Panduan Penggunaan](#panduan-penggunaan)
4. [Fitur-Fitur Detail](#fitur-fitur-detail)
5. [Tips & Trik](#tips--trik)

---

## 🎯 Fitur Utama

Tampilan guru menyediakan fitur lengkap untuk mengelola siswa, nilai, jadwal, dan profil:

### ✅ 1. Input Nilai Siswa
- Tambah nilai untuk setiap siswa per mata pelajaran
- Edit nilai yang sudah diinput
- Hapus nilai jika diperlukan
- Tambahkan catatan/keterangan
- Validasi otomatis untuk nilai 0-100

### ✅ 2. Manajemen Data Siswa
- Lihat daftar lengkap siswa yang diajar
- Lihat profil detail setiap siswa dengan foto
- Lihat semua nilai siswa dalam satu halaman
- Filter berdasarkan siswa untuk melihat nilai spesifik

### ✅ 3. Mengganti Password
- Form aman untuk mengubah password
- Validasi password lama
- Persyaratan minimal 8 karakter
- Konfirmasi password baru

### ✅ 4. Tambah/Edit Profil
- Edit nama lengkap
- Edit nomor telepon
- Edit alamat
- Edit biodata singkat
- Upload/ubah foto profil
- Lihat informasi yang tidak bisa diubah (Email, NIP, Bidang Keahlian)

---

## 🧭 Navigasi Menu

### Sidebar Menu (Kiri)
```
📍 Dashboard          → Halaman utama
📅 Jadwal Mengajar   → Lihat jadwal mengajar
👥 Data Siswa        → Daftar siswa yang diajar
⭐ Kelola Nilai      → Input dan kelola nilai siswa
👤 Profil            → Edit profil guru
─────────────────────
🔔 Informasi         → Pengumuman dari sekolah
📋 Kegiatan          → Daftar kegiatan sekolah
✉️ Kontak            → Informasi kontak sekolah
─────────────────────
🚪 Keluar            → Logout dari sistem
```

---

## 📖 Panduan Penggunaan

### 1. Login Sebagai Guru

```
URL: http://localhost:8000/login
Username: [username guru]
Password: [password guru]
Role: guru
```

Setelah login, Anda akan diarahkan ke Dashboard Guru.

---

### 2. Dashboard (Halaman Utama)

**Akses**: Klik menu "Dashboard" di sidebar

**Fitur:**
- 📊 Statistik: Total Siswa, Mata Pelajaran, Jadwal, Profil
- ⚡ Aksi Cepat: Tombol untuk akses cepat fitur utama
- 👤 Info Profil: Ringkasan data guru

---

### 3. Input Nilai Siswa

**Akses**: 
- Dari Dashboard → Klik "Tambah Nilai Baru"
- Dari Menu Sidebar → "Kelola Nilai" → Klik "Tambah Nilai Baru"

**Langkah-langkah:**

1. **Pilih Siswa**
   - Dropdown akan menampilkan nama siswa, kelas, dan NISN
   - Pilih siswa yang akan dinilai

2. **Masukkan Mata Pelajaran**
   - Contoh: "Matematika", "Bahasa Indonesia", "IPA", dll
   - Nama mata pelajaran dapat disesuaikan

3. **Masukkan Nilai (0-100)**
   - Sistem akan otomatis menampilkan kualitas nilai:
     - **Sangat Baik (A)**: 85-100
     - **Baik (B)**: 75-84
     - **Cukup (C)**: 65-74
     - **Kurang (D)**: 55-64
     - **Sangat Kurang (E)**: 0-54

4. **Tambahkan Keterangan (Opsional)**
   - Catatan tambahan tentang nilai siswa
   - Maksimal 500 karakter

5. **Klik "Simpan Nilai"**
   - Nilai akan disimpan dan Anda akan kembali ke daftar nilai

---

### 4. Kelola Nilai Siswa

**Akses**: Menu Sidebar → "Kelola Nilai"

**Fitur:**

1. **Filter Berdasarkan Siswa**
   - Dropdown untuk memilih siswa tertentu
   - Atau lihat semua nilai dari semua siswa
   - Klik "Cari" atau sistem auto-filter

2. **Tabel Nilai**
   - Tampilkan nama siswa, kelas, mata pelajaran, nilai
   - Color-coded badges:
     - 🟢 Green (≥75): Nilai bagus
     - 🟡 Yellow (70-74): Nilai cukup
     - 🔵 Blue (60-69): Nilai kurang
     - 🔴 Red (<60): Nilai sangat kurang

3. **Edit Nilai**
   - Klik tombol "Edit" (pensil) di samping nilai
   - Ubah data sesuai kebutuhan
   - Klik "Update Nilai"

4. **Hapus Nilai**
   - Klik tombol "Hapus" (tempat sampah)
   - Konfirmasi penghapusan
   - Nilai akan dihapus

---

### 5. Data Siswa

**Akses**: Menu Sidebar → "Data Siswa"

**Tampilan:**
- Kartu siswa dalam layout grid/kolom
- Setiap kartu menampilkan:
  - Foto profil siswa
  - Nama lengkap
  - Kelas
  - NISN, Email, No. Telepon

**Aksi:**

1. **Lihat Detail Siswa**
   - Klik "Lihat Detail"
   - Tampilan detail siswa dengan:
     - Foto dan informasi lengkap
     - Daftar semua nilai siswa
     - Rata-rata nilai
     - Total mata pelajaran
   - Dapat edit/hapus nilai dari sini

2. **Kelola Nilai Siswa**
   - Klik "Kelola Nilai"
   - Filter nilai hanya siswa tersebut

---

### 6. Jadwal Mengajar

**Akses**: Menu Sidebar → "Jadwal Mengajar"

**Tampilan:**
- Tabel jadwal dengan kolom:
  - Hari (Monday, Tuesday, dst)
  - Mata Pelajaran
  - Jam Mulai
  - Jam Selesai
  - Ruangan

---

### 7. Edit Profil

**Akses**: Menu Sidebar → "Profil"

**Bagian Kiri:**
- 📸 Upload/Ubah Foto Profil
- 🔐 Tombol untuk Ubah Password

**Bagian Kanan:**
- Form Edit Data:
  - Nama Lengkap (dapat diubah) ✏️
  - Email (tidak dapat diubah) 🔒
  - NIP (tidak dapat diubah) 🔒
  - Bidang Keahlian (tidak dapat diubah) 🔒
  - No. Telepon (dapat diubah) ✏️
  - Alamat (dapat diubah) ✏️
  - Biodata Singkat (dapat diubah) ✏️

**Langkah-langkah:**
1. Ubah data yang ingin diubah
2. Klik "Simpan Perubahan"
3. Sistem akan menampilkan pesan sukses

---

### 8. Upload Foto Profil

**Akses**: 
- Dari Profil → Klik "Ubah Foto"
- Atau Menu Sidebar → "Profil" → Bagian Foto → Klik "Ubah Foto"

**Persyaratan:**
- Format: JPG, PNG, GIF
- Maksimal: 2MB
- Akan tampil preview sebelum upload

**Langkah-langkah:**
1. Klik "Pilih Foto" atau drag-drop file
2. Preview akan menampilkan gambaran foto
3. Klik "Upload Foto"
4. Foto lama akan otomatis dihapus
5. Foto baru akan ditampilkan di profil

---

### 9. Ubah Password

**Akses**: 
- Dari Profil → Klik "Ubah Password"
- Atau Menu Sidebar → "Profil" → Bagian Keamanan

**Persyaratan:**
- ✅ Minimal 8 karakter
- ✅ Berbeda dengan password lama
- ✅ Kedua password harus sama (konfirmasi)

**Langkah-langkah:**
1. Masukkan password saat ini (untuk verifikasi)
2. Masukkan password baru
3. Konfirmasi password baru (ketik ulang)
4. Klik "Ubah Password"
5. Sistem akan menampilkan pesan sukses

---

## 🎓 Fitur-Fitur Detail

### A. Dashboard Cards

| Card | Informasi | Aksi |
|------|-----------|------|
| Total Siswa | Jumlah siswa yang diajar | Lihat Daftar Siswa |
| Mata Pelajaran | Jumlah subjek yang diajar | Kelola Nilai |
| Jadwal Mengajar | Status jadwal | Lihat Jadwal |
| Profil | Info profil guru | Edit Profil |

### B. Grade Quality Indicator

Saat memasukkan nilai, sistem akan menampilkan:

```
Nilai 95 → 🟢 Sangat Baik (A)
Nilai 80 → 🟢 Baik (B)
Nilai 70 → 🔵 Cukup (C)
Nilai 60 → 🟡 Kurang (D)
Nilai 40 → 🔴 Sangat Kurang (E)
```

### C. Filter Otomatis

Ketika memilih siswa di halaman "Kelola Nilai", form akan otomatis di-submit untuk filter nilai siswa tersebut.

### D. Statistik Nilai

- **Rata-rata**: Dihitung otomatis dari semua nilai yang ditampilkan
- **Keterangan**: Catatan yang ditambahkan saat input nilai
- **Tanggal**: Tanggal nilai dibuat/diubah

---

## 💡 Tips & Trik

### 1. Navigasi Cepat
- Gunakan menu sidebar untuk navigasi cepat
- Klik logo untuk kembali ke dashboard dari mana saja
- Gunakan tombol "Kembali" untuk kembali ke halaman sebelumnya

### 2. Input Nilai Efisien
- Gunakan "Kelola Nilai" untuk melihat semua nilai sekaligus
- Filter berdasarkan siswa untuk fokus pada siswa tertentu
- Edit langsung dari tabel atau dari detail siswa

### 3. Manajemen Data Siswa
- Lihat profil siswa untuk informasi lengkap
- Klik "Lihat Detail" untuk melihat semua nilai siswa dalam satu halaman
- Dari detail siswa, Anda dapat langsung edit atau hapus nilai

### 4. Keamanan Password
- Ganti password secara berkala
- Gunakan password yang kuat dan mudah diingat
- Jangan berikan password ke orang lain

### 5. Foto Profil
- Gunakan foto yang profesional
- Pastikan ukuran file tidak terlalu besar (max 2MB)
- Format yang didukung: JPG, PNG, GIF

### 6. Backup Data
- Catat nilai-nilai penting
- Export/print laporan jika diperlukan (fitur admin)
- Pastikan data sudah tersimpan sebelum logout

---

## ⚠️ Validasi & Error Handling

### Input Nilai
- ❌ Nilai harus antara 0-100
- ❌ Siswa harus dipilih
- ❌ Mata pelajaran harus diisi
- ❌ Keterangan maksimal 500 karakter

### Profile Update
- ✅ Nama harus diisi
- ✅ Email tidak dapat diubah
- ✅ NIP tidak dapat diubah
- ✅ Telepon harus format yang valid

### Password Change
- ❌ Password lama harus benar
- ❌ Password baru minimal 8 karakter
- ❌ Password baru harus berbeda dengan password lama
- ❌ Password baru harus sama saat konfirmasi

### File Upload
- ❌ Foto harus format JPG, PNG, atau GIF
- ❌ Ukuran file maksimal 2MB
- ❌ Hanya 1 foto yang dapat diupload sekaligus

---

## 🔐 Keamanan

### Role-Based Access
- Hanya guru yang login bisa akses teacher dashboard
- Setiap guru hanya bisa lihat siswa yang diajar
- Setiap guru hanya bisa kelola nilai siswa yang diajar

### Data Protection
- Password tidak pernah ditampilkan
- Setiap aksi memerlukan verifikasi
- Log audit untuk penghapusan data (jika diimplementasikan)

---

## 📞 Support

Jika mengalami masalah:

1. **Error 403**: Anda tidak memiliki akses, periksa role dan permission
2. **Error 404**: Halaman tidak ditemukan, periksa URL
3. **Database Error**: Hubungi admin, mungkin ada masalah dengan database
4. **File Upload Error**: Periksa format dan ukuran file

---

## 📝 Changelog

### Version 1.1 (Latest)
- ✨ Improved UI/UX dengan gradient backgrounds
- ✨ Added student detail view
- ✨ Real-time grade quality feedback
- ✨ Better form styling dan validation
- ✨ Enhanced dashboard dengan statistics
- 📱 Responsive design untuk mobile devices

### Version 1.0
- ✅ Basic teacher dashboard
- ✅ Grade management
- ✅ Student management
- ✅ Profile management
- ✅ Password change
- ✅ Photo upload

---

**Terakhir diperbarui**: 19 Mei 2026
**Versi**: 1.1
**Status**: ✅ Production Ready
