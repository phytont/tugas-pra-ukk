<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Tampilkan peminjaman yang menunggu persetujuan
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->menunggu()
            ->latest()
            ->paginate(10);
            
        return view('petugas.peminjamans.index', compact('peminjamans'));
    }

    // Tampilkan semua peminjaman untuk dipantau
    public function semua()
    {
        $peminjamans = Peminjaman::with(['user', 'alat', 'approvedBy'])
            ->disetujui()
            ->latest()
            ->paginate(10);
            
        return view('petugas.peminjamans.semua', compact('peminjamans'));
    }

    // Detail peminjaman
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat', 'approvedBy']);
        return view('petugas.peminjamans.show', compact('peminjaman'));
    }

    // Setuju peminjaman
    public function setuju(Peminjaman $peminjaman)
    {
        // Kurangi stok alat
        $alat = $peminjaman->alat;
        if ($alat->jumlah_tersedia < $peminjaman->jumlah_pinjam) {
            return back()->with('error', 'Stok alat tidak mencukupi!');
        }

        $peminjaman->update([
            'status_persetujuan' => 'disetujui',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $alat->decrement('jumlah_tersedia', $peminjaman->jumlah_pinjam);
        
        if ($alat->jumlah_tersedia == 0) {
            $alat->update(['status' => 'dipinjam']);
        }

        return redirect()->route('petugas.peminjamans.index')
            ->with('success', 'Peminjaman berhasil disetujui!');
    }

    // Tolak peminjaman
    public function tolak(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $peminjaman->update([
            'status_persetujuan' => 'ditolak',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'keterangan' => $request->alasan_penolakan
        ]);

        return redirect()->route('petugas.peminjamans.index')
            ->with('success', 'Peminjaman berhasil ditolak!');
    }
}