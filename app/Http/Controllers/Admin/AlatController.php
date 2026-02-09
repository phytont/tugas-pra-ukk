<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->paginate(10);
        return view('admin.alats.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alats.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'merk' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'jumlah_total' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak,maintenance',
        ]);

        $validated['jumlah_tersedia'] = $validated['jumlah_total'];

        Alat::create($validated);

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    public function show(Alat $alat)
    {
        $alat->load('kategori', 'peminjamans.user');
        return view('admin.alats.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alats.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'merk' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'jumlah_total' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak,maintenance',
        ]);

        $dipinjam = $alat->jumlah_total - $alat->jumlah_tersedia;
        $validated['jumlah_tersedia'] = max(0, $validated['jumlah_total'] - $dipinjam);

        $alat->update($validated);

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil diupdate!');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();
        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil dihapus!');
    }
}