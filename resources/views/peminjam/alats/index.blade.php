@extends('layouts.peminjam')

@section('title', 'Daftar Alat Tersedia')
@section('header', 'Daftar Alat yang Tersedia')

@section('content')
<div class="mb-6">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
        <p class="text-blue-700">
            <i class="fas fa-info-circle mr-2"></i>
            Berikut adalah alat yang tersedia untuk dipinjam. Klik "Detail" untuk melihat informasi lengkap dan mengajukan peminjaman.
        </p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($alats as $alat)
    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
        @if($alat->foto)
            <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                <i class="fas fa-image text-gray-400 text-4xl"></i>
            </div>
        @endif

        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                    {{ $alat->kategori->nama_kategori }}
                </span>
                <span class="px-2 py-1 text-xs rounded 
                    {{ $alat->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($alat->status) }}
                </span>
            </div>
            
            <h3 class="text-lg font-semibold mb-2">{{ $alat->nama_alat }}</h3>
            
            <div class="space-y-2 text-sm text-gray-600 mb-4">
                <p><i class="fas fa-industry mr-2"></i>Merk: {{ $alat->merk ?? '-' }}</p>
                <p><i class="fas fa-cube mr-2"></i>Model: {{ $alat->model ?? '-' }}</p>
                <p><i class="fas fa-boxes mr-2"></i>Tersedia: <span class="font-bold text-green-600">{{ $alat->jumlah_tersedia }}</span> / {{ $alat->jumlah_total }} unit</p>
            </div>
            
            <a href="{{ route('peminjam.alats.show', $alat) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-eye mr-2"></i>Lihat Detail
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-8">
        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Tidak ada alat yang tersedia saat ini</p>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $alats->links() }}
</div>
@endsection