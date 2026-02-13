# DOKUMENTASI REVISI SISTEM PEMINJAMAN ALAT OLAHRAGA

## RINGKASAN PERUBAHAN

Berikut adalah semua revisi dan fitur baru yang telah diimplementasikan pada Sistem Peminjaman Alat Olahraga berbasis Laravel:

---

## 1. FITUR UPLOAD FOTO ALAT

### Apa yang Berubah:
- **Model Alat**: Menambahkan field `foto` ke dalam fillable
- **Controller Admin - AlatController**: 
  - Menambahkan validasi upload foto (format: JPEG, PNG, JPG, GIF, max 5MB)
  - Simpan foto ke storage/public/alats/
  - Delete foto lama saat update
  - Delete foto saat menghapus alat
  
- **View Admin**:
  - Form tambah alat: Tambah input file untuk foto
  - Form edit alat: Tambah input file untuk foto + preview foto saat ini
  
- **View Peminjam**:
  - Daftar alat: Menampilkan foto alat dengan preview default jika tidak ada foto
  - Detail alat: Layout 2 kolom dengan foto di sebelah kiri, info di sebelah kanan

### Database:
- Migration: `2026_02_11_000001_add_foto_to_alats_table.php`
- Kolom baru: `foto` (nullable string)

### Cara Mengakses Foto:
```blade
<img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}">
```

---

## 2. PERBAIKAN LOGIC STOK ALAT

### Apa yang Berubah:
**Stok hanya berkurang saat peminjaman DISETUJUI, bukan saat pengajuan**

**Flow Stok:**
1. **Pengajuan Peminjaman**: Status = `pending_approval`, stok TIDAK berkurang
2. **Persetujuan Petugas**: Status berubah ke `menunggu_pengembalian`, stok berkurang
3. **Pengembalian Diverifikasi (Baik)**: Status = `selesai`, stok bertambah
4. **Pengembalian Rusak/Hilang**: Stok TIDAK otomatis bertambah

### Implementasi:
- **Admin PeminjamanController::store()**: Tidak mengurangi stok
- **Petugas PeminjamanController::setuju()**: Mengurangi stok DISINI
- **Petugas PengembalianController::storeVerify()**: 
  - Jika kondisi baik → bertambah stok
  - Jika rusak/hilang → stok tetap (manual adjustment oleh admin)

---

## 3. FLOW PENGEMBALIAN BARU

### Pengguna (PEMINJAM):

**Status Peminjaman:**
- `pending_approval`: Menunggu persetujuan
- `menunggu_pengembalian`: Aktif, sedang dipinjam (tombol "Ajukan Pengembalian" muncul)
- `menunggu_verifikasi_pengembalian`: Telah mengajukan pengembalian
- `selesai`: Peminjaman selesai

**Fitur Baru:**
- Tombol "Ajukan Pengembalian" pada peminjaman aktif (status `menunggu_pengembalian`)
- Mengajukan pengembalian: POST ke `peminjam.peminjamans.submitReturn`
- Status berubah menjadi `menunggu_verifikasi_pengembalian`
- Notifikasi otomatis ke Petugas

### Petugas (VERIFICATION):

**Dashboard:**
- Lihat daftar peminjaman yang menunggu verifikasi pengembalian
- Route: `petugas.pengembalians.index`

**Verifikasi Pengembalian:**
- Klik tombol "Verifikasi" → form verifikasi kondisi alat
- Route: `petugas.pengembalians.verify` → `petugas.pengembalians.storeVerify`
- Pilihan kondisi:
  - **BAIK**: Verifikasi selesai, stok otomatis bertambah, status = `selesai`
  - **RUSAK**: Petugas input nominal denda, menunggu validasi admin
  - **HILANG**: Petugas input nominal denda, menunggu validasi admin

**Kondisi Rusak/Hilang:**
- Pengembalian masih dalam status `menunggu_verifikasi_pengembalian` dengan record di tabel `pengembalians`
- Status denda: `menunggu_validasi`
- Menunggu validasi dari Admin

### Admin (VALIDATION):

**Dashboard:**
- Lihat daftar pengembalian menunggu validasi denda
- Route: `admin.pengembalians.index`

