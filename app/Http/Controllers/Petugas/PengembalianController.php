<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    // ⬇️⬇️⬇️ METHOD BARU - TAMBAHKAN INI ⬇️⬇️⬇️
    // Form input pengembalian manual oleh petugas
    public function create()
    {
        // Ambil peminjaman yang sedang dipinjam (bisa dikembalikan)
        $peminjamans = Peminjaman::where('status', 'dipinjam')
            ->where('status_persetujuan', 'disetujui')
            ->with(['user', 'alat'])
            ->get();
            
        return view('petugas.pengembalians.create', compact('peminjamans'));
    }

    // Simpan pengembalian manual oleh petugas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'keterangan' => 'nullable|string|max:1000',
            'denda_final' => 'required|integer|min:0',
        ], [
            'denda_final.required' => 'Nominal denda final harus diisi',
        ]);

        $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);

        // Cek status
        if ($peminjaman->status != 'dipinjam') {
            return back()->with('error', 'Peminjaman ini tidak dalam status dipinjam.');
        }

        // Cek apakah sudah ada pengembalian
        if ($peminjaman->pengembalian) {
            return back()->with('error', 'Pengembalian untuk peminjaman ini sudah ada.');
        }

        // Simpan pengembalian
        if ($validated['kondisi'] == 'baik') {
            // Kondisi baik - langsung selesai
            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali' => now()->toDateString(),
                'jumlah_kembali' => $peminjaman->jumlah_pinjam,
                'kondisi' => 'baik',
                'keterangan' => $validated['keterangan'],
                'denda_final' => 0,
                'status_pembayaran' => 'sudah_bayar',
                'validated_by_petugas' => Auth::id(),
            ]);

            $peminjaman->update([
                'status' => 'selesai',
                'status_verifikasi_petugas' => 'approved',
                'verified_by_petugas' => Auth::id(),
                'verified_at_petugas' => now(),
                'tanggal_kembali_aktual' => now()->toDateString(),
            ]);

            // Kembalikan stok
            $alat = $peminjaman->alat;
            $alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
            if ($alat->jumlah_tersedia > 0 && $alat->status != 'maintenance') {
                $alat->update(['status' => 'tersedia']);
            }

            return redirect()->route('petugas.pengembalians.index')
                ->with('success', 'Pengembalian berhasil dicatat! Alat dalam kondisi baik, stok dikembalikan.');
        } else {
            // Kondisi rusak_ringan, rusak_berat, atau hilang - denda langsung final dari petugas
            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali' => now()->toDateString(),
                'jumlah_kembali' => $peminjaman->jumlah_pinjam,
                'kondisi' => $validated['kondisi'],
                'keterangan' => $validated['keterangan'],
                'denda_final' => $validated['denda_final'],
                'status_pembayaran' => $validated['denda_final'] > 0 ? 'belum_bayar' : 'sudah_bayar',
                'validated_by_petugas' => Auth::id(),
            ]);

            // Update status peminjaman ke selesai (tanpa tunggu admin)
            $peminjaman->update([
                'status' => 'selesai',
                'status_verifikasi_petugas' => 'approved',
                'verified_by_petugas' => Auth::id(),
                'verified_at_petugas' => now(),
                'tanggal_kembali_aktual' => now()->toDateString(),
            ]);

            // Return stok jika tidak ada denda kerusakan (denda_final = 0)
            // Jika ada denda kerusakan, stok tetap hilang sampai denda dibayar
            if ($validated['denda_final'] == 0) {
                $alat = $peminjaman->alat;
                $alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
                if ($alat->jumlah_tersedia > 0 && $alat->status != 'maintenance') {
                    $alat->update(['status' => 'tersedia']);
                }
            }

            if ($validated['denda_final'] > 0) {
                return redirect()->route('petugas.pengembalians.index')
                    ->with('success', 'Pengembalian berhasil dicatat! Denda Rp ' . number_format($validated['denda_final'], 0, ',', '.') . ' langsung ditagihkan ke peminjam.');
            } else {
                return redirect()->route('petugas.pengembalians.index')
                    ->with('success', 'Pengembalian berhasil dicatat! Tidak ada denda, stok alat dikembalikan.');
            }
        }
    }
    // ⬆️⬆️⬆️ SAMPAI SINI ⬆️⬆️⬆️


    // Method yang sudah ada sebelumnya (jangan dihapus!)

    // Tampilkan daftar pengembalian yang menunggu verifikasi
    public function index()
    {
        $pengembalians = Peminjaman::where('status', 'menunggu_verifikasi_pengembalian')
            ->with(['user', 'alat', 'pengembalian'])
            ->latest()
            ->paginate(10);
            
        return view('petugas.pengembalians.index', compact('pengembalians'));
    }

    // Tampilkan pengembalian yang menunggu pembayaran denda
    public function verified()
    {
        $pengembalians = Pengembalian::where('status_pembayaran', 'belum_bayar')
            ->with(['peminjaman.user', 'peminjaman.alat'])
            ->latest()
            ->paginate(10);
            
        return view('petugas.pengembalians.verified', compact('pengembalians'));
    }

    // Mark denda sebagai sudah dibayar
    public function markAsPaid(Pengembalian $pengembalian)
    {
        if ($pengembalian->status_pembayaran == 'sudah_bayar') {
            return back()->with('error', 'Denda ini sudah ditandai sebagai sudah dibayar.');
        }

        $pengembalian->update([
            'status_pembayaran' => 'sudah_bayar',
            'tanggal_pembayaran' => now(),
        ]);

        // Return stok alat ketika denda sudah dibayar
        $peminjaman = $pengembalian->peminjaman;
        $alat = $peminjaman->alat;
        $alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
        if ($alat->jumlah_tersedia > 0 && $alat->status != 'maintenance') {
            $alat->update(['status' => 'tersedia']);
        }

        return back()->with('success', 'Denda berhasil ditandai sebagai sudah dibayar! Stok alat dikembalikan.');
    }

    // Form verifikasi pengembalian
    public function verify(Peminjaman $peminjaman)
    {
        // Cek status peminjaman
        if ($peminjaman->status != 'menunggu_verifikasi_pengembalian') {
            abort(404, 'Peminjaman tidak ditemukan atau tidak menunggu verifikasi.');
        }

        $peminjaman->load(['user', 'alat', 'pengembalian']);
        return view('petugas.pengembalians.verify', compact('peminjaman'));
    }

    // Proses verifikasi pengembalian
    public function storeVerify(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status != 'menunggu_verifikasi_pengembalian') {
            return back()->with('error', 'Peminjaman tidak dalam status menunggu verifikasi.');
        }

        $validated = $request->validate([
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'keterangan' => 'nullable|string|max:1000',
            'denda_final' => 'required|integer|min:0',
        ], [
            'denda_final.required' => 'Nominal denda final harus diisi',
        ]);

        // Cek apakah sudah ada pengembalian (HARUS ADA, made by peminjam)
        if (!$peminjaman->pengembalian) {
            return back()->with('error', 'Tidak ada pencatatan pengembalian dari peminjam.');
        }

        $pengembalian = $peminjaman->pengembalian;

        // UPDATE pengembalian record dengan kondisi dan denda verifikasi petugas
        $pengembalian->update([
            'kondisi' => $validated['kondisi'],
            'keterangan' => $validated['keterangan'],
            'denda_final' => $validated['denda_final'],
            'status_pembayaran' => $validated['denda_final'] > 0 ? 'belum_bayar' : 'sudah_bayar',
            'validated_by_petugas' => Auth::id(),
        ]);

        // Handle kondisi baik
        if ($validated['kondisi'] == 'baik') {
            // Kondisi baik - langsung selesai dan stok kembali
            $peminjaman->update([
                'status' => 'selesai',
                'status_verifikasi_petugas' => 'approved',
                'verified_by_petugas' => Auth::id(),
                'verified_at_petugas' => now(),
                'tanggal_kembali_aktual' => $pengembalian->tanggal_kembali,
            ]);

            // Kembalikan stok alat
            $alat = $peminjaman->alat;
            $alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
            if ($alat->jumlah_tersedia > 0 && $alat->status != 'maintenance') {
                $alat->update(['status' => 'tersedia']);
            }

            return redirect()->route('petugas.pengembalians.index')
                ->with('success', 'Pengembalian diverifikasi! Alat dalam kondisi baik, stok dikembalikan.');
        } else {
            // Kondisi rusak_ringan, rusak_berat, atau hilang - denda langsung final dari petugas
            $peminjaman->update([
                'status' => 'selesai',
                'status_verifikasi_petugas' => 'approved',
                'verified_by_petugas' => Auth::id(),
                'verified_at_petugas' => now(),
                'tanggal_kembali_aktual' => $pengembalian->tanggal_kembali,
            ]);

            // Return stok jika tidak ada denda kerusakan (denda_final = 0)
            // Jika ada denda kerusakan, stok tetap hilang sampai denda dibayar
            if ($validated['denda_final'] == 0) {
                $alat = $peminjaman->alat;
                $alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
                if ($alat->jumlah_tersedia > 0 && $alat->status != 'maintenance') {
                    $alat->update(['status' => 'tersedia']);
                }
            }

            if ($validated['denda_final'] > 0) {
                return redirect()->route('petugas.pengembalians.index')
                    ->with('success', 'Pengembalian diverifikasi! Denda Rp ' . number_format($validated['denda_final'], 0, ',', '.') . ' langsung ditagihkan ke peminjam.');
            } else {
                return redirect()->route('petugas.pengembalians.index')
                    ->with('success', 'Pengembalian diverifikasi! Tidak ada denda, stok alat dikembalikan.');
            }
        }
    }

    // Detail pengembalian
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.alat', 'verifiedByAdmin']);
        return view('petugas.pengembalians.show', compact('pengembalian'));
    }
}