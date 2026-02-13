<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjaman;
use App\Http\Controllers\Admin\PengembalianController as AdminPengembalian;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjaman;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalian;
use App\Http\Controllers\Petugas\LaporanController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk User biasa (bisa ajukan peminjaman)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function() {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user?->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user?->isPetugas()) {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('peminjam.dashboard'); // ✅ Benar
        }
    })->name('dashboard');
});

// ============================================
// ROUTE ADMIN (Full Access)
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    Route::resource('users', UserController::class);
    Route::resource('kategoris', KategoriController::class);
    Route::resource('alats', AlatController::class);
    Route::resource('peminjamans', AdminPeminjaman::class);
    
    // Daftar Denda (Admin hanya melihat)
    Route::get('/pengembalians', [AdminPengembalian::class, 'index'])->name('pengembalians.index');
    Route::get('/pengembalians/{pengembalian}', [AdminPengembalian::class, 'show'])->name('pengembalians.show');
    
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

// ============================================
// ROUTE PETUGAS (Approval & Monitoring)
// ============================================
Route::middleware(['auth', 'role:petugas,admin'])->prefix('petugas')->name('petugas.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    
    // Persetujuan Peminjaman
    Route::get('/peminjamans/menunggu', [PetugasPeminjaman::class, 'index'])->name('peminjamans.index');
    Route::get('/peminjamans/semua', [PetugasPeminjaman::class, 'semua'])->name('peminjamans.semua');
    Route::get('/peminjamans/{peminjaman}', [PetugasPeminjaman::class, 'show'])->name('peminjamans.show');
    Route::post('/peminjamans/{peminjaman}/setuju', [PetugasPeminjaman::class, 'setuju'])->name('peminjamans.setuju');
    Route::post('/peminjamans/{peminjaman}/tolak', [PetugasPeminjaman::class, 'tolak'])->name('peminjamans.tolak');
    
// Input Pengembalian Manual oleh Petugas
    Route::get('/pengembalians/create', [PetugasPengembalian::class, 'create'])->name('pengembalians.create');
    Route::post('/pengembalians', [PetugasPengembalian::class, 'store'])->name('pengembalians.store');

    // Pengembalian & Denda
    Route::get('/pengembalians', [PetugasPengembalian::class, 'index'])->name('pengembalians.index');
    Route::get('/pengembalians/verified', [PetugasPengembalian::class, 'verified'])->name('pengembalians.verified');
    Route::get('/pengembalians/{peminjaman}/verify', [PetugasPengembalian::class, 'verify'])->name('pengembalians.verify');
    Route::post('/pengembalians/{peminjaman}/verify', [PetugasPengembalian::class, 'storeVerify'])->name('pengembalians.storeVerify');
    Route::post('/pengembalians/{pengembalian}/mark-paid', [PetugasPengembalian::class, 'markAsPaid'])->name('pengembalians.markAsPaid');
    Route::get('/pengembalians/{pengembalian}', [PetugasPengembalian::class, 'show'])->name('pengembalians.show');
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::post('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/stok-alat', [LaporanController::class, 'stokAlat'])->name('laporan.stok');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

});

// ============================================
// ROUTE PEMINJAM (User Biasa)
// ============================================
Route::middleware(['auth', 'role:user,admin,petugas'])->prefix('peminjam')->name('peminjam.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Peminjam\DashboardController::class, 'index'])->name('dashboard');
    
    // Lihat Daftar Alat (yang tersedia saja)
    Route::get('/alats', [App\Http\Controllers\Peminjam\AlatController::class, 'index'])->name('alats.index');
    Route::get('/alats/{alat}', [App\Http\Controllers\Peminjam\AlatController::class, 'show'])->name('alats.show');
    
    // Ajukan Peminjaman
    Route::get('/peminjamans/create', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'create'])->name('peminjamans.create');
    Route::post('/peminjamans', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'store'])->name('peminjamans.store');
    Route::get('/peminjamans', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'index'])->name('peminjamans.index');
    Route::get('/peminjamans/{peminjaman}', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'show'])->name('peminjamans.show');
    Route::post('/peminjamans/{peminjaman}/submit-return', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'submitReturn'])->name('peminjamans.submitReturn');
    
    // YANG BENAR (pakai PeminjamanController):
    Route::get('/peminjamans/{peminjaman}/return', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'createReturn'])->name('peminjamans.createReturn');
    Route::post('/peminjamans/{peminjaman}/return', [App\Http\Controllers\Peminjam\PeminjamanController::class, 'storeReturn'])->name('peminjamans.storeReturn');
    
    // Pengembalian routes (pakai PengembalianController):
    Route::get('/pengembalians/create', [App\Http\Controllers\Peminjam\PengembalianController::class, 'create'])->name('pengembalians.create');
    Route::post('/pengembalians', [App\Http\Controllers\Peminjam\PengembalianController::class, 'store'])->name('pengembalians.store');
    
    // Lihat Denda
    Route::get('/denda', [App\Http\Controllers\Peminjam\DendaController::class, 'index'])->name('denda.index');
});     


require __DIR__.'/auth.php';