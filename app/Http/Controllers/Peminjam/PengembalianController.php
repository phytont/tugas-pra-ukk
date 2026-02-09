<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // Form ajukan pengembalian (sesuai flowchart: "Kembalikan alat")
    public function create()
    {
        // Cek apakah punya alat dipinjam (sesuai flowchart: "Punya alat dipinjam?")
        $peminjamans = Peminjaman::where('user_id', auth()->id())
            ->where('status', 'dipinjam')
            ->where('status_persetujuan', 'disetujui')
            ->with('alat')
            ->get();
            
        if ($peminjamans->isEmpty()) {
            return redirect()->route('peminjam.dashboard')
                ->with('error', 'Anda tidak memiliki alat yang sedang dipinjam.');
        }
        
        return view('peminjam.pengembalians.create', compact('peminjamans'));
    }

    // Simpan pengajuan pengembalian
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_kembali' => 'required|date',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::find($validated['peminjaman_id']);
        
        // Cek kepemilikan
        if ($peminjaman->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }
        
        // Cek status
        if ($peminjaman->status != 'dipinjam') {
            return back()->with('error', 'Alat ini sudah dikembalikan atau belum disetujui.');
        }

        // Cek apakah sudah ada pengembalian
        if ($peminjaman->pengembalian) {
            return back()->with('error', 'Pengembalian untuk peminjaman ini sudah diajukan.');
        }

        // Simpan pengembalian (menunggu konfirmasi petugas)
        Pengembalian::create([
            'peminjaman_id' => $validated['peminjaman_id'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'jumlah_kembali' => $peminjaman->jumlah_pinjam,
            'kondisi' => $validated['kondisi'],
            'keterangan' => $validated['keterangan'],
            'denda' => 0, // Akan dihitung petugas nanti
        ]);

        // Update status peminjaman
        $peminjaman->update(['status' => 'dikembalikan']);

        return redirect()->route('peminjam.peminjamans.index')
            ->with('success', 'Pengajuan pengembalian berhasil! Menunggu konfirmasi petugas untuk penghitungan denda.');
    }
}