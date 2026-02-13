<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();
        $peminjamanAktif = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->where('status_persetujuan', 'disetujui')
            ->count();
        $menungguPersetujuan = Peminjaman::where('user_id', $user->id)
            ->where('status_persetujuan', 'menunggu')
            ->count();
        
        // Hitung total denda dari denda_final dan belum dibayar
        $totalDenda = Pengembalian::whereHas('peminjaman', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->where('status_pembayaran', 'belum_bayar')
        ->sum('denda_final');
        
        return view('peminjam.dashboard', compact(
            'totalPeminjaman',
            'peminjamanAktif',
            'menungguPersetujuan',
            'totalDenda'
        ));
    }
}