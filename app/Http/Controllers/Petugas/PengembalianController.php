<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    // Tampilkan daftar pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat'])
            ->latest()
            ->paginate(10);
            
        return view('petugas.pengembalians.index', compact('pengembalians'));
    }

    // Form input pengembalian
    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')
            ->where('status_persetujuan', 'disetujui')
            ->with(['user', 'alat'])
            ->get();
            
        return view('petugas.pengembalians.create', compact('peminjamans'));
    }

    // Simpan pengembalian + hitung denda otomatis
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tanggal_kembali' => 'required|date',
            'jumlah_kembali' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::find($validated['peminjaman_id']);
        
        if ($validated['jumlah_kembali'] > $peminjaman->jumlah_pinjam) {
            return back()->with('error', 'Jumlah kembali melebihi jumlah pinjam!');
        }

        // Hitung denda
        $denda = $this->hitungDenda($peminjaman, $validated['tanggal_kembali'], $validated['kondisi']);

        $validated['denda'] = $denda;

        Pengembalian::create($validated);

        // Update peminjaman
        $peminjaman->update([
            'status' => $denda > 0 ? 'terlambat' : 'dikembalikan',
            'tanggal_kembali_aktual' => $validated['tanggal_kembali'],
        ]);

        // Update stok alat
        $alat = $peminjaman->alat;
        $alat->increment('jumlah_tersedia', $validated['jumlah_kembali']);
        
        if ($alat->jumlah_tersedia > 0) {
            $alat->update(['status' => 'tersedia']);
        }

        return redirect()->route('petugas.pengembalians.index')
            ->with('success', 'Pengembalian berhasil dicatat! Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    // Edit denda (kalau perlu koreksi)
    public function edit(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.alat']);
        return view('petugas.pengembalians.edit', compact('pengembalian'));
    }

    // Update denda
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'denda' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $pengembalian->update($validated);

        return redirect()->route('petugas.pengembalians.index')
            ->with('success', 'Denda berhasil diupdate!');
    }

    // Detail pengembalian
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.alat']);
        return view('petugas.pengembalians.show', compact('pengembalian'));
    }

    // Fungsi hitung denda
    private function hitungDenda($peminjaman, $tanggalKembali, $kondisi)
    {
        $denda = 0;
        
        // Denda keterlambatan
        $tglKembali = Carbon::parse($tanggalKembali);
        $tglRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        
        if ($tglKembali->gt($tglRencana)) {
            $hariTerlambat = $tglKembali->diffInDays($tglRencana);
            $denda += $hariTerlambat * 10000; // Rp 10.000/hari
        }
        
        // Denda kerusakan
        switch ($kondisi) {
            case 'rusak_ringan':
                $denda += 50000;
                break;
            case 'rusak_berat':
                $denda += 150000;
                break;
        }
        
        return $denda;
    }
}