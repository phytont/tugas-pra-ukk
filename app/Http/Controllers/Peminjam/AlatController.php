<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    // Lihat daftar alat yang tersedia (sesuai flowchart)
    public function index()
    {
        $kategoris = Kategori::with(['alats' => function($q) {
            $q->where('jumlah_tersedia', '>', 0)
              ->where('status', 'tersedia');
        }])->get();
        
        $alats = Alat::where('jumlah_tersedia', '>', 0)
            ->where('status', 'tersedia')
            ->with('kategori')
            ->paginate(12);
            
        return view('peminjam.alats.index', compact('alats', 'kategoris'));
    }

    // Detail alat
    public function show(Alat $alat)
    {
        // Cek apakah alat tersedia
        if ($alat->jumlah_tersedia <= 0 || $alat->status != 'tersedia') {
            return redirect()->route('peminjam.alats.index')
                ->with('error', 'Alat tidak tersedia untuk dipinjam');
        }
        
        return view('peminjam.alats.show', compact('alat'));
    }
}