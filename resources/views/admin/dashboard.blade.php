@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-tools text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Alat</p>
                <p class="text-2xl font-bold">{{ $totalAlat }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total User</p>
                <p class="text-2xl font-bold">{{ $totalUser }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-tags text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Kategori</p>
                <p class="text-2xl font-bold">{{ $totalKategori }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-hand-holding text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Peminjaman Aktif</p>
                <p class="text-2xl font-bold">{{ $peminjamanAktif }}</p>
            </div>
        </div>
    </div>
</div>

@if($peminjamanTerlambat > 0)
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-red-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">
                Terdapat <strong>{{ $peminjamanTerlambat }}</strong> peminjaman yang terlambat dikembalikan!
            </p>
        </div>
    </div>
</div>
@endif
@endsection