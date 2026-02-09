@extends('layouts.admin')

@section('title', 'Catat Pengembalian')
@section('header', 'Catat Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Pengembalian</h3>
    </div>
    
    <form action="{{ route('admin.pengembalians.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Peminjaman</label>
            <select name="peminjaman_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('peminjaman_id') border-red-500 @enderror">
                <option value="">Pilih Peminjaman</option>
                @foreach($peminjamans as $peminjaman)
                    <option value="{{ $peminjaman->id }}" {{ old('peminjaman_id') == $peminjaman->id ? 'selected' : '' }}>
                        {{ $peminjaman->user->name }} - {{ $peminjaman->alat->nama_alat }} ({{ $peminjaman->jumlah_pinjam }} unit)
                    </option>
                @endforeach
            </select>
            @error('peminjaman_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_kembali') border-red-500 @enderror">
                @error('tanggal_kembali')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kembali</label>
                <input type="number" name="jumlah_kembali" value="{{ old('jumlah_kembali') }}" min="1"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_kembali') border-red-500 @enderror">
                @error('jumlah_kembali')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Alat</label>
            <select name="kondisi" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('kondisi') border-red-500 @enderror">
                <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
            @error('kondisi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('keterangan') }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection