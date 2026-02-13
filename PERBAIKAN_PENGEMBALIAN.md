# LAPORAN PERBAIKAN FITUR PENGEMBALIAN ALAT

## Tanggal: 11 Februari 2026

---

## 📋 RINGKASAN MASALAH YANG DITEMUKAN

Ketika peminjam melakukan pengembalian alat, data tidak tersimpan lengkap ke database dan ada beberapa kondisi kemungkinan tidak terpenuhi.

### Masalah Spesifik:

1. **❌ Field Pengembalian Tidak Lengkap** (PENTING)
   - Data yang disimpan hanya sebagian dari field yang diperlukan
   - Field yang hilang:
     - `tanggal_pengajuan_peminjam` - Kapan peminjam mengajukan pengembalian
     - `denda_telat_otomatis` - Denda keterlambatan otomatis dari sistem
     - `jumlah_hari_telat` - Berapa hari terlambat
     - `denda_final` - Denda kerusakan alat
     - `status_pembayaran` - Status pembayaran denda (belum_bayar / sudah_bayar)

2. **❌ Tidak Ada Perhitungan Denda Telat Otomatis** (KRITIS)
   - Sistem tidak menghitung otomatis jika ada keterlambatan pengembalian
   - Denda telat (Rp 10.000/hari) harus dihitung dari selisih tanggal kembali aktual dengan tanggal kembali rencana

3. **❌ Tidak Ada Perhitungan Denda Kerusakan** (KRITIS)
   - Kondisi alat dipilih tapi tidak mempengaruhi denda
   - Seharusnya:
     - Rusak Ringan: Rp 50.000
     - Rusak Berat: Rp 150.000

4. **❌ Validasi Status Peminjaman Kurang Ketat**
   - Filter menggunakan status `'dipinjam'` yang sudah deprecated
   - Seharusnya hanya status `'menunggu_pengembalian'` setelah disetujui petugas

5. **❌ Routes Tidak Sesuai Convention**
   - Route menggunakan `POST /pengembalians/store` bukan `POST /pengembalians`
   - Tidak mengikuti RESTful convention

---

## ✅ PERBAIKAN YANG TELAH DILAKUKAN

### 1. **File: [app/Http/Controllers/Peminjam/PengembalianController.php](app/Http/Controllers/Peminjam/PengembalianController.php)**

#### A. Method `create()` - Perbaikan Filter Status
```diff
- ->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
+ ->where('status', 'menunggu_pengembalian')
+ ->where('status_persetujuan', 'disetujui')
```

**Alasan**: 
- Status `'dipinjam'` sudah deprecated dalam sistem yang baru
- Menambahkan validasi `status_persetujuan` untuk memastikan hanya peminjaman yang disetujui yang bisa dikembalikan

---

#### B. Method `store()` - Penambahan Logika Penting

**Perubahan 1: Validasi Status Peminjaman Lebih Ketat**
```php
// Cek status peminjaman: HARUS sudah disetujui dan dalam status menunggu pengembalian
if ($peminjaman->status_persetujuan !== 'disetujui') {
    return back()->with('error', 'Peminjaman belum disetujui oleh petugas.');
}

if ($peminjaman->status !== 'menunggu_pengembalian') {
    return back()->with('error', 'Peminjaman ini tidak dalam status yang dapat dikembalikan.');
}
```

**Perubahan 2: Perhitungan Denda Telat Otomatis**
```php
// HITUNG DENDA TELAT OTOMATIS
$tanggalKembali = Carbon::parse($validated['tanggal_kembali']);
$tanggalRencana = $peminjaman->tanggal_kembali_rencana;
$hariTelat = 0;
$dendaTelat = 0;

if ($tanggalKembali->gt($tanggalRencana)) {
    $hariTelat = $tanggalKembali->diffInDays($tanggalRencana);
    $dendaTelat = $hariTelat * 10000; // 10rb per hari
}
```

**Alasan**: Denda keterlambatan harus dihitung otomatis tanpa menunggu petugas

**Perubahan 3: Perhitungan Denda Kerusakan**
```php
// HITUNG DENDA KERUSAKAN
$dendaKerusakan = 0;
if ($validated['kondisi'] === 'rusak_ringan') {
    $dendaKerusakan = 50000;
} elseif ($validated['kondisi'] === 'rusak_berat') {
    $dendaKerusakan = 150000;
}
```

**Alasan**: Denda kerusakan otomatis dihitung berdasarkan pilihan kondisi

**Perubahan 4: Penyimpanan Data Lengkap**
```php
Pengembalian::create([
    'peminjaman_id' => $peminjaman->id,
    'tanggal_kembali' => $validated['tanggal_kembali'],
    'jumlah_kembali' => $peminjaman->jumlah_pinjam,
    'kondisi' => $validated['kondisi'],
    'keterangan' => $validated['keterangan'],
    
    // ✅ FIELD BARU YANG DITAMBAHKAN:
    'tanggal_pengajuan_peminjam' => now()->toDateString(),
    'denda_telat_otomatis' => $dendaTelat,
    'jumlah_hari_telat' => $hariTelat,
    'denda_final' => $dendaKerusakan,
    'status_pembayaran' => 'belum_bayar',
    'denda' => $dendaTelat + $dendaKerusakan, // Total denda
    'status_denda' => 'menunggu_validasi',
]);
```

