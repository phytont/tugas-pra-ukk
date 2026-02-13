# UNIT TESTING - SISTEM PEMINJAMAN ALAT OLAHRAGA

## Tabel Unit Testing Sistem

| No. | ID Tes | Modul | Skenario Pengujian | Langkah-langkah | Data Uji (Jika Perlu) | Hasil yang Diharapkan | Hasil Aktual (Lulus/Gagal) |
|-----|--------|-------|-------------------|-----------------|----------------------|----------------------|---------------------------|
| 1 | AUTH-001 | Autentikasi | Gagal - Akses Halaman Terproteksi Tanpa Login | 1. Logout<br/>2. Coba akses URL /admin secara manual | - | Pengguna dialihkan ke halaman /auth/login | |
| 2 | AUTH-002 | Autentikasi | Gagal - Login (Password Salah) | 1. Buka /auth/login<br/>2. Masukkan username yang benar<br/>3. Masukkan password yang salah<br/>4. Klik tombol masuk | Username: admin<br/>Password: SalahPassword | Login gagal, tampil pesan error | |
| 3 | AUTH-003 | Autentikasi | Sukses - Login (Admin) | 1. Buka /auth/login<br/>2. Masukkan username admin<br/>3. Masukkan password yang benar<br/>4. Klik tombol masuk | Username: admin<br/>Password: Admin123 | Login berhasil, redirect ke halaman /admin/dashboard | |
| 4 | AUTH-004 | Autentikasi | Sukses - Login (Petugas) | 1. Buka /auth/login<br/>2. Masukkan username petugas<br/>3. Masukkan password yang benar<br/>4. Klik tombol masuk | Username: petugas1<br/>Password: Petugas123 | Login berhasil, redirect ke halaman /petugas/dashboard | |
| 5 | AUTH-005 | Autentikasi | Sukses - Login (Peminjam/User) | 1. Buka /auth/login<br/>2. Masukkan username user<br/>3. Masukkan password yang benar<br/>4. Klik tombol masuk | Username: user1<br/>Password: User123 | Login berhasil, redirect ke halaman /peminjam/dashboard | |
| 6 | AUTH-006 | Autentikasi | Sukses - Logout | 1. Login dengan kredensial yang valid<br/>2. Navigasi ke halaman dashboard<br/>3. Klik tombol logout di header/menu<br/>4. Konfirmasi logout | - | Logout berhasil, pengguna dialihkan ke halaman login | |
| 7 | USER-001 | Kelola Pengguna | Sukses - Lihat Daftar Semua Pengguna | 1. Login sebagai admin<br/>2. Navigasi ke /admin/users<br/>3. Tunggu tabel dimuat | Username: admin<br/>Password: Admin123 | Daftar semua pengguna tampil dengan info: nama, email, role, aksi | |
| 8 | USER-002 | Kelola Pengguna | Sukses - Tambah Pengguna Baru | 1. Login sebagai admin<br/>2. Buka halaman /admin/users<br/>3. Klik tombol "Tambah User"<br/>4. Isi form (nama, email, password, role)<br/>5. Klik simpan | Nama: Budi Santoso<br/>Email: budi@example.com<br/>Password: Budi123<br/>Role: user | Pengguna baru berhasil ditambahkan dan muncul di daftar | |
| 9 | USER-003 | Kelola Pengguna | Gagal - Tambah Pengguna dengan Email Duplikat | 1. Login sebagai admin<br/>2. Buka halaman /admin/users<br/>3. Klik tombol "Tambah User"<br/>4. Isi form dengan email yang sudah ada<br/>5. Klik simpan | Email: admin@example.com (yang sudah ada) | Muncul pesan error "Email sudah terdaftar" | |
| 10 | USER-004 | Kelola Pengguna | Sukses - Edit Data Pengguna | 1. Login sebagai admin<br/>2. Buka halaman /admin/users<br/>3. Klik icon edit pada pengguna<br/>4. Ubah data (nama, email, role)<br/>5. Klik simpan | Nama Baru: Ahmad Wijaya<br/>Email Baru: ahmad@example.com<br/>Role: petugas | Data pengguna berhasil diubah dan terupdate di daftar | |
| 11 | USER-005 | Kelola Pengguna | Sukses - Hapus Pengguna | 1. Login sebagai admin<br/>2. Buka halaman /admin/users<br/>3. Klik icon hapus pada pengguna<br/>4. Konfirmasi penghapusan<br/>5. Klik ya/confirm | - | Pengguna berhasil dihapus, tidak muncul lagi di daftar | |
| 12 | KAT-001 | Kelola Kategori | Sukses - Lihat Daftar Kategori | 1. Login sebagai admin<br/>2. Navigasi ke /admin/kategoris<br/>3. Tunggu tabel dimuat | Username: admin<br/>Password: Admin123 | Daftar kategori tampil dengan info: nama kategori, deskripsi, jumlah alat, aksi | |
| 13 | KAT-002 | Kelola Kategori | Sukses - Tambah Kategori Baru | 1. Login sebagai admin<br/>2. Buka halaman /admin/kategoris<br/>3. Klik tombol "Tambah Kategori"<br/>4. Isi form (nama, deskripsi)<br/>5. Klik simpan | Nama: Peralatan Renang<br/>Deskripsi: Semua alat untuk renang | Kategori baru berhasil ditambahkan dan muncul di daftar | |
| 14 | KAT-003 | Kelola Kategori | Gagal - Tambah Kategori dengan Nama Duplikat | 1. Login sebagai admin<br/>2. Buka halaman /admin/kategoris<br/>3. Klik tombol "Tambah Kategori"<br/>4. Isi form dengan nama yang sudah ada<br/>5. Klik simpan | Nama: Peralatan Olahraga (yang sudah ada) | Muncul pesan error "Nama kategori sudah ada" | |
| 15 | KAT-004 | Kelola Kategori | Sukses - Edit Data Kategori | 1. Login sebagai admin<br/>2. Buka halaman /admin/kategoris<br/>3. Klik icon edit pada kategori<br/>4. Ubah nama/deskripsi<br/>5. Klik simpan | Nama Baru: Perlengkapan Badminton<br/>Deskripsi Baru: Semua alat badminton | Data kategori berhasil diubah | |
| 16 | KAT-005 | Kelola Kategori | Sukses - Hapus Kategori | 1. Login sebagai admin<br/>2. Buka halaman /admin/kategoris<br/>3. Klik icon hapus pada kategori (yang tidak ada alat)<br/>4. Konfirmasi penghapusan | - | Kategori berhasil dihapus, tidak muncul di daftar | |
| 17 | ALT-001 | Kelola Alat | Sukses - Lihat Daftar Alat | 1. Login sebagai admin<br/>2. Navigasi ke /admin/alats<br/>3. Tunggu tabel dimuat | Username: admin<br/>Password: Admin123 | Daftar alat tampil dengan: nama alat, kategori, merk, stok total, tersedia, kondisi, foto, aksi | |
| 18 | ALT-002 | Kelola Alat | Sukses - Tambah Alat Baru | 1. Login sebagai admin<br/>2. Buka halaman /admin/alats<br/>3. Klik tombol "Tambah Alat"<br/>4. Isi form (nama, kategori, merk, model, stok, deskripsi, foto)<br/>5. Klik simpan | Nama: Laptop Dell<br/>Kategori: Elektronik<br/>Merk: Dell<br/>Model: Inspiron 15<br/>Stok: 10<br/>Foto: upload file | Alat baru berhasil ditambahkan dan muncul di daftar | |
| 19 | ALT-003 | Kelola Alat | Sukses - Upload Foto Alat | 1. Login sebagai admin<br/>2. Buka halaman tambah/edit alat<br/>3. Upload foto alat<br/>4. Simpan | File: JPG/PNG max 2MB | Foto berhasil diupload dan ditampilkan di list alat | |
| 20 | ALT-004 | Kelola Alat | Sukses - Edit Data Alat | 1. Login sebagai admin<br/>2. Buka halaman /admin/alats<br/>3. Klik icon edit pada alat<br/>4. Ubah data (nama, merk, stok, deskripsi, foto)<br/>5. Klik simpan | Nama Baru: Laptop ASUS<br/>Stok: 8 | Data alat berhasil diubah dan terupdate | |
| 21 | ALT-005 | Kelola Alat | Sukses - Hapus Alat | 1. Login sebagai admin<br/>2. Buka halaman /admin/alats<br/>3. Klik icon hapus pada alat<br/>4. Konfirmasi penghapusan | - | Alat berhasil dihapus, foto juga dihapus, tidak muncul di daftar | |
| 22 | PNJM-001 | Peminjaman | Sukses - Lihat Daftar Alat Tersedia | 1. Login sebagai peminjam<br/>2. Navigasi ke /peminjam/alats<br/>3. Tunggu tabel dimuat | Username: user1<br/>Password: User123 | Daftar alat yang tersedia tampil dengan: nama, kategori, stok tersedia, aksi detail | |
| 23 | PNJM-002 | Peminjaman | Sukses - Lihat Detail Alat | 1. Login sebagai peminjam<br/>2. Buka halaman /peminjam/alats<br/>3. Klik tombol "Detail" atau klik nama alat | - | Detail alat tampil dengan: foto, nama, kategori, merk, deskripsi, stok | |
| 24 | PNJM-003 | Peminjaman | Sukses - Ajukan Peminjaman | 1. Login sebagai peminjam (tidak ada peminjaman aktif)<br/>2. Navigasi ke /peminjam/peminjamans/create<br/>3. Pilih alat yang ingin dipinjam<br/>4. Isi alasan peminjaman<br/>5. Klik tombol "Ajukan" | Alat: Laptop ASUS<br/>Alasan: Tugas presentasi | Peminjaman berhasil diajukan dengan status "Menunggu Persetujuan" | |
| 25 | PNJM-004 | Peminjaman | Gagal - Ajukan Peminjaman saat Sudah 2 Peminjaman Aktif | 1. Login sebagai peminjam dengan 2 peminjaman aktif<br/>2. Coba akses /peminjam/peminjamans/create<br/>3. Lihat respons sistem | - | Tampil pesan "Sudah mencapai maksimal 2 peminjaman aktif" atau form tidak bisa diakses | |
| 26 | PNJM-005 | Peminjaman | Gagal - Ajukan Peminjaman saat Ada Peminjaman Terlambat | 1. Login sebagai peminjam dengan peminjaman terlambat<br/>2. Coba akses /peminjam/peminjamans/create<br/>3. Lihat respons sistem | - | Tampil pesan "Ada peminjaman terlambat, silakan kembalikan terlebih dahulu" | |
| 27 | PNJM-006 | Peminjaman | Sukses - Lihat Riwayat Peminjaman Saya | 1. Login sebagai peminjam<br/>2. Navigasi ke /peminjam/peminjamans<br/>3. Tunggu tabel dimuat | - | Daftar peminjaman saya tampil dengan: alat, status, tgl ajuan, aksi | |
| 28 | PNJM-007 | Peminjaman | Sukses - Batalkan Peminjaman (Status Menunggu) | 1. Login sebagai peminjam<br/>2. Buka halaman /peminjam/peminjamans<br/>3. Cari peminjaman status "Menunggu Persetujuan"<br/>4. Klik tombol "Batalkan"<br/>5. Konfirmasi pembatalan | - | Peminjaman berhasil dibatalkan, status berubah menjadi "Dibatalkan" | |
| 29 | PNJM-008 | Peminjaman | Gagal - Batalkan Peminjaman (Status Sudah Disetujui) | 1. Login sebagai peminjam<br/>2. Buka halaman /peminjam/peminjamans<br/>3. Cari peminjaman status "Sedang Dipinjam"<br/>4. Coba klik tombol batalkan (jika ada) | - | Tombol batalkan tidak tersedia, tampil pesan "Tidak bisa membatalkan keputusan" | |
| 30 | PNJM-009 | Peminjaman | Sukses - Petugas Lihat Peminjaman Menunggu Persetujuan | 1. Login sebagai petugas<br/>2. Navigasi ke /petugas/peminjamans/menunggu<br/>3. Tunggu tabel dimuat | Username: petugas1<br/>Password: Petugas123 | Daftar peminjaman menunggu persetujuan tampil dengan: peminjam, alat, alasan, tgl ajuan, aksi | |
| 31 | PNJM-010 | Peminjaman | Sukses - Petugas Lihat Semua Peminjaman | 1. Login sebagai petugas<br/>2. Navigasi ke /petugas/peminjamans/semua<br/>3. Tunggu tabel dimuat | - | Daftar semua peminjaman tampil dengan: peminjam, alat, status, durasi, tgl mulai, tgl akhir | |
| 32 | PNJM-011 | Peminjaman | Sukses - Petugas Setujui Peminjaman | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/peminjamans/menunggu<br/>3. Klik detail peminjaman<br/>4. Klik tombol "Setujui"<br/>5. Input durasi peminjaman<br/>6. Klik konfirmasi | Durasi: 7 hari | Peminjaman berhasil disetujui, status "Sedang Dipinjam", stok berkurang, tanggal otomatis terisi | |
| 33 | PNJM-012 | Peminjaman | Sukses - Petugas Tolak Peminjaman | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/peminjamans/menunggu<br/>3. Klik detail peminjaman<br/>4. Klik tombol "Tolak"<br/>5. Input alasan penolakan<br/>6. Klik konfirmasi | Alasan: Stok terbatas, alat sedang rusak | Peminjaman berhasil ditolak, status "Ditolak", alasan tersimpan | |
| 34 | PNJM-013 | Peminjaman | Sukses - Admin Lihat Semua Peminjaman | 1. Login sebagai admin<br/>2. Buka halaman /admin/peminjamans<br/>3. Tunggu tabel dimuat | Username: admin<br/>Password: Admin123 | Daftar semua peminjaman tampil dengan: peminjam, alat, status, durasi, aksi | |
| 35 | PGLB-001 | Pengembalian | Sukses - Peminjam Submit Pengembalian | 1. Login sebagai peminjam<br/>2. Buka halaman /peminjam/peminjamans<br/>3. Cari peminjaman status "Sedang Dipinjam"<br/>4. Klik tombol "Kembalikan"<br/>5. Klik tombol "Submit Pengembalian" | - | Pengembalian berhasil diajukan, status berubah "Menunggu Verifikasi Pengembalian" | |
| 36 | PGLB-002 | Pengembalian | Sukses - Petugas Verifikasi Pengembalian (Kondisi Baik) | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/pengembalians<br/>3. Cari peminjaman menunggu verifikasi<br/>4. Klik "Verifikasi"<br/>5. Pilih kondisi "Baik"<br/>6. Klik proses pengembalian | Kondisi: Baik | Pengembalian berhasil, record pengembalian tersimpan, stok bertambah, status "Dikembalikan" | |
| 37 | PGLB-003 | Pengembalian | Sukses - Petugas Verifikasi Pengembalian (Rusak Ringan) | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/pengembalians<br/>3. Cari peminjaman menunggu verifikasi<br/>4. Klik "Verifikasi"<br/>5. Pilih kondisi "Rusak Ringan"<br/>6. Klik proses pengembalian | Kondisi: Rusak Ringan | Pengembalian berhasil dengan status kondisi "Rusak Ringan", stok tetap, denda dihitung | |
| 38 | PGLB-004 | Pengembalian | Sukses - Petugas Verifikasi Pengembalian (Rusak Berat) | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/pengembalians<br/>3. Cari peminjaman menunggu verifikasi<br/>4. Klik "Verifikasi"<br/>5. Pilih kondisi "Rusak Berat"<br/>6. Klik proses pengembalian | Kondisi: Rusak Berat | Pengembalian berhasil dengan status kondisi "Rusak Berat", stok tetap, denda lebih besar | |
| 39 | PGLB-005 | Pengembalian | Sukses - Petugas Verifikasi Pengembalian (Hilang) | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/pengembalians<br/>3. Cari peminjaman menunggu verifikasi<br/>4. Klik "Verifikasi"<br/>5. Pilih kondisi "Hilang"<br/>6. Klik proses pengembalian | Kondisi: Hilang | Pengembalian berhasil dengan status kondisi "Hilang", stok tetap, denda maksimal | |
| 40 | PGLB-006 | Pengembalian | Sukses - Petugas Lihat Pengembalian Terverifikasi | 1. Login sebagai petugas<br/>2. Buka halaman /petugas/pengembalians/verified<br/>3. Tunggu tabel dimuat | - | Daftar pengembalian yang sudah terverifikasi tampil | |
| 41 | DNDA-001 | Denda | Sukses - Hitung Denda Keterlambatan Otomatis | 1. Login sebagai petugas<br/>2. Buka halaman verifikasi pengembalian<br/>3. Proses pengembalian untuk alat yang terlambat lebih dari tanggal jatuh tempo<br/>4. Pilih kondisi "Baik"<br/>5. Lihat denda keterlambatan | Terlambat: 3 hari | Denda keterlambatan otomatis dihitung dan ditampilkan (per hari) | |
| 42 | DNDA-002 | Denda | Sukses - Hitung Denda Kerusakan (Manual Input) | 1. Login sebagai petugas<br/>2. Buka halaman verifikasi pengembalian<br/>3. Proses pengembalian dengan kondisi "Rusak Ringan/Berat"<br/>4. Input nominal denda kerusakan<br/>5. Simpan | Denda Rusak Ringan: 50000<br/>Denda Rusak Berat: 100000 | Denda kerusakan berhasil diinput dan tersimpan | |
| 43 | DNDA-003 | Denda | Sukses - Lihat Daftar Denda Saya (Peminjam) | 1. Login sebagai peminjam<br/>2. Navigasi ke /peminjam/denda<br/>3. Tunggu tabel dimuat | - | Daftar denda saya tampil dengan: alat, nominal, status pembayaran, tanggal | |
| 44 | DNDA-004 | Denda | Sukses - Lihat Semua Denda (Petugas) | 1. Login sebagai petugas<br/>2. Buka halaman pengembalian terverifikasi<br/>3. Lihat daftar denda dari semua pengembalian | - | Daftar denda tampil dengan: peminjam, alat, nominal, status, aksi pembayaran | |
| 45 | DNDA-005 | Denda | Sukses - Catat Pembayaran Denda | 1. Login sebagai petugas<br/>2. Buka halaman pengembalian terverifikasi<br/>3. Cari denda dengan status "Belum Bayar"<br/>4. Klik "Bayar"<br/>5. Konfirmasi pembayaran | - | Denda berhasil dicatat sebagai "Lunas", tanggal pembayaran tercatat | |
| 46 | LPRN-001 | Laporan | Sukses - Generate Laporan Peminjaman | 1. Login sebagai admin/petugas<br/>2. Navigasi ke /petugas/laporan<br/>3. Pilih periode tanggal<br/>4. Klik "Lihat" atau "Download PDF" | Dari: 2026-02-01<br/>Sampai: 2026-02-28 | Laporan peminjaman berhasil dibuat dengan data lengkap | |
| 47 | LPRN-002 | Laporan | Sukses - Generate Laporan Pengembalian | 1. Login sebagai admin/petugas<br/>2. Navigasi ke /petugas/laporan<br/>3. Pilih opsi "Laporan Pengembalian"<br/>4. Pilih periode<br/>5. Klik "Lihat" atau "Download PDF" | Dari: 2026-02-01<br/>Sampai: 2026-02-28 | Laporan pengembalian berhasil dibuat dengan data kondisi alat | |
| 48 | LPRN-003 | Laporan | Sukses - Generate Laporan Stok Alat | 1. Login sebagai admin/petugas<br/>2. Navigasi ke /petugas/laporan<br/>3. Klik "Laporan Stok Alat"<br/>4. Data tabel tampil | - | Laporan stok alat tampil dengan: nama alat, stok total, tersedia, dipinjam | |
| 49 | LOG-001 | Log Aktivitas | Sukses - Lihat Log Aktivitas Sistem | 1. Login sebagai admin<br/>2. Navigasi ke /admin/logs<br/>3. Tunggu tabel dimuat | - | Daftar log aktivitas tampil dengan: pengguna, aktivitas, tanggal, waktu | |
| 50 | DASH-001 | Dashboard | Sukses - Admin Lihat Dashboard | 1. Login sebagai admin<br/>2. Sistem otomatis redirect ke /admin/dashboard<br/>3. Tunggu data dashboard dimuat | Username: admin<br/>Password: Admin123 | Dashboard tampil dengan: statistik total alat, user, kategori, peminjaman aktif, terlambat | |
| 51 | DASH-002 | Dashboard | Sukses - Petugas Lihat Dashboard | 1. Login sebagai petugas<br/>2. Sistem otomatis redirect ke /petugas/dashboard<br/>3. Tunggu data dashboard dimuat | Username: petugas1<br/>Password: Petugas123 | Dashboard petugas tampil dengan: statistik peminjaman menunggu, verifikasi, pengembalian | |
| 52 | DASH-003 | Dashboard | Sukses - Peminjam Lihat Dashboard | 1. Login sebagai peminjam<br/>2. Sistem otomatis redirect ke /peminjam/dashboard<br/>3. Tunggu data dashboard dimuat | Username: user1<br/>Password: User123 | Dashboard peminjam tampil dengan: peminjaman aktif, riwayat, denda saya | |

