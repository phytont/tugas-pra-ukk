<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->paginate(10);
        return view('admin.peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::all();
        $alats = Alat::where('jumlah_tersedia', '>', 0)->get();
        return view('admin.peminjamans.create', compact('users', 'alats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'alat_id' => 'required|exists:alats,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string',
        ]);

        $alat = Alat::find($validated['alat_id']);
        
        if ($alat->jumlah_tersedia < $validated['jumlah_pinjam']) {
            return back()->with('error', 'Jumlah alat tersedia tidak mencukupi!');
        }

        $validated['status'] = 'dipinjam';

        Peminjaman::create($validated);

        $alat->decrement('jumlah_tersedia', $validated['jumlah_pinjam']);
        if ($alat->jumlah_tersedia == 0) {
            $alat->update(['status' => 'dipinjam']);
        }

        return redirect()->route('admin.peminjamans.index')
            ->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat', 'pengembalian']);
        return view('admin.peminjamans.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $users = User::all();
        $alats = Alat::all();
        return view('admin.peminjamans.edit', compact('peminjaman', 'users', 'alats'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'alat_id' => 'required|exists:alats,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman->update($validated);

        return redirect()->route('admin.peminjamans.index')
            ->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status == 'dipinjam') {
            $alat = $peminjaman->alat;
            $alat->increment('jumlah_tersedia', $peminjaman->jumlah_pinjam);
            $alat->update(['status' => 'tersedia']);
        }

        $peminjaman->delete();
        return redirect()->route('admin.peminjamans.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }
}