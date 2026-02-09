@extends('layouts.admin')

@section('title', 'Edit Alat')
@section('header', 'Edit Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Edit Alat</h3>
    </div>
    
    <form action="{{ route('admin.alats.update', $alat) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat</label>
            <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('nama_alat') border-red-500 @enderror">
            @error('nama_alat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select name="kategori_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('kategori_id') border-red-500 @enderror">
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Merk</label>
                <input type="text" name="merk" value="{{ old('merk', $alat->merk) }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Model</label>
                <input type="text" name="model" value="{{ old('model', $alat->model) }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Total</label>
            <input type="number" name="jumlah_total" value="{{ old('jumlah_total', $alat->jumlah_total) }}" min="0"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_total') border-red-500 @enderror">
            @error('jumlah_total')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('status') border-red-500 @enderror">
                <option value="tersedia" {{ old('status', $alat->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="dipinjam" {{ old('status', $alat->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="rusak" {{ old('status', $alat->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="maintenance" {{ old('status', $alat->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.alats.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection