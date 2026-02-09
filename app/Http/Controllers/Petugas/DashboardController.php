<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;

class DashboardController extends Controller
{
    public function index()
    {
        $menungguPersetujuan = Peminjaman::menunggu()->count();
        $totalPeminjamanAktif = Peminjaman::where('status', 'dipinjam')->where('status_persetujuan', 'disetujui')->count();
        $totalPengembalianHariIni = Pengembalian::whereDate('tanggal_kembali', today())->count();
        $totalDendaBelumLunas = Pengembalian::where('denda', '>', 0)->whereHas('peminjaman', function($q) {
            $q->where('status', '!=', 'dikembalikan');
        })->sum('denda');

        return view('petugas.dashboard', compact(
            'menungguPersetujuan',
            'totalPeminjamanAktif',
            'totalPengembalianHariIni',
            'totalDendaBelumLunas'
        ));
    }
}