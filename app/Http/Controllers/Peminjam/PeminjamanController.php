<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Lihat riwayat peminjaman saya
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', auth()->id())
            ->with(['alat', 'pengembalian'])
            ->latest()
            ->paginate(10);
            
        return view('peminjam.peminjamans.index', compact('peminjamans'));
    }

    // Form ajukan peminjaman (sesuai flowchart)
    public function create()
    {
        // Ambil alat yang tersedia
        $alats = Alat::where('jumlah_tersedia', '>', 0)
            ->where('status', 'tersedia')
            ->with('kategori')
            ->get();
            
        return view('peminjam.peminjamans.create', compact('alats'));
    }

    // Simpan pengajuan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $alat = Alat::find($validated['alat_id']);
        
        // Cek ketersediaan (sesuai flowchart: "Alat tersedia?")
        if ($alat->jumlah_tersedia < $validated['jumlah_pinjam']) {
            return back()->with('error', 'Maaf, jumlah alat yang tersedia tidak mencukupi.')
                ->withInput();
        }

        // Simpan peminjaman dengan status menunggu persetujuan
        Peminjaman::create([
            'user_id' => auth()->id(),
            'alat_id' => $validated['alat_id'],
            'jumlah_pinjam' => $validated['jumlah_pinjam'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'status' => 'dipinjam',
            'status_persetujuan' => 'menunggu', // Menunggu persetujuan petugas
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('peminjam.peminjamans.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim! Mohon tunggu persetujuan petugas.');
    }

    // Detail peminjaman saya
    public function show(Peminjaman $peminjaman)
    {
        // Cek kepemilikan
        if ($peminjaman->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
        
        $peminjaman->load(['alat', 'pengembalian', 'approvedBy']);
        
        return view('peminjam.peminjamans.show', compact('peminjaman'));
    }
}