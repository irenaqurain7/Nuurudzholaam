# Dokumentasi Fitur Validasi Pre-Upload Data Siswa & Guru

## Ringkasan Fitur

Fitur validasi pre-upload menambahkan lapisan keamanan dan verifikasi data sebelum data siswa dan guru disimpan ke database. Admin dapat:

1. **Download Template** - Template CSV dengan struktur kolom yang benar
2. **Upload File** - Upload file CSV untuk divalidasi
3. **Preview & Validasi** - Sistem otomatis melakukan validasi terhadap:
   - Struktur file (kolom yang sesuai)
   - Format data (email, NISN, NIP, password)
   - Duplikasi data (NISN, NIP, Email)
   - Format sesuai jenjang/role
4. **Review Hasil** - Lihat data valid dan error dalam preview
5. **Simpan atau Perbaiki** - Jika valid, langsung simpan; jika ada error, download log dan perbaiki

---

## Perubahan Kolom Template

Template CSV sekarang memiliki 9 kolom (sebelumnya 6):

| Kolom | Deskripsi | Contoh |
|-------|-----------|--------|
| Nama Lengkap | Nama lengkap siswa/guru | Ahmad Fauzi |
| Email | Email untuk login | ahmad@nuurudzholaam.sch.id |
| Password | Password login (min 6 karakter) | Rahasia123 |
| Role (siswa/guru) | siswa atau guru | siswa |
| **NISN/NIP** | NISN (13 digit) untuk siswa, NIP (18 digit) untuk guru | 0012345678901 (siswa) atau 123456789012345678 (guru) |
| **Jenjang (Siswa) / Spesialisasi (Guru)** | TK/SD/SMP/SMA/SMK untuk siswa, Spesialisasi untuk guru | SD atau Matematika |
| **Kelas / -** | Kelas untuk siswa, gunakan "-" untuk guru | 5A atau - |
| No Telepon | Nomor telepon (opsional) | 08123456789 |
| Alamat | Alamat (opsional) | Jl. Contoh No. 123 |

---

## Validasi yang Dilakukan

### 1. Validasi File
- ✓ Format file: .csv atau .txt
- ✓ Ukuran file maksimal: 2MB
- ✓ Struktur kolom harus sesuai dengan yang ditentukan

### 2. Validasi Data Wajib
- ✓ Nama Lengkap tidak boleh kosong
- ✓ Email tidak boleh kosong dan harus format valid
- ✓ Password minimal 6 karakter
- ✓ Role hanya: siswa atau guru
- ✓ NISN/NIP tidak boleh kosong

### 3. Validasi Format
- ✓ Email: format yang valid (example@domain.com)
- ✓ NISN: 13 digit angka untuk siswa
- ✓ NIP: 18 digit angka untuk guru
- ✓ Password: minimal 6 karakter
- ✓ No Telepon: format Indonesia (08xxx) atau internasional

### 4. Validasi Business Rules
- ✓ **Untuk Siswa**:
  - Jenjang hanya: TK, SD, SMP, SMA, SMK
  - Kelas tidak boleh kosong
  - NISN tidak boleh duplikat dengan data yang ada
  
- ✓ **Untuk Guru**:
  - Spesialisasi tidak boleh kosong
  - NIP tidak boleh duplikat dengan data yang ada

### 5. Validasi Duplikasi Global
- ✓ Email tidak boleh duplikat di database
- ✓ NISN/NIP tidak boleh duplikat di database

---

## Alur Penggunaan

### Step 1: Unduh Template
```
Admin → Klik "Download Template Format CSV"
Sistem → Download file template_siswa_guru.csv
```

### Step 2: Isi Data
Admin membuka file CSV dengan Excel/LibreOffice dan isi data sesuai template.

**Contoh Isi CSV:**
```
Nama Lengkap,Email,Password,Role (siswa/guru),NISN/NIP,Jenjang (Siswa) / Spesialisasi (Guru),Kelas / -,No Telepon,Alamat
Ahmad Fauzi,ahmad@nuurudzholaam.sch.id,rahasia123,siswa,0012345678901,SD,5A,08123456789,Purwakarta
Siti Aminah,siti@nuurudzholaam.sch.id,passwordguru,guru,123456789012345678,Matematika,-,08987654321,Bungursari
```

