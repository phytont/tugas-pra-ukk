<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Form pilih jenis laporan
    public function index()
    {
        return view('petugas.laporan.index');
    }

    // Laporan peminjaman
    public function peminjaman(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        $peminjamans = Peminjaman::with(['user', 'alat', 'approvedBy'])
            ->whereBetween('tanggal_pinjam', [$request->dari_tanggal, $request->sampai_tanggal])
            ->latest()
            ->get();

        $total = $peminjamans->count();
        $disetujui = $peminjamans->where('status_persetujuan', 'disetujui')->count();
        $ditolak = $peminjamans->where('status_persetujuan', 'ditolak')->count();
        $menunggu = $peminjamans->where('status_persetujuan', 'menunggu')->count();

        return view('petugas.laporan.peminjaman', compact(
            'peminjamans', 'total', 'disetujui', 'ditolak', 'menunggu',
            'request'
        ));
    }

    // Laporan pengembalian
    public function pengembalian(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat'])
            ->whereBetween('tanggal_kembali', [$request->dari_tanggal, $request->sampai_tanggal])
            ->latest()
            ->get();

        $total = $pengembalians->count();
        $totalDenda = $pengembalians->sum('denda');
        $tepatWaktu = $pengembalians->where('denda', 0)->count();
        $terlambat = $pengembalians->where('denda', '>', 0)->count();

        return view('petugas.laporan.pengembalian', compact(
            'pengembalians', 'total', 'totalDenda', 'tepatWaktu', 'terlambat',
            'request'
        ));
    }

    // Laporan stok alat
    public function stokAlat()
    {
        $alats = Alat::with('kategori')->get();
        $totalAlat = $alats->sum('jumlah_total');
        $totalTersedia = $alats->sum('jumlah_tersedia');
        $totalDipinjam = $totalAlat - $totalTersedia;

        return view('petugas.laporan.stok', compact(
            'alats', 'totalAlat', 'totalTersedia', 'totalDipinjam'
        ));
    }

    // Cetak laporan (print-friendly)
    public function cetak(Request $request)
    {
        $jenis = $request->jenis;
        
        if ($jenis == 'peminjaman') {
            $peminjamans = Peminjaman::with(['user', 'alat'])->get();
            return view('petugas.laporan.cetak-peminjaman', compact('peminjamans'));
        }
        
        if ($jenis == 'pengembalian') {
            $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat'])->get();
            return view('petugas.laporan.cetak-pengembalian', compact('pengembalians'));
        }

        return back()->with('error', 'Jenis laporan tidak valid');
    }
}