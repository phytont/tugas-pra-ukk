@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('header', 'Dashboard Petugas')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
        <a href="{{ route('petugas.peminjamans.index') }}" class="text-yellow-600 text-sm mt-2 inline-block hover:underline">
            Lihat Detail →
        </a>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-hand-holding text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Peminjaman Aktif</p>
                <p class="text-2xl font-bold">{{ $totalPeminjamanAktif }}</p>
            </div>
        </div>
    </div>

    <!-- Pengembalian Hari Ini -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-undo text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Pengembalian Hari Ini</p>
                <p class="text-2xl font-bold">{{ $totalPengembalianHariIni }}</p>
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
                <p class="text-gray-500 text-sm">Total Denda Belum Lunas</p>
                <p class="text-2xl font-bold">Rp {{ number_format($totalDendaBelumLunas, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Menu Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('petugas.peminjamans.index') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
            <i class="fas fa-clipboard-check text-yellow-600 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Persetujuan Peminjaman</p>
                <p class="text-sm text-gray-500">Setujui/tolak peminjaman</p>
            </div>
        </a>
        
        <a href="{{ route('petugas.pengembalians.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
            <i class="fas fa-undo text-green-600 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Input Pengembalian</p>
                <p class="text-sm text-gray-500">Catat pengembalian & denda</p>
            </div>
        </a>
        
        <a href="{{ route('petugas.laporan.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
            <i class="fas fa-file-alt text-blue-600 text-2xl mr-3"></i>
            <div>
                <p class="font-semibold">Cetak Laporan</p>
                <p class="text-sm text-gray-500">Laporan peminjaman & pengembalian</p>
            </div>
        </a>
    </div>
</div>
@endsection