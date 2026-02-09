<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class DendaController extends Controller
{
    // Lihat denda saya (sesuai flowchart)
    public function index()
    {
        $pengembalians = Pengembalian::whereHas('peminjaman', function($q) {
            $q->where('user_id', auth()->id());
        })
        ->with(['peminjaman.alat', 'peminjaman.user'])
        ->where('denda', '>', 0)
        ->latest()
        ->paginate(10);
        
        $totalDenda = $pengembalians->sum('denda');
        $sudahDibayar = 0; // Bisa dikembangkan dengan tabel pembayaran
        $belumDibayar = $totalDenda - $sudahDibayar;
        
        return view('peminjam.denda.index', compact(
            'pengembalians',
            'totalDenda',
            'sudahDibayar',
            'belumDibayar'
        ));
    }
}