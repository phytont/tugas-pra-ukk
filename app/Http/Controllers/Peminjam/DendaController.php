<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DendaController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::whereHas('peminjaman', function($q) {
            $q->where('user_id', Auth::id());
        })
        ->where(function($q) {
            $q->where('denda_telat_otomatis', '>', 0)
              ->orWhere('denda_final', '>', 0);
        })
        ->with(['peminjaman.alat', 'validatedByPetugas'])
        ->latest()
        ->get();

        $totalDenda = $pengembalians->sum(function($p) {
            return ($p->denda_telat_otomatis ?? 0) + ($p->denda_final ?? 0);
        });

        $belumDibayar = $pengembalians->where('status_pembayaran', 'belum_bayar')->sum(function($p) {
            return ($p->denda_telat_otomatis ?? 0) + ($p->denda_final ?? 0);
        });

        $sudahDibayar = $pengembalians->where('status_pembayaran', 'sudah_bayar')->sum(function($p) {
            return ($p->denda_telat_otomatis ?? 0) + ($p->denda_final ?? 0);
        });

        return view('peminjam.denda.index', compact('pengembalians', 'totalDenda', 'belumDibayar', 'sudahDibayar'));
    }
}