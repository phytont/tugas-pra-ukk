@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')
@section('header', 'Tambah Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Tambah Peminjaman</h3>
    </div>
    
    <form action="{{ route('admin.peminjamans.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Peminjam</label>
            <select name="user_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('user_id') border-red-500 @enderror">
                <option value="">Pilih User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
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
                <option value="">Pilih Alat</option>
                @foreach($alats as $alat)
                    <option value="{{ $alat->id }}" {{ old('alat_id') == $alat->id ? 'selected' : '' }}>
                        {{ $alat->nama_alat }} (Tersedia: {{ $alat->jumlah_tersedia }})
                    </option>
                @endforeach
            </select>
            @error('alat_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Pinjam</label>
            <input type="number" name="jumlah_pinjam" value="{{ old('jumlah_pinjam') }}" min="1"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_pinjam') border-red-500 @enderror">
            @error('jumlah_pinjam')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_pinjam') border-red-500 @enderror">
                @error('tanggal_pinjam')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali_rencana" value="{{ old('tanggal_kembali_rencana') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('tanggal_kembali_rencana') border-red-500 @enderror">
                @error('tanggal_kembali_rencana')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('keterangan') }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.peminjamans.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection