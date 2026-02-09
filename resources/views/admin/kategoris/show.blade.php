@extends('layouts.admin')

@section('title', 'Detail Kategori')
@section('header', 'Detail Kategori')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
        <p class="text-lg">{{ $kategori->nama_kategori }}</p>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
        <p class="text-lg">{{ $kategori->deskripsi ?? '-' }}</p>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Alat</label>
        <p class="text-lg">{{ $kategori->alats->count() }}</p>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Daftar Alat</label>
        <ul class="list-disc list-inside">
            @forelse($kategori->alats as $alat)
                <li>{{ $alat->nama_alat }}</li>
            @empty
                <li class="text-gray-500">Belum ada alat</li>
            @endforelse
        </ul>
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('admin.kategoris.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Kembali</a>
    </div>
</div>
@endsection