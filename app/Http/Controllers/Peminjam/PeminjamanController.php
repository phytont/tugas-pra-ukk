<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // ============================================
    // METHOD LAMA (TETAP SAMA)
    // ============================================
    
    // Lihat riwayat peminjaman saya
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->with(['alat', 'pengembalian'])
            ->latest()
            ->paginate(10);
            
        return view('peminjam.peminjamans.index', compact('peminjamans'));
    }

    // Form ajukan peminjaman (sesuai flowchart)
    public function create()
    {
        // Ambil alat yang tersedia
        $alats = Alat::where('jumlah_tersedia', '>', 0)
            ->where('status', 'tersedia')
            ->with('kategori')
            ->get();
            
        return view('peminjam.peminjamans.create', compact('alats'));
    }

    // Simpan pengajuan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $alat = Alat::find($validated['alat_id']);
        
        // Cek ketersediaan (sesuai flowchart: "Alat tersedia?")
        if ($alat->jumlah_tersedia < $validated['jumlah_pinjam']) {
            return back()->with('error', 'Maaf, jumlah alat yang tersedia tidak mencukupi.')
                ->withInput();
        }

        // Simpan peminjaman dengan status menunggu persetujuan
        Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $validated['alat_id'],
            'jumlah_pinjam' => $validated['jumlah_pinjam'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'status' => 'pending_approval',
            'status_persetujuan' => 'menunggu',
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('peminjam.peminjamans.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim! Mohon tunggu persetujuan petugas.');
    }

    // Detail peminjaman saya
    public function show(Peminjaman $peminjaman)
    {
        // Cek kepemilikan
        if ($peminjaman->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
        
        $peminjaman->load(['alat', 'pengembalian', 'approvedBy']);
        
        return view('peminjam.peminjamans.show', compact('peminjaman'));
    }

    // ============================================
    // METHOD BARU (PENGEMBALIAN DENGAN PELANGGARAN)
    // ============================================
    
    // Form ajukan pengembalian dengan pelanggaran
    public function createReturn(Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id != Auth::id()) {
            abort(403);
        }

        if ($peminjaman->status != 'menunggu_pengembalian') {
            return back()->with('error', 'Peminjaman tidak dalam status aktif.');
        }

        // Cek apakah sudah ada pengajuan pengembalian
        if ($peminjaman->pengembalian) {
            return back()->with('error', 'Anda sudah mengajukan pengembalian untuk peminjaman ini.');
        }

        $peminjaman->load('alat');
        
        // Hitung keterlambatan otomatis
        $today = now();
        $rencanaKembali = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $hariTelat = 0;
        $dendaTelat = 0;

        if ($today->gt($rencanaKembali)) {
            $hariTelat = $today->diffInDays($rencanaKembali);
            $dendaTelat = $hariTelat * 10000; // 10rb per hari
        }

        return view('peminjam.peminjamans.create_return', compact('peminjaman', 'hariTelat', 'dendaTelat'));
    }

    // Simpan pengajuan pengembalian
    public function storeReturn(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id != Auth::id()) {
            abort(403);
        }

        if ($peminjaman->status != 'menunggu_pengembalian') {
            return back()->with('error', 'Peminjaman tidak dalam status aktif.');
        }

        $validated = $request->validate([
            'jenis_pelanggaran' => 'required|in:tidak_ada,telat,rusak_ringan,hilang',
            'keterangan_pelanggaran' => 'nullable|string|max:1000',
        ]);

        // Hitung denda telat otomatis
        $today = now();
        $rencanaKembali = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $hariTelat = 0;
        $dendaTelat = 0;

        if ($today->gt($rencanaKembali)) {
            $hariTelat = $today->diffInDays($rencanaKembali);
            $dendaTelat = $hariTelat * 10000;
        }

        // Jika memilih telat tapi tidak telat, error
        if ($validated['jenis_pelanggaran'] == 'telat' && $hariTelat == 0) {
            return back()->with('error', 'Anda tidak terlambat, tidak perlu memilih opsi telat.');
        }

        // Buat record pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali' => $today->toDateString(),
            'jumlah_kembali' => $peminjaman->jumlah_pinjam,
            'kondisi' => 'baik', // Default, akan diubah petugas saat verifikasi
            'jenis_pelanggaran' => $validated['jenis_pelanggaran'],
            'tanggal_pengajuan_peminjam' => $today->toDateString(),
            'keterangan_pelanggaran' => $validated['keterangan_pelanggaran'],
            'denda_telat_otomatis' => $dendaTelat,
            'jumlah_hari_telat' => $hariTelat,
            'denda_final' => 0,
            'status_pembayaran' => 'belum_bayar',
        ]);

        // Update status peminjaman
        $peminjaman->update([
            'status' => 'menunggu_verifikasi_pengembalian',
            'tanggal_pengajuan_pengembalian' => $today->toDateString(),
        ]);

        return redirect()->route('peminjam.peminjamans.index')
            ->with('success', 'Pengajuan pengembalian berhasil! Mohon tunggu verifikasi petugas.');
    }
}