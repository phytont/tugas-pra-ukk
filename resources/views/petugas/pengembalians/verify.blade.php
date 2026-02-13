@extends('layouts.petugas')

@section('title', 'Verifikasi Pengembalian Alat')
@section('header', 'Verifikasi Pengembalian Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-3xl mx-auto p-6">
    <div class="mb-6 pb-6 border-b">
        <h3 class="text-lg font-semibold mb-4">Detail Pengajuan Peminjam</h3>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-gray-600 text-sm">Peminjam</label>
                <p class="font-semibold">{{ $peminjaman->user->name }}</p>
            </div>
            <div>
                <label class="text-gray-600 text-sm">Email Peminjam</label>
                <p class="font-semibold">{{ $peminjaman->user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-gray-600 text-sm">Alat yang Dipinjam</label>
                <p class="font-semibold">{{ $peminjaman->alat->nama_alat }}</p>
            </div>
            <div>
                <label class="text-gray-600 text-sm">Jumlah Dipinjam</label>
                <p class="font-semibold text-lg text-blue-600">{{ $peminjaman->jumlah_pinjam }} unit</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-gray-600 text-sm">Tanggal Peminjaman</label>
                <p class="font-semibold">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div>
                <label class="text-gray-600 text-sm">Tanggal Kembali Rencana</label>
                <p class="font-semibold">{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
            </div>
        </div>

        @if($peminjaman->pengembalian)
        <div class="bg-blue-50 p-4 rounded-lg mt-4">
            <h4 class="font-semibold text-blue-800 mb-2">Informasi Pengajuan Peminjam:</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Jenis Pelanggaran:</span>
                    <p class="font-semibold">
                        @switch($peminjaman->pengembalian->jenis_pelanggaran)
                            @case('tidak_ada') <span class="text-green-600">Baik/Normal</span> @break
                            @case('telat') <span class="text-yellow-600">Terlambat ({{ $peminjaman->pengembalian->jumlah_hari_telat }} hari)</span> @break
                            @case('rusak_ringan') <span class="text-orange-600">Rusak Ringan</span> @break
                            @case('hilang') <span class="text-red-600">Hilang/Rusak Berat</span> @break
                        @endswitch
                    </p>
                </div>
                <div>
                    <span class="text-gray-600">Denda Telat Otomatis:</span>
                    <p class="font-semibold text-red-600">
                        Rp {{ number_format($peminjaman->pengembalian->denda_telat_otomatis, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @if($peminjaman->pengembalian->keterangan_pelanggaran)
            <div class="mt-2">
                <span class="text-gray-600">Keterangan Peminjam:</span>
                <p class="mt-1 p-2 bg-white rounded text-sm">{{ $peminjaman->pengembalian->keterangan_pelanggaran }}</p>
            </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Form Verifikasi -->
    <form action="{{ route('petugas.pengembalians.storeVerify', $peminjaman) }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-gray-700 font-bold mb-3">Kondisi Alat Setelah Pemeriksaan Fisik</label>
            <p class="text-sm text-gray-600 mb-3">Pilih kondisi alat berdasarkan pemeriksaan fisik Anda</p>
            <div class="space-y-3">
                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                    <input type="radio" name="kondisi" value="baik" id="kondisi_baik" class="mr-3 kondisi-radio"
                           @if(old('kondisi', $peminjaman->pengembalian->kondisi ?? '') == 'baik') checked @endif required>
                    <label for="kondisi_baik" class="text-green-600 font-semibold cursor-pointer flex-1">
                        ✓ Baik (Sesuai kondisi semula)
                    </label>
                </div>
                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                    <input type="radio" name="kondisi" value="rusak_ringan" id="kondisi_rusak_ringan" class="mr-3 kondisi-radio"
                           @if(old('kondisi', $peminjaman->pengembalian->kondisi ?? '') == 'rusak_ringan') checked @endif>
                    <label for="kondisi_rusak_ringan" class="text-yellow-600 font-semibold cursor-pointer flex-1">
                        ⚠ Rusak Ringan (Lecet, cat pudar, dll)
                    </label>
                </div>
                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                    <input type="radio" name="kondisi" value="rusak_berat" id="kondisi_rusak_berat" class="mr-3 kondisi-radio"
                           @if(old('kondisi', $peminjaman->pengembalian->kondisi ?? '') == 'rusak_berat') checked @endif>
                    <label for="kondisi_rusak_berat" class="text-orange-600 font-semibold cursor-pointer flex-1">
                        🔧 Rusak Berat (Tidak bisa digunakan)
                    </label>
                </div>
                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                    <input type="radio" name="kondisi" value="hilang" id="kondisi_hilang" class="mr-3 kondisi-radio"
                           @if(old('kondisi', $peminjaman->pengembalian->kondisi ?? '') == 'hilang') checked @endif>
                    <label for="kondisi_hilang" class="text-red-600 font-semibold cursor-pointer flex-1">
                        ✗ Hilang (Tidak dikembalikan)
                    </label>
                </div>
            </div>
            @error('kondisi')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Denda Final -->
        <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
            <label class="block text-gray-700 font-bold mb-2">Nominal Denda Final</label>
            <p class="text-sm text-gray-600 mb-2">
                Masukkan total denda yang harus dibayar peminjam (termasuk denda keterlambatan jika ada).
            </p>
            <div class="flex items-center mb-2">
                <span class="text-lg font-semibold text-gray-700 mr-2">Rp</span>
                <input type="number" name="denda_final" id="denda_final" min="0" 
                       value="{{ old('denda_final', $peminjaman->pengembalian->denda_telat_otomatis ?? 0) }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-red-500 @error('denda_final') border-red-500 @enderror"
                       placeholder="0" required>
            </div>
            <p class="text-xs text-gray-500">
                Denda keterlambatan otomatis: Rp {{ number_format($peminjaman->pengembalian->denda_telat_otomatis ?? 0, 0, ',', '.') }} 
                (bisa ditambah/dikurangi sesuai kondisi alat)
            </p>
            @error('denda_final')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-bold mb-2">Keterangan Verifikasi</label>
            <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Catatan hasil pemeriksaan fisik...">{{ old('keterangan', $peminjaman->pengembalian->keterangan ?? '') }}</textarea>
        </div>

        <div class="flex gap-3 pt-4 border-t">
            <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 ml-auto">
                <i class="fas fa-check mr-2"></i>Simpan Verifikasi
            </button>
        </div>
    </form>
</div>
@endsection