### Step 3: Upload & Validasi
```
Admin → Pilih file CSV → Klik "Preview & Validasi"
Sistem → Memvalidasi semua baris
Sistem → Tampilkan preview hasil validasi
```

### Step 4: Review Hasil
- **Jika Semua Valid**: 
  - Tampil ringkasan data valid (warna hijau)
  - Tombol "Simpan DATA" aktif
  - Admin klik "Simpan" untuk menyimpan ke database

- **Jika Ada Error**:
  - Tampil ringkasan: berapa valid, berapa error
  - Tabel error menampilkan detail keterangan error per baris
  - Tombol "Download Log Error" untuk download file log
  - Admin dapat memperbaiki data dan upload ulang

### Step 5: Konfirmasi Simpan
```
Admin → Klik "Simpan N Data"
Sistem → Simpan data ke database
Sistem → Redirect ke halaman daftar users dengan notifikasi sukses
```

---

## Pesan Error Umum

| Error | Penyebab | Solusi |
|-------|---------|--------|
| Format email tidak valid | Email tidak sesuai format | Gunakan format: nama@domain.com |
| NISN harus 13 digit angka | NISN tidak valid | Periksa NISN, harus 13 digit angka |
| NIP harus 18 digit angka | NIP tidak valid | Periksa NIP, harus 18 digit angka |
| Password minimal 6 karakter | Password terlalu pendek | Gunakan password minimal 6 karakter |
| NISN sudah terdaftar | NISN duplikat | Gunakan NISN yang berbeda |
| Email sudah terdaftar | Email duplikat | Gunakan email yang berbeda |
| Jenjang hanya boleh: TK, SD, SMP, SMA, SMK | Jenjang tidak valid | Periksa jenjang, gunakan salah satu: TK, SD, SMP, SMA, SMK |
| Kelas tidak boleh kosong untuk siswa | Kelas kosong | Isi kolom Kelas untuk siswa (misal: 5A) |
| Role hanya boleh: siswa atau guru | Role tidak valid | Gunakan: siswa atau guru |

---

## Fitur Tambahan

### 1. Download Log Error
Jika ada data dengan error, admin dapat mendownload file log error dalam format CSV untuk kemudian diperbaiki dan di-upload ulang.

### 2. Backup Data
Semua data yang valid disimpan ke database dengan tanda:
- `is_active = true` (user aktif)
- User untuk siswa akan membuat record di tabel `students` dengan NISN dan Kelas yang sesuai
- User untuk guru akan membuat record di tabel `teachers` dengan NIP dan Spesialisasi yang sesuai

### 3. Peringatan (Warnings)
Sistem juga menampilkan peringatan untuk data yang mungkin tidak ideal tapi masih valid, misalnya:
- Format nomor telepon yang mungkin tidak sesuai standar

---

## Keamanan Data

1. **Validasi Duplikasi**: NISN, NIP, dan Email divalidasi untuk mencegah duplikasi
2. **Hashing Password**: Password di-hash menggunakan bcrypt sebelum disimpan
3. **Logging**: Setiap error import di-log ke sistem untuk audit
4. **Transactional**: Semua data disimpan sebagai satu transaksi (semua atau tidak sama sekali)

---

## Tips & Best Practices

1. **Pastikan File Format CSV**: Gunakan charset UTF-8 dan separator koma (,)
2. **Cek Duplikasi Sebelumnya**: Pastikan NISN/NIP/Email belum ada di sistem
3. **Gunakan Template**: Selalu download dan gunakan template terbaru
4. **Backup Data Original**: Simpan copy file CSV original sebelum upload
5. **Batch Kecil**: Jika data banyak, pisah menjadi beberapa batch kecil
6. **Review Sebelum Simpan**: Selalu cek preview sebelum klik "Simpan Data"

---

## Troubleshooting

### "File tidak dapat dibaca"
- Pastikan file adalah CSV plain text, bukan file Excel
- Pada Excel: Save As → CSV (Comma delimited) → UTF-8

### "Kolom kurang"
- Download template terbaru
- Pastikan tidak ada kolom yang dihapus
- Cek bahwa header row tidak dimodifikasi

### "Semua data error"
- Download log error untuk detail lengkap
- Cek template contoh yang sudah disediakan
- Pastikan format sesuai: NISN 13 digit, NIP 18 digit, dll

---

**Dokumentasi Dibuat**: 2026-07-06  
**Versi**: 1.0  
**Status**: Active