**Alasan**: Semua field fillable di model Pengembalian sekarang tersimpan dengan data yang akurat

**Perubahan 5: Update Status Peminjaman**
```php
$peminjaman->update([
    'status' => 'menunggu_verifikasi_pengembalian',
    'tanggal_pengajuan_pengembalian' => now()->toDateString(), // ✅ TAMBAHAN
]);
```

---

### 2. **File: [resources/views/peminjam/pengembalians/create.blade.php](resources/views/peminjam/pengembalians/create.blade.php)**

#### Perbaikan: Pesan Peringatan Lebih Akurat

**Sebelum:**
```blade
<strong>Perhatian:</strong> Denda akan dihitung oleh petugas berdasarkan:
```

**Sesudah:**
```blade
<strong>Perhatian:</strong> Denda akan dihitung otomatis berdasarkan:
<ul class="list-disc list-inside mt-2 ml-4">
    <li><strong>Keterlambatan pengembalian:</strong> Rp 10.000/hari (dihitung otomatis)</li>
    <li><strong>Kerusakan alat:</strong> 
        <ul class="list-circle list-inside ml-4 mt-1">
            <li>Rusak Ringan: Rp 50.000</li>
            <li>Rusak Berat: Rp 150.000</li>
        </ul>
    </li>
</ul>
```

**Alasan**: Memberitahu pengguna dengan akurat bahwa denda sudah dihitung otomatis oleh sistem, bukan menunggu petugas

---

### 3. **File: [routes/web.php](routes/web.php)**

#### Perbaikan: Routes RESTful Convention

**Sebelum:**
```php
Route::post('/pengembalians/store', [App\Http\Controllers\Peminjam\PengembalianController::class, 'store'])->name('pengembalians.store');
```

**Sesudah:**
```php
Route::post('/pengembalians', [App\Http\Controllers\Peminjam\PengembalianController::class, 'store'])->name('pengembalians.store');
```

**Alasan**: Mengikuti RESTful convention dimana POST ke `/pengembalians` berarti menyimpan data baru

---

## 📊 TABEL PERBANDINGAN SEBELUM & SESUDAH

| Aspek | ❌ Sebelum | ✅ Sesudah |
|-------|-----------|----------|
| **Field Tersimpan** | 7 field | 12 field (lengkap) |
| **Denda Telat** | Tidak dihitung | Dihitung otomatis |
| **Denda Kerusakan** | Tidak dihitung | Dihitung otomatis |
| **Validasi Status** | Kurang ketat | Sangat ketat |
| **Status Pembayaran** | Tidak ada | Tersimpan sebagai `belum_bayar` |
| **Routes** | Non-standard | RESTful convention |

---

## 🧪 CHECKLIST TESTING

Untuk memverifikasi perbaikan bekerja dengan baik, lakukan test berikut:

- [ ] Login sebagai peminjam
- [ ] Pergi ke halaman pengembalian alat
- [ ] Pilih peminjaman yang sudah **disetujui** petugas
- [ ] Pilih tanggal kembali **lebih lambat** dari rencana (misal: seharusnya 5 Februari, dikembalikan 11 Februari = 6 hari telat = Rp 60.000)
- [ ] Pilih kondisi **Rusak Ringan** (Rp 50.000)
- [ ] Submit pengembalian
- [ ] **Verifikasi di database:**
  ```sql
  SELECT peminjaman_id, denda_telat_otomatis, denda_final, denda, status_pembayaran 
  FROM pengembalians 
  WHERE peminjaman_id = X;
  ```
  - `denda_telat_otomatis` harus: 60000 (6 hari × Rp 10.000)
  - `denda_final` harus: 50000 (Rusak Ringan)
  - `denda` harus: 110000 (total)
  - `status_pembayaran` harus: `belum_bayar`

---

## 📝 CATATAN PENTING

1. **Denda Otomatis**: Denda telat dan kerusakan sekarang dihitung **otomatis saat peminjam mengajukan pengembalian**, bukan menunggu validasi petugas.

2. **Validasi Ketat**: Peminjaman harus dalam status `menunggu_pengembalian` dan sudah disetujui petugas sebelum bisa dikembalikan.

3. **Status Pembayaran**: Semua denda baru akan memiliki status `belum_bayar` dan siap untuk divalidasi oleh admin.

4. **Backward Compatibility**: Jika ada pengembalian lama dengan data tidak lengkap, tidak akan error tapi data baru akan lengkap sesuai perbaikan ini.

---

## 🎯 HASIL AKHIR

✅ **Data pengembalian sekarang tersimpan lengkap dengan semua field required**

✅ **Denda telat dan kerusakan dihitung otomatis dengan akurat**

✅ **Validasi status peminjaman lebih ketat dan sesuai business logic**

✅ **Routes mengikuti RESTful convention**

✅ **View memberitahu pengguna dengan akurat tentang perhitungan denda**
