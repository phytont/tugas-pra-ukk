<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // Admin hanya bisa melihat daftar denda
    public function index()
    {
        $pengembalians = Pengembalian::where(function($q) {
            $q->where('denda_telat_otomatis', '>', 0)
              ->orWhere('denda_final', '>', 0);
        })
        ->with(['peminjaman.user', 'peminjaman.alat', 'validatedByPetugas'])
        ->latest()
        ->paginate(10);

        return view('admin.pengembalians.index', compact('pengembalians'));
    }

    // Detail denda
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.alat', 'validatedByPetugas']);
        return view('admin.pengembalians.show', compact('pengembalian'));
    }
}