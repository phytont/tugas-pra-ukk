@extends('layouts.petugas')

@section('title', 'Edit Denda')
@section('header', 'Edit Denda Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Edit Denda</h3>
    </div>
    
    <form action="{{ route('petugas.pengembalians.update', $pengembalian) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <div class="grid grid-cols-2 gap-4 mb-2">
                <div>
                    <label class="block text-gray-500 text-sm">Peminjam</label>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->user->name }}</p>
                </div>
                <div>
                    <label class="block text-gray-500 text-sm">Alat</label>
                    <p class="font-semibold">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                </div>
            </div>
            <div>
                <label class="block text-gray-500 text-sm">Tanggal Kembali</label>
                <p>{{ $pengembalian->tanggal_kembali->format('d/m/Y') }}</p>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Denda (Rp)</label>
            <input type="number" name="denda" value="{{ old('denda', $pengembalian->denda) }}" min="0" step="1000"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('denda') border-red-500 @enderror">
            @error('denda')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-xs mt-1">Masukkan 0 jika tidak ada denda</p>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan Perubahan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('keterangan', $pengembalian->keterangan) }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Update Denda
            </button>
        </div>
    </form>
</div>
@endsection