@extends('layouts.peminjam')

@section('title', 'Ajukan Pengembalian')
@section('header', 'Ajukan Pengembalian Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="mb-6 border-b pb-4">
        <h3 class="text-lg font-semibold mb-2">Detail Peminjaman</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-600">Alat:</span>
                <p class="font-semibold">{{ $peminjaman->alat->nama_alat }}</p>
            </div>
            <div>
                <span class="text-gray-600">Jumlah:</span>
                <p class="font-semibold">{{ $peminjaman->jumlah_pinjam }} unit</p>
            </div>
            <div>
                <span class="text-gray-600">Tanggal Pinjam:</span>
                <p>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div>
                <span class="text-gray-600">Tanggal Kembali Rencana:</span>
                <p class="{{ $hariTelat > 0 ? 'text-red-600 font-bold' : '' }}">
                    {{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}
                    @if($hariTelat > 0)
                        (Terlambat {{ $hariTelat }} hari)
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if($hariTelat > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
            <span class="font-semibold text-yellow-800">Anda Terlambat!</span>
        </div>
        <p class="text-sm text-yellow-700 mb-2">
            Anda terlambat <strong>{{ $hariTelat }} hari</strong> dari tanggal kembali yang direncanakan.
        </p>
        <p class="text-sm text-yellow-700">
            Denda otomatis: <strong>Rp {{ number_format($dendaTelat, 0, ',', '.') }}</strong> (Rp 10.000/hari)
        </p>
    </div>
    @endif

    <form action="{{ route('peminjam.peminjamans.storeReturn', $peminjaman) }}" method="POST">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-3">Kondisi Pengembalian</label>
            <p class="text-sm text-gray-600 mb-3">Pilih salah satu kondisi yang sesuai:</p>
            
            <div class="space-y-3">
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <input type="radio" name="jenis_pelanggaran" value="tidak_ada" class="mr-3" required
                           {{ old('jenis_pelanggaran') == 'tidak_ada' ? 'checked' : '' }}>
                    <div>
                        <span class="font-semibold text-green-600">✓ Baik / Normal</span>
                        <p class="text-sm text-gray-600">Alat kembali dalam kondisi baik, tidak ada kerusakan</p>
                    </div>
                </label>

                @if($hariTelat > 0)
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <input type="radio" name="jenis_pelanggaran" value="telat" class="mr-3"
                           {{ old('jenis_pelanggaran') == 'telat' ? 'checked' : '' }}>
                    <div>
                        <span class="font-semibold text-yellow-600">⏰ Terlambat</span>
                        <p class="text-sm text-gray-600">Hanya terlambat mengembalikan, alat dalam kondisi baik</p>
                        <p class="text-sm text-red-600 font-semibold">Denda otomatis: Rp {{ number_format($dendaTelat, 0, ',', '.') }}</p>
                    </div>
                </label>
                @endif

                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <input type="radio" name="jenis_pelanggaran" value="rusak_ringan" class="mr-3"
                           {{ old('jenis_pelanggaran') == 'rusak_ringan' ? 'checked' : '' }}>
                    <div>
                        <span class="font-semibold text-orange-600">🔧 Rusak Ringan</span>
                        <p class="text-sm text-gray-600">Alat rusak ringan (lecet, cat pudar, dll)</p>
                    </div>
                </label>

                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <input type="radio" name="jenis_pelanggaran" value="hilang" class="mr-3"
                           {{ old('jenis_pelanggaran') == 'hilang' ? 'checked' : '' }}>
                    <div>
                        <span class="font-semibold text-red-600">✗ Hilang / Rusak Berat</span>
                        <p class="text-sm text-gray-600">Alat hilang atau rusak berat tidak bisa dipakai</p>
                    </div>
                </label>
            </div>
            @error('jenis_pelanggaran')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Keterangan (Opsional)</label>
            <textarea name="keterangan_pelanggaran" rows="3" 
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Jelaskan kondisi alat jika rusak/hilang...">{{ old('keterangan_pelanggaran') }}</textarea>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('peminjam.peminjamans.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 ml-auto">
                <i class="fas fa-paper-plane mr-2"></i>Ajukan Pengembalian
            </button>
        </div>
    </form>
</div>
@endsection