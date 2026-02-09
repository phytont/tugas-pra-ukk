<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat'])->latest()->paginate(10);
        return view('admin.pengembalians.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->with(['user', 'alat'])->get();
        return view('admin.pengembalians.create', compact('peminjamans'));
    }

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

        $denda = 0;
        $tanggalKembali = Carbon::parse($validated['tanggal_kembali']);
        $tanggalRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        
        if ($tanggalKembali->gt($tanggalRencana)) {
            $hariTerlambat = $tanggalKembali->diffInDays($tanggalRencana);
            $denda = $hariTerlambat * 10000;
        }

        $validated['denda'] = $denda;

        Pengembalian::create($validated);

        $peminjaman->update([
            'status' => $denda > 0 ? 'terlambat' : 'dikembalikan',
            'tanggal_kembali_aktual' => $validated['tanggal_kembali'],
        ]);

        $alat = $peminjaman->alat;
        $alat->increment('jumlah_tersedia', $validated['jumlah_kembali']);
        $alat->update(['status' => 'tersedia']);

        return redirect()->route('admin.pengembalians.index')
            ->with('success', 'Pengembalian berhasil dicatat!');
    }

    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.alat']);
        return view('admin.pengembalians.show', compact('pengembalian'));
    }
}