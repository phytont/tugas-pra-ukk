@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Peminjaman -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-list text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Peminjaman</p>
                <p class="text-2xl font-bold">{{ $totalPeminjaman }}</p>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-hand-holding text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Sedang Dipinjam</p>
                <p class="text-2xl font-bold">{{ $peminjamanAktif }}</p>
            </div>
        </div>
    </div>

    <!-- Menunggu Persetujuan -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold">{{ $menungguPersetujuan }}</p>
            </div>
        </div>
    </div>

    <!-- Total Denda -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Denda</p>
                <p class="text-2xl font-bold">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Menu Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('peminjam.alats.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
            <i class="fas fa-tools text-blue-600 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Lihat Alat Tersedia</p>
                <p class="text-sm text-gray-500">Cek alat yang bisa dipinjam</p>
            </div>
        </a>
        
        <a href="{{ route('peminjam.peminjamans.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
            <i class="fas fa-plus-circle text-green-600 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Ajukan Peminjaman</p>
                <p class="text-sm text-gray-500">Pinjam alat baru</p>
            </div>
        </a>
        
        <a href="{{ route('peminjam.pengembalians.create') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
            <i class="fas fa-undo text-yellow-600 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Kembalikan Alat</p>
                <p class="text-sm text-gray-500">Ajukan pengembalian alat</p>
            </div>
        </a>
    </div>
</div>
@endsection