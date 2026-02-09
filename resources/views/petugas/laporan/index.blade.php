@extends('layouts.petugas')

@section('title', 'Laporan')
@section('header', 'Cetak Laporan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Laporan Peminjaman -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-3">
                <i class="fas fa-hand-holding text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Laporan Peminjaman</h3>
        </div>
        
        <form action="{{ route('petugas.laporan.peminjaman') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-eye mr-2"></i>Lihat Laporan
            </button>
        </form>
    </div>

    <!-- Laporan Pengembalian -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-3">
                <i class="fas fa-undo text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Laporan Pengembalian</h3>
        </div>
        
        <form action="{{ route('petugas.laporan.pengembalian') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-eye mr-2"></i>Lihat Laporan
            </button>
        </form>
    </div>

    <!-- Laporan Stok Alat -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-3">
                <i class="fas fa-boxes text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Laporan Stok Alat</h3>
        </div>
        
        <p class="text-gray-500 text-sm mb-4">Lihat stok alat saat ini, alat yang tersedia, dipinjam, dan rusak.</p>
        
        <a href="{{ route('petugas.laporan.stok') }}" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-center">
            <i class="fas fa-eye mr-2"></i>Lihat Laporan
        </a>
    </div>
</div>
@endsection