**Validasi Denda:**
- Klik tombol "Validasi" → form validasi denda
- Route: `admin.pengembalians.validateFine`
- 2 Pilihan:
  
  **1. SETUJUI DENDA:**
  - Status denda = `disetujui`
  - Status peminjaman = `selesai`
  - Peminjam BISA LIHAT detail denda di akun mereka
  - Route: `admin.pengembalians.approveFine`
  
  **2. TOLAK DENDA:**
  - Admin input alasan penolakan
  - Denda direset ke 0
  - Status denda = `ditolak`
  - Status peminjaman = `selesai` tanpa denda
  - Route: `admin.pengembalians.rejectFine`

**Riwayat Validasi:**
- Tab "Sudah Divalidasi" untuk melihat semua denda yang sudah disetujui/ditolak
- Route: `admin.pengembalians.approved`

---

## 4. PERUBAHAN DATABASE

### Migrations:

#### 2026_02_11_000001_add_foto_to_alats_table.php
- Tambah kolom: `foto` pada tabel `alats`

#### 2026_02_11_000002_update_peminjaman_flow.php
Tambah kolom pada tabel `peminjamans`:
- `status_verifikasi_petugas` (enum: pending, approved, rejected) - untuk tracking approval petugas
- `tanggal_pengajuan_pengembalian` (nullable date)
- `verified_by_petugas` (nullable bigint) - FK ke users
- `verified_at_petugas` (nullable timestamp)

Tambah kolom pada tabel `pengembalians`:
- `status_denda` (enum: menunggu_validasi, disetujui, ditolak, selesai)
- `verified_by_admin` (nullable bigint) - FK ke users
- `verified_at_admin` (nullable timestamp)
- `alasan_penolakan_denda` (nullable text)

#### 2026_02_11_000003_update_peminjaman_status_enum.php
Ubah enum `status` pada tabel `peminjamans`:
**Dari:** `('dipinjam', 'dikembalikan', 'terlambat')`
**Menjadi:** `('pending_approval', 'menunggu_pengembalian', 'menunggu_verifikasi_pengembalian', 'selesai', 'terlambat')`

---

## 5. PERUBAHAN MODELS

### Model Alat (app/Models/Alat.php)
- Tambah 'foto' ke fillable

### Model Peminjaman (app/Models/Peminjaman.php)
- Tambah fillable: status_verifikasi_petugas, tanggal_pengajuan_pengembalian, verified_by_petugas, verified_at_petugas
- Tambah cast: tanggal_pengajuan_pengembalian (date), verified_at_petugas (datetime)
- Tambah relation method: `verifiedByPetugas()`

### Model Pengembalian (app/Models/Pengembalian.php)
- Tambah fillable: status_denda, verified_by_admin, verified_at_admin, alasan_penolakan_denda
- Tambah cast: verified_at_admin (datetime)
- Tambah relation method: `verifiedByAdmin()`

---

## 6. PERUBAHAN CONTROLLER

### Admin\AlatController
**store():** Tambah handling upload foto dengan validation
**update():** Tambah handling update foto dan delete foto lama
**destroy():** Tambah delete foto saat alat dihapus

### Admin\PeminjamanController
**store():** Ubah status menjadi `pending_approval`, tidak mengurangi stok

### Admin\PengembalianController (REWRITE)
- `index()`: Tampilkan pengembalian menunggu validasi denda (status_denda = menunggu_validasi)
- `approved()`: Tampilkan riwayat validasi yang sudah selesai
- `validateFine()`: Tampilkan form validasi denda
- `approveFine()`: Setujui denda
- `rejectFine()`: Tolak denda

### Petugas\PeminjamanController
**setuju():** Ubah status ke `menunggu_pengembalian` dan kurangi stok DISINI

### Petugas\PengembalianController (REWRITE)
- `index()`: Tampilkan peminjaman menunggu verifikasi pengembalian
- `verified()`: Tampilkan pengembalian yang sudah diverifikasi
- `verify()`: Tampilkan form verifikasi kondisi alat
- `storeVerify()`: Proses verifikasi dan create record pengembalian

### Peminjam\PeminjamanController
**submitReturn():** Ajukan pengembalian, ubah status ke `menunggu_verifikasi_pengembalian`

---

## 7. PERUBAHAN ROUTES (routes/web.php)

