<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAlat = Alat::count();
        $totalUser = User::count();
        $totalKategori = Kategori::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $peminjamanTerlambat = Peminjaman::where('status', 'terlambat')->count();
        
        return view('admin.dashboard', compact(
            'totalAlat', 'totalUser', 'totalKategori', 
            'peminjamanAktif', 'peminjamanTerlambat'
        ));
    }
}