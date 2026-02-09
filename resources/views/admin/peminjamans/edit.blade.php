@extends('layouts.admin')

@section('title', 'Edit Peminjaman')
@section('header', 'Edit Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Edit Peminjaman</h3>
    </div>
    
    <form action="{{ route('admin.peminjamans.update', $peminjaman) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Peminjam</label>
            <select name="user_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('user_id') border-red-500 @enderror">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Alat</label>
            <select name="alat_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('alat_id') border-red-500 @enderror">
                @foreach($alats as $alat)
                    <option value="{{ $alat->id }}" {{ old('alat_id', $peminjaman->alat_id) == $alat->id ? 'selected' : '' }}>
                        {{ $alat->nama_alat }}
                    </option>
                @endforeach
            </select>
            @error('alat_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Pinjam</label>
            <input type="number" name="jumlah_pinjam" value="{{ old('jumlah_pinjam', $peminjaman->jumlah_pinjam) }}" min="1"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_pinjam') border-red-500 @enderror">
            @error('jumlah_pinjam')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_pinjam') border-red-500 @enderror">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana->format('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_kembali_rencana') border-red-500 @enderror">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('status') border-red-500 @enderror">
                <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="dikembalikan" {{ old('status', $peminjaman->status) == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                <option value="terlambat" {{ old('status', $peminjaman->status) == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.peminjamans.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection