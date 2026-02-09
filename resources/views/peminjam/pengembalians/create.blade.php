@extends('layouts.peminjam')

@section('title', 'Kembalikan Alat')
@section('header', 'Form Pengembalian Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Pengembalian Alat</h3>
        <p class="text-gray-500 text-sm">Pilih peminjaman yang ingin dikembalikan</p>
    </div>
    
    @if($peminjamans->isEmpty())
    <div class="p-6 text-center">
        <i class="fas fa-info-circle text-yellow-500 text-4xl mb-4"></i>
        <p class="text-gray-600 mb-4">Anda tidak memiliki alat yang sedang dipinjam.</p>
        <a href="{{ route('peminjam.alats.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Lihat Alat Tersedia
        </a>
    </div>
    @else
    <form action="{{ route('peminjam.pengembalians.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Peminjaman</label>
            <select name="peminjaman_id" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('peminjaman_id') border-red-500 @enderror">
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjamans as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->alat->nama_alat }} ({{ $p->jumlah_pinjam }} unit) - 
                        Kembali: {{ $p->tanggal_kembali_rencana->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
            @error('peminjaman_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengembalian</label>
            <input type="date" name="tanggal_kembali" required value="{{ date('Y-m-d') }}"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_kembali') border-red-500 @enderror">
            @error('tanggal_kembali')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Alat</label>
            <select name="kondisi" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('kondisi') border-red-500 @enderror">
                <option value="baik">Baik (Tidak ada kerusakan)</option>
                <option value="rusak_ringan">Rusak Ringan</option>
                <option value="rusak_berat">Rusak Berat</option>
            </select>
            @error('kondisi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Jelaskan kondisi alat jika ada kerusakan..."></textarea>
        </div>
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-yellow-800 text-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Perhatian:</strong> Denda akan dihitung oleh petugas berdasarkan:
                <ul class="list-disc list-inside mt-2 ml-4">
                    <li>Keterlambatan pengembalian (Rp 10.000/hari)</li>
                    <li>Kerusakan alat (Ringan: Rp 50.000, Berat: Rp 150.000)</li>
                </ul>
            </p>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('peminjam.dashboard') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                <i class="fas fa-undo mr-2"></i>Ajukan Pengembalian
            </button>
        </div>
    </form>
    @endif
</div>
@endsection