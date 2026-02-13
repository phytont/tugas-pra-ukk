@extends('layouts.admin')

@section('title', 'Tambah Alat')
@section('header', 'Tambah Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Form Tambah Alat</h3>
    </div>
    
    <form action="{{ route('admin.alats.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat</label>
            <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('nama_alat') border-red-500 @enderror">
            @error('nama_alat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <select name="kategori_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('kategori_id') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                <input type="text" name="merk" value="{{ old('merk') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('merk') border-red-500 @enderror">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Model</label>
                <input type="text" name="model" value="{{ old('model') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('model') border-red-500 @enderror">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Total</label>
            <input type="number" name="jumlah_total" value="{{ old('jumlah_total') }}" min="0"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('jumlah_total') border-red-500 @enderror">
            @error('jumlah_total')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('status') border-red-500 @enderror">
                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Alat</label>
            <input type="file" name="foto" accept="image/*" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('foto') border-red-500 @enderror">
            <p class="text-gray-500 text-xs mt-1">Format: JPEG, PNG, JPG, GIF (Maks 5MB)</p>
            @error('foto')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.alats.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection