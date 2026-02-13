@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Alat -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                <i class="fas fa-tools text-primary text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Total</span>
        </div>
        <p class="text-3xl font-bold text-dark mb-1">{{ $totalAlat }}</p>
        <p class="text-sm text-gray-500">Total Alat</p>
    </div>

    <!-- Total User -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-blue-500 text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Total</span>
        </div>
        <p class="text-3xl font-bold text-dark mb-1">{{ $totalUser }}</p>
        <p class="text-sm text-gray-500">Total User</p>
    </div>

    <!-- Total Kategori -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-tags text-purple-500 text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Total</span>
        </div>
        <p class="text-3xl font-bold text-dark mb-1">{{ $totalKategori }}</p>
        <p class="text-sm text-gray-500">Total Kategori</p>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-hand-holding text-orange-500 text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Aktif</span>
        </div>
        <p class="text-3xl font-bold text-dark mb-1">{{ $peminjamanAktif }}</p>
        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
    </div>
</div>

@if($peminjamanTerlambat > 0)
<div class="mb-8 bg-red-50 border border-red-200 rounded-2xl p-6 flex items-center gap-4">
    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
    </div>
    <div>
        <h3 class="font-semibold text-red-800 mb-1">Peringatan!</h3>
        <p class="text-red-600 text-sm">Terdapat <strong>{{ $peminjamanTerlambat }}</strong> peminjaman yang terlambat dikembalikan. Segera tindak lanjuti!</p>
    </div>
    <a href="{{ route('admin.peminjamans.index') }}" class="ml-auto px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition-all">
        Lihat Detail
    </a>
</div>
@endif

<!-- Quick Actions -->
<div class="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
    <h3 class="text-lg font-bold text-dark mb-6">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.users.create') }}" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-primary/10 border border-gray-100 hover:border-primary/30 transition-all group">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-primary transition-all">
                <i class="fas fa-user-plus text-gray-400 group-hover:text-dark"></i>
            </div>
            <div>
                <p class="font-semibold text-dark">Tambah User</p>
                <p class="text-xs text-gray-500">Buat akun user baru</p>
            </div>
        </a>
        
        <a href="{{ route('admin.alats.create') }}" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-primary/10 border border-gray-100 hover:border-primary/30 transition-all group">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-primary transition-all">
                <i class="fas fa-plus text-gray-400 group-hover:text-dark"></i>
            </div>
            <div>
                <p class="font-semibold text-dark">Tambah Alat</p>
                <p class="text-xs text-gray-500">Tambah data alat baru</p>
            </div>
        </a>
        
        <a href="{{ route('admin.peminjamans.index') }}" class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-primary/10 border border-gray-100 hover:border-primary/30 transition-all group">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm group-hover:bg-primary transition-all">
                <i class="fas fa-clipboard-list text-gray-400 group-hover:text-dark"></i>
            </div>
            <div>
                <p class="font-semibold text-dark">Kelola Peminjaman</p>
                <p class="text-xs text-gray-500">Lihat status peminjaman</p>
            </div>
        </a>
    </div>
</div>
@endsection