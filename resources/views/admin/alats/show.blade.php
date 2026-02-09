@extends('layouts.admin')

@section('title', 'Detail Alat')
@section('header', 'Detail Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat</label>
            <p class="text-lg">{{ $alat->nama_alat }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
            <p class="text-lg">{{ $alat->kategori->nama_kategori }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Merk</label>
            <p class="text-lg">{{ $alat->merk ?? '-' }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Model</label>
            <p class="text-lg">{{ $alat->model ?? '-' }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Total</label>
            <p class="text-lg">{{ $alat->jumlah_total }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Tersedia</label>
            <p class="text-lg">{{ $alat->jumlah_tersedia }}</p>
        </div>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
        <span class="px-2 py-1 text-xs rounded 
            {{ $alat->status == 'tersedia' ? 'bg-green-100 text-green-800' : 
               ($alat->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 
               ($alat->status == 'rusak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
            {{ ucfirst($alat->status) }}
        </span>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
        <p class="text-lg">{{ $alat->deskripsi ?? '-' }}</p>
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('admin.alats.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Kembali</a>
    </div>
</div>
@endsection