---

## Catatan Penting

### Fitur yang Tidak Ada di Sistem (TIDAK DITEST):
- Blokir akun pengguna
- Validasi denda oleh admin
- Perpanjangan peminjaman
- SMS/Notifikasi otomatis

### Validasi Password:
- Minimal 8 karakter (sesuai dengan validation rule di UserController)

### Status Peminjaman:
- `pending_approval` - Menunggu Persetujuan
- `disetujui` - Disetujui
- `ditolak` - Ditolak
- `dipinjam` - Sedang Dipinjam
- `menunggu_verifikasi_pengembalian` - Menunggu Verifikasi Pengembalian
- `dikembalikan` - Dikembalikan
- `dibatalkan` - Dibatalkan
- `terlambat` - Terlambat

### Kondisi Alat di Pengembalian:
- **Baik** - Alat dikembalikan dalam kondisi baik, stok bertambah, tanpa denda kerusakan
- **Rusak Ringan** - Alat ada kerusakan kecil, stok tetap, denda kerusakan manual
- **Rusak Berat** - Alat ada kerusakan parah, stok tetap, denda kerusakan manual (lebih besar)
- **Hilang** - Alat hilang, stok tetap, denda maksimal

### Role & Akses:
- **Admin** - Akses penuh semua modul
- **Petugas** - Akses persetujuan peminjaman, verifikasi pengembalian, laporan, dening
- **User/Peminjam** - Akses ajukan peminjaman, lihat riwayat, lihat denda

### URL Penting:
- Login: `/auth/login`
- Admin Dashboard: `/admin/dashboard`
- Petugas Dashboard: `/petugas/dashboard`
- Peminjam Dashboard: `/peminjam/dashboard`

---

**Tanggal Pembuatan**: 12 Februari 2026  
**Status**: Siap untuk ditest
