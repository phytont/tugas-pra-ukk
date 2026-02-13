<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    // Form pengembalian alat
    public function create()
    {
        // Hanya tampilkan peminjamans milik user yang sudah disetujui petugas dan dalam status menunggu pengembalian
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'menunggu_pengembalian')
            ->where('status_persetujuan', 'disetujui')
            ->with(['alat', 'pengembalian'])
            ->latest()
            ->get();
            
        return view('peminjam.pengembalians.create', compact('peminjamans'));
    }

    // Proses pengembalian alat
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id|integer',
            'tanggal_kembali' => 'required|date|before_or_equal:today',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);

        // Validasi kepemilikan
        if ($peminjaman->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }

        // Cek status peminjaman: HARUS sudah disetujui dan dalam status menunggu pengembalian
        if ($peminjaman->status_persetujuan !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui oleh petugas.')
                ->withInput();
        }

        if ($peminjaman->status !== 'menunggu_pengembalian') {
            return back()->with('error', 'Peminjaman ini tidak dalam status yang dapat dikembalikan.')
                ->withInput();
        }

        // Cek apakah sudah ada pengembalian
        if ($peminjaman->pengembalian) {
            return back()->with('error', 'Pengembalian untuk peminjaman ini sudah ada.')
                ->withInput();
        }

        // PERBAIKAN: HITUNG DENDA TELAT OTOMATIS
        $tanggalKembali = Carbon::parse($validated['tanggal_kembali']);
        $tanggalRencana = $peminjaman->tanggal_kembali_rencana;
        $hariTelat = 0;
        $dendaTelat = 0;

        if ($tanggalKembali->gt($tanggalRencana)) {
            $hariTelat = $tanggalKembali->diffInDays($tanggalRencana);
            $dendaTelat = $hariTelat * 10000; // 10rb per hari
        }

        // PERBAIKAN: HITUNG DENDA KERUSAKAN
        $dendaKerusakan = 0;
        if ($validated['kondisi'] === 'rusak_ringan') {
            $dendaKerusakan = 50000;
        } elseif ($validated['kondisi'] === 'rusak_berat') {
            $dendaKerusakan = 150000;
        }

        // PERBAIKAN: SIMPAN SEMUA DATA YANG DIPERLUKAN
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'jumlah_kembali' => $peminjaman->jumlah_pinjam,
            'kondisi' => $validated['kondisi'],  // 'baik', 'rusak_ringan', atau 'rusak_berat'
            'keterangan' => $validated['keterangan'],
            'tanggal_pengajuan_peminjam' => now()->toDateString(),  // TAMBAHAN: tanggal pengajuan
            'denda_telat_otomatis' => $dendaTelat,  // TAMBAHAN: denda telat
            'jumlah_hari_telat' => $hariTelat,  // TAMBAHAN: hari telat
            'denda_final' => $dendaKerusakan,  // TAMBAHAN: denda kerusakan
            'status_pembayaran' => 'belum_bayar',  // TAMBAHAN: status pembayaran default
            'denda' => $dendaTelat + $dendaKerusakan,  // total denda
            'status_denda' => 'menunggu_validasi',
        ]);

        // Update status peminjaman
        $peminjaman->update([
            'status' => 'menunggu_verifikasi_pengembalian',
            'tanggal_pengajuan_pengembalian' => now()->toDateString(),
        ]);

        return redirect()->route('peminjam.peminjamans.index')
            ->with('success', 'Pengembalian berhasil diajukan! Mohon tunggu verifikasi petugas.');
    }
}