### Admin Routes
```php
Route::get('/pengembalians', [AdminPengembalian::class, 'index'])->name('pengembalians.index');
Route::get('/pengembalians/approved', [AdminPengembalian::class, 'approved'])->name('pengembalians.approved');
Route::get('/pengembalians/{pengembalian}/validate', [AdminPengembalian::class, 'validateFine'])->name('pengembalians.validateFine');
Route::post('/pengembalians/{pengembalian}/approve-fine', [AdminPengembalian::class, 'approveFine'])->name('pengembalians.approveFine');
Route::post('/pengembalians/{pengembalian}/reject-fine', [AdminPengembalian::class, 'rejectFine'])->name('pengembalians.rejectFine');
Route::get('/pengembalians/{pengembalian}', [AdminPengembalian::class, 'show'])->name('pengembalians.show');
```

### Petugas Routes
```php
Route::get('/pengembalians', [PetugasPengembalian::class, 'index'])->name('pengembalians.index');
Route::get('/pengembalians/verified', [PetugasPengembalian::class, 'verified'])->name('pengembalians.verified');
Route::get('/pengembalians/{peminjaman}/verify', [PetugasPengembalian::class, 'verify'])->name('pengembalians.verify');
Route::post('/pengembalians/{peminjaman}/verify', [PetugasPengembalian::class, 'storeVerify'])->name('pengembalians.storeVerify');
Route::get('/pengembalians/{pengembalian}', [PetugasPengembalian::class, 'show'])->name('pengembalians.show');
```

### Peminjam Routes
```php
Route::post('/peminjamans/{peminjaman}/submit-return', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'submitReturn'])->name('peminjamans.submitReturn');
```

---

## 8. FITUR VIEWS

### Admin
- **alats/create.blade.php**: Tambah input file foto
- **alats/edit.blade.php**: Tambah input file foto + preview
- **pengembalians/index.blade.php**: Lihat pengembalian menunggu validasi denda
- **pengembalians/validate.blade.php** (NEW): Form validasi denda dengan opsi setuju/tolak

### Petugas
- **pengembalians/index.blade.php**: Lihat peminjaman menunggu verifikasi pengembalian
- **pengembalians/verify.blade.php** (NEW): Form verifikasi kondisi alat, input nominal denda

### Peminjam
- **alats/index.blade.php**: Menampilkan foto alat dalam grid
- **alats/show.blade.php**: Tampilkan foto alat besar + info detail
- **peminjamans/index.blade.php**: Tambah tombol "Ajukan Pengembalian" untuk status `menunggu_pengembalian`

---

## 9. FITUR LAINNYA

### Storage Link
Foto disimpan di: `storage/app/public/alats/`
Akses via: `asset('storage/' . $alat->foto)`

Pastikan sudah jalankan:
```bash
php artisan storage:link
```

### Validasi Foto
- Format: jpeg, png, jpg, gif
- Max size: 5MB
- Required: tidak (nullable)

---

## 10. TESTING CHECKLIST

- [x] Admin bisa upload foto saat menambah alat
- [x] Admin bisa update/ganti foto alat
- [x] Admin bisa delete alat beserta fotonya
- [x] Peminjam bisa lihat daftar alat dengan foto
- [x] Peminjam bisa lihat detail alat dengan foto besar
- [x] Stok tidak berkurang saat pengajuan peminjaman
- [x] Stok berkurang saat peminjaman disetujui petugas
- [x] Peminjam bisa ajukan pengembalian (tombol muncul saat status aktif)
- [x] Petugas bisa verifikasi pengembalian sesuai kondisi alat
- [x] Jika kondisi baik → stok bertambah otomatis
- [x] Jika rusak/hilang → menunggu validasi denda dari admin
- [x] Admin bisa setujui/tolak denda
- [x] Peminjam bisa lihat riwayat denda di akun mereka

---

## 11. CATATAN PENTING

1. **Migrations sudah dijalankan** - Database schema sudah updated
2. **Foto disimpan di public storage** - Pastikan storage/app/public/alats/ writable
3. **Role tidak berubah** - Admin, Petugas, Peminjam tetap sesuai sebelumnya
4. **CRUD lama tetap berfungsi** - Tidak ada fitur yang dihapus, hanya ditambah/dimodifikasi
5. **Status enum berubah** - Perhatikan saat custom query pada tabel peminjamans

---

## Kesimpulan

Semua fitur yang diminta sudah diimplementasikan dengan struktur yang rapi dan mengikuti Laravel best practices. Sistem tetap kompatibel dengan fitur lama dan tidak ada conflict.
