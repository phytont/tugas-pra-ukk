@extends('layouts.petugas')

@section('title', 'Validasi Pembayaran Denda')
@section('header', 'Validasi Pembayaran Denda')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="mb-6 border-b pb-4">
        <h3 class="text-lg font-semibold mb-4">Detail Denda</h3>
        
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="text-gray-600 text-sm">Peminjam:</span>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->user->name }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Alat:</span>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                </div>
            </div>
            
            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between mb-2">
                    <span>Denda Telat (Otomatis):</span>
                    <span>Rp {{ number_format($pengembalian->denda_telat_otomatis, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Denda Kerusakan (Petugas):</span>
                    <span>Rp {{ number_format($pengembalian->denda_final, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-red-600 border-t pt-2 mt-2">
                    <span>TOTAL:</span>
                    <span>Rp {{ number_format($pengembalian->total_denda, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('petugas.pengembalians.storeBayarDenda', $pengembalian) }}" method="POST">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Tanggal Pembayaran *</label>
            <input type="date" name="tanggal_pembayaran" required
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                   value="{{ old('tanggal_pembayaran', now()->format('Y-m-d')) }}">
            @error('tanggal_pembayaran')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Catatan Pembayaran</label>
            <textarea name="catatan" rows="2" 
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                      placeholder="Contoh: Dibayar tunai, transfer, dll...">{{ old('catatan') }}</textarea>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-2"></i>
                <div class="text-sm text-yellow-800">
                    <p class="font-semibold mb-1">Penting:</p>
                    <p>Pastikan peminjam sudah membayar denda secara offline (tunai/transfer) sebelum menekan tombol "Validasi Pembayaran".</p>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('petugas.pengembalians.verified') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 ml-auto"
                    onclick="return confirm('Yakin sudah menerima pembayaran denda?')">
                <i class="fas fa-check-circle mr-2"></i>Validasi Pembayaran
            </button>
        </div>
    </form>
</div>
@endsection