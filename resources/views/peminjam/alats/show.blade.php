@extends('layouts.peminjam')

@section('title', 'Detail Alat')
@section('header', 'Detail Alat')

@section('content')
<div class="bg-white rounded-lg shadow max-w-4xl mx-auto overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <!-- Foto Alat -->
        <div class="bg-gray-100 flex items-center justify-center min-h-96">
            @if($alat->foto)
                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-full h-full object-cover">
            @else
                <div class="text-center">
                    <i class="fas fa-image text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-500">Tidak ada foto</p>
                </div>
            @endif
        </div>

        <!-- Informasi Alat -->
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                    {{ $alat->kategori->nama_kategori }}
                </span>
                <span class="px-3 py-1 rounded-full text-sm 
                    {{ $alat->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($alat->status) }}
                </span>
            </div>
            
            <h2 class="text-2xl font-bold mb-4">{{ $alat->nama_alat }}</h2>
            
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-gray-500 text-sm mb-1">Merk</label>
                    <p class="font-medium">{{ $alat->merk ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-gray-500 text-sm mb-1">Model</label>
                    <p class="font-medium">{{ $alat->model ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-gray-500 text-sm mb-1">Jumlah Tersedia</label>
                    <p class="text-2xl font-bold text-green-600">{{ $alat->jumlah_tersedia }} unit</p> dari {{ $alat->jumlah_total }} unit
                </div>
            </div>

            @if($alat->deskripsi)
            <div class="mb-6">
                <label class="block text-gray-500 text-sm mb-2">Deskripsi</label>
                <p class="bg-gray-50 p-4 rounded">{{ $alat->deskripsi }}</p>
            </div>
            @endif
            
            <div class="flex gap-3">
                <a href="{{ route('peminjam.alats.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                
                @if($alat->jumlah_tersedia > 0 && $alat->status == 'tersedia')
                <a href="{{ route('peminjam.peminjamans.create', ['alat_id' => $alat->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex-1">
                    <i class="fas fa-plus-circle mr-2"></i>Ajukan Peminjaman
                </a>
                @else
                <button disabled class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed flex-1">
                    Tidak Tersedia
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection