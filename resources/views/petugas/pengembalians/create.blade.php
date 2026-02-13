@extends('layouts.petugas')

@section('title', 'Input Pengembalian')
@section('header', 'Input Pengembalian Manual')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('petugas.pengembalians.store') }}" method="POST">
            @csrf

            <!-- Pilih Peminjaman -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Pilih Peminjaman</label>
                <select name="peminjaman_id" class="w-full border rounded-lg px-4 py-2 @error('peminjaman_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Peminjaman --</option>
                    @foreach($peminjamans as $pinjam)
                        <option value="{{ $pinjam->id }}" {{ old('peminjaman_id') == $pinjam->id ? 'selected' : '' }}>
                            {{ $pinjam->user->name }} - {{ $pinjam->alat->nama_alat }} 
                            ({{ $pinjam->jumlah_pinjam }} unit) - 
                            Kembali: {{ $pinjam->tanggal_kembali_rencana }}
                        </option>
                    @endforeach
                </select>
                @error('peminjaman_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kondisi -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Kondisi Alat</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input type="radio" name="kondisi" value="baik" {{ old('kondisi') == 'baik' ? 'checked' : '' }} class="mr-2" onchange="toggleDenda()">
                        <span class="text-green-600">Baik</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="kondisi" value="rusak" {{ old('kondisi') == 'rusak' ? 'checked' : '' }} class="mr-2" onchange="toggleDenda()">
                        <span class="text-yellow-600">Rusak</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="kondisi" value="hilang" {{ old('kondisi') == 'hilang' ? 'checked' : '' }} class="mr-2" onchange="toggleDenda()">
                        <span class="text-red-600">Hilang</span>
                    </label>
                </div>
                @error('kondisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nominal Denda (Hidden by default) -->
            <div class="mb-4" id="dendaSection" style="display: none;">
                <label class="block text-gray-700 font-semibold mb-2">Nominal Denda (Rp)</label>
                <input type="number" name="nominal_denda" value="{{ old('nominal_denda', 0) }}" 
                    class="w-full border rounded-lg px-4 py-2 @error('nominal_denda') border-red-500 @enderror" 
                    min="0" placeholder="Masukkan nominal denda">
                @error('nominal_denda')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Isi 0 jika tidak ada denda, atau masukkan nominal untuk validasi admin.</p>
            </div>

            <!-- Keterangan -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded-lg px-4 py-2 @error('keterangan') border-red-500 @enderror" 
                    placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Simpan Pengembalian
                </button>
                <a href="{{ route('petugas.dashboard') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDenda() {
    const kondisi = document.querySelector('input[name="kondisi"]:checked')?.value;
    const dendaSection = document.getElementById('dendaSection');
    
    if (kondisi === 'rusak' || kondisi === 'hilang') {
        dendaSection.style.display = 'block';
    } else {
        dendaSection.style.display = 'none';
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', toggleDenda);
</script>
@